<?php  $TITLE = "Edit Whatsapp Details"; ?> 

<?php require_once("./main_components/header.php");?>

<!--wrapper-->
<div class="wrapper">

    <!--sidebar wrapper -->
    <?php require_once("./main_components/sidebar.php");?>
    <!--end sidebar wrapper -->

    <!--start header -->
    <?php require_once("./main_components/navbar.php");?>
    <!--end header -->

    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            <div class="row">
                <div class="col-xl-10 mx-auto">
                    <hr/>
                    <div class="card border-top border-0 border-4 border-white">
                        <div class="card-body p-5">
                            <div class="card-title d-flex align-items-center">
                                <div><i class="bx bxs-user me-1 font-22 text-white"></i></div>
                                <h5 class="mb-0 text-white">Edit Whatsapp Details</h5>
                            </div>
                            <hr>
                            <form method="post" class="row g-3">
                                <input type="hidden" name="whatsapp_id" value="<?php echo $WhatsappDetails['id']; ?>">

                                <div class="col-md-6">
                                    <label for="lead_source" class="form-label">Whatsapp Detail</label>
                                    <input type="text" name="whatsappname" value="<?php echo $WhatsappDetails['whatsapp_name']; ?>" required class="form-control" id="lead_source">
                                </div>
                                <div class="col-md-6">
                                    <label for="lead_source" class="form-label">Whatsapp Detail</label>
                                    <input type="text" name="whatsappnnumber" value="<?php echo $WhatsappDetails['whatsapp_number']; ?>" required class="form-control" id="lead_source">
                                </div>

                                <div class="col-12 text-center">
                                    <button type="submit" name="update_whatsappdetail" class="btn btn-light px-5">Update </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Notification Modal -->
                    <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="notificationModalLabel">Notification</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <?php echo $_SESSION['up_brand'] ?? $_SESSION['up_brand']; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--end page wrapper -->

    <?php require_once("./main_components/footer.php");?>  
</div>