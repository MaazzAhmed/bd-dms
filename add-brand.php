<?php



$TITLE = "Add Brand"; ?>

<?php require_once("./main_components/header.php"); 

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
    header('Location: index');
    exit();
}?>

<!--wrapper-->

<div class="wrapper">

    <!--sidebar wrapper -->

    <?php require_once("./main_components/sidebar.php"); ?>

    <!--end sidebar wrapper -->

    <!--start header -->

    <?php require_once("./main_components/navbar.php"); ?>



    <!--end header -->

    <!--start page wrapper -->

    <div class="page-wrapper">

        <div class="page-content">


            <div class="row">

                <div class="col-xl-10 mx-auto">

                    <div class="card border-top border-0 border-4 border-white">

                        <div class="card-body p-5">

                            <div class="card-title d-flex align-items-center">

                                <div><i class="bx bxs-user me-1 font-22 text-white"></i>

                                </div>

                                <h5 class="mb-0 text-white">Add Brand</h5>

                            </div>

                            <hr>

                            <form method="post" class="row g-3">

                                <div class="col-md-12">

                                    <label for="inputFirstName" class="form-label">Brand Name</label>

                                    <input type="text" name="brandname" class="form-control" required id="inputFirstName">

                                </div>
                                <br>
                                <div class="col-md-12">
                                    <center><h3>Email Credentials</h3></center>
                                </div>

                                <div class="col-md-6">
                                        <label for="inputFirstName" class="form-label">Server Name</label>
                                        <input type="text" class="form-control" required id="inputFirstName"  name="servername">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputFirstName" class="form-label">Server Port</label>
                                        <input type="text" class="form-control" required id="inputFirstName" name="port">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputFirstName" class="form-label">Server Email</label>
                                        <input type="email" class="form-control" required id="inputFirstName" name="email" >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputFirstName" class="form-label">Server Password</label>
                                        <input type="text" class="form-control" required id="inputFirstName" name="password">
                                    </div>
                                    <div class="col-md-12">
                                        <textarea name="desc" id="textsss" cols="20" rows="10" class="form-control"></textarea>
                                    </div>



                                

                                <div class="col-12 text-center">

                                    <button type="submit" name="create-brand" class="btn btn-light px-5">Add Brand</button>

                                </div>

                            </form>

                        </div>

                    </div>

                    <div class="modal fade" id="notificationModalC" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">

                        <div class="modal-dialog" role="document">

                            <div class="modal-content">

                                <div class="modal-header">

                                    <h5 class="modal-title" id="notificationModalLabel">Notification</h5>

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                        <span aria-hidden="true">&times;</span>

                                    </button>

                                </div>

                                <div class="modal-body">

                                    <?php echo $_SESSION['Createbrand'] ?? $_SESSION['CreatebrandError']; ?>

                                </div>

                                <div class="modal-footer">

                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                                </div>

                            </div>

                        </div>

                    </div>



                    <?php

                    if (isset($_SESSION['Createbrand'])) {
                        echo "<script>alertify.success('{$_SESSION['Createbrand']}', { position: 'top-right' });</script>";
                        unset($_SESSION['Createbrand']);
                    }
                    ?>
                    <?php require_once("./main_components/footer.php"); ?>