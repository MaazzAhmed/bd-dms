<?php

require_once("configration.php");

session_start();

// Function to fetch roles for dropdown

function getRoles($conn)

{

    $roles = array();

    $query = "SHOW COLUMNS FROM `user` LIKE 'role'";

    $result = mysqli_query($conn, $query);



    if ($result) {

        $row = mysqli_fetch_assoc($result);

        $enumStr = $row['Type'];

        $enumStr = substr($enumStr, 6, -2); // Extract enum values from string

        $roles = explode("','", $enumStr);
    }



    return $roles;
}



// Function to get users from the database with related information

function getUsers($conn)
{

    $users = array();

    $query = "SELECT userId, name, email, role, team_name, shift_type, start_timing, end_timing, system_status

              FROM user 

              LEFT JOIN team ON user.team_Id = team.teamId

              LEFT JOIN shift ON user.shift_id = shift.shiftId 
              WHERE user.del_status != 'Deleted'

              ORDER BY userId DESC";

    $result = mysqli_query($conn, $query);


    if (!$result) {
        die("Query failed: " . mysqli_error($conn));  // Display the error message
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    // while ($row = mysqli_fetch_assoc($result)) {

    //     $users[] = $row;
    // }



    return $users;
}





// Function to fetch Teamname for dropdown

function getTeams($conn)
{
    $teams = array();
    $query = "SELECT teamId, team_name FROM team";
    $stmt = mysqli_prepare($conn, $query);

    if (!$stmt) {
        // Error handling
        echo "Error: " . mysqli_error($conn);
        // You might want to handle the error more gracefully, like logging it or returning an empty array
        return $teams;
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $teams[] = $row;
    }

    return $teams;
}
// Function to fetch Shifttype for dropdown

function getShift($conn)

{

    $shifts = array();

    $query = "SELECT shiftId, shift_type, start_timing, end_timing FROM shift";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);



    while ($row = mysqli_fetch_assoc($result)) {

        $shifts[] = $row;
    }



    return $shifts;
}



// Function to fetch permissions for dropdown

function getPermissions($conn)

{

    $permissions = array();

    $query = "SELECT permissionid, lead_management, log_management FROM permissions";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);



    while ($row = mysqli_fetch_assoc($result)) {

        $permissions[] = $row;
    }



    return $permissions;
}



// Function to fetch team leader name for dropdown

function getName($conn)

{

    $username = array();

    $query = "SELECT userId, name FROM user";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);



    while ($row = mysqli_fetch_assoc($result)) {

        $username[] = $row;
    }



    return $username;
}





// For log 

function customLogToFile($message, $logFileName = 'log.txt')

{
    date_default_timezone_set('Asia/Karachi');

    $logFile = 'logs/' . $logFileName;



    if (!file_exists($logFile)) {

        $logDir = 'logs';

        if (!file_exists($logDir)) {

            mkdir($logDir, 0755, true);
        }

        touch($logFile);
    }



    file_put_contents($logFile, date('Y-m-d H:i:s') . ' - ' . $message . PHP_EOL, FILE_APPEND);
}

// End Log



// Initialize error message

$error = '';



if (isset($_POST['login'])) {



    $email = $_POST['email'];

    $password = $_POST['password'];





    $sql = "SELECT * FROM user WHERE email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();



    // Check if a user with the provided email exists

    if ($result->num_rows === 1) {

        $row = $result->fetch_assoc();

        $storedPassword = $row['password'];

        if (password_verify($password, $storedPassword)) {

            // Password is correct, now check the status

            $status = $row['system_status'];



            // Check if the user's role is Inactive

            if ($status === 'Blocked') {

                $error = 'Your account has been blocked. Please contact admin.';
            } elseif ($row['system_status'] == 'Off') {

                $error = "Quick news: Our Portal DMS is currently down due to some unexpected server work. We're fixing it as fast as we can!";
            } elseif ($row['del_status'] == 'Deleted') {

                $error = "Your account has been deleted. To recover the account, please contact the admin.";
            } else {

                // Authentication successful

                $_SESSION['id'] = $row['userId']; // Set the 'id' in the session

                $_SESSION['user'] = $row['name'];

                $_SESSION['email'] = $row['email'];

                $_SESSION['role'] = $row['role'];

                $_SESSION['team_id'] = $row['team_Id'];

                $_SESSION['avatar'] = $row['avatar'];

                $_SESSION['status'] = $row['system_status'];

                $_SESSION['secret_key'] = $row['secret_key'];

                $_SESSION['last_id_address'] = $row['last_id_address'];

                $_SESSION['last_login'] = $row['last_login'];

                $_SESSION['delete_key'] = $row['delete_key'];


                // Debugging statements

                echo 'Session ID: ' . session_id() . '<br>';

                echo 'Session User: ' . $_SESSION['user'] . '<br>';



                header('Location: ./verification'); // Redirect to the verification page

                exit;
            }
        } else {

            $error = 'Incorrect password';
        }
    } else {

        $error = 'User with the provided email not found';
    }


    $stmt->close();
}
// End Login

// // System status check

$sql = "SELECT * FROM user ORDER BY userId DESC;";

$systemset = $conn->query($sql);



$row = $systemset->fetch_assoc();



if (isset($_SESSION['status']) && $row['system_status'] == 'off') {



    header('Location: logout');
}
// System status check

// Check if the verification form is submitted
if (isset($_POST['verify'])) {

    $userProvidedKey = $_POST['key'];

    $correctKey = $_SESSION['secret_key'];



    if (!isset($_SESSION['login_attempts'])) {

        $_SESSION['login_attempts'] = 0;
    }
    if ($userProvidedKey === $correctKey) {
        $_SESSION['key'] = $correctKey;
        header('Location: ./');
        exit;
    } else {

        $_SESSION['login_attempts']++;
        $maxAttempts = 3;

        if ($_SESSION['login_attempts'] >= $maxAttempts) {


            $status = 'Blocked';

            $userId = $_POST['id'];



            $sql = "UPDATE user SET system_status = ? WHERE userId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $status, $userId);
            $stmt->execute();
            $stmt->close();
            header('Location: logout.php');

            exit;
        }





        // Display remaining attempts to the user

        $remainingAttempts = $maxAttempts - $_SESSION['login_attempts'];

        echo "<h3 class='form-control bd-danger'><center>Incorrect key. $remainingAttempts attempts remaining.</center></h3>";
    }
}

// End

// Create User Form
if (isset($_POST['create'])) {
    // Retrieve form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $teamId = $_POST['teamId'];
    $shift = $_POST['shift'];
    $secret_key = $_POST['secret_key'];
    $stytem_status = $_POST['system_status'];
    $permissions = isset($_POST['permissions']) ? $_POST['permissions'] : array();
    $permissions = array_map(function ($permission) {
        // Replace hyphens with underscores
        return str_replace('-', '_', $permission);
    }, $permissions);

    $selectedBrands = $_POST['brandname'];

    $delete_key = "delete";

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $checkEmailQuery = "SELECT COUNT(*) as count FROM user WHERE email = ?";
    $stmtCheckEmail = mysqli_prepare($conn, $checkEmailQuery);
    mysqli_stmt_bind_param($stmtCheckEmail, "s", $email);
    mysqli_stmt_execute($stmtCheckEmail);
    $result = mysqli_stmt_get_result($stmtCheckEmail);
    $row = mysqli_fetch_assoc($result);

    if ($row['count'] > 0) {
        // Email already exists, display a message to the user
        $erroradduser = "Error: Email already exists.";
    } else {

        // Insert user data without delete_key
        $insertUserQuery = "INSERT INTO `user` (name, email, password, role, team_Id, shift_id, secret_key, system_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtUser = mysqli_prepare($conn, $insertUserQuery);
        mysqli_stmt_bind_param($stmtUser, "ssssiiss", $name, $email, $hashedPassword, $role, $teamId, $shift, $secret_key, $stytem_status);


        if (mysqli_stmt_execute($stmtUser)) {
            // User inserted successfully
            $userId = mysqli_insert_id($conn);

            // Log user creation
            $logFileName = 'user_creation_log.txt';
            $logMessage = "{$_SESSION['user']} created a new user $name.";
            customLogToFile($logMessage, $logFileName);

            // Insert or update permissions for the user
            $insertPermissionsQuery = "INSERT INTO permissions (user_id, " . implode(', ', $permissions) . ") VALUES (?, " . str_repeat('1, ', count($permissions) - 1) . "1) ON DUPLICATE KEY UPDATE " . implode(', ', array_map(function ($permission) {
                return "`$permission` = 1";
            }, $permissions));
            $stmtPermissions = mysqli_prepare($conn, $insertPermissionsQuery);
            mysqli_stmt_bind_param($stmtPermissions, "i", $userId);

            foreach ($selectedBrands as $brand) {
                $insertBrandPermissionQuery = "INSERT INTO `brand_permissions` (brandpermission, user_id) VALUES (?, ?)";
                $stmtBrandPermission = mysqli_prepare($conn, $insertBrandPermissionQuery);
                mysqli_stmt_bind_param($stmtBrandPermission, "si", $brand, $userId);

                if (!mysqli_stmt_execute($stmtBrandPermission)) {
                    echo "Error inserting brand permissions: " . mysqli_error($conn);
                }
                // Close brand permission statement
                mysqli_stmt_close($stmtBrandPermission);
            }

            if (!mysqli_stmt_execute($stmtPermissions)) {
                echo "Error: " . mysqli_error($conn);
                if (mysqli_errno($conn) == 1062) {
                    echo "Duplicate key error: " . mysqli_error($conn);
                    die();
                } else {
                    // Handle other errors
                    echo "Error: " . mysqli_error($conn);
                    echo $insertPermissionsQuery;
                    die();
                }
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }


        // Close statements
        mysqli_stmt_close($stmtPermissions);
        mysqli_stmt_close($stmtUser);

        // Redirect user
        // Redirect user and set session message


        $_SESSION['message'] = 'User created successfully.';
        header("Location: add-user");
        exit();
    }
}



// End User Form



// Function to fetch column names from the permissions table

function getColumnPermissions($conn)

{

    $query = "SHOW COLUMNS FROM permissions WHERE Field NOT IN ('permissionid', 'user_id')";

    $result = mysqli_query($conn, $query);



    $columns = array();

    while ($row = mysqli_fetch_assoc($result)) {

        $columns[] = $row['Field'];
    }



    return $columns;
}

// function getAllowedBrandsForUser($conn, $userId) {
//     $query = "SELECT b.brand_name FROM brand_permissions bp JOIN brands b ON bp.brandpermission = b.id WHERE bp.user_id = ?";
//     $stmt = mysqli_prepare($conn, $query);
//     mysqli_stmt_bind_param($stmt, "i", $userId);
//     mysqli_stmt_execute($stmt);
//     $result = mysqli_stmt_get_result($stmt);
//     $brands = mysqli_fetch_all($result, MYSQLI_ASSOC);
//     mysqli_stmt_close($stmt);
//     return $brands;
// }
function getAllowedDisplayBrandsForUser($conn, $userId)
{
    $query = "SELECT brandpermission FROM brand_permissions where user_id = ?";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $brands = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_stmt_close($stmt);
    return $brands;
}
function getAllowedBrandsForUser($conn, $userId)
{
    $query = "SELECT b.brand_name 
              FROM brand_permissions bp 
              JOIN brands b ON bp.brandpermission = b.id 
              WHERE bp.user_id = $userId";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Database query failed: " . mysqli_error($conn));
    }

    $brands = mysqli_fetch_all($result, MYSQLI_ASSOC);

    return $brands;
}


// View Users

$readQuery = "SELECT * FROM User";

$result = mysqli_query($conn, $readQuery);

// End View Users



// View users Permission

$readQuery = "SELECT * FROM permissions";

$result = mysqli_query($conn, $readQuery);

// End View Users Permissions




// Start edit user

if (isset($_POST['edit_user'])) {

    $userId = $_POST['userId'];

    // $editUserQuery = "SELECT * FROM user WHERE userId = ?";
    // $stmtEditUser = mysqli_prepare($conn, $editUserQuery);
    // mysqli_stmt_bind_param($stmtEditUser, "i", $userId);
    // mysqli_stmt_execute($stmtEditUser);
    // $resultEditUser = mysqli_stmt_get_result($stmtEditUser);
    // $editUserData = mysqli_fetch_assoc($resultEditUser);
    // mysqli_stmt_close($stmtEditUser);
    $editUserQuery = "
    SELECT u.*, bp.brandpermission 
    FROM user u
    LEFT JOIN brand_permissions bp ON u.userId = bp.user_id
    WHERE u.userId = ?
";

    $stmtEditUser = mysqli_prepare($conn, $editUserQuery);
    mysqli_stmt_bind_param($stmtEditUser, "i", $userId);
    mysqli_stmt_execute($stmtEditUser);
    $resultEditUser = mysqli_stmt_get_result($stmtEditUser);

    $editUserData = [];
    $brandPermissions = [];

    // Fetch the user data and their brand permissions
    while ($row = mysqli_fetch_assoc($resultEditUser)) {
        // Store the first user data
        if (empty($editUserData)) {
            $editUserData = $row;
        }

        // Add each brand permission to the array
        if (!empty($row['brandpermission'])) {
            $brandPermissions[] = $row['brandpermission'];
        }
    }
    mysqli_stmt_close($stmtEditUser);
}


