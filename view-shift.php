<?php $TITLE = "View Shifts"; ?>

<?php require_once("./main_components/header.php"); 


if (!isset($_SESSION['role']) || 
    ($_SESSION['role'] !== 'Admin' && 
    $userPermissions['view_shift'] !== 'Allow')) {
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



            <h6 class="mb-0 text-uppercase">Shift</h6>

            <hr />

            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="example" class="table table-striped table-bordered" style="width:100%">

                            <thead>

                                <tr>

                                    <th>Shift ID</th>

                                    <th>Shift Type</th>

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

                                $shifts = getShiftsRecords($conn);

                                foreach ($shifts as $shift) : ?>

                                    <tr>

                                        <td><?php echo $shift['shiftId']; ?></td>

                                        <td><?php echo $shift['shift_type'].' <b>'. $shift['start_timing'].'</b>  TO <b>'. $shift['end_timing'] .'</b>'; ?></td>

                                        <?php
                                        if ($_SESSION['role'] == 'Admin') {

                                        ?>
                                            <form method='post' action='edit-shift'>

                                                <input type='hidden' name='shift_id' value='<?php echo $shift['shiftId']; ?>'>

                                                <td>

                                                    <button type="submit" name='edit_shift'
                                                        class="bg-secondary text-white px-3 rounded-pill">

                                                        <div class="col" tabindex="6">

                                                            <div
                                                                class="d-flex bg-secondary align-items-center theme-icons shadow-sm cursor-pointer rounded-pill">

                                                                <div class="text-white"><i class="fadeIn animated bx bx-pencil"
                                                                        style="font-size:17px;"></i>

                                                                </div>

                                                                <div class="ms-2">Edit</div>

                                                            </div>

                                                        </div>

                                                    </button>

                                                </td>

                                            </form>

                                            <form method="post"
                                                onsubmit="return confirm('Are you sure you want to delete this Shift?');">

                                                <input type="hidden" name="shift_id" value="<?php echo $shift['shiftId']; ?>">

                                                <td>

                                                    <button type="submit" name="delete_shift"
                                                        class="bg-danger text-white px-3 rounded-pill">

                                                        <div class="col" tabindex="6">

                                                            <div
                                                                class="d-flex bg-danger align-items-center theme-icons shadow-sm cursor-pointer rounded-pill">

                                                                <div class="text-white"><i class="fadeIn animated bx bx-trash"
                                                                        style="font-size:17px;"></i>

                                                                </div>

                                                                <div class="ms-2">Delete</div>

                                                            </div>

                                                        </div>

                                                    </button>

                                                </td>

                                            </form>
                                        <?php } ?>
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


if (isset($_SESSION['editshift'])) {
    echo "<script>alertify.success('{$_SESSION['editshift']}', { position: 'top-right' });</script>";
    unset($_SESSION['editshift']);
}


if (isset($_SESSION['delshift'])) {
    echo "<script>alertify.success('{$_SESSION['delshift']}', { position: 'top-right' });</script>";
    unset($_SESSION['delshift']);
}

?>





<?php require_once("./main_components/footer.php"); ?>