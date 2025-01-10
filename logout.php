<?php

require_once('main_components/global.php');

session_start();

date_default_timezone_set('Asia/Karachi');

function getUserIPv4() {
    // Check if shared internet or proxy server is used
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Check if forwarded IP exists
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        // If multiple IPs exist, take the first one
        $ip = explode(',', $ip)[0];
    } else {
        // Default remote address
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    // Validate and return IPv4 address only
    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
        return $ip;
    }

    return '0.0.0.0'; // Return a default invalid IP if no valid IPv4 is found
}

if (isset($_SESSION['id'])) {

    // Get the user's IPv4 address
    $client_ip = getUserIPv4();

    $userId = $_SESSION['id'];
    $currentDateTime = date('Y-m-d H:i:s');

    $updateQuery = "UPDATE user SET last_ip_address = '$client_ip', last_login = '$currentDateTime' WHERE userId = $userId";
    mysqli_query($conn, $updateQuery);
    mysqli_close($conn);
}

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page
header("Location: login");
exit();

?>