if (isset($_POST['update_user'])) {

    if (isset($_POST['update_user'])) {

        $userId = $_POST['userId'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $teamId = $_POST['team_Id'];
        $shiftId = $_POST['shift_id'];
        $secret_key = $_POST['secret_key'];
        $system_status = $_POST['stytem_status'];
        $wfh = $_POST['wfh'];
        $password = $_POST['password'];
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $brandname = $_POST['brandname']; // New brand permissions (array of brand names)

        // Update user data logic
        if ($password == null) {
            $updateUserQuery = "UPDATE `user` SET name=?, email=?, role=?, team_Id=?, shift_id=?, secret_key=?, system_status=?, wfh = ? WHERE userId=?";
            $stmtUpdateUser = mysqli_prepare($conn, $updateUserQuery);
            mysqli_stmt_bind_param($stmtUpdateUser, "ssssisssi", $name, $email, $role, $teamId, $shiftId, $secret_key, $system_status, $wfh, $userId);
        } else {
            $updateUserQuery = "UPDATE `user` SET name=?, email=?, role=?, team_Id=?, shift_id=?, secret_key=?, system_status=?, password=?, wfh = ? WHERE userId=?";
            $stmtUpdateUser = mysqli_prepare($conn, $updateUserQuery);
            mysqli_stmt_bind_param($stmtUpdateUser, "ssssissssi", $name, $email, $role, $teamId, $shiftId, $secret_key, $system_status, $hashedPassword, $wfh, $userId);
        }

        // Fetch current user data to compare changes
        $query = "SELECT * FROM user WHERE userId = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $currentUserData = mysqli_stmt_get_result($stmt)->fetch_assoc();
        mysqli_stmt_close($stmt);

        // Run update query
        if (mysqli_stmt_execute($stmtUpdateUser)) {
            $_SESSION['eumessage'] = "User updated successfully!";

            // Log user update
            $logFileName = 'user_update_log.txt';
            $logMessage = "{$_SESSION['user']} has updated the user information";
            $changedFields = hasUserDataChanged($currentUserData, $name, $email, $role, $teamId, $shiftId, $system_status, $wfh);

            if (!empty($changedFields)) {
                $logMessage .= ", Updated Fields: ";
                foreach ($changedFields as $field => $values) {
                    $logMessage .= "$field (Before: {$values['before']}, After: {$values['after']}), ";
                }
                $logMessage = rtrim($logMessage, ', ');
            } else {
                $logMessage .= ", but no fields were changed.";
            }
            customLogToFile($logMessage, $logFileName);
        } else {
            $_SESSION['eumessage'] = "Error updating user: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmtUpdateUser);

        // Brand Permissions Update Logic
        // Fetch current brand permissions for the user
        $existingPermissions = [];
        $query = "SELECT brandpermission FROM brand_permissions WHERE user_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        while ($row = mysqli_fetch_assoc($result)) {
            $existingPermissions[] = $row['brandpermission'];
        }
        mysqli_stmt_close($stmt);

        // Compare if brand permissions have changed
        $newPermissions = $brandname; // The submitted new brand permissions array
        sort($existingPermissions);
        sort($newPermissions);

        if ($existingPermissions != $newPermissions) {
            // If permissions have changed, delete old ones and insert new ones

            // Delete old permissions
            $deleteQuery = "DELETE FROM brand_permissions WHERE user_id = ?";
            $stmtDelete = mysqli_prepare($conn, $deleteQuery);
            mysqli_stmt_bind_param($stmtDelete, "i", $userId);
            mysqli_stmt_execute($stmtDelete);
            mysqli_stmt_close($stmtDelete);

            // Insert new permissions
            $insertQuery = "INSERT INTO brand_permissions (user_id, brandpermission) VALUES (?, ?)";
            $stmtInsert = mysqli_prepare($conn, $insertQuery);

            foreach ($newPermissions as $permission) {
                mysqli_stmt_bind_param($stmtInsert, "is", $userId, $permission);
                mysqli_stmt_execute($stmtInsert);
            }
            mysqli_stmt_close($stmtInsert);

            // Log changes in brand permissions
            $logMessage = "{$_SESSION['user']} has updated the brand permissions for user: $name.";
            customLogToFile($logMessage, $logFileName);
        }

        header("Location: view-user");
        exit();
    } else {
        $_SESSION['eumessage'] = "Invalid request!";
        header("Location: view-user");
        exit();
    }
}

// End Edit user 

// Function to check if user data has changed and return changed fields
// Function to check if user data has changed and return changed fields with before and after values
function hasUserDataChanged($currentUserData, $name, $email, $role, $teamId, $shiftId, $system_status, $wfh)
{
    $changedFields = [];

    // Compare each field and add to changedFields only if it has changed
    if ($currentUserData['name'] !== $name) {
        $changedFields['Name'] = ['before' => $currentUserData['name'], 'after' => $name];
    }

    if ($currentUserData['email'] !== $email) {
        $changedFields['Email'] = ['before' => $currentUserData['email'], 'after' => $email];
    }

    if ($currentUserData['role'] !== $role) {
        $changedFields['Role'] = ['before' => $currentUserData['role'], 'after' => $role];
    }

    if ($currentUserData['team_Id'] !== $teamId) {
        $changedFields['Team ID'] = ['before' => $currentUserData['team_Id'], 'after' => $teamId];
    }

    if ($currentUserData['shift_id'] !== $shiftId) {
        $changedFields['Shift'] = ['before' => $currentUserData['shift_id'], 'after' => $shiftId];
    }

    if ($currentUserData['system_status'] !== $system_status) {
        $changedFields['System Status'] = ['before' => $currentUserData['system_status'], 'after' => $system_status];
    }

    if ($currentUserData['wfh'] !== $wfh) {
        $changedFields['Work From Home'] = ['before' => $currentUserData['wfh'], 'after' => $wfh];
    }

    return $changedFields;
}



// Delete User and Permissions
if (isset($_POST['action']) && $_POST['action'] === 'delete_user' && isset($_POST['userId']) && isset($_POST['inputKey'])) {
    error_log("Checkpoint: Delete request received with User ID: " . $_POST['userId']);  // Log for debugging

    $userId = $_POST['userId'];
    $deletepersonname = $_SESSION['user'];
    $inputKey = $_POST['inputKey'];
    $secret_key = 'XqzQh9G4Ju87Gqfy4xZkQzZ+2HdF0YqM/pjHoN6ITe0='; // Base64-encoded secret key

   

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
                // Log user and permissions deletion

                $logFileName = '../logs/user_deletion_log.txt'; // Ensure correct path to logs folder

                $logMessage = "The '$userName' account was deleted successfully by user: $deletepersonname";
                
                // Ensure the logs directory exists
                $logDir = realpath(__DIR__ . '/../logs');
                if ($logDir === false || !is_dir($logDir)) {
                    // Attempt to create the logs directory if it doesn't exist
                    $logDir = __DIR__ . '/../logs';
                    mkdir($logDir, 0755, true);
                }
                
                // Full path for log file
                $logFile = $logDir . '/' . $logFileName;
                
                // Create the log file if it doesn't exist
                if (!file_exists($logFile)) {
                    touch($logFile);
                }
                
                // Write the log message to the file
                file_put_contents($logFile, date('Y-m-d H:i:s') . ' - ' . $logMessage . PHP_EOL, FILE_APPEND);
                

                // Return success response
                echo json_encode(['status' => 'success', 'message' => 'User and permissions deleted successfully!']);
                error_log("Checkpoint: User deleted successfully."); 
            } catch (Exception $e) {
                mysqli_rollback($conn);
                error_log("Error during deletion: " . $e->getMessage());  
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

// End Delete User



// Start View Permissions

function getPermissionsData($conn)

{

    $permissionsv = array();

    // Fetch data from the view

    $viewQuery = "SELECT p.permissionid, p.view_lead, p.log_management, u.userId, u.name as username, u.role

FROM permissions p

JOIN user u ON p.user_id = u.userId 
WHERE p.del_status != 'Deleted'

 Order BY u.userID DESC";

$result = mysqli_query($conn, $viewQuery);

// Check if query execution failed
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

while ($row = mysqli_fetch_assoc($result)) {
    $permissionsv[] = $row;
}


    return $permissionsv;
}

// End View Permissions



// Start Edit Permissions 



if (isset($_POST['edit_permissions'])) {

    $per_id = $_POST['pd_id'];



    $editQuery = "SELECT p.*, u.name FROM permissions p JOIN user u ON p.user_id = u.userId WHERE p.permissionid = ?";

    $stmt = $conn->prepare($editQuery);
    if (!$stmt) {
        die('Error: ' . mysqli_error($conn));
    }

    $stmt->bind_param("i", $per_id);
    $stmt->execute();

    $editResult = $stmt->get_result();
    $editPermissionData = $editResult->fetch_assoc();
}





if (isset($_POST['update_permissions'])) {

    $permissionId = $_POST['permissionId'];



    $logManagement = isset($_POST['permissions']) && in_array('log_management', $_POST['permissions']) ? 'Allow' : 'Deny';

    $viewUsers = isset($_POST['permissions']) && in_array('view_users', $_POST['permissions']) ? 'Allow' : 'Deny';

    $addUser = isset($_POST['permissions']) && in_array('Add_user', $_POST['permissions']) ? 'Allow' : 'Deny';

    $addShift = isset($_POST['permissions']) && in_array('add_shift', $_POST['permissions']) ? 'Allow' : 'Deny';

    $viewShift = isset($_POST['permissions']) && in_array('view_shift', $_POST['permissions']) ? 'Allow' : 'Deny';

    $viewTeam = isset($_POST['permissions']) && in_array('view_team', $_POST['permissions']) ? 'Allow' : 'Deny';

    $addTeam = isset($_POST['permissions']) && in_array('add_team', $_POST['permissions']) ? 'Allow' : 'Deny';

    $addLead = isset($_POST['permissions']) && in_array('add_lead', $_POST['permissions']) ? 'Allow' : 'Deny';

    $viewLead = isset($_POST['permissions']) && in_array('view_lead', $_POST['permissions']) ? 'Allow' : 'Deny';

    $addcoreLead = isset($_POST['permissions']) && in_array('add_core_lead', $_POST['permissions']) ? 'Allow' : 'Deny';

    $viewcoreLead = isset($_POST['permissions']) && in_array('view_core_lead', $_POST['permissions']) ? 'Allow' : 'Deny';

    $viewOrder = isset($_POST['permissions']) && in_array('view_order', $_POST['permissions']) ? 'Allow' : 'Deny';

    $filter1 = isset($_POST['permissions']) && in_array('filter1', $_POST['permissions']) ? 'Allow' : 'Deny';

    $filter2 = isset($_POST['permissions']) && in_array('filter2', $_POST['permissions']) ? 'Allow' : 'Deny';

    $filter3 = isset($_POST['permissions']) && in_array('filter3', $_POST['permissions']) ? 'Allow' : 'Deny';





    $updateQuery = "UPDATE permissions SET  log_management = ?, view_users = ?, Add_user =?, add_shift = ?, view_shift = ?, view_team = ?, add_team = ?, add_lead = ?, view_lead = ?,add_core_lead = ?, view_core_lead = ?, view_order = ?, filter1 = ?, filter2 = ?, filter3 = ? WHERE permissionid = ?";

    $stmt = $conn->prepare($updateQuery);



    $stmt->bind_param("sssssssssssssssi", $logManagement, $viewUsers, $addUser, $addShift, $viewShift, $viewTeam, $addTeam, $addLead, $viewLead, $addcoreLead, $viewcoreLead, $viewOrder, $filter1, $filter2, $filter3, $permissionId);



    if ($stmt->execute()) {

        // Successfully updated permissions

        $_SESSION['epermission'] = 'Edit Permission SuccessFully!.';
        header("Location: view-permission");

        exit();
    } else {

        // Handle error

        $_SESSION['epermission'] = "Error updating permissions: " . $stmt->error;
    }



    $stmt->close();
}





// End Edit Permissions 





// Create Team Form

if (isset($_POST['create-team'])) {

    $teamName = $_POST['tname'];

    $teamLead = $_POST['tlead'];



    // Insert into team table

    $insertTeamQuery = "INSERT INTO team (team_name, team_lead) VALUES (?, ?)";

    $stmtTeam = mysqli_prepare($conn, $insertTeamQuery);

    mysqli_stmt_bind_param($stmtTeam, "si", $teamName, $teamLead);



    // Execute the statement and check for success

    $executeResult = mysqli_stmt_execute($stmtTeam);



    // Close statement

    mysqli_stmt_close($stmtTeam);



    if ($executeResult) {

        $_SESSION['Createteam'] = 'Team created successfully!.';
    } else {

        $_SESSION['Createteam'] = 'Error creating team. Please try again.';
    }
}



// Function to get teams from the database with team lead names

function getTeamsRecords($conn)

{

    $teams = array();

    $query = "SELECT t.teamId, t.team_name, t.team_lead, u.name as team_lead_name 

              FROM team t

              INNER JOIN user u ON t.team_lead = u.userId";

    $result = mysqli_query($conn, $query);



    while ($row = mysqli_fetch_assoc($result)) {

        $teams[] = $row;
    }



    return $teams;
}





// Start Fetch Edit team details

function getTeamDetails($conn, $teamId)

{

    $query = "SELECT team_name, team_lead FROM team WHERE teamId = ?";

    $stmt = mysqli_prepare($conn, $query);

    mysqli_stmt_bind_param($stmt, "i", $teamId);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $teamDetails = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);



    return $teamDetails;
}





if (isset($_POST['edit_team'])) {

    $teamId = $_POST['team_id'];



    $teamDetails = getTeamDetails($conn, $teamId);
}

// End Fetch Edit team details



// Start Update Team 

if (isset($_POST['update_team'])) {

    $teamId = $_POST['team_id'];

    $teamName = $_POST['team_name'];

    $teamLead = $_POST['team_lead'];



    $updateTeamQuery = "UPDATE team SET team_name = ?, team_lead = ? WHERE teamId = ?";

    $stmtUpdateTeam = mysqli_prepare($conn, $updateTeamQuery);

    mysqli_stmt_bind_param($stmtUpdateTeam, "ssi", $teamName, $teamLead, $teamId);

    $executeResult = mysqli_stmt_execute($stmtUpdateTeam);

    mysqli_stmt_close($stmtUpdateTeam);



    if ($executeResult) {

        $_SESSION['up_team'] = 'Team updated successfully!.';
        header("Location: view-team");
    } else {

        $_SESSION['up_team'] = 'Error updating team. Please try again.';
        header("Location: view-team");
    }
}

// End Update Team 



// Delete  Team 

if (isset($_POST['delete_team'])) {

    $teamId = $_POST['team_id'];



    // Delete the team from the database

    $deleteQuery = "DELETE FROM team WHERE teamId = ?";

    $stmt = mysqli_prepare($conn, $deleteQuery);

    mysqli_stmt_bind_param($stmt, "i", $teamId);

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);



    $_SESSION['delteam'] = "Team deleted successfully!";
}

