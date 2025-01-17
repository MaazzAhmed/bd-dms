<?php

require_once("configration.php");
session_start();


function getUserData($conn, $tableName, $userIdColumn, $userId)
{
    $query = "Select * from $tableName where $userIdColumn = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $userData = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    return $userData;
}
// Get filter values from the POST request
$ipFilter = $_POST['ipFilter'] ?? '';
$orderStatus = $_POST['orderStatus'] ?? '';
$secondfilter = $_POST['secondfilter'] ?? '';
$currentPage = $_POST['currentPage'] ?? 1;
$recordsPerPage = $_POST['recordsPerPage'] ?? 25;

// $startDate = $_POST['startDate'] ?? '';

$month = $_POST['month'] ?? '';
$year = $_POST['year'] ?? '';
$leadsource = $_POST['leadsource'] ?? '';
$currency = $_POST['currency'] ?? '';
$creatorName = $_POST['creatorName'] ?? '';
$orderconfirmationdate = $_POST['orderconfirmationdate'] ?? '';
$finaldeadlinetime = $_POST['finaldeadlinetime'] ?? '';
$brandname = $_POST['brandname'] ?? '';

$startDate = $_POST['startDate'] ?? null;
$endDate = $_POST['endDate'] ?? null;


$offset = ($currentPage - 1) * $recordsPerPage;
$userid = $_SESSION['id'] ?? '';
$teamId = $_SESSION['team_id'] ?? '';

$userDetails = getUserData($conn, 'user', 'userId', $_SESSION['id']);

global $userDetails;


