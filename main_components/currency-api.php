<?php 

require_once("configration.php");
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $receivePayment = $_POST["receivePayment"];
    $currency = $_POST["currency"];

    // Replace 'YOUR_API_KEY' with your actual API key from exchangeratesapi.io
    $api_key = '613fbda0d10281547b0c8839';

    // API Endpoint
    $api_url = "https://open.er-api.com/v6/latest?base={$currency}&apikey={$api_key}";

    // Fetch exchange rates
    $response = file_get_contents($api_url);
    $data = json_decode($response, true);

    // Check if the API request was successful
    if ($data["result"] == "success") {
        $conversion_rate = $data["rates"]["USD"];
        $converted_amount = $receivePayment * $conversion_rate;

        echo $converted_amount;  // Return the converted amount
    } else {
        echo "Failed to fetch exchange rates. Please try again later.";
    }
}
?>