// End Delete  Team 





// Start Create Shift 

if (isset($_POST['create_shift'])) {

    $shiftType = $_POST['shift_type'];

    // $startTiming = $_POST['start_timing'];

    // $endTiming = $_POST['end_timing'];



    $insertShiftQuery = "INSERT INTO shift (shift_type) VALUES (?)";

    $stmtShift = mysqli_prepare($conn, $insertShiftQuery);

    mysqli_stmt_bind_param($stmtShift, "s", $shiftType);

    $executeResult = mysqli_stmt_execute($stmtShift);



    mysqli_stmt_close($stmtShift);

    if ($executeResult) {

        $_SESSION['ShiftCreate'] = 'Shift created successfully!';
    } else {

        $_SESSION['ShiftCreate'] = 'Error creating shift. Please try again.';
    }
}

// End Create Shift



// Function to fetch possible ENUM values for a given column

function fetchEnumValues($conn, $table, $column)

{

    $enumValues = array();



    $query = "SHOW COLUMNS FROM $table LIKE '$column'";

    $result = mysqli_query($conn, $query);

    $row = mysqli_fetch_assoc($result);



    $enumDefinition = $row['Type'];

    preg_match("/^enum\(\'(.*)\'\)$/", $enumDefinition, $matches);



    if (isset($matches[1])) {

        $enumValues = explode("','", $matches[1]);
    }



    return $enumValues;
}


function getShiftsRecords($conn)
{
    $shifts = array();
    $query = "SELECT shiftId, shift_type, start_timing, end_timing FROM shift";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Error handling
        echo "Error: " . mysqli_error($conn);
        // You might want to handle the error more gracefully, like logging it or returning an empty array
        return $shifts;
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $shifts[] = $row;
    }

    return $shifts;
}


// Start Edit Shift Form

if (isset($_POST['edit_shift'])) {

    $shiftId = $_POST['shift_id'];



    // Fetch shift data for editing

    $selectShiftQuery = "SELECT * FROM shift WHERE shiftId = ?";

    $stmtSelectShift = mysqli_prepare($conn, $selectShiftQuery);

    mysqli_stmt_bind_param($stmtSelectShift, "i", $shiftId);

    mysqli_stmt_execute($stmtSelectShift);

    $result = mysqli_stmt_get_result($stmtSelectShift);

    $shiftData = mysqli_fetch_assoc($result);
}



if (isset($_POST['update_shift'])) {

    $shiftId = $_POST['shift_id'];

    $shiftType = $_POST['shift_type'];

    // $startTiming = $_POST['start_timing'];

    // $endTiming = $_POST['end_timing'];

    date_default_timezone_set('Asia/Karachi');



    $updateShiftQuery = "UPDATE shift SET shift_type = ? WHERE shiftId = ?";

    $stmtUpdateShift = mysqli_prepare($conn, $updateShiftQuery);

    mysqli_stmt_bind_param($stmtUpdateShift, "si", $shiftType, $shiftId);

    $executeResult = mysqli_stmt_execute($stmtUpdateShift);



    // Close statement

    mysqli_stmt_close($stmtUpdateShift);



    if ($executeResult) {

        $_SESSION['editshift'] = 'Shift updated successfully!.';
        header("Location: view-shift");
    } else {

        $_SESSION['editshift'] = 'Error updating shift. Please try again.';
        header("Location: view-shift");
    }
}

// End Edit Shift Form



// Start Shift Delete 

if (isset($_POST['delete_shift'])) {

    $shiftIdToDelete = $_POST['shift_id'];



    // Delete from Shift table

    $deleteShiftQuery = "DELETE FROM shift WHERE shiftId = ?";

    $stmtDeleteShift = mysqli_prepare($conn, $deleteShiftQuery);

    mysqli_stmt_bind_param($stmtDeleteShift, "i", $shiftIdToDelete);

    $executeResult = mysqli_stmt_execute($stmtDeleteShift);



    mysqli_stmt_close($stmtDeleteShift);



    if ($executeResult) {

        $_SESSION['delshift'] = 'Shift Deleted successfully!.';
    } else {

        $_SESSION['delshift'] = 'Error deleting shift. Please try again.';
    }
}

// End Shift Delete 



// Start create lead

if (isset($_POST["create_lead"])) {

    // Retrieve form data
    date_default_timezone_set('Asia/Karachi');

    $campId = $_POST["campId"];
    $clientName = $_POST["client_name"];
    $clientContactNumber = $_POST["client_contact_number"];
    $leadLandingDate = date("Y-m-d");
    $clientCountry = $_POST["client_country"];
    $client_email = $_POST["client_email"];
    $userId = $_POST["user_id"];
    $creator_name = $_POST["creator_name"];
    $client_info = $_POST["client_info"];
    $lsource = $_POST["lsource"];
    $brandname = $_POST["brandname"];
    $whatsappname = $_POST["whatsappname"];
    $referClientName = $_POST["clientName"];
    $platform = $_POST["platform"];
    $lead_type = "Live";

    // Insert data into leads table
    if ($lsource == "Refer") {
        $insertLeadQuery = "INSERT INTO leads (campId, client_name, client_contact_number, lead_landing_date, client_country, client_email, client_info, lead_source, brand_name, whatsapp_name, refer_client_name, lead_type, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmtInsertLead = mysqli_prepare($conn, $insertLeadQuery);
        if ($stmtInsertLead === false) {
            // Debug: Display error if prepare failed
            echo "Failed to prepare the statement: " . mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmtInsertLead, "ssssssssssssi", $campId, $clientName, $clientContactNumber, $leadLandingDate, $clientCountry, $client_email, $client_info, $lsource, $brandname, $whatsappname, $referClientName, $lead_type, $userId);
    } elseif ($lsource == "Social Media Marketing") {
        $insertLeadQuery = "INSERT INTO leads (campId, client_name, client_contact_number, lead_landing_date, client_country, client_email, client_info, lead_source, brand_name, whatsapp_name, platform, lead_type, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmtInsertLead = mysqli_prepare($conn, $insertLeadQuery);
        if ($stmtInsertLead === false) {
            // Debug: Display error if prepare failed
            echo "Failed to prepare the statement: " . mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmtInsertLead, "ssssssssssssi", $campId, $clientName, $clientContactNumber, $leadLandingDate, $clientCountry, $client_email, $client_info, $lsource, $brandname, $whatsappname, $platform, $lead_type, $userId);
    } else {
        $insertLeadQuery = "INSERT INTO leads (campId, client_name, client_contact_number, lead_landing_date, client_country, client_email, client_info, lead_source, brand_name, whatsapp_name, lead_type, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmtInsertLead = mysqli_prepare($conn, $insertLeadQuery);
        if ($stmtInsertLead === false) {
            // Debug: Display error if prepare failed
            echo "Failed to prepare the statement: " . mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmtInsertLead, "sssssssssssi", $campId, $clientName, $clientContactNumber, $leadLandingDate, $clientCountry, $client_email, $client_info, $lsource, $brandname, $whatsappname, $lead_type, $userId);
    }

    // Execute the statement
    if (mysqli_stmt_execute($stmtInsertLead)) {
        // Log lead creation with a dynamically specified log file name
        $logMessage = "$creator_name Created The Lead - Client Name: $clientName, Client Contact Number: $clientContactNumber, Lead Landing Date: $leadLandingDate";
        $logFileName = 'lead_created_log.txt';
        customLogToFile($logMessage, $logFileName);

        $_SESSION['adlead'] = 'Lead created successfully!.';
    } else {
        // Output error if execution failed
        echo "Error creating lead: " . mysqli_error($conn);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmtInsertLead);
}


// End create lead 


// Start Edit Lead

if (isset($_POST['edit_lead'])) {

    $l_id = $_POST['l_id'];



    $selectedleadid = "SELECT * from leads where id = ?";

    $stmtSelectLeadSource = mysqli_prepare($conn, $selectedleadid);

    mysqli_stmt_bind_param($stmtSelectLeadSource, "i", $l_id);

    mysqli_stmt_execute($stmtSelectLeadSource);

    $result = mysqli_stmt_get_result($stmtSelectLeadSource);

    $leadSourceData = mysqli_fetch_assoc($result);
}




// Check if the update_lead form is submitted
if (isset($_POST['update_lead'])) {

    // Fetch the lead ID
    $l_id = $_POST['l_id']; // Make sure this is passed correctly from the form

    // Fetch form data
    $creator_name = $_POST["creator_name"];
    $campId = $_POST['campId'];
    $clientName = $_POST['client_name'];
    $clientContactNumber = $_POST['client_contact_number'];
    $clientCountry = $_POST['client_country'];
    $client_email = $_POST['client_email'];
    $client_info = $_POST['client_info'];
    $lsource = $_POST['lsource'];
    $brandName = $_POST['brandname'];
    $whatsappName = $_POST['whatsappname'];
    $referClientName = $_POST['RclientName'];
    $platform = $_POST['platform'];
    $referClientNamenull = '';
    $platformnull = '';

    // Retrieve the current lead information from the database
    $currentLeadInfo = getLeadInfo($l_id);

    // Prepare a log message and changes array
    $logMessage = "$creator_name updated lead: ";
    $logChanges = [];

    // Compare each field and log changes if there's a difference
    if ($currentLeadInfo['campId'] !== $campId) {
        $logChanges[] = "Camp ID: {$currentLeadInfo['campId']} to $campId";
    }
    if ($currentLeadInfo['client_name'] !== $clientName) {
        $logChanges[] = "Client Name: {$currentLeadInfo['client_name']} to $clientName";
    }
    if ($currentLeadInfo['client_contact_number'] !== $clientContactNumber) {
        $logChanges[] = "Client Contact Number: {$currentLeadInfo['client_contact_number']} to $clientContactNumber";
    }
    if ($currentLeadInfo['client_country'] !== $clientCountry) {
        $logChanges[] = "Client Country: {$currentLeadInfo['client_country']} to $clientCountry";
    }
    if ($currentLeadInfo['client_info'] !== $client_info) {
        $logChanges[] = "Client Info: {$currentLeadInfo['client_info']} to $client_info";
    }
    if ($currentLeadInfo['lead_source'] !== $lsource) {
        $logChanges[] = "Lead Source: {$currentLeadInfo['lead_source']} to $lsource";
    }
    if ($currentLeadInfo['brand_name'] !== $brandName) {
        $logChanges[] = "Brand Name: {$currentLeadInfo['brand_name']} to $brandName";
    }
    if ($currentLeadInfo['whatsapp_name'] !== $whatsappName) {
        $logChanges[] = "WhatsApp Name: {$currentLeadInfo['whatsapp_name']} to $whatsappName";
    }
    if ($currentLeadInfo['refer_client_name'] !== $referClientName) {
        $logChanges[] = "Refer Client Name: {$currentLeadInfo['refer_client_name']} to $referClientName";
    }
    if ($currentLeadInfo['platform'] !== $platform) {
        $logChanges[] = "PlatForm: {$currentLeadInfo['platform']} to $platform";
    }

    // Log the changes
    if (!empty($logChanges)) {
        $logMessage .= implode(", ", $logChanges);
        $logFileName = 'lead_update_log.txt';
        customLogToFile($logMessage, $logFileName);
    }

    if ($lsource == "Refer") {

        // Update the lead information in the database
        $updateLeadQuery = "UPDATE leads SET campId = ?, client_name = ?, client_contact_number = ?, client_country = ?, client_email = ?, client_info = ?, lead_source = ?, brand_name = ?, whatsapp_name = ?, refer_client_name = ? WHERE id = ?";


        $stmtUpdateQuery = mysqli_prepare($conn, $updateLeadQuery);

        // Bind the parameters to the query
        mysqli_stmt_bind_param($stmtUpdateQuery, "ssssssssssi", $campId, $clientName, $clientContactNumber, $clientCountry, $client_email, $client_info, $lsource, $brandName, $whatsappName, $referClientName, $l_id);
    } elseif ($lsource == "Social Media Marketing") {

        $updateLeadQuery = "UPDATE leads SET campId = ?, client_name = ?, client_contact_number = ?, client_country = ?, client_email = ?, client_info = ?, lead_source = ?, brand_name = ?, whatsapp_name = ?, platform = ? WHERE id = ?";


        $stmtUpdateQuery = mysqli_prepare($conn, $updateLeadQuery);

        // Bind the parameters to the query
        mysqli_stmt_bind_param($stmtUpdateQuery, "ssssssssssi", $campId, $clientName, $clientContactNumber, $clientCountry, $client_email, $client_info, $lsource, $brandName, $whatsappName, $platform, $l_id);
    } else {
        // Update the lead information in the database
        $updateLeadQuery = "UPDATE leads SET campId = ?, client_name = ?, client_contact_number = ?, client_country = ?, client_email = ?, client_info = ?, lead_source = ?, brand_name = ?, whatsapp_name = ?, refer_client_name = ?, platform = ? WHERE id = ?";


        $stmtUpdateQuery = mysqli_prepare($conn, $updateLeadQuery);

        // Bind the parameters to the query
        mysqli_stmt_bind_param($stmtUpdateQuery, "sssssssssssi", $campId, $clientName, $clientContactNumber, $clientCountry, $client_email, $client_info, $lsource, $brandName, $whatsappName, $referClientNamenull, $platformnull, $l_id);
    }


    // Execute the query and check the result
    if (mysqli_stmt_execute($stmtUpdateQuery)) {
        $_SESSION['elead'] = 'Successfully updated!.';
        header("Location: view-leads");
        exit(); // Make sure to stop script execution after redirection
    } else {
        // Capture any error and store in session
        $_SESSION['elead'] = 'Something went wrong: ' . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmtUpdateQuery);
}