// Build the base SQL query based on the user's role
if ($_SESSION['role'] == 'Admin') {
    $sql = "SELECT `order`.*, user.name, user.team_Id, 
            leads.campId, leads.client_name, leads.client_contact_number, 
            leads.lead_landing_date, leads.client_email, leads.client_info, leads.lead_source, leads.brand_name,
            recent_payments.receive_payment AS latest_received,
               recent_payments.pending_payment AS latest_pending,
               recent_payments.currency AS currency,
               recent_payments.total_payment AS total_payment   
            FROM `order`
            LEFT JOIN user ON `order`.user_id = user.userId
            LEFT JOIN leads ON `order`.lead_id = leads.id
               LEFT JOIN (
                SELECT op1.order_id, op1.receive_payment, op1.pending_payment, op1.currency, op1.total_payment
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
            WHERE order.del_status != 'Deleted'";
} else if ($_SESSION['role'] == 'Manager' || $_SESSION['role'] == 'Executive' && isset($userDetails['leads_order_view']) &&        $userDetails['leads_order_view'] != 'Deny') {
    $sql = "SELECT `order`.*, user.name, user.team_Id, 
            leads.campId, leads.client_name, leads.client_contact_number, 
            leads.lead_landing_date, leads.client_email, leads.client_info, leads.lead_source, leads.brand_name,
            recent_payments.receive_payment AS latest_received,
               recent_payments.pending_payment AS latest_pending,
               recent_payments.currency AS currency,
               recent_payments.total_payment AS total_payment   
            FROM `order`
            LEFT JOIN user ON `order`.user_id = user.userId
            LEFT JOIN leads ON `order`.lead_id = leads.id
            LEFT JOIN `team` ON `user`.team_Id = team.teamId
             LEFT JOIN (
                SELECT op1.order_id, op1.receive_payment, op1.pending_payment, op1.currency, op1.total_payment
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
            WHERE `user`.team_Id = $teamId AND order.del_status != 'Deleted'";

    echo $userDetails['leads_order_view'] . "Exexutive Allow";
} else {
    $sql = "SELECT `order`.*, user.name, user.team_Id, 
            leads.campId, leads.client_name, leads.client_contact_number, 
            leads.lead_landing_date, leads.client_email, leads.client_info, leads.lead_source, leads.brand_name,
            recent_payments.receive_payment AS latest_received,
               recent_payments.pending_payment AS latest_pending,
               recent_payments.currency AS currency,
               recent_payments.total_payment AS total_payment   
            FROM `order`
            LEFT JOIN user ON `order`.user_id = user.userId
            LEFT JOIN leads ON `order`.lead_id = leads.id
             LEFT JOIN (
                SELECT op1.order_id, op1.receive_payment, op1.pending_payment, op1.currency, op1.total_payment
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
            WHERE user.userId = '$userid' AND order.del_status != 'Deleted'";
}

// Apply filters based on user input
if (!empty($ipFilter)) {
    $sql .= " AND (
        leads.client_email LIKE '%$ipFilter%' 
        OR `order`.order_id_input LIKE '%$ipFilter%' 
        OR order.order_title LIKE '%$ipFilter%'
        OR order.order_confirmation_month LIKE '%$ipFilter%'
        OR order.order_status LIKE '%$ipFilter%'
        OR order.payment_status LIKE '%$ipFilter%'
        OR recent_payments.pending_payment LIKE '%$ipFilter%'
        OR recent_payments.receive_payment LIKE '%$ipFilter%'
        OR recent_payments.currency LIKE '%$ipFilter%'
        OR leads.client_contact_number LIKE '%$ipFilter%'
        OR leads.client_name LIKE '%$ipFilter%'
        OR leads.lead_source LIKE '%$ipFilter%'
        OR leads.client_info LIKE '%$ipFilter%'
    )";
}

if (!empty($orderStatus)) {
    $sql .= " AND order.order_status = '$orderStatus'";
}
if (!empty($month)) {
    $sql .= " AND order.order_confirmation_month = '$month'";
}
if (!empty($year)) {
    $sql .= " AND order.year = '$year'";
}
if (!empty($leadsource)) {
    $sql .= " AND leads.lead_source = '$leadsource'";
}
if (!empty($currency)) {
    $sql .= " AND order.currency = '$currency'";
}
if (!empty($creatorName)) {
    $sql .= " AND user.name = '$creatorName'";
}
// if (!empty($orderconfirmationdate)) {
//     $sql .= " AND order.order_confirmation_date = '$orderconfirmationdate'";
// }

if (!empty($startDate) && !empty($endDate)) {
    $sql .= " AND order.order_confirmation_date BETWEEN '$startDate' AND '$endDate'";
}
if (!empty($finaldeadlinetime)) {
    $sql .= " AND (order.final_deadline_time LIKE '%$finaldeadlinetime%')";
}
if (!empty($brandname)) {
    $sql .= " AND leads.brand_name = '$brandname'";
}

if (!empty($secondfilter)) {
    $sql .= " AND (
        leads.client_email LIKE '%$secondfilter%'
        OR `order`.order_id_input LIKE '%$secondfilter%'
        OR order.order_title LIKE '%$secondfilter%'
        OR leads.client_contact_number LIKE '%$secondfilter%'
        OR leads.client_name LIKE '%$secondfilter%'
    )";
}

// Final query with sorting and pagination
$sql .= " ORDER BY `order`.orderId DESC";



echo "Debug: SQL Query: $sql";

$totalRecordsQuery = "SELECT COUNT(*) as total FROM ($sql) AS subquery";


$totalRecordsResult = $conn->query($totalRecordsQuery);

if ($totalRecordsResult === false) {
    echo "Debug: MySQL Error: " . $conn->error;
    exit;
}

$totalRecords = $totalRecordsResult->fetch_assoc()['total'];

$sql .= " LIMIT $offset, $recordsPerPage";

$result = $conn->query($sql);
$idCounter = 1;

if ($result === false) {
    echo "Debug: MySQL Error: " . $conn->error;
    exit;
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        date_default_timezone_set('Asia/Karachi');
        $currentDate = date("Y-m-d");

        $deadlineDate = date("Y-m-d", strtotime($row['final_deadline_time']));

        $isTodayDeadline = ($currentDate == $deadlineDate);

        echo "<tr class='bold'>";
        echo "<td>{$idCounter}</td>";
        echo "<td>{$row['client_info']}</td>";
        echo "<td>{$row['client_name']}</td>";
        echo "<td>{$row['client_email']}</td>";
        echo "<td>{$row['client_contact_number']}</td>";
        echo "<td>" . date("j-M-Y", strtotime($row['order_confirmation_date'])) . "</td>";
        echo "<td>" . date("d-M-Y h:i a", strtotime($row['portal_due_date'])) . "</td>";
        echo '<td' . ($isTodayDeadline ? ' style="background-color: red;"' : '') . '>' . date('d-M-Y h:i a', strtotime($row['final_deadline_time'])) . '</td>';
        echo "<td data-bs-toggle='tooltip' data-bs-placement='top' title='{$row['comment']}'>{$row['order_id_input']}</td>";
        echo "<td>{$row['order_title']}</td>";
        if ($row['order_status'] == 'Follow up') {
            echo "<td style='background-color: #e6b8af;'><span class='badge' style='background-color: #e6b8af;'>{$row['order_status']}</span></td>";
        } elseif ($row['order_status'] == 'Revision') {
            echo "<td style='background-color: #9bbb59;'><span class='badge' style='background-color: #9bbb59;'>{$row['order_status']}</span></td>";
        } elseif ($row['order_status'] == 'File not received') {
            echo "<td style='background-color: #ff00ff;'><span class='badge' style='background-color: #ff00ff;'>{$row['order_status']}</span></td>";
        } elseif ($row['order_status'] == 'Refund/Deadline') {
            echo "<td style='background-color: Red;'><span class='badge' style='background-color: Red;'>{$row['order_status']}</span></td>";
        } elseif ($row['order_status'] == 'Half Payment') {
            echo "<td style='background-color: Black;color:white;'><span class='badge' style='background-color: Black;color:white;'>{$row['order_status']}</span></td>";
        } elseif ($row['order_status'] == 'Converted') {
            echo "<td  style='background-color: #320f99;'><span class='badge' style='background-color: #320f99;'>{$row['order_status']}</span></td>";
        } elseif ($row['order_status'] == 'Delivered') {
            echo "<td style='background-color: #00ffff;'><span class='badge' style='background-color: #00ffff;'>{$row['order_status']}</span></td>";
        } elseif ($row['order_status'] == 'cancelled') {
            echo "<td style='background-color: #ff1313;'><span class='badge' style='background-color: #00ffff;'>{$row['order_status']}</span></td>";
        } else {
            echo "<td>{$row['order_status']}</td>";
        }
        echo "<td>{$row['word_count']}</td>";


        echo "<td>{$row['lead_source']}</td>";
        if ($row['payment_status'] == 'Full Payment') {
            echo "<td style='background-color: Yellow;'><span class='badge' style='color: grey ;'>{$row['payment_status']}</span></td>";
        } elseif ($row['payment_status'] == 'Half Payment') {
            echo "<td style='background-color: Black !important;color:white;'><span class='badge' style='background-color: Black;color:white;'>{$row['payment_status']}</span></td>";
        } else {
            echo "<td>{$row['payment_status']}</td>";
        }
        echo "<td>{$row['latest_pending']}</td>";
        echo "<td>{$row['latest_received']}</td>";
        echo "<td>{$row['total_payment']}</td>";
        echo "<td>{$row['currency']}</td>";
        echo "<td>{$row['brand_name']}</td>";


        echo "<td>
        <form method='post' action='add-payment'>
       <input type='hidden' name='order_id' value='{$row['orderId']}'>
       <button type='submit' class='btn btn-warning dm' name='add-payment'><i class='bx bx-plus dmd'>Payment</i></button>
   </form>  </td>";

        //          echo "<td>
        //         <form method='post' action='view-payments'>
        //        <input type='hidden' name='order_id' value='{$row['orderId']}'>
        //        <button type='submit' class='btn btn-success dm' name='view-payment'><i class='fa fa-eye dmd'>Payment</i></button>
        //    </form> </td>";
        echo "<td>
         <form method='post' action='view-payments'>
                <input type='hidden' name='order_id' value='{$row['orderId']}'>
                <button type='submit' class='btn btn-success dm' name='view-payment'><i class='fa fa-eye dmd'>Payment</i></button>
            </form> 
     </td>";




        echo "<td class='mt-4'><a href='#invoiceModal' class='open-invoice btn btn-secondary' data-invoice-id='{$row['lead_id']}' data-toggle='modal'>Template</a>

        </td>";


        echo "<td>
         <form method='post' action='edit-order'>
        <input type='hidden' name='order_id' value='{$row['orderId']}'>
        <button type='submit' class='btn btn-info ' name='edit_order'>Edit</button>
    </form> </td>";
        if ($_SESSION['role'] == 'Admin') {
            echo "<td>
            <form method='post' action='' id='deleteOrderForm_{$row['orderId']}' onsubmit='return false;'>
                <input type='hidden' name='order_id' value='{$row['orderId']}'>
                <input type='hidden' name='deleted_name' value='{$_SESSION['user']}'>
                <input type='hidden' name='order_title' value='{$row['order_title']}'>
                <button type='button' class='btn btn-danger' onclick='confirmKeyAndDeleteOrder({$row['orderId']})'>Delete</button>
            </form>
        </td>";
        }
        echo "<td>
        <form action='view-all-orders' method='post'>
        <input type='hidden' name='allordersid' value='{$row['orderId']}'>
        <button type='submit' name='view-all-orders' class='btn btn-success'>View</button>
        </form>
        </td>";
        // echo "<td>
        // <form method='post' action='order-payment'>
        // <input type='hidden' name='order_id' value='{$row['orderId']}'>
        // </form> </td>";
        echo "</tr>";
        $idCounter++;
    }
} else {
    echo "<tr><td colspan='4'>No records found</td></tr>";
}

$conn->close();

// Calculate total pages
$totalPages = ceil($totalRecords / $recordsPerPage);

// Generate pagination links
echo '<tr><td colspan="4"><nav><ul class="pagination">';

if ($currentPage > 1) {
    echo "<li class='page-item'><a class='page-link pagination-link' href='#' data-page='" . ($currentPage - 1) . "'>Previous</a></li>";
}

for ($i = 1; $i <= $totalPages; $i++) {
    $activeClass = $i == $currentPage ? 'active' : '';
    echo "<li class='page-item $activeClass'><a class='page-link pagination-link' href='#' data-page='$i'>$i</a></li>";
}

if ($currentPage < $totalPages) {
    echo "<li class='page-item'><a class='page-link pagination-link' href='#' data-page='" . ($currentPage + 1) . "'>Next</a></li>";
}

echo '</ul></nav></td></tr>';
