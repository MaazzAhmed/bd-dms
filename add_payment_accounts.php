<?php  $TITLE = "Add Payment Account"; ?> 

<?php require_once("./main_components/header.php");


if (!isset($_SESSION['role']) || 
    ($_SESSION['role'] !== 'Admin' )) {
        echo "<script>window.location.href = 'index';</script>";
        exit(); 
}
?>

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

				<!--breadcrumb-->

				

				<!--end breadcrumb-->

				<div class="row">

					<div class="col-xl-10 mx-auto">

						<!-- <h6 class="mb-0 text-uppercase">Basic Form</h6> -->

						<hr/>

        <div class="card border-top border-0 border-4 border-white">

            <div class="card-body p-5">

                <div class="card-title d-flex align-items-center">

                    <div><i class="bx bxs-user me-1 font-22 text-white"></i>

                    </div>

                    <h5 class="mb-0 text-white">Add bank</h5>

                </div>

                <hr>

                <form method="post"  class="row g-3">

                    <div class="col-md-6">

                        <label for="inputFirstName" class="form-label">Bank Name</label>

                        <input  type="text" name="account_name"  class="form-control" required id="inputFirstName">

                    </div>

                    <div class="col-12 ">

                        <button type="submit" name="create-bank" class="btn btn-light px-5">Add</button>

                    </div>

                </form>

            </div>

        </div>





<!-- Add this modal code at the end of your HTML body -->

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

                <?php echo $_SESSION['Createbank']?? $_SESSION['CreatebankError']; ?>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>



<?php


// Check if session message is set

if (isset($_SESSION['Createbank'])) {

    // Display the message using Alertify with position at top right

 

    echo "<script>alertify.success('{$_SESSION['Createbank']}', { position: 'top-right' });</script>";



    // Unset the session variable to remove it after displaying the message

    unset($_SESSION['Createbank']);

}

?>

<?php require_once("./main_components/footer.php");?>