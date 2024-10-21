<?php

require_once('main_components/global.php');

session_start();

date_default_timezone_set('Asia/Karachi');

if(isset($_SESSION['id'])) {

    // Get the user's IP address
$client_ip = $_SERVER['REMOTE_ADDR'];

    $userId = $_SESSION['id'];
    $currentDateTime = date('Y-m-d H:i:s');

     $updateQuery = "UPDATE user SET last_id_address = '$client_ip' , last_login = '$currentDateTime' WHERE userId = $userId";
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