// Function to retrieve lead information
function getLeadInfo($leadId)
{
    global $conn;

    $sql = "SELECT campId, client_name, client_contact_number, client_country, client_email, client_info, lead_source, brand_name, whatsapp_name, refer_client_name FROM leads WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $leadId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $leadInfo = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return $leadInfo;
}




// Start Delete Leads

if (isset($_POST['action']) && $_POST['action'] === 'delete_live_lead' && isset($_POST['l_id']) && isset($_POST['inputKey'])) {
    $leadIdDelete = $_POST['l_id'];
    $inputKey = $_POST['inputKey'];
    $creator_name = $_POST['creator_name'];
    $leadstatus = "Deleted";
    $secret_key = 'XqzQh9G4Ju87Gqfy4xZkQzZ+2HdF0YqM/pjHoN6ITe0='; // Your base64-encoded secret key
    date_default_timezone_set('Asia/Karachi');

    // Fetch and decrypt the key from the delete_keys table
    $sql = "SELECT `key` FROM delete_keys WHERE id = 3"; // Adjust the ID as needed
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dbKey = decrypt($row['key'], $secret_key); // Assuming you have the decrypt function

        // Validate the key
        if ($inputKey === $dbKey) {
            // Retrieve lead information before deletion
            $leadToDelete = getLeadInfo($leadIdDelete);
            
            // Update the lead's status
            $deleteLeadQuery = "UPDATE leads SET del_status = ? WHERE id = ?";
            $stmtDeleteLead = mysqli_prepare($conn, $deleteLeadQuery);
            mysqli_stmt_bind_param($stmtDeleteLead, "si", $leadstatus, $leadIdDelete);
            $executeResult = mysqli_stmt_execute($stmtDeleteLead);
            mysqli_stmt_close($stmtDeleteLead);

            if ($executeResult) {
                // Log lead deletion
                $logMessage = "$creator_name has deleted Lead - ID: $leadIdDelete, Client Name: {$leadToDelete['client_name']}, Client Contact Number: {$leadToDelete['client_contact_number']}, Client Country: {$leadToDelete['client_country']}";
                $logFileName = '../logs/lead_deleted_log.txt';
                file_put_contents($logFileName, date('Y-m-d H:i:s') . ' - ' . $logMessage . PHP_EOL, FILE_APPEND);

                echo json_encode(['status' => 'success', 'message' => 'Lead deleted successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error deleting lead. Please try again.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Incorrect deletion key.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Deletion key not found.']);
    }

    exit();
}




// Start create Core lead

if (isset($_POST["create_core_lead"])) {
    // Retrieve form data
    date_default_timezone_set('Asia/Karachi');

    $campId = $_POST["campId"];
    $clientName = $_POST["client_name"];
    $clientContactNumber = $_POST["client_contact_number"];
    $leadLandingDate = date("Y-m-d");
    $clientCountry = $_POST["client_country"];
    $client_email = $_POST["client_email"];
    $userId = $_POST["user_id"];
    $creator_name = $_POST["creator_name"];
    $client_info = $_POST["client_info"];
    $lsource = $_POST["lsource"];
    $brandname = $_POST["brandname"];
    $whatsappname = $_POST["whatsappname"];
    $referClientName = $_POST["clientName"];
    $platform = $_POST["platform"];
    $lead_type = "Core";

    // Insert data into core_leads table
    if ($lsource == "Refer") {
        $insertLeadQuery = "INSERT INTO core_leads 
        (campId, client_name, client_contact_number, lead_landing_date, client_country, client_email, client_info, lead_source, brand_name, whatsapp_name, refer_client_name, lead_type, user_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; // Added the missing comma here

        $stmtInsertLead = mysqli_prepare($conn, $insertLeadQuery);
        if ($stmtInsertLead === false) {
            // Debug: Display error if prepare failed
            echo "Failed to prepare the statement: " . mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmtInsertLead, "ssssssssssssi", $campId, $clientName, $clientContactNumber, $leadLandingDate, $clientCountry, $client_email, $client_info, $lsource, $brandname, $whatsappname, $referClientName, $lead_type, $userId);
    } elseif ($lsource == "Social Media Marketing") {
        $insertLeadQuery = "INSERT INTO core_leads 
        (campId, client_name, client_contact_number, lead_landing_date, client_country, client_email, client_info, lead_source, brand_name, whatsapp_name, platform, lead_type, user_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; // Added the missing comma here

        $stmtInsertLead = mysqli_prepare($conn, $insertLeadQuery);
        if ($stmtInsertLead === false) {
            // Debug: Display error if prepare failed
            echo "Failed to prepare the statement: " . mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmtInsertLead, "ssssssssssssi", $campId, $clientName, $clientContactNumber, $leadLandingDate, $clientCountry, $client_email, $client_info, $lsource, $brandname, $whatsappname, $platform, $lead_type, $userId);
    } else {
        $insertLeadQuery = "INSERT INTO core_leads 
        (campId, client_name, client_contact_number, lead_landing_date, client_country, client_email, client_info, lead_source, brand_name, whatsapp_name, lead_type, user_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"; // Added the missing comma here

        $stmtInsertLead = mysqli_prepare($conn, $insertLeadQuery);
        if ($stmtInsertLead === false) {
            // Debug: Display error if prepare failed
            echo "Failed to prepare the statement: " . mysqli_error($conn);
            exit();
        }

        mysqli_stmt_bind_param($stmtInsertLead, "sssssssssssi", $campId, $clientName, $clientContactNumber, $leadLandingDate, $clientCountry, $client_email, $client_info, $lsource, $brandname, $whatsappname, $lead_type, $userId);
    }

    // Execute the statement
    if (mysqli_stmt_execute($stmtInsertLead)) {
        // Log lead creation with a dynamically specified log file name
        $logMessage = "$creator_name Created The Lead - Client Name: $clientName, Client Contact Number: $clientContactNumber, Lead Landing Date: $leadLandingDate";
        $logFileName = 'core_lead_created_log.txt';
        customLogToFile($logMessage, $logFileName);

        $_SESSION['adCorelead'] = 'Core Lead created successfully!';
    } else {
        // Output error if execution failed
        echo "Error creating core lead: " . mysqli_error($conn);
    }

    // Close the prepared statement
    mysqli_stmt_close($stmtInsertLead);
}

// End create Core lead 

// SIngle View Core Leads
function getDetailsForSelectedcoreleads($conn, $leadid)
{
    $leadid = mysqli_real_escape_string($conn, $leadid);
    $query = "SELECT * FROM `core_leads`  LEFT JOIN user ON `core_leads`.user_id = user.userId 
              WHERE `core_leads`.id = '$leadid'";


    $result = mysqli_query($conn, $query);
    if (!$result) {

        die("Query execution failed: " . mysqli_error($conn));
    }
    return mysqli_fetch_assoc($result);
}
// End  SIngle View Core Leads

// Start Edit Lead

if (isset($_POST['edit_core_lead'])) {

    $l_id = $_POST['l_id'];



    $selectedleadid = "SELECT * from core_leads where id = ?";

    $stmtSelectLeadSource = mysqli_prepare($conn, $selectedleadid);

    mysqli_stmt_bind_param($stmtSelectLeadSource, "i", $l_id);

    mysqli_stmt_execute($stmtSelectLeadSource);

    $result = mysqli_stmt_get_result($stmtSelectLeadSource);

    $leadSourceData = mysqli_fetch_assoc($result);
}




// Check if the update_lead form is submitted
if (isset($_POST['update_core_lead'])) {

    // Fetch the lead ID
    $l_id = $_POST['l_id']; // Make sure this is passed correctly from the form

    // Fetch form data
    $creator_name = $_POST["creator_name"];
    $campId = $_POST['campId'];
    $clientName = $_POST['client_name'];
    $clientContactNumber = $_POST['client_contact_number'];
    $clientCountry = $_POST['client_country'];
    $client_email = $_POST['client_email'];
    $client_info = $_POST['client_info'];
    $lsource = $_POST['lsource'];
    $brandName = $_POST['brandname'];
    $whatsappName = $_POST['whatsappname'];
    $referClientName = $_POST['clientName'];
    $platform = $_POST['platform'];
    $referClientNamenull = '';
    $platformnull = '';

    // Retrieve the current lead information from the database
    $currentLeadInfo = getCoreLeadInfo($l_id);

    // Prepare a log message and changes array
    $logMessage = "$creator_name updated lead: ";
    $logChanges = [];

    // Compare each field and log changes if there's a difference
    if ($currentLeadInfo['campId'] !== $campId) {
        $logChanges[] = "Camp ID: {$currentLeadInfo['campId']} to $campId";
    }
    if ($currentLeadInfo['client_name'] !== $clientName) {
        $logChanges[] = "Client Name: {$currentLeadInfo['client_name']} to $clientName";
    }
    if ($currentLeadInfo['client_contact_number'] !== $clientContactNumber) {
        $logChanges[] = "Client Contact Number: {$currentLeadInfo['client_contact_number']} to $clientContactNumber";
    }
    if ($currentLeadInfo['client_country'] !== $clientCountry) {
        $logChanges[] = "Client Country: {$currentLeadInfo['client_country']} to $clientCountry";
    }
    if ($currentLeadInfo['client_info'] !== $client_info) {
        $logChanges[] = "Client Info: {$currentLeadInfo['client_info']} to $client_info";
    }
    if ($currentLeadInfo['lead_source'] !== $lsource) {
        $logChanges[] = "Lead Source: {$currentLeadInfo['lead_source']} to $lsource";
    }
    if ($currentLeadInfo['brand_name'] !== $brandName) {
        $logChanges[] = "Brand Name: {$currentLeadInfo['brand_name']} to $brandName";
    }
    if ($currentLeadInfo['whatsapp_name'] !== $whatsappName) {
        $logChanges[] = "WhatsApp Name: {$currentLeadInfo['whatsapp_name']} to $whatsappName";
    }
    if ($currentLeadInfo['refer_client_name'] !== $referClientName) {
        $logChanges[] = "Refer Client Name: {$currentLeadInfo['refer_client_name']} to $referClientName";
    }
    if ($currentLeadInfo['platform'] !== $referClientName) {
        $logChanges[] = "PlatForm: {$currentLeadInfo['platform']} to $platform";
    }

    // Log the changes
    if (!empty($logChanges)) {
        $logMessage .= implode(", ", $logChanges);
        $logFileName = 'core_lead_update_log.txt';
        customLogToFile($logMessage, $logFileName);
    }

    if ($lsource == "Refer") {

        // Update the lead information in the database
        $updateLeadQuery = "UPDATE core_leads SET campId = ?, client_name = ?, client_contact_number = ?, client_country = ?, client_email = ?, client_info = ?, lead_source = ?, brand_name = ?, whatsapp_name = ?, refer_client_name = ? WHERE id = ?";


        $stmtUpdateQuery = mysqli_prepare($conn, $updateLeadQuery);

        // Bind the parameters to the query
        mysqli_stmt_bind_param($stmtUpdateQuery, "ssssssssssi", $campId, $clientName, $clientContactNumber, $clientCountry, $client_email, $client_info, $lsource, $brandName, $whatsappName, $referClientName, $l_id);
    } elseif ($lsource == "Socail Media Marketing") {
        // Update the lead information in the database
        $updateLeadQuery = "UPDATE core_leads SET campId = ?, client_name = ?, client_contact_number = ?, client_country = ?, client_email = ?, client_info = ?, lead_source = ?, brand_name = ?, whatsapp_name = ?, platform = ? WHERE id = ?";


        $stmtUpdateQuery = mysqli_prepare($conn, $updateLeadQuery);

        // Bind the parameters to the query
        mysqli_stmt_bind_param($stmtUpdateQuery, "ssssssssssi", $campId, $clientName, $clientContactNumber, $clientCountry, $client_email, $client_info, $lsource, $brandName, $whatsappName, $platform, $l_id);
    } else {
        // Update the lead information in the database
        $updateLeadQuery = "UPDATE core_leads SET campId = ?, client_name = ?, client_contact_number = ?, client_country = ?, client_email = ?, client_info = ?, lead_source = ?, brand_name = ?, whatsapp_name = ?, refer_client_name = ?, platform = ? WHERE id = ?";


        $stmtUpdateQuery = mysqli_prepare($conn, $updateLeadQuery);

        // Bind the parameters to the query
        mysqli_stmt_bind_param($stmtUpdateQuery, "sssssssssssi", $campId, $clientName, $clientContactNumber, $clientCountry, $client_email, $client_info, $lsource, $brandName, $whatsappName, $referClientNamenull, $platformnull, $l_id);
    }


    // Execute the query and check the result
    if (mysqli_stmt_execute($stmtUpdateQuery)) {
        $_SESSION['ecorelead'] = 'Successfully updated!.';
        header("Location: view-core-leads");
        exit(); // Make sure to stop script execution after redirection
    } else {
        // Capture any error and store in session
        $_SESSION['ecorelead'] = 'Something went wrong: ' . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmtUpdateQuery);
}

// Function to retrieve lead information
function getCoreLeadInfo($leadId)
{
    global $conn;

    $sql = "SELECT campId, client_name, client_contact_number, client_country, client_email, client_info, lead_source, brand_name, whatsapp_name, refer_client_name, platform FROM core_leads WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $leadId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $leadInfo = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);

    return $leadInfo;
}

// Start Delete Core Leads

// if (isset($_POST['core_lead_delete'])) {

//     $leadIdDelete = $_POST['l_id'];

//     $creator_name = $_POST['creator_name'];

//     $leadstatus = "Deleted";


//     // Retrieve lead information before deletion

//     $leadToDelete = getLeadInfo($leadIdDelete);


//     // Delete from Shift table

//     $deleteShiftQuery = "UPDATE core_leads SET del_status = ? WHERE id = ?";

//     $stmtDeleteShift = mysqli_prepare($conn, $deleteShiftQuery);

//     mysqli_stmt_bind_param($stmtDeleteShift, "si", $leadstatus, $leadIdDelete);

//     $executeResult = mysqli_stmt_execute($stmtDeleteShift);



//     mysqli_stmt_close($stmtDeleteShift);



//     if ($executeResult) {

//         // Log lead deletion

//         $logMessage = "$creator_name has deleted Lead - ID: $leadIdDelete, Client Name: {$leadToDelete['client_name']}, Client Contact Number: {$leadToDelete['client_contact_number']}, Client Country: {$leadToDelete['client_country']}";

//         $logFileName = 'core_lead_deleted_log.txt';

//         customLogToFile($logMessage, $logFileName);



//         $_SESSION['dlead'] = 'Lead deleted successfully!.';
//     } else {

//         $_SESSION['dlead'] = 'Error deleting lead. Please try again.';
//     }
// }


if (isset($_POST['action']) && $_POST['action'] === 'delete_lead' && isset($_POST['l_id']) && isset($_POST['inputKey'])) {
    $leadIdDelete = $_POST['l_id'];
    $inputKey = $_POST['inputKey'];
    $creator_name = $_POST['creator_name'];
    $leadstatus = "Deleted";
    $secret_key = 'XqzQh9G4Ju87Gqfy4xZkQzZ+2HdF0YqM/pjHoN6ITe0='; // Your base64-encoded secret key

    // Fetch and decrypt the key from the delete_keys table
    $sql = "SELECT `key` FROM delete_keys WHERE id = 5"; // Adjust the ID as needed
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dbKey = decrypt($row['key'], $secret_key); // Assuming you have the decrypt function

        // Validate the key
        if ($inputKey === $dbKey) {
            // Retrieve lead information before deletion
            $leadToDelete = getLeadInfo($leadIdDelete);
            
            // Update the lead's status
            $deleteLeadQuery = "UPDATE core_leads SET del_status = ? WHERE id = ?";
            $stmtDeleteLead = mysqli_prepare($conn, $deleteLeadQuery);
            mysqli_stmt_bind_param($stmtDeleteLead, "si", $leadstatus, $leadIdDelete);
            $executeResultss = mysqli_stmt_execute($stmtDeleteLead);
            mysqli_stmt_close($stmtDeleteLead);

            if ($executeResultss) {
                // Log lead deletion
                $logMessage = "$creator_name has deleted Lead - ID: $leadIdDelete, Client Name: {$leadToDelete['client_name']}, Client Contact Number: {$leadToDelete['client_contact_number']}, Client Country: {$leadToDelete['client_country']}";
                $logFileName = '../logs/core_lead_deleted_log.txt'; // Define the log file path
                file_put_contents($logFileName, date('Y-m-d H:i:s') . ' - ' . $logMessage . PHP_EOL, FILE_APPEND);

                echo json_encode(['status' => 'success', 'message' => 'Lead deleted successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error deleting lead. Please try again.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Incorrect deletion key.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Deletion key not found.']);
    }

    exit();
}
    // Include the encryption and decryption functions
    function encrypt($data, $key)
    {
        $encryption_key = base64_decode($key);
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
        return base64_encode($encrypted . '::' . $iv);
    }
// Decrypt function
function decrypt($data, $key) {
    $encryption_key = base64_decode($key);
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
}

// End Delete Core Leads



// Start create Order

if (isset($_POST['create-order'])) {



    $leadid = $_POST['leadid'];

    $order_id_input = $_POST['order_id_input'];

    $order_title = $_POST['order_title'];

    $order_status = $_POST['order_status'];
    $payment_status = $_POST['payment_status'];

    $word_count = $_POST['word_count'];

    $pending_payment = $_POST['pending_payment'];

    $receive_payment = $_POST['receive_payment'];

    $currency = $_POST['currency'];

    $whatsapp_account = $_POST['whatsapp_account'];

    $payment_account = $_POST['payment_account'];

    $portal_due_date = $_POST['portal_due_date'];

    $final_deadline_time = date("Y-m-d h:i:s", strtotime($_POST['final_deadline_time']));

    $order_confirmation_date = date("Y-m-d", strtotime($_POST['order_confirmation_date']));

    $order_confirmation_month = date("F", strtotime($_POST['order_confirmation_date']));
    $pending_payment_status = $_POST['pending_payment_status'];


    date_default_timezone_set('Asia/Karachi');



    $writers_team = $_POST['writers_team'];

    $plan = $_POST['plan'];

    $assigned_to = $_POST['assigned_to'];

    $year = date('Y');
    $years = $_POST['years'];
    $comment = $_POST['comment'];

    $client_requirements = $_POST['client_requirements'];

    $user_id = $_POST['user_id'];

    $creator_name = $_POST['creator_name'];



    // Insert data into `order` table

    $sql = "INSERT INTO `order` (

        order_title,order_id_input, order_status, payment_status, word_count, pending_payment, receive_payment,

        currency, whatsapp_account, payment_account, portal_due_date, final_deadline_time,

        order_confirmation_date, pending_payment_status, writers_team, plan, assigned_to, year, years, comment, client_requirements,

        order_confirmation_month, user_id, lead_id)

    VALUES ('$order_title','$order_id_input', '$order_status', '$payment_status', $word_count, $pending_payment, $receive_payment, '$currency', '$whatsapp_account', '$payment_account', '$portal_due_date', '$final_deadline_time', '$order_confirmation_date','$pending_payment_status', '$writers_team', '$plan', '$assigned_to', $year, $years, '$comment','$client_requirements', '$order_confirmation_month', $user_id, $leadid)";




    if ($conn->query($sql) === TRUE) {

        // Log order creation

        $logMessage = "creator_name Created The  Order - Order ID: $order_id_input, Order Title: $order_title";

        $logFileName = 'order_created_log.txt';

        customLogToFile($logMessage, $logFileName);

        header("Location: view-orders");
        $_SESSION['CreateOrder'] = 'Order created successfully!.';
    } else {

        $_SESSION['CreateOrder'] = 'Error: ' . $sql . '<br>' . $conn->error;
    }
}

// End create Order
// Start Convert core leads

if (isset($_POST['create-corelead-order'])) {

    $leadid = $_POST['l_id'];
    $query = "SELECT * FROM core_leads WHERE id = $leadid";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch the result as an associative array
        $row = mysqli_fetch_assoc($result);

        date_default_timezone_set('Asia/Karachi');

        // Assign fetched values to variables
        $campId = $row["campId"];
        $clientName = $row["client_name"];
        $clientContactNumber = $row["client_contact_number"];
        $leadLandingDate = $row["lead_landing_date"];
        $clientCountry = $row["client_country"];
        $client_email = $row["client_email"];
        $userId = $row["user_id"];
        // $creator_name = $row["creator_name"];
        $client_info = $row["client_info"];
        $lsource = $row["lead_source"];
        $brandname = $row["brand_name"];
        $whatsappname = $row["whatsapp_name"];
        $referClientName = $row["client_name"];
        $lead_type = $row["lead_type"];

        // Prepare and bind the insert statement based on whether referClientName exists
        if ($referClientName != '') {
            $insertLeadQuery = "INSERT INTO leads (campId, client_name, client_contact_number, lead_landing_date, client_country, client_email, client_info, lead_source, brand_name, whatsapp_name, refer_client_name, lead_type, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmtInsertLead = mysqli_prepare($conn, $insertLeadQuery);
            if ($stmtInsertLead === false) {
                echo "Failed to prepare the statement: " . mysqli_error($conn);
                exit();
            }

            mysqli_stmt_bind_param($stmtInsertLead, "ssssssssssssi", $campId, $clientName, $clientContactNumber, $leadLandingDate, $clientCountry, $client_email, $client_info, $lsource, $brandname, $whatsappname, $referClientName, $lead_type, $userId);
        } else {
            $insertLeadQuery = "INSERT INTO leads (campId, client_name, client_contact_number, lead_landing_date, client_country, client_email, client_info, lead_source, brand_name, whatsapp_name, lead_type, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmtInsertLead = mysqli_prepare($conn, $insertLeadQuery);
            if ($stmtInsertLead === false) {
                echo "Failed to prepare the statement: " . mysqli_error($conn);
                exit();
            }

            mysqli_stmt_bind_param($stmtInsertLead, "sssssssssssi", $campId, $clientName, $clientContactNumber, $leadLandingDate, $clientCountry, $client_email, $client_info, $lsource, $brandname, $whatsappname, $lead_type, $userId);
        }

        // Execute the statement
        if (mysqli_stmt_execute($stmtInsertLead)) {
            // Log lead creation
            $logMessage = "$creator_name Created The Lead - Client Name: $clientName, Client Contact Number: $clientContactNumber, Lead Landing Date: $leadLandingDate";
            $logFileName = 'lead_created_log.txt';
            customLogToFile($logMessage, $logFileName);

            // Delete the original lead from core_leads
            $deleteShiftQuery = "DELETE FROM core_leads WHERE id = ?";
            $stmtDeleteShift = mysqli_prepare($conn, $deleteShiftQuery);
            mysqli_stmt_bind_param($stmtDeleteShift, "i", $leadid);
            mysqli_stmt_execute($stmtDeleteShift);
            mysqli_stmt_close($stmtDeleteShift);

            // Redirect with success message
            $_SESSION['elead'] = 'Lead Converted successfully!.';
            header("Location: view-leads");
        } else {
            $_SESSION['elead'] = "Error Converting lead: " . mysqli_error($conn);
        }

        // Close the insert statement
        mysqli_stmt_close($stmtInsertLead);
    } else {
        echo "No lead found with ID: $leadid";
    }
}


// End create Order

if (isset($_POST['order-payment'])) {



    date_default_timezone_set('Asia/Karachi');

    $leadid = $_POST['leadid'];
    $user_id = $_POST['user_id'];


    $order_id = $_POST['order_id'];

    $creator_name = $_POST['creator_name'];

    $order_id_input = $_POST['order_id_input'];

    $order_title = $_POST['order_title'];

    $order_status = $_POST['order_status'];
    $payment_status = $_POST['payment_status'];

    $word_count = $_POST['word_count'];

    $pending_payment = $_POST['pending_payment'];

    $receive_payment = $_POST['receive_payment'];

    $currency = $_POST['currency'];

    $whatsapp_account = $_POST['whatsapp_account'];

    $payment_account = $_POST['payment_account'];

    $portal_due_date = $_POST['portal_due_date'];

    $final_deadline_time = $_POST['final_deadline_time'];

    $order_confirmation_date = $_POST['order_confirmation_date'];

    $order_confirmation_month = date("F", strtotime($_POST['order_confirmation_date']));


    $writers_team = $_POST['writers_team'];

    $plan = $_POST['plan'];

    $assigned_to = $_POST['assigned_to'];
    $year = date('Y');

    $years = $_POST['years'];
    $comment = $_POST['comment'];

    $client_requirements = $_POST['client_requirements'];






    // Insert data into `order` table

    $sql = "INSERT INTO `order` (
        order_id_input, order_title, order_status, payment_status, word_count, pending_payment, receive_payment,
        currency, whatsapp_account, payment_account, portal_due_date, final_deadline_time,
        order_confirmation_date, writers_team, plan, assigned_to, year, years, comment, client_requirements,
        order_confirmation_month, user_id, lead_id)
    VALUES (
        '$order_id_input', '$order_title', '$order_status', '$payment_status', '$word_count', '$pending_payment', '$receive_payment',
        '$currency', '$whatsapp_account', '$payment_account', '$portal_due_date', '$final_deadline_time',
        '$order_confirmation_date', '$writers_team', '$plan', '$assigned_to', '$year', '$years', '$comment', '$client_requirements',
        '$order_confirmation_month', '$user_id', '$leadid')";





    if ($conn->query($sql) === TRUE) {

        // Log order creation

        $logMessage = "creator_name Created The  Order - Order ID: $order_id_input, Order Title: $order_title";

        $logFileName = 'order_created_log.txt';

        customLogToFile($logMessage, $logFileName);

        header("Location: view-orders.php");
        $_SESSION['CreateOrder'] = 'Order created successfully!.';
    } else {

        $_SESSION['CreateOrder'] = 'Error: ' . $sql . '<br>' . $conn->error;
    }
}




// View Orders

//Start Function to get shifts from the database

function getOrderRecords($conn)

{

    $orders = array();

    $query = "SELECT orderId,order_id_input, order_title, payment_status, order_status, word_count, pending_payment, receive_payment, currency, whatsapp_account, payment_account, portal_due_date, final_deadline_time, order_confirmation_date, writers_team, plan, assigned_to, year, years, comment, client_requirements, user.name, leads.campId, leads.client_name, leads.client_contact_number, leads.lead_landing_date, leads.client_name,leads.client_contact_number, leads.lead_landing_date, leads.client_country, leads.client_email,lead_id

    FROM `order`

    LEFT JOIN user ON `order`.user_id = user.userId

    LEFT JOIN leads ON `order`.lead_id = leads.id

    ORDER BY orderId DESC";

    $result = mysqli_query($conn, $query);



    if (!$result) {

        die("Query execution failed: " . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($result)) {

        $orders[] = $row;
    }



    return $orders;
}

// End View Orders

function getEnumValues($conn, $table, $column)

{

    $enumValues = array();

    $query = "SHOW COLUMNS FROM `$table` LIKE '$column'";

    $result = mysqli_query($conn, $query);



    if ($result) {

        $row = mysqli_fetch_assoc($result);



        // Extract enum values using regular expression

        preg_match('/enum\((.*?)\)$/', $row['Type'], $matches);



        // Split comma-separated values and remove quotes

        $enumValues = explode(',', $matches[1]);

        $enumValues = array_map('trim', $enumValues);

        $enumValues = array_map(function ($value) {

            return trim($value, "'");
        }, $enumValues);
    }



    return $enumValues;
}



function getDetailsForSelectedOrder($conn, $orderId)

{

    $query = "SELECT * FROM `order`

              LEFT JOIN user ON `order`.user_id = user.userId

              LEFT JOIN leads ON `order`.lead_id = leads.id
              
              LEFT JOIN shift ON user.shift_id = shift.shiftId
              LEFT JOIN team ON user.team_Id = team.teamId


              WHERE orderId = $orderId";



    $result = mysqli_query($conn, $query);



    if (!$result) {

        die("Query execution failed: " . mysqli_error($conn));
    }



    return mysqli_fetch_assoc($result);
}


function getDetailsForSelectedleads($conn, $leadid)
{
    // Make sure the leadid is properly sanitized to prevent SQL injection
    $leadid = mysqli_real_escape_string($conn, $leadid);

    // Update the query to include a WHERE clause to fetch the specific lead
    $query = "SELECT * FROM `leads` 
              LEFT JOIN user ON `leads`.user_id = user.userId 
              WHERE `leads`.id = '$leadid'";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query execution failed: " . mysqli_error($conn));
    }

    // Fetch the specific lead based on the leadid
    return mysqli_fetch_assoc($result);
}



// Function to retrieve order information

function getOrderInfo($orderId)

{

    global $conn;



    $sql = "SELECT * FROM `order` WHERE orderId = ?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $orderId);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $orderInfo = mysqli_fetch_assoc($result);

    mysqli_stmt_close($stmt);



    return $orderInfo;
}



// Edit Order

if (isset($_POST['edit_order'])) {

    $orderID = $_POST['order_id'];

    $selectOrderQuery = "SELECT * FROM `order` WHERE orderId = ?";

    $stmtSelectOrder = mysqli_prepare($conn, $selectOrderQuery);



    if ($stmtSelectOrder) {

        mysqli_stmt_bind_param($stmtSelectOrder, "i", $orderID);

        mysqli_stmt_execute($stmtSelectOrder);

        $result = mysqli_stmt_get_result($stmtSelectOrder);



        // Check if any rows were returned

        if ($result) {

            $orderValues = mysqli_fetch_assoc($result);



            // Use $orderValues for further processing or displaying

        } else {

            echo "No rows returned.";
        }



        mysqli_stmt_close($stmtSelectOrder);
    } else {

        echo "Error preparing statement: " . mysqli_error($conn);
    }
}


if (isset($_POST['update-order'])) {

    date_default_timezone_set('Asia/Karachi');

    $order_id = $_POST['order_id'];
    $creator_name = $_POST['creator_name'];
    $order_id_input = $_POST['order_id_input'];
    $order_title = $_POST['order_title'];
    $order_status = $_POST['order_status'];
    $payment_status = $_POST['payment_status'];
    $word_count = $_POST['word_count'];
    $pending_payment = $_POST['pending_payment'];
    $receive_payment = $_POST['receive_payment'];
    $currency = $_POST['currency'];
    $whatsapp_account = $_POST['whatsapp_account'];
    $payment_account = $_POST['payment_account'];
    $portal_due_date = $_POST['portal_due_date'];
    $final_deadline_time = $_POST['final_deadline_time'];
    $order_confirmation_date = $_POST['order_confirmation_date'];
    $writers_team = $_POST['writers_team'];
    $plan = $_POST['plan'];
    $assigned_to = $_POST['assigned_to'];
    $years = $_POST['years'];
    $comment = $_POST['comment'];
    $client_requirements = $_POST['client_requirements'];
    $pending_payment_status = $_POST['pending_payment_status'];

    // Retrieve current order information from the database
    $currentOrderInfo = getOrderInfo($order_id);

    // Check if there is a change in order information
    $logMessage = " Order updated for ID $order_id: ";
    $logChanges = [];
    $fieldsToCheck = [
        'order_id_input',
        'order_title',
        'order_status',
        'payment_status',
        'word_count',
        'pending_payment',
        'receive_payment',
        'currency',
        'whatsapp_account',
        'payment_account',
        'portal_due_date',
        'final_deadline_time',
        'order_confirmation_date',
        'writers_team',
        'plan',
        'assigned_to',
        'client_requirements',
        'pending_payment_status'
    ];
    foreach ($fieldsToCheck as $field) {
        if ($currentOrderInfo[$field] !== $_POST[$field]) {
            $logChanges[] = "$field: {$currentOrderInfo[$field]} to {$_POST[$field]}";
        }
    }

    // Log the changes
    if (!empty($logChanges)) {
        $logMessage .= implode(", ", $logChanges);
        $logFileName = 'order_update_log.txt';
        customLogToFile($logMessage, $logFileName);
    }

    // Check if pending payment status is 'Paid'
    if ($pending_payment_status == 'Paid') {
        // Get the current month
        $current_month = date('F');
        // Update data in the order table
        $updateOrderQuery = "UPDATE `order` SET order_id_input=?, order_title = ?, order_status = ?, payment_status = ?, word_count = ?, pending_payment = ?, receive_payment = ?, currency = ?, whatsapp_account = ?, payment_account = ?, portal_due_date = ?, final_deadline_time = ?, order_confirmation_date = ?, pending_payment_status = ?, writers_team = ?, plan = ?, assigned_to = ?, years = ?, comment = ?, client_requirements = ?, pending_payment_Month = ? WHERE orderId = ?";
        $stmtUpdateOrder = mysqli_prepare($conn, $updateOrderQuery);
        if ($stmtUpdateOrder) {
            mysqli_stmt_bind_param(
                $stmtUpdateOrder,
                "sssssssssssssssssssssi",
                $order_id_input,
                $order_title,
                $order_status,
                $payment_status,
                $word_count,
                $pending_payment,
                $receive_payment,
                $currency,
                $whatsapp_account,
                $payment_account,
                $portal_due_date,
                $final_deadline_time,
                $order_confirmation_date,
                $pending_payment_status,
                $writers_team,
                $plan,
                $assigned_to,
                $years,
                $comment,
                $client_requirements,
                $current_month,
                $order_id
            );
            if (mysqli_stmt_execute($stmtUpdateOrder)) {
                $_SESSION['eorder'] = "Order updated successfully.";
                header('Location: view-orders');
            } else {
                $_SESSION['eorder'] = "Error updating order: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmtUpdateOrder);
        } else {
            $_SESSION['eorder'] = "Error preparing update statement: " . mysqli_error($conn);
        }
    } else {
        // Update data in the order table
        $updateOrderQuery = "UPDATE `order` SET order_id_input=?, order_title = ?, order_status = ?, payment_status = ?, word_count = ?, pending_payment = ?, receive_payment = ?, currency = ?, whatsapp_account = ?, payment_account = ?, portal_due_date = ?, final_deadline_time = ?, order_confirmation_date = ?, pending_payment_status = ?, writers_team = ?, plan = ?, assigned_to = ?, years = ?, comment = ?, client_requirements = ? WHERE orderId = ?";
        $stmtUpdateOrder = mysqli_prepare($conn, $updateOrderQuery);
        if ($stmtUpdateOrder) {
            mysqli_stmt_bind_param(
                $stmtUpdateOrder,
                "ssssssssssssssssssssi",
                $order_id_input,
                $order_title,
                $order_status,
                $payment_status,
                $word_count,
                $pending_payment,
                $receive_payment,
                $currency,
                $whatsapp_account,
                $payment_account,
                $portal_due_date,
                $final_deadline_time,
                $order_confirmation_date,
                $pending_payment_status,
                $writers_team,
                $plan,
                $assigned_to,
                $years,
                $comment,
                $client_requirements,
                $order_id
            );
            if (mysqli_stmt_execute($stmtUpdateOrder)) {
                $_SESSION['eorder'] = "Order updated successfully.";
                header('Location: view-orders');
            } else {
                $_SESSION['eorder'] = "Error updating order: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmtUpdateOrder);
        } else {
            $_SESSION['eorder'] = "Error preparing update statement: " . mysqli_error($conn);
        }
    }
}

// Start Delete Order

// if (isset($_POST['delete_order'])) {

//     $order_id = $_POST['order_id'];
//     $deleted_name = $_POST['deleted_name'];
//     $order_title = $_POST['order_title'];
//     $del_status = "Deleted";
//     // Retrieve order information before deletion
//     $orderInfo = getOrderInfo($order_id);
//     // Delete the order from the database
//     $deleteQuery = "UPDATE `order`  SET del_status = ?   WHERE orderId = ?";

//     $stmt = mysqli_prepare($conn, $deleteQuery);

//     if ($stmt) {
//         mysqli_stmt_bind_param($stmt, "si", $del_status, $order_id);
//         // Log the order deletion

//         $logMessage = "Order deleted for ID $order_id: ";

//         $logChanges = [];

//         // Include relevant information in the log
//         $logChanges[] = "Order Title: {$order_title}";
//         // Add more fields as needed
//         $logMessage .= implode(", ", $logChanges);
//         $logFileName = 'order_delete_log.txt';
//         customLogToFile($logMessage, $logFileName);
//         // Execute the deletion

//         if (mysqli_stmt_execute($stmt)) {
//             $_SESSION['dorder'] = 'Order deleted successfully!.';
//         } else {

//             $_SESSION['dorder'] =  "Error executing deletion: " . mysqli_error($conn);
//         }
//         mysqli_stmt_close($stmt);
//     } else {

//         $_SESSION['dorder'] = "Error preparing delete statement: " . mysqli_error($conn);
//     }
// }
if (isset($_POST['action']) && $_POST['action'] === 'delete_order' && isset($_POST['order_id']) && isset($_POST['inputKey'])) {
    $order_id = $_POST['order_id'];
    $inputKey = $_POST['inputKey'];
    $deleted_name = $_POST['deleted_name'];
    $order_title = $_POST['order_title'];
    $del_status = "Deleted";
    $secret_key = 'XqzQh9G4Ju87Gqfy4xZkQzZ+2HdF0YqM/pjHoN6ITe0='; // Your base64-encoded secret key

    // Fetch and decrypt the key from the delete_keys table
    $sql = "SELECT `key` FROM delete_keys WHERE id = 4"; // Adjust the ID as needed
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dbKey = decrypt($row['key'], $secret_key); // Assuming you have the decrypt function

        // Validate the key
        if ($inputKey === $dbKey) {
            // Retrieve order information before deletion
            $orderInfo = getOrderInfo($order_id);

            // Update the order's status to 'Deleted'
            $deleteOrderQuery = "UPDATE `order` SET del_status = ? WHERE orderId = ?";
            $stmt = mysqli_prepare($conn, $deleteOrderQuery);
            mysqli_stmt_bind_param($stmt, "si", $del_status, $order_id);

            // Execute the deletion
            if (mysqli_stmt_execute($stmt)) {
                // Log order deletion
                $logMessage = "Order deleted for Order ID $order_id by $deleted_name: Order Title: $order_title";
                $logFileName = '../logs/order_delete_log.txt';
                file_put_contents($logFileName, date('Y-m-d H:i:s') . ' - ' . $logMessage . PHP_EOL, FILE_APPEND);

                echo json_encode(['status' => 'success', 'message' => 'Order deleted successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error deleting order.']);
            }

            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Incorrect deletion key.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Deletion key not found.']);
    }

    exit();
}
date_default_timezone_set('Asia/Karachi');

// End Delete Order




// Email setting template 
if (isset($_POST['server_credentials-2'])) {
    // Check if the ID is set in the POST request
    if (isset($_POST['id'])) {
        $rowId = intval($_POST['id']); // Get the ID from the POST data

        // Get the updated email settings from the form
        $servername = $_POST['servername'];
        $port = $_POST['port'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $description = $_POST['desc'];

        // Use prepared statements to avoid SQL injection
        $query4 = "UPDATE email_setting SET servername = ?, port = ?, email = ?, password = ?, description = ? WHERE id = ?";
        
        // Prepare the statement
        $stmt = $conn->prepare($query4);
        $stmt->bind_param("sssssi", $servername, $port, $email, $password, $description, $rowId); // Bind the ID as well

        if ($stmt->execute()) {
            $_SESSION['eset2'] = 'Email settings updated successfully.'; 
                       echo "<script>window.location.href = 'index.php';</script>"; // Adjust the filename as necessary

        } else {
            $_SESSION['eset2'] = "Error updating email settings: " . $stmt->error;
            echo "<script>window.location.href = 'index.php';</script>"; // Adjust the filename as necessary

        }

        // Close the statement
        $stmt->close();
    } else {
        echo "No ID specified.";
    }
}

// End Email Setting template

if (isset($_POST['create-bank'])) {
    $account_name = $_POST['account_name'];

    $sql = "INSERT INTO bank_accounts (account_name) VALUES ('$account_name')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['Createbank'] = "New account name created successfully";
    } else {
        $_SESSION['CreatebankError'] = "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST['delete_payment'])) {

    $id = $_POST['payment_id'];

    $stmt = $conn->prepare("DELETE FROM bank_accounts WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['delpayment'] = "Record deleted successfully";
    } else {
        $_SESSION['delpayment'] = "Error: " . $stmt->error;
    }

    $stmt->close();
}


if (isset($_POST['edit-payment-account'])) {
    $id = $_POST['id'];
    $account_name = $_POST['account_name'];

    $sql = "UPDATE bank_accounts SET account_name='$account_name' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['up_payment_account'] = "Record updated successfully";
        header("Location: view-payment-account");
    } else {
        $_SESSION['up_payment_account'] = "Error: " . $sql . "<br>" . $conn->error;
        header("Location: view-payment-account");
    }
}


// Plan


if (isset($_POST['create_plan'])) {
    $plan = $_POST['plan'];

    $sql = "INSERT INTO plan (plan) VALUES ('$plan')";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['Createplan'] = "New plan created successfully";
    } else {
        $_SESSION['CreatePlanError'] = "Error: " . $sql . "<br>" . $conn->error;
    }
}


if (isset($_POST['delete_plan'])) {
    $id = $_POST['plan_id'];
    $sql = "DELETE FROM `plan` WHERE `id`='$id'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['delplan'] = "Record deleted successfully";
    } else {
        $_SESSION['delplan'] = "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_POST['edit-plan'])) {
    $id = $_POST['id'];
    $account_name = $_POST['account_name'];

    $sql = "UPDATE plan SET plan='$account_name' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['up_plan_account'] = "Record updated successfully";
        header("Location: view-plan-account");
    } else {
        $_SESSION['up_plan_account'] = "Error: " . $sql . "<br>" . $conn->error;
        header("Location: view-plan-account");
    }
}


//  Start Create LEad Source

if (isset($_POST['create-lead-source'])) {

    $leadsourcename = $_POST['leadsourcename'];


    // Insert into team table

    $insertLeadSourceQuery = "INSERT INTO lead_source (source) VALUES (?)";

    $stmtleadSource = mysqli_prepare($conn, $insertLeadSourceQuery);

    mysqli_stmt_bind_param($stmtleadSource, "s", $leadsourcename);



    // Execute the statement and check for success

    $executeResult = mysqli_stmt_execute($stmtleadSource);



    // Close statement

    mysqli_stmt_close($stmtleadSource);



    if ($executeResult) {

        $_SESSION['CreateleadSource'] = 'Lead Source created successfully!.';
    } else {

        $_SESSION['CreateleadSource'] = 'Error creating Lead Source. Please try again.';
    }
}
//  End Create LEad Source

// Start Fetch LEad Source
function getLeadSource($conn)

{

    $leadsource = array();

    $query = "SELECT id, source FROM lead_source";

    $result = mysqli_query($conn, $query);



    while ($row = mysqli_fetch_assoc($result)) {

        $leadsource[] = $row;
    }



    return $leadsource;
}

// End Fetch LEad Source

// Start Edit Lead Source
function getLeadSourceDetails($conn, $leadsource_id)
{
    $query = "SELECT id, source FROM lead_source WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $leadsource_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $leadSourceDetails = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    return $leadSourceDetails;
}

if (isset($_POST['edit_lead_source'])) {
    $leadsource_id = $_POST['leadsource_id'];

    // Fetch the lead source details
    $leadSourceDetails = getLeadSourceDetails($conn, $leadsource_id);
}

// End Fetch Edit LEad source details



// Start Update Lead Source 

if (isset($_POST['update_lead_source'])) {

    $leadsource_id = $_POST['leadsource_id'];

    $lead_source = $_POST['lead_source'];




    $updateLeadSourceQuery = "UPDATE lead_source SET source = ? WHERE id = ?";

    $stmtUpdateLeadSource = mysqli_prepare($conn, $updateLeadSourceQuery);

    mysqli_stmt_bind_param($stmtUpdateLeadSource, "si", $lead_source, $leadsource_id);

    $executeResult = mysqli_stmt_execute($stmtUpdateLeadSource);

    mysqli_stmt_close($stmtUpdateLeadSource);



    if ($executeResult) {

        $_SESSION['up_leadSource'] = 'Lead Source updated successfully!.';
        header("Location: view-lead-source");
    } else {

        $_SESSION['up_leadSource'] = 'Error updating Lead Source. Please try again.';
        header("Location: view-lead-source");
    }
}

// ENd Update Lead Source
// ENd Delete  Lead Source

if (isset($_POST['delete_lead_source'])) {

    $leadsource_id = $_POST['leadsource_id'];

    $deleteQuery = "DELETE FROM lead_source WHERE id = ?";

    $stmt = mysqli_prepare($conn, $deleteQuery);

    mysqli_stmt_bind_param($stmt, "i", $leadsource_id);

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);



    $_SESSION['delleadSource'] = "Lead Source deleted successfully!";
}

