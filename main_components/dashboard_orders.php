<?php
require_once("configration.php");
session_start();

// Capture POST data
$startDate = $_POST['start_date'];
$endDate = $_POST['end_date'];
$Filter_tmId = $_POST['teamId'] ?? '';
$Filter_UserId = $_POST['userId'] ??'';
$Filter_brandName = $_POST['brandName']  ?? '';


// Initialize totals
$totalPaymentUSD = 0;
$pendingPaymentUSD = 0;
$totalOrders = 0;
$userid = $_SESSION['id'] ?? '';
$teamId = $_SESSION['team_id'] ?? '';

// Prepare the SQL query with date range 

if ($_SESSION['role'] == 'Admin') {
    $sql = "SELECT 
            recent_payments.receive_payment AS receive_payment,
            recent_payments.pending_payment AS pending_payment, leads.brand_name,
            recent_payments.currency AS currency,
            `order`.orderId, `order`.user_id
        FROM `order`
                    LEFT JOIN leads ON `order`.lead_id = leads.id
                    LEFT JOIN `user` ON `order`.user_id = `user`.userId
                    LEFT JOIN `team` ON `user`.team_Id = team.teamId


        LEFT JOIN (
            SELECT op1.order_id, op1.receive_payment, op1.pending_payment, op1.payment_date, op1.total_payment, op1.currency
            FROM order_payments op1
            INNER JOIN (
                SELECT order_id, MAX(timestamp) AS max_timestamp
                FROM order_payments
                WHERE del_status != 'Deleted'
                GROUP BY order_id
            ) op2 ON op1.order_id = op2.order_id 
            AND op1.timestamp = op2.max_timestamp
            WHERE op1.del_status != 'Deleted'
        ) AS recent_payments ON `order`.orderId = recent_payments.order_id
        WHERE `order`.del_status != 'Deleted'
        AND recent_payments.payment_date BETWEEN '$startDate' AND '$endDate'";
} else if ($_SESSION['role'] == 'Manager' || $_SESSION['role'] == 'Executive' && isset($userDetails['leads_order_view']) && $userDetails['leads_order_view'] != 'Deny') {
    $sql = "SELECT 
            recent_payments.receive_payment AS receive_payment,
            recent_payments.pending_payment AS pending_payment, 
            recent_payments.currency AS currency,
            `order`.orderId, `order`.user_id
        FROM `order`
        LEFT JOIN `user` ON `order`.user_id = `user`.userId
            LEFT JOIN `team` ON `user`.team_Id = team.teamId
        LEFT JOIN (
            SELECT op1.order_id, op1.receive_payment, op1.pending_payment, op1.payment_date, op1.total_payment, op1.currency
            FROM order_payments op1
            INNER JOIN (
                SELECT order_id, MAX(timestamp) AS max_timestamp
                FROM order_payments
                WHERE del_status != 'Deleted'
                GROUP BY order_id
            ) op2 ON op1.order_id = op2.order_id 
            AND op1.timestamp = op2.max_timestamp
            WHERE op1.del_status != 'Deleted'
        ) AS recent_payments ON `order`.orderId = recent_payments.order_id
        WHERE `order`.del_status != 'Deleted'
        AND recent_payments.payment_date BETWEEN '$startDate' AND '$endDate' AND  `user`.team_Id = $teamId";
} else {
    $sql = "SELECT 
            recent_payments.receive_payment AS receive_payment,
            recent_payments.pending_payment AS pending_payment,
            recent_payments.currency AS currency,
            `order`.orderId, `order`.user_id
        FROM `order`
        LEFT JOIN `user` ON `order`.user_id = `user`.userId
            LEFT JOIN `team` ON `user`.team_Id = team.teamId
        LEFT JOIN (
            SELECT op1.order_id, op1.receive_payment, op1.pending_payment, op1.payment_date, op1.total_payment, op1.currency
            FROM order_payments op1
            INNER JOIN (
                SELECT order_id, MAX(timestamp) AS max_timestamp
                FROM order_payments
                WHERE del_status != 'Deleted'
                GROUP BY order_id
            ) op2 ON op1.order_id = op2.order_id 
            AND op1.timestamp = op2.max_timestamp
            WHERE op1.del_status != 'Deleted'
        ) AS recent_payments ON `order`.orderId = recent_payments.order_id
        WHERE `order`.del_status != 'Deleted'
        AND recent_payments.payment_date BETWEEN '$startDate' AND '$endDate' AND  user.userId = '$userid'";
}
if (!empty($Filter_tmId)) {
    $sql .= " AND `user`.team_Id = $Filter_tmId";
}
if (!empty($Filter_UserId)) {
    $sql .= " AND `order`.user_id = '$Filter_UserId'";
}
if (!empty($Filter_brandName)) {
    $sql .= " AND leads.brand_name = '$Filter_brandName'";
}

error_log("Generated SQL: $sql");


$result = $conn->query($sql);

if ($result === false) {
    error_log("SQL Query Error: " . $conn->error);
    echo json_encode(['error' => 'SQL query error, check logs for details']);
    exit;
}

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'No matching records found']);
    exit;
}


if ($result) {
    $currencies = [];
    $payments = [];

    while ($row = $result->fetch_assoc()) {
        $currency = $row['currency'] ?? 'USD';

        // Add each payment and currency to the list
        $payments[] = [
            'receive_payment' => $row['receive_payment'] ?? 0,
            'pending_payment' => $row['pending_payment'] ?? 0,
            'currency' => $currency
        ];

        // Collect unique currencies for conversion rates
        if ($currency !== 'USD' && !in_array($currency, $currencies)) {
            $currencies[] = $currency;
        }

        $totalOrders++;

        
    }
// Log payments and currencies for debugging
error_log("Payments: " . json_encode($payments));
error_log("Currencies: " . json_encode($currencies));

    // Fetch conversion rates for each unique currency
    $conversion_rates = [];
    foreach ($currencies as $currency) {
        $api_key = '613fbda0d10281547b0c8839'; // Replace with actual API key
        $api_url = "https://open.er-api.com/v6/latest/{$currency}?apikey={$api_key}";

        $response = file_get_contents($api_url);
        $data = json_decode($response, true);

        if ($data && $data["result"] == "success") {
            $conversion_rates[$currency] = $data["rates"]["USD"] ?? 1;
        } else {
            $conversion_rates[$currency] = 1; // Default rate if API fails
        }
    }

    // Calculate total_payment and pending_payment in USD
    foreach ($payments as $payment) {
        $currency = $payment['currency'];
        $rate = $currency === 'USD' ? 1 : ($conversion_rates[$currency] ?? 1);

        $totalPaymentUSD += $payment['receive_payment'] * $rate;
        $pendingPaymentUSD += $payment['pending_payment'] * $rate;
    }
} else {
    error_log("SQL Query Error: " . $conn->error);
    echo json_encode(['error' => 'No data found or SQL query issue']);
    exit; // Exit to avoid sending incomplete data
}

// Return the response as JSON
echo json_encode([
    'receive_payment' => number_format($totalPaymentUSD, 2), // Format to two decimal places
    'pending_payment' => number_format($pendingPaymentUSD, 2),
    'total_orders' => $totalOrders
]);
