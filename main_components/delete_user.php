<?php 
require_once('configration.php');

// Error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['action']) && $_POST['action'] === 'delete_user' && isset($_POST['userId']) && isset($_POST['inputKey'])) {
    error_log("Checkpoint: Delete request received with User ID: " . $_POST['userId']);  // Log for debugging

    $userId = $_POST['userId'];
    $inputKey = $_POST['inputKey'];
    $secret_key = 'XqzQh9G4Ju87Gqfy4xZkQzZ+2HdF0YqM/pjHoN6ITe0='; // Base64-encoded secret key
    
    // Decrypt function
    function decrypt($data, $key) {
        $encryption_key = base64_decode($key);
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
    }

    // Fetch and decrypt the key from the delete_keys table
    $sql = "SELECT `key` FROM delete_keys WHERE id = 2";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        error_log("Checkpoint: Key found in database.");  // Log for debugging
        $row = $result->fetch_assoc();
        $dbKey = decrypt($row['key'], $secret_key);

        // Validate the key
        if ($inputKey === $dbKey) {
            error_log("Checkpoint: Key validated successfully.");  // Log for debugging
            // Proceed with deletion
            $del_status = "Deleted";

            // Start transaction
            mysqli_begin_transaction($conn);

            try {
                // Get the username for logging purposes
                $getUserNameQuery = "SELECT name FROM user WHERE userId = ?";
                $stmtGetUserName = mysqli_prepare($conn, $getUserNameQuery);
                mysqli_stmt_bind_param($stmtGetUserName, "i", $userId);
                mysqli_stmt_execute($stmtGetUserName);
                $resultUserName = mysqli_stmt_get_result($stmtGetUserName);
                $userName = mysqli_fetch_assoc($resultUserName)['name'];
                mysqli_stmt_close($stmtGetUserName);

                // Update the user table
                $deleteUserQuery = "UPDATE user SET del_status = ? WHERE userId = ?";
                $stmtDeleteUser = mysqli_prepare($conn, $deleteUserQuery);
                mysqli_stmt_bind_param($stmtDeleteUser, "si", $del_status, $userId);
                mysqli_stmt_execute($stmtDeleteUser);

                // Update the permissions table
                $deletePermissionsQuery = "UPDATE permissions SET del_status = ? WHERE user_id = ?";
                $stmtDeletePermissions = mysqli_prepare($conn, $deletePermissionsQuery);
                mysqli_stmt_bind_param($stmtDeletePermissions, "si", $del_status, $userId);
                mysqli_stmt_execute($stmtDeletePermissions);

                // Commit transaction
                mysqli_commit($conn);

                // Log the deletion
                $logFileName = 'user_deletion_log.txt';
                $logMessage = "The '$userName' account was deleted successfully by user ID: $userId";
                customLogToFile($logMessage, $logFileName);

                // Return success response
                echo json_encode(['status' => 'success', 'message' => 'User and permissions deleted successfully!']);
                error_log("Checkpoint: User deleted successfully.");  // Log for debugging
            } catch (Exception $e) {
                mysqli_rollback($conn);
                error_log("Error during deletion: " . $e->getMessage());  // Log errors if any
                echo json_encode(['status' => 'error', 'message' => 'Error deleting user. Please try again.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Incorrect deletion key.']);
            error_log("Error: Incorrect deletion key.");
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Deletion key not found.']);
        error_log("Error: Deletion key not found.");
    }

    exit();
}
?>