// End Delete Lead Source 



//  Start Create Brand

if (isset($_POST['create-brand'])) {
    $brandname = $_POST['brandname'];
    $servername = $_POST['servername'];
    $port = $_POST['port'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $desc = $_POST['desc'];
    $templateFileName = $brandname .'-email-template';

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    mysqli_begin_transaction($conn);

    try {
        // Insert Brand
        $insertBrandQuery = "INSERT INTO brands (brand_name) VALUES (?)";
        $stmtBrand = mysqli_prepare($conn, $insertBrandQuery);
        mysqli_stmt_bind_param($stmtBrand, "s", $brandname);
        mysqli_stmt_execute($stmtBrand);
        $brandId = mysqli_insert_id($conn);  // Get last inserted ID for the brand

        $insertEmailSettingQuery = "INSERT INTO email_setting (id, email, password, servername, port, description, file_name, brandname) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtEmailSetting = mysqli_prepare($conn, $insertEmailSettingQuery);
        mysqli_stmt_bind_param($stmtEmailSetting, "isssssss", $brandId, $email, $password, $servername, $port, $desc, $templateFileName, $brandname);
        
        // Check if email settings insertion was successful
        if (!mysqli_stmt_execute($stmtEmailSetting)) {
            throw new Exception('Error inserting email settings.');
        }
        $templateContent ='
        <?php $TITLE = "' . $brandname . ' Email Template"; ?>  
        <?php $file_name = " '.$templateFileName. '"; ?>
        <?php require_once("./main_components/header.php"); ?>
        <?php require_once("email-template-component.php");?>
        
        ';
        $filePath =  $templateFileName.".php";
        file_put_contents($filePath, $templateContent);



        // Commit transaction
        mysqli_commit($conn);

        $_SESSION['Createbrand'] = 'Brand, email settings, and template created successfully!';
    } catch (Exception $e) {
        // Rollback transaction in case of error
        mysqli_rollback($conn);
        $_SESSION['Createbrand'] = 'Error creating brand or template: ' . $e->getMessage();
    }

    mysqli_stmt_close($stmtBrand);
    mysqli_stmt_close($stmtEmailSetting);
}


//  End Create Brand

// Start Fetch Brands
function getBrands($conn)
{
    $brands = array();
    $query = "SELECT id, brand_name FROM brands";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $brands[] = $row;
    }
    return $brands;
}
function getAllBrands($conn)
{
    $brands = [];
    $query = "SELECT brand_name FROM brands"; // Adjust based on your brands table
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $brands[] = $row;
    }
    return $brands;
}

