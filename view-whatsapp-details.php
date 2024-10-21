<?php $TITLE = "View Whatsapp Details"; ?>

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



            <h6 class="mb-0 text-uppercase">Whatsapp Details</h6>

            <hr />

            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="example" class="table table-striped table-bordered" style="width:100%">

                            <thead>

                                <tr>

                                    <th>ID</th>

                                    <th>Whatsapp Name</th>
                                    <th>Whatsapp Number</th>

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

                                $whatsapp = getWhatsapp($conn);



                                foreach ($whatsapp as $whatsappdetail) : ?>

                                    <tr>

                                        <td><?php echo $whatsappdetail['id']; ?></td>

                                        <td><?php echo $whatsappdetail['whatsapp_name']; ?></td>
                                        <td><?php echo $whatsappdetail['whatsapp_number']; ?></td>

                                      
                                        <?php
                                        if ($_SESSION['role'] == 'Admin') {

                                        ?>

                                            <form method='post' action='edit-whatsapp-detail'>

                                                <input type='hidden' name='whatsapp_id' value='<?php echo $whatsappdetail['id']; ?>'>

                                                <td>

                                                    <button type="submit" name='edit-whatsappdetail' class="bg-secondary text-white px-3 rounded-pill">

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

                                                <form method="post" onsubmit="return confirm('Are you sure you want to delete this Whatsapp Detail?');">

                                                    <input type="hidden" name="whatsapp_id" value="<?php echo $whatsappdetail['id']; ?>">

                                                    <button type="submit" name="delete_whatsappdetail" class="bg-danger text-white px-3 rounded-pill">

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


if (isset($_SESSION['up_whatsappDetail'])) {
    echo "<script>alertify.success('{$_SESSION['up_whatsappDetail']}', { position: 'top-right' });</script>";
    unset($_SESSION['up_whatsappDetail']);
}

if (isset($_SESSION['delWhatsappDetail'])) {
    echo "<script>alertify.success('{$_SESSION['delWhatsappDetail']}', { position: 'top-right' });</script>";
    unset($_SESSION['delWhatsappDetail']);
}

?>

<?php require_once("./main_components/footer.php"); ?>