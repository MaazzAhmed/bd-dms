<?php $TITLE = "Edit Shift"; ?>

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



            <div class="row">

                <div class="col-xl-10 mx-auto">

                    <!-- <h6 class="mb-0 text-uppercase">Basic Form</h6> -->

                    <hr />

                    <div class="card border-top border-0 border-4 border-white">

                        <div class="card-body p-5">

                            <div class="card-title d-flex align-items-center">

                                <div><i class="bx bxs-user me-1 font-22 text-white"></i>

                                </div>

                                <h5 class="mb-0 text-white">Edit Shift</h5>

                            </div>

                            <hr>

                            <form method="post" class="row g-3">

                                <input type="hidden" name="shift_id" value="<?php echo $shiftData['shiftId']; ?>">

                                <div class="col-md-6">

                                    <label for="inputShift" class="form-label">Shift Type</label>

                                    <select name="shift_type" id="inputShift" required class="form-select">

                                        <?php

                                        $enumValues = fetchEnumValues($conn, 'shift', 'shift_type');



                                        foreach ($enumValues as $enum) {

                                            echo "<option value='$enum'" . ($shiftData['shift_type'] == $enum ? ' selected' : '') . ">$enum</option>";
                                        }

                                        ?>

                                    </select>

                                </div>

                                    <!-- <div class="col-md-6">

                                        <label for="inputTime" class="form-label">Start Timing</label>

                                        <input type="time" name="start_timing" value="<?php echo $shiftData['start_timing']; ?>" required id="inputTime" class="form-select">



                                    </div>

                                    <div class="col-md-12">

                                        <label for="inputEndTime" class="form-label">End Timing</label>

                                        <input type="time" name="end_timing" value="<?php echo $shiftData['end_timing']; ?>" required id="inputTime" class="form-select">



                                    </div> -->

                                <div class="col-md-12 ">

                                    <button type="submit" name="update_shift" class="btn btn-light px-5">Update Shift</button>

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

                                    <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span> -->

                                    </button>

                                </div>

                                <div class="modal-body">

                                    <?php echo $_SESSION['notification'] ?? $_SESSION['notificationError']; ?>

                                </div>

                                <div class="modal-footer">

                                    <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->

                                </div>

                            </div>

                        </div>

                    </div>



                    <!-- JavaScript to show the modal -->

                    <script>
                        $(document).ready(function() {

                            <?php

                            if (isset($_SESSION['notification']) || isset($_SESSION['notificationError'])) {

                                echo "$('#notificationModal').modal('show');";

                                unset($_SESSION['notification']); // Clear the session variable

                                unset($_SESSION['notificationError']); // Clear the session variable

                            }

                            ?>



                            $('#notificationModal').on('hidden.bs.modal', function() {

                                redirectToPage();

                            });



                            // Function to redirect after modal is closed

                            function redirectToPage() {

                                window.location.href = 'view-shift';

                            }

                        });
                    </script>

                    <?php require_once("./main_components/footer.php"); ?>