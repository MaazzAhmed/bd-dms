<?php $TITLE = "Import Live Lead"; ?>

<?php require_once("./main_components/global.php"); ?>

<?php require_once("./main_components/header.php"); ?>

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

            <!--breadcrumb-->



            <!--end breadcrumb-->

            <div class="row">

                <div class="col-xl-10 mx-auto">

                    <div class="card border-top border-0 border-4 border-white">

                        <div class="card-body p-5">

                            <div class="card-title d-flex align-items-center">

                                <div><i class="bx bxs-user me-1 font-22 text-white"></i>

                                </div>

                                <h5 class="mb-0 text-white">Import Live Lead</h5>

                            </div>

                            <hr>

                            <form method="post" enctype="multipart/form-data" class="row g-3">
                                <div class="col-md-6">
                                    <label for="csv_file" class="form-label">Upload File</label>
                                    <input type="file" class="form-control" id="csv_file" name="csv_file" accept=".csv">
                                </div>
                                <div class="col-md-12">
                                    <label for="csv_file" class="form-label">Example CSV</label>
                                    <a href="examplecsv/examples.csv" download=""><b>Download</b></a>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" name="import-leads" class="btn btn-light px-5">Import CSV</button>
                                </div>
                            </form>


                        </div>

                    </div>



                    <?php require_once("./main_components/footer.php"); ?>