// Start Fetch BrandsPermisiion
function getBrandsPermissions($conn)
{
    $brands = array();
    $query = "SELECT id, brandpermission, user_id FROM brands";
    $result = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $brandspermission[] = $row;
    }
    return $brandspermission;
}

// End Fetch Brands

// Start Edit Brand
function getBrandDetails($conn, $brand_id)
{
    $query = "SELECT id, brand_name FROM brands WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $brand_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $BrandDetails = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    return $BrandDetails;
}

if (isset($_POST['edit_brand'])) {
    $brand_id = $_POST['brand_id'];

    // Fetch the Brand details
    $BrandDetails = getBrandDetails($conn, $brand_id);
}

// End Fetch Edit Brand details



// Start Update Brand 

if (isset($_POST['update_brand'])) {

    $brand_id = $_POST['brand_id'];

    $brandname = $_POST['brandname'];



// Update Brands
    $updateBrandQuery = "UPDATE brands SET brand_name = ? WHERE id = ?";

    $stmtUpdateBrande = mysqli_prepare($conn, $updateBrandQuery);

    mysqli_stmt_bind_param($stmtUpdateBrande, "si", $brandname, $brand_id);

    $executeResult = mysqli_stmt_execute($stmtUpdateBrande);

    mysqli_stmt_close($stmtUpdateBrande);

    // Update Email Settings Brand Name
    $updateEmailSettingQuery = "UPDATE email_setting SET brandname = ? WHERE id = ?";
    
    $stmtUpdateEmailSete = mysqli_prepare($conn, $updateEmailSettingQuery);

    mysqli_stmt_bind_param($stmtUpdateEmailSete, "si", $brandname, $brand_id);

    $executeResult = mysqli_stmt_execute($stmtUpdateEmailSete);

    mysqli_stmt_close($stmtUpdateEmailSete);



    if ($executeResult) {

        $_SESSION['up_brand'] = 'Brand updated successfully!.';
        header("Location: view-brand");
    } else {

        $_SESSION['up_brand'] = 'Error updating Brand. Please try again.';
        header("Location: view-brand");
    }
}

