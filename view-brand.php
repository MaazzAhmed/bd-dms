<?php $TITLE = "View Brand"; ?>

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



            <h6 class="mb-0 text-uppercase">View Brands</h6>

            <hr />

            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="example" class="table table-striped table-bordered" style="width:100%">

                            <thead>

                                <tr>

                                    <th>ID</th>

                                    <th>Brand Names</th>

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

                                $brands = getBrands($conn);



                                foreach ($brands as $brand) : ?>

                                    <tr>

                                        <td><?php echo $brand['id']; ?></td>

                                        <td><?php echo $brand['brand_name']; ?></td>


                                        <?php
                                        if ($_SESSION['role'] == 'Admin') {

                                        ?>

                                            <form method='post' action='edit-brand'>

                                                <input type='hidden' name='brand_id' value='<?php echo $brand['id']; ?>'>

                                                <td>

                                                    <button type="submit" name='edit_brand' class="bg-secondary text-white px-3 rounded-pill">

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

                                                <form method="post" action="" id="deleteBrandForm_<?php echo $brand['id']; ?>" onsubmit="return false;">
                                                    <input type="hidden" name="brand_id" value="<?php echo $brand['id']; ?>">
                                                    <button type="button" class="bg-danger text-white px-3 rounded-pill" onclick="confirmKeyAndDeleteBrand('<?php echo $brand['id']; ?>')">
                                                        <div class="col" tabindex="6">
                                                            <div class="d-flex bg-danger align-items-center theme-icons shadow-sm cursor-pointer rounded-pill">
                                                                <div class="text-white">
                                                                    <i class="fadeIn animated bx bx-trash" style="font-size:17px;"></i>
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
<script>
    function confirmKeyAndDeleteBrand(brandId) {
        Swal.fire({
            title: 'Enter Deletion Key',
            input: 'text',
            inputLabel: 'Please enter the key to confirm brand deletion',
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
                const formData = new FormData(document.getElementById('deleteBrandForm_' + brandId));
                formData.append('inputKey', inputKey);
                formData.append('action', 'delete_brand');

                $.ajax({
                    url: 'main_components/global.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Deleted!', response.message, 'success');
                             setTimeout(() => {
                                Swal.close(); 
                                location.reload(); // Reload the page after closing the alert
                            }, 2000); // 5000 milliseconds = 5 seconds

                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error!', 'An error occurred during the deletion process.', 'error');
                    }
                });
            }
        });
    }
</script>
<?php


if (isset($_SESSION['up_brand'])) {
    echo "<script>alertify.success('{$_SESSION['up_brand']}', { position: 'top-right' });</script>";
    unset($_SESSION['up_brand']);
}





if (isset($_SESSION['delbrand'])) {

    echo "<script>alertify.success('{$_SESSION['delbrand']}', { position: 'top-right' });</script>";

    unset($_SESSION['delbrand']);
}

?>

<?php require_once("./main_components/footer.php"); ?>