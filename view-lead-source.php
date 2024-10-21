<?php $TITLE = "View Lead Source"; ?>

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



    <!--end header -->



    <!--start page wrapper -->

    <div class="page-wrapper">

        <div class="page-content">



            <h6 class="mb-0 text-uppercase">Lead Source</h6>

            <hr />

            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="example" class="table table-striped table-bordered" style="width:100%">

                            <thead>

                                <tr>

                                    <th>ID</th>

                                    <th>Source</th>

                                    <?php
                                    if ($_SESSION['role'] == 'Admin') {

                                    ?>

                                        <th>Edit</th>

                                        <th>Delete</th>
                                    <?php } ?>

                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                $leadsource = getLeadSource($conn);



                                foreach ($leadsource as $source) : ?>

                                    <tr>

                                        <td><?php echo $source['id']; ?></td>

                                        <td><?php echo $source['source']; ?></td>

                                      
                                        <?php
                                        if ($_SESSION['role'] == 'Admin') {

                                        ?>

                                            <form method='post' action='edit-lead-source'>

                                                <input type='hidden' name='leadsource_id' value='<?php echo $source['id']; ?>'>

                                                <td>

                                                    <button type="submit" name='edit_lead_source' class="bg-secondary text-white px-3 rounded-pill">

                                                        <div class="col" tabindex="6">

                                                            <div class="d-flex bg-secondary align-items-center theme-icons shadow-sm cursor-pointer rounded-pill">

                                                                <div class="text-white"><i class="fadeIn animated bx bx-pencil" style="font-size:17px;"></i>

                                                                </div>

                                                                <div class="ms-2">Edit</div>

                                                            </div>

                                                        </div>

                                                    </button>

                                                </td>

                                            </form>

                                            <td>

                                                <form method="post" onsubmit="return confirm('Are you sure you want to delete this Lead Source?');">

                                                    <input type="hidden" name="leadsource_id" value="<?php echo $source['id']; ?>">

                                                    <button type="submit" name="delete_lead_source" class="bg-danger text-white px-3 rounded-pill">

                                                        <div class="col" tabindex="6">

                                                            <div class="d-flex bg-danger align-items-center theme-icons shadow-sm cursor-pointer rounded-pill">

                                                                <div class="text-white"><i class="fadeIn animated bx bx-trash" style="font-size:17px;"></i>

                                                                </div>

                                                                <div class="ms-2">Delete</div>

                                                            </div>

                                                        </div>

                                                    </button>

                                                </form>
                                            <?php } ?>

                                            </td>


                                    </tr>
                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php

if (isset($_SESSION['up_leadSource'])) {
    echo "<script>alertify.success('{$_SESSION['up_leadSource']}', { position: 'top-right' });</script>";
    unset($_SESSION['up_leadSource']);
}

if (isset($_SESSION['delleadSource'])) {

    echo "<script>alertify.success('{$_SESSION['delleadSource']}', { position: 'top-right' });</script>";
    unset($_SESSION['delleadSource']);
}

?>







<?php require_once("./main_components/footer.php"); ?>