// ENd Update Brand

// Start Delete  Brand

if (isset($_POST['action']) && $_POST['action'] === 'delete_brand' && isset($_POST['brand_id']) && isset($_POST['inputKey'])) {
    $brand_id = $_POST['brand_id'];
    $inputKey = $_POST['inputKey'];
    $secret_key = 'XqzQh9G4Ju87Gqfy4xZkQzZ+2HdF0YqM/pjHoN6ITe0='; // Your base64-encoded secret key

    // Fetch and decrypt the key from the delete_keys table
    $sql = "SELECT `key` FROM delete_keys WHERE id = 6"; // Adjust the ID as needed
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dbKey = decrypt($row['key'], $secret_key); // Assuming you have the decrypt function

        // Validate the key
        if ($inputKey === $dbKey) {
            // Delete the brand from the database
            $deleteQuery = "DELETE FROM brands WHERE id = ?";
            $stmt = mysqli_prepare($conn, $deleteQuery);
            mysqli_stmt_bind_param($stmt, "i", $brand_id);
            $executeResult = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $deleteQuery_email_setting = "DELETE FROM email_setting WHERE id = ?";
            $stmt = mysqli_prepare($conn, $deleteQuery_email_setting);
            mysqli_stmt_bind_param($stmt, "i", $brand_id);
            $executeResult = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            if ($executeResult) {
                echo json_encode(['status' => 'success', 'message' => 'Brand & Email Settings deleted successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error deleting Brand & Email Setting.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Incorrect Deletion key.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Deletion key not found.']);
    }

    exit();
}

// End Delete Brand





//  Start Create Whatsapp Details

if (isset($_POST['create-whatsapp'])) {

    $whatsappname = $_POST['whatsappname'];
    $whatsappnumber = $_POST['whatsappnumber'];

    // Corrected SQL query with the correct column names
    $insertWhatsappQuery = "INSERT INTO whatsapp (whatsapp_name, whatsapp_number) VALUES (?, ?)";

    // Prepare the statement
    if ($stmtwhatsapp = mysqli_prepare($conn, $insertWhatsappQuery)) {

        // Bind parameters
        mysqli_stmt_bind_param($stmtwhatsapp, "ss", $whatsappname, $whatsappnumber);

        // Execute the statement
        $executeResult = mysqli_stmt_execute($stmtwhatsapp);

        // Close the statement
        mysqli_stmt_close($stmtwhatsapp);

        // Set session messages based on execution result
        if ($executeResult) {
            $_SESSION['CreateWhatsapp'] = 'Whatsapp Details created successfully!';
        } else {
            $_SESSION['CreateWhatsappError'] = 'Error creating Whatsapp Details. Please try again.';
        }
    } else {
        // Prepare failed, log error
        $_SESSION['CreateWhatsappError'] = 'Database query failed: ' . mysqli_error($conn);
    }
}
//  End Create Whatsapp Details

//  End Create Whatsapp Details

// Start Fetch Whatsapp Details
function getWhatsapp($conn)

{

    $whatsapp = array();

    $query = "SELECT id, whatsapp_name, whatsapp_number	FROM whatsapp";

    $result = mysqli_query($conn, $query);



    while ($row = mysqli_fetch_assoc($result)) {

        $whatsapp[] = $row;
    }



    return $whatsapp;
}
// End Fetch Whatsapp Details

// Start Edit Brand
function getWhatsappdetails($conn, $whatsapp_id)
{
    $query = "SELECT id, whatsapp_name, whatsapp_number FROM whatsapp WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $whatsapp_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $WhatsappDetails = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    return $WhatsappDetails;
}

if (isset($_POST['edit-whatsappdetail'])) {
    $whatsapp_id = $_POST['whatsapp_id'];

    $WhatsappDetails = getWhatsappdetails($conn, $whatsapp_id);
}

// End Fetch Edit Brand details



// Start Update Brand 

if (isset($_POST['update_whatsappdetail'])) {

    $whatsapp_id = $_POST['whatsapp_id'];

    $whatsappname = $_POST['whatsappname'];
    $whatsappnnumber = $_POST['whatsappnnumber'];

    $updateWhatsappQuery = "UPDATE whatsapp SET whatsapp_name = ?, whatsapp_number = ? WHERE id = ?";

    $stmtUpdateWhatsapp = mysqli_prepare($conn, $updateWhatsappQuery);

    mysqli_stmt_bind_param($stmtUpdateWhatsapp, "ssi", $whatsappname, $whatsappnnumber, $whatsapp_id);

    $executeResult = mysqli_stmt_execute($stmtUpdateWhatsapp);

    mysqli_stmt_close($stmtUpdateWhatsapp);

    if ($executeResult) {

        $_SESSION['up_whatsappDetail'] = 'Whatsapp Detail updated successfully!.';
        header("Location: view-whatsapp-details");
    } else {

        $_SESSION['up_whatsappDetail'] = 'Error updating Whatsapp Detail. Please try again.';
        header("Location: view-whatsapp-details");
    }
}

// ENd Update Whatsapp Detail

// Start Delete Whatsapp Detail

if (isset($_POST['delete_whatsappdetail'])) {

    $whatsapp_id = $_POST['whatsapp_id'];

    $deleteQuery = "DELETE FROM whatsapp WHERE id = ?";

    $stmt = mysqli_prepare($conn, $deleteQuery);

    mysqli_stmt_bind_param($stmt, "i", $whatsapp_id);

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);



    $_SESSION['delWhatsappDetail'] = "Whatsapp Detail deleted successfully!";
}
// End Delete Whatsapp Detail


