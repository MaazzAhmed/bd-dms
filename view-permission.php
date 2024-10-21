<?php $TITLE = "View Permissions"; ?>




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

            <?php

            if (isset($_SESSION['epermission'])) {
                echo "<script>alertify.success('{$_SESSION['epermission']}', { position: 'top-right' });</script>";
                unset($_SESSION['epermission']);
            }

            ?>

            <h6 class="mb-0 text-uppercase">Permissions</h6>

            <hr />

            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="example" class="table table-striped table-bordered" style="width:100%">

                            <thead>

                                <tr>

                                    <th>Permission ID</th>

                                    <th>UserName</th>

                                    <th>User Role</th>

                                    <th>View Lead</th>

                                    <th>Log Management</th>
                                    <?php
                                    if ($_SESSION['role'] == 'Admin') {

                                    ?>

                                        <th>Edit</th>
                                    <?php } ?>

                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                $getPermissionsData = getPermissionsData($conn);

                                foreach ($getPermissionsData as $permissionData) : ?>



                                    <tr>

                                        <td><?php echo $permissionData['permissionid']; ?></td>

                                        <td><?php echo $permissionData['username']; ?></td>

                                        <td><?php echo $permissionData['role']; ?></td>

                                        <td><?php echo $permissionData['view_lead']; ?></td>

                                        <td><?php echo $permissionData['log_management']; ?></td>
                                        <?php
                                        if ($_SESSION['role'] == 'Admin') {

                                        ?>

                                            <form method="post" action="edit-permissions">

                                                <input type="hidden" name="pd_id" value="<?php echo $permissionData['permissionid']; ?>">

                                                <td>

                                                    <button type="submit" name="edit_permissions" class="bg-secondary text-white px-3 rounded-pill">

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

<?php require_once("./main_components/footer.php"); ?>