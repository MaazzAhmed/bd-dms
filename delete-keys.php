<?php $TITLE = "Edit Lead"; ?>

<?php require_once("./main_components/global.php"); ?>

<?php require_once("./main_components/header.php"); 
if (!isset($_SESSION['role']) || 
($_SESSION['role'] !== 'Admin')) {
    echo "<script>window.location.href = 'index';</script>";
    exit(); 
}

?>

<!--wrapper-->

<div class="wrapper">

    <!--sidebar wrapper -->

    <?php require_once("./main_components/sidebar.php"); ?>



    <!--end sidebar wrapper -->

    <!--start header -->

    <?php require_once("./main_components/navbar.php"); ?>
    <?php
    // Initialize error message
    $error_message = "";

    if (isset($_POST['scrtkey'])) {

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Get the input secret key
        $secret_key = $_POST['secret_key'];

        // Query to check the secret key
        $sql = "SELECT `key` FROM delete_keys WHERE id = 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $veri_keys = $row['key'];

            // Check if the input secret key matches the veri_keys
            if ($secret_key === $veri_keys) {
                // Show the second form
                echo "<script>document.addEventListener('DOMContentLoaded', function () {
                    document.getElementById('first-form').style.display = 'none';
                    document.getElementById('second-form').style.display = 'block';
                });</script>";
            } else {
                // Invalid key, show an error message
                $error_message = "Invalid secret key. Please try again.";
            }
        } else {
            // No record found with id 3
            $error_message = "No valid key found. Please contact the Admin.";
        }
    }

    // Define your secret key for encryption/decryption
    $secret_key = 'XqzQh9G4Ju87Gqfy4xZkQzZ+2HdF0YqM/pjHoN6ITe0='; // Your base64-encoded secret key




    // Fetch clearchat and deletemsg keys from the database
    $clearchat = "";
    $deletemsg = "";
    $deleteorderfilefetch = "";
    $adminaccountkeyfetch = "";



    // Query to fetch user key
    $sql = "SELECT `key` FROM delete_keys WHERE id = 2";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $clearchat = decrypt($row['key'], $secret_key);
    }

    // Query to fetch live lead key
    $sql = "SELECT `key` FROM delete_keys WHERE id = 3";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $deletemsg = decrypt($row['key'], $secret_key);
    }
    // Query to fetch order key
    $sql = "SELECT `key` FROM delete_keys WHERE id = 4";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $deleteorderfetch = decrypt($row['key'], $secret_key);
    }
    // Query to fetch core leads key
    $sql = "SELECT `key` FROM delete_keys WHERE id = 5";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $deleteleadfetch = decrypt($row['key'], $secret_key);
    }
    // Query to fetch brand key
    $sql = "SELECT `key` FROM delete_keys WHERE id = 6";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $brandfetch = decrypt($row['key'], $secret_key);
    }


    // Process second form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['clearchatkey']) && isset($_POST['deletemsgkey']) && isset($_POST['deleteorder'])&& isset($_POST['deletecorelead']) && isset($_POST['deletebrand'])) {
        // Update keys in the database
        $clearchatkey = encrypt($_POST['clearchatkey'], $secret_key);
        $deletemsgkey = encrypt($_POST['deletemsgkey'], $secret_key);
        $deleteorder = encrypt($_POST['deleteorder'], $secret_key);
        $deleteorder = encrypt($_POST['deletecorelead'], $secret_key);
        $deleteorder = encrypt($_POST['deletebrand'], $secret_key);


        // Update query for user delete key
        $sql1 = "UPDATE delete_keys SET `key` = ? WHERE id = 2";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("s", $clearchatkey);

        // Update query for delete live lead
        $sql2 = "UPDATE delete_keys SET `key` = ? WHERE id = 3";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("s", $deletemsgkey);

        // Update query for delete order
        $sql3 = "UPDATE delete_keys SET `key` = ? WHERE id = 4";
        $stmt3 = $conn->prepare($sql3);
        $stmt3->bind_param("s", $deleteorder);
        // Update query for delete core lead
        $sql4 = "UPDATE delete_keys SET `key` = ? WHERE id = 5";
        $stmt4 = $conn->prepare($sql4);
        $stmt4->bind_param("s", $deleteorder);
        // Update query for delete brand
        $sql5 = "UPDATE delete_keys SET `key` = ? WHERE id = 6";
        $stmt5 = $conn->prepare($sql5);
        $stmt5->bind_param("s", $deleteorder);


        if ($stmt1->execute() && $stmt2->execute() && $stmt3->execute() && $stmt4->execute() && $stmt5->execute()) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Success!', 
                        text: 'Keys updated successfully!',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 2500
                    }).then(function() {
                        window.location = 'delete-keys';
                    });
                });
            </script>";
        } else {
            $error_message = "Failed to update keys. Please try again.";
        }
    }
    ?>

    <!--end header -->

    <!--start page wrapper -->

    <div class="page-wrapper">

        <div class="page-content">

            <!--breadcrumb-->



            <!--end breadcrumb-->

            <div class="row">

                <div class="col-xl-10 mx-auto">

                    <!-- <h6 class="mb-0 text-uppercase">Basic Form</h6> -->

                    <!-- <hr /> -->

                    <div class="card border-top border-0 border-4 border-white">

                        <div class="card-body p-5">

                            <div class="card-title d-flex align-items-center">

                                <div><i class="bx bxs-trash me-1 font-22 text-white"></i>

                                </div>

                                <h5 class="mb-0 text-white">Delete Keys</h5>

                            </div>

                            <hr>


                            <div class="container" id="first-form" >
                                <?php
                                if (!empty($error_message)) {
                                ?>
                                    <div class="alert alert-danger" style="background-color:rgb(255 255 255 / 15%)" role="alert" style="text-transform : capitalize;">
                                       <b>- Access Denied </b><br><br>
                                        <?php
                                        echo '<div class="alert alert-danger" role="alert" style="background-color:rgb(255 255 255 / 15%)"><b>' . $error_message . '</b></div>';
                                        ?>
                                    </div>
                                <?php
                                } ?>
                                <form method="post" class="row g-3">
                                    <div class="col-md-10">
                                        <label for="secret_key" class="form-label">Secret Key:</label>
                                        <input type="password" class="form-control" id="secret_key"  name="secret_key" required>
                                    </div>
                                    <br>
                                    <div class="col-10 text-center">
                                    <button type="submit" name="scrtkey" class="btn btn-primary mt-2">Submit</button>
                                    </div>
                                </form>
                            </div>

                            <div class="container" id="second-form" style="width: 850px !important; display: none;">
                                <h2>Update Secret Keys</h2>
                                <form method="post" class="row g-3">
                                    <div class="col-md-10">
                                        <label for="clearchatkey" style="margin-top:20px" class="form-label">User Delete Key:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($clearchat); ?>" id="clearchatkey" name="clearchatkey" required>
                                    </div>
                                    <div class="col-md-10">
                                        <label for="deletemsgkey" style="margin-top:20px" class="form-label">Live Lead Delete Key:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($deletemsg); ?>" id="deletemsgkey" name="deletemsgkey" required>
                                    </div>
                                    <div class="col-md-10">
                                        <label for="deleteorder" style="margin-top:20px" class="form-label">Order Delete Key:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($deleteorderfetch); ?>" id="deletemsgkey" name="deleteorder" required>
                                    </div>
                                    <div class="col-md-10">
                                        <label for="deleteorder" style="margin-top:20px" class="form-label">Core Lead Delete Key:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($deleteleadfetch); ?>" id="deletemsgkey" name="deletecorelead" required>
                                    </div>
                                    <div class="col-md-10">
                                        <label for="deleteorder" style="margin-top:20px" class="form-label">Brands Delete Key:</label>
                                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($brandfetch); ?>" id="deletemsgkey" name="deletebrand" required>
                                    </div>

                                    <div class="col-10 text-center">
                                    <button type="submit" class="btn btn-primary mt-2">Save Changes</button>
                                    </div>
                                </form>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php require_once("./main_components/footer.php"); ?>