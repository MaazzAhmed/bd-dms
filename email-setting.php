<?php $TITLE = $_POST['title']; ?>

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

    <?php require_once("./main_components/navbar.php");
  

    if (isset($_POST['id'])) {
        $rowId = intval($_POST['id']); 

        $query = "SELECT * FROM email_setting WHERE id = $rowId";
        $queryResult = $conn->query($query);

        if ($queryResult->num_rows == 1) {
            $row = $queryResult->fetch_assoc();

            $email = $row['email'];
            $password = $row['password'];
            $servername = $row['servername'];
            $port = $row['port'];
            $description = $row['description'];
            $brand = $row['brandname'];
    ?>
            <!--end header -->

            <!--start page wrapper -->

            <div class="page-wrapper">

                <div class="page-content">
                    <?php

                    if (isset($_SESSION['eset2'])) {
                        echo "<script>alertify.success('{$_SESSION['eset2']}', { position: 'top-right' });</script>";
                        unset($_SESSION['eset2']);
                    }
                    ?>
                    <div class="row">
                        <div class="col-xl-7 mx-auto">
                            <div class="card border-top border-0 border-4 border-white">
                                <div class="card-body p-5">
                                    <div class="card-title d-flex align-items-center">
                                        <div><i class="bx bxs-envelope me-1 font-22 text-white"></i>
                                        </div>
                                        <h5 class="mb-0 text-white"><?php echo $brand ?> Email Setting</h5>
                                    </div>
                                    <hr>
                                    <form method="post" class="row g-3">
                                        <input type="hidden" name="id" value="<?php echo $rowId; ?>">
                                        <div class="col-md-6">
                                            <label for="inputFirstName" class="form-label">Server Name</label>
                                            <input type="text" class="form-control" required id="inputFirstName" value="<?php echo htmlspecialchars($servername); ?>" name="servername">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputFirstName" class="form-label">Server Port</label>
                                            <input type="text" class="form-control" required id="inputFirstName" name="port" value="<?php echo htmlspecialchars($port); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputFirstName" class="form-label">Server Email</label>
                                            <input type="email" class="form-control" required id="inputFirstName" name="email" value="<?php echo htmlspecialchars($email); ?>">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="inputFirstName" class="form-label">Server Password</label>
                                            <input type="text" class="form-control" required id="inputFirstName" name="password" value="<?php echo htmlspecialchars($password); ?>">
                                        </div>
                                        <div class="col-md-12">
                                            <textarea name="desc" id="textsss" cols="20" rows="10" class="form-control"><?php echo htmlspecialchars($description); ?></textarea>
                                        </div>
                                        <div class="col-12 text-center">
                                            <button type="submit" name="server_credentials-2" class="btn btn-light px-5">Save Changes</button>
                                        </div>
                                    </form>


                                </div>

                            </div>
                        </div>
                    </div>
                    <?php
                } else {
                    echo "No records found.";
                }
            } else {
                echo "No ID specified.";
            }
            $conn->close();
                    ?>
                    <?php require_once("./main_components/footer.php"); ?>