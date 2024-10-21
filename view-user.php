<?php $TITLE = "View Users"; ?>
<?php require_once("./main_components/header.php");



if (!isset($_SESSION['role']) || 
    ($_SESSION['role'] !== 'Admin' && 
    $userPermissions['view_users'] !== 'Allow')) {
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



            <h6 class="mb-0 text-uppercase">Users</h6>

            <hr />



            <?php

            if (isset($_SESSION['eumessage'])) {
                echo "<script>alertify.success('{$_SESSION['eumessage']}', { position: 'top-right' });</script>";
                unset($_SESSION['eumessage']);
            }

            if (isset($_SESSION['delumessage'])) {
                echo "<script>alertify.success('{$_SESSION['delumessage']}', { position: 'top-right' });</script>";
                unset($_SESSION['delumessage']);
            }

            ?>

            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="example" class="table table-striped table-bordered" style="width:100%">

                            <thead>

                                <tr>

                                    <th>User ID</th>

                                    <th>Name</th>

                                    <th>Email</th>

                                    <th>Role</th>

                                    <th>Team Name</th>

                                    <th>Shift</th>

                                    <th>Status</th>
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

                                // View Users

                                $users = getUsers($conn);

                                foreach ($users as $user) : ?>

                                    <tr>

                                        <td><?php echo $user['userId']; ?></td>

                                        <td><?php echo $user['name']; ?></td>

                                        <td><?php echo $user['email']; ?></td>

                                        <td><?php echo $user['role']; ?></td>

                                        <td><?php echo $user['team_name']; ?></td>

                                        <td><?php echo $user['shift_type']; ?></td>

                                        <td><?php echo $user['system_status']; ?></td>


                                        <?php
                                        if ($_SESSION['role'] == 'Admin') {

                                        ?>
                                            <form method="post" action="edit-user">

                                                <input type="hidden" name="userId" value="<?php echo $user['userId']; ?>">

                                                <td>

                                                    <button type="submit" name="edit_user" class="bg-secondary text-white px-3 rounded-pill">

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

                                            <form method="post" action="" id="deleteUserForm_<?php echo $user['userId']; ?>" onsubmit="return false;">
                                                <input type="hidden" name="userId" value="<?php echo $user['userId']; ?>">
                                                <td>
                                                    <button type="button" class="bg-danger text-white px-3 rounded-pill" onclick="confirmKeyAndDelete('<?php echo $user['userId']; ?>')">
                                                        <div class="col">
                                                            <div class="d-flex bg-danger align-items-center theme-icons shadow-sm cursor-pointer rounded-pill">
                                                                <div class="text-white">
                                                                    <i class="fadeIn animated bx bx-trash" style="font-size:17px;"></i>
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





<script>
    function confirmKeyAndDelete(userId) {
        Swal.fire({
            title: 'Enter Deletion Key',
            input: 'text',
            inputLabel: 'Please enter the key to confirm deletion',
            inputPlaceholder: 'Enter your key here',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            preConfirm: (inputKey) => {
                if (!inputKey) {
                    Swal.showValidationMessage('Key is required!');
                    return false;
                } else {
                    return inputKey;
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const inputKey = result.value;
                $.ajax({
                    url: 'main_components/global.php',
                    type: 'POST',
                    data: {
                        action: 'delete_user',
                        userId: userId,
                        inputKey: inputKey
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log("AJAX Response:", response); // Add this to inspect the response
                        if (response.status === 'success') {
                            Swal.fire('Deleted!', response.message, 'success');
                            location.reload(); 
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", xhr.responseText); 
                        Swal.fire('Error!', 'An error occurred during the deletion process.', 'error');
                    }
                });
            }
        });
    }
</script>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php require_once("./main_components/footer.php"); ?>