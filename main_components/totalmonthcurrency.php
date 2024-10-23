<?php
require_once("configration.php");

$ipFilter = isset($_POST['ipFilter']) ? $_POST['ipFilter'] : '';
$monthFilter = isset($_POST['month']) ? $_POST['month'] : '';
$yearFilter = isset($_POST['year']) ? $_POST['year'] : '';

$combinedResult = sumAndConvertCurrency($ipFilter, $monthFilter, $yearFilter);

echo json_encode($combinedResult);

function sumAndConvertCurrency($ipFilter, $monthFilter, $yearFilter)
{
    global $conn;

    // Your logic to sum both received and pending currency for the given month
    $sql = "
        SELECT 
            SUM(`order`.receive_payment) as received_amount,
            SUM(`order`.pending_payment) as pending_amount,
            `order`.currency
        FROM `order`
        WHERE `order`.order_confirmation_month LIKE '%$monthFilter%' 
        AND `order`.year = '$yearFilter'
        AND (`order`.order_confirmation_month LIKE '%$ipFilter%' OR `order`.order_status LIKE '%$ipFilter%')
        GROUP BY `order`.currency";

    $result = $conn->query($sql);

    if ($result === false) {
        return array("error" => "MySQL Error: " . $conn->error);
    }

    $combinedResult = array();

    while ($row = $result->fetch_assoc()) {
        $received_amount = $row['received_amount'];
        $pending_amount = $row['pending_amount'];
        $currency = $row['currency'];

        // Convert both received and pending amounts (use your existing conversion logic)
        $api_key = 'YOUR_API_KEY'; // Replace with actual API key
        $api_url = "https://open.er-api.com/v6/latest?base={$currency}&apikey={$api_key}";

        $response = file_get_contents($api_url);
        $data = json_decode($response, true);

        if ($data["result"] == "success") {
            $conversion_rate = $data["rates"]["USD"];
            $converted_received = $received_amount * $conversion_rate;
            $converted_pending = $pending_amount * $conversion_rate;

            // Add both received and pending converted amounts to the result array
            $combinedResult[] = array(
                "currency" => $currency,
                "received_amount" => $received_amount,
                "pending_amount" => $pending_amount,
                "converted_received" => $converted_received,
                "converted_pending" => $converted_pending
            );
        } else {
            // Handle conversion failure
            $combinedResult[] = array(
                "currency" => $currency,
                "received_amount" => $received_amount,
                "pending_amount" => $pending_amount,
                "converted_received" => "Conversion failed",
                "converted_pending" => "Conversion failed"
            );
        }
    }

    return $combinedResult;
}
?>