// Start Export CSV Live Leads
if (isset($_POST['export_csv'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=live_leads.csv');
    $output = fopen("php://output", "w");

    // Updated headers to include 'User Name'
    fputcsv($output, array(
        'Camp ID',
        'Client Name',
        'Client Contact Number',
        'Client Country',
        'Client Email',
        'Lead Landing Date',
        'Client Info',
        'Lead Source',
        'Brand Name',
        'Whatsapp Name',
        'Refer Client Name',
        'Platform',
        'Lead Type',
        'User Name'
    ));

    $query = "
        SELECT 
            l.campId, l.client_name, l.client_contact_number, l.client_country, l.client_email, 
            l.lead_landing_date, l.client_info, l.lead_source, l.brand_name, l.whatsapp_name, 
            l.refer_client_name, l.platform, l.lead_type, u.name AS user_name 
        FROM leads l
        LEFT JOIN user u ON l.user_id = u.userId
    ";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Query Error: ' . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        // Output CSV row with 'user_name' included
        fputcsv($output, array(
            $row['campId'],
            $row['client_name'],
            $row['client_contact_number'],
            $row['client_country'],
            $row['client_email'],
            $row['lead_landing_date'],
            $row['client_info'],
            $row['lead_source'],
            $row['brand_name'],
            $row['whatsapp_name'],
            $row['refer_client_name'],
            $row['platform'],
            $row['lead_type'],
            $row['user_name']
        ));
    }
    fclose($output);
    exit();
}
// End Export CSV Live Leads
// Start Import Live Leads 
if (isset($_POST['import-leads'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['csv_file']['tmp_name'];
        $user_id = $_POST['userid'];

        if ($_FILES['csv_file']['size'] > 0) {
            $file = fopen($fileName, 'r');

            fgetcsv($file);

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $campId = mysqli_real_escape_string($conn, $column[0]);
                $client_name = mysqli_real_escape_string($conn, $column[1]);
                $client_contact_number = mysqli_real_escape_string($conn, $column[2]);
                $client_country = mysqli_real_escape_string($conn, $column[3]);
                $client_email = mysqli_real_escape_string($conn, $column[4]);
                $lead_landing_date = mysqli_real_escape_string($conn, $column[5]);
                $client_info = mysqli_real_escape_string($conn, $column[6]);
                $lead_source = mysqli_real_escape_string($conn, $column[7]);
                $brand_name = mysqli_real_escape_string($conn, $column[8]);
                $whatsapp_name = mysqli_real_escape_string($conn, $column[9]);
                $refer_client_name = mysqli_real_escape_string($conn, $column[10]);
                $platform = mysqli_real_escape_string($conn, $column[11]);
                $lead_type = mysqli_real_escape_string($conn, $column[12]);
                // $user_id = mysqli_real_escape_string($conn, $column[13]);

                $sql = "INSERT INTO leads (campId, client_name, client_contact_number, client_country, client_email, lead_landing_date, client_info, lead_source, brand_name, whatsapp_name, refer_client_name, platform, lead_type, user_id)
                        VALUES ('$campId', '$client_name', '$client_contact_number', '$client_country', '$client_email', '$lead_landing_date', '$client_info', '$lead_source', '$brand_name', '$whatsapp_name', '$refer_client_name', '$platform', '$lead_type', '$user_id')";

                if (!mysqli_query($conn, $sql)) {
                    echo "<script>alert('Error importing data: " . mysqli_error($conn) . "');</script>";
                    exit();
                }
            }
            fclose($file);

            echo "<script>alert('Leads imported successfully!');</script>";
        } else {
            echo "<script>alert('File is empty!');</script>";
        }
    } else {
        echo "<script>alert('File upload error or file not found!');</script>";
    }
}
// End Import Live Leads 







// Start Export CSV Core Leads
if (isset($_POST['export_csv_core_lead'])) {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=core_leads.csv');
    $output = fopen("php://output", "w");

    // CSV Header
    fputcsv($output, array(
        'Camp ID',
        'Client Name',
        'Client Contact Number',
        'Client Country',
        'Client Email',
        'Lead Landing Date',
        'Client Info',
        'Lead Source',
        'Brand Name',
        'Whatsapp Name',
        'Refer Client Name',
        'Platform',
        'Lead Type',
        'User Name'
    ));

    $query = "
        SELECT 
            cl.campId, cl.client_name, cl.client_contact_number, cl.client_country, cl.client_email, 
            cl.lead_landing_date, cl.client_info, cl.lead_source, cl.brand_name, cl.whatsapp_name, 
            cl.refer_client_name, cl.platform, cl.lead_type, u.name AS user_name 
        FROM core_leads cl
        LEFT JOIN user u ON cl.user_id = u.userId
    ";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Query Error: ' . mysqli_error($conn));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        // Output CSV row
        fputcsv($output, array(
            $row['campId'],
            $row['client_name'],
            $row['client_contact_number'],
            $row['client_country'],
            $row['client_email'],
            $row['lead_landing_date'],
            $row['client_info'],
            $row['lead_source'],
            $row['brand_name'],
            $row['whatsapp_name'],
            $row['refer_client_name'],
            $row['platform'],
            $row['lead_type'],
            $row['user_name']
        ));
    }
    fclose($output);
    exit();
}
// End Export CSV Core Leads


// Start Import Core Leads 
if (isset($_POST['import-core-leads'])) {
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['csv_file']['tmp_name'];

        if ($_FILES['csv_file']['size'] > 0) {
            $file = fopen($fileName, 'r');
            $user_id = $_POST['userid'];
            fgetcsv($file);

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $campId = mysqli_real_escape_string($conn, $column[0]);
                $client_name = mysqli_real_escape_string($conn, $column[1]);
                $client_contact_number = mysqli_real_escape_string($conn, $column[2]);
                $client_country = mysqli_real_escape_string($conn, $column[3]);
                $client_email = mysqli_real_escape_string($conn, $column[4]);
                $lead_landing_date = mysqli_real_escape_string($conn, $column[5]);
                $client_info = mysqli_real_escape_string($conn, $column[6]);
                $lead_source = mysqli_real_escape_string($conn, $column[7]);
                $brand_name = mysqli_real_escape_string($conn, $column[8]);
                $whatsapp_name = mysqli_real_escape_string($conn, $column[9]);
                $refer_client_name = mysqli_real_escape_string($conn, $column[10]);
                $platform = mysqli_real_escape_string($conn, $column[11]);
                $lead_type = mysqli_real_escape_string($conn, $column[12]);
                // $user_id = mysqli_real_escape_string($conn, $column[13]);

                $sql = "INSERT INTO core_leads (campId, client_name, client_contact_number, client_country, client_email, lead_landing_date, client_info, lead_source, brand_name, whatsapp_name, refer_client_name, platform, lead_type, user_id)
                        VALUES ('$campId', '$client_name', '$client_contact_number', '$client_country', '$client_email', '$lead_landing_date', '$client_info', '$lead_source', '$brand_name', '$whatsapp_name', '$refer_client_name', '$platform', '$lead_type', '$user_id')";

                if (!mysqli_query($conn, $sql)) {
                    echo "<script>alert('Error importing data: " . mysqli_error($conn) . "');</script>";
                    exit();
                }
            }
            fclose($file);

            echo "<script>alert('Leads imported successfully!');</script>";
        } else {
            echo "<script>alert('File is empty!');</script>";
        }
    } else {
        echo "<script>alert('File upload error or file not found!');</script>";
    }
}
// End Import Core Leads 
