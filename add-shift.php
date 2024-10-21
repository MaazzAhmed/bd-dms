<?php  $TITLE = "Add Shift"; ?> 

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

				<!--breadcrumb-->

				

				<!--end breadcrumb-->

				<div class="row">

					<div class="col-xl-10 mx-auto">

						<h6 class="mb-0 text-uppercase">Add Shift</h6>

						<hr/>

        <div class="card border-top border-0 border-4 border-white">

            <div class="card-body p-5">

                <div class="card-title d-flex align-items-center">

                    <div><i class="bx bxs-user me-1 font-22 text-white"></i>

                    </div>

                    <h5 class="mb-0 text-white">User Registration</h5>

                </div>

                <hr>

                <form method="post"  class="row g-3">

				<div class="col-md-6">

                        <label for="inputShift" class="form-label">Shift Type</label>

                        <select   name="shift_type" id="inputShift" class="form-select">

                            <option selected disabled>Choose...</option>

							<?php

            $enumValues = fetchEnumValues($conn, 'shift', 'shift_type');

            foreach ($enumValues as $enum) {

                echo "<option value='$enum'>$enum</option>";

            }

            ?>

                        </select>

                    </div>


                    <div class="col-12 text-center">

                        <button type="submit" name="create_shift" class="btn btn-light px-5">Create Shift</button>

                    </div>

                </form>

            </div>

        </div>


        <?php


// Check if session message is set
if (isset($_SESSION['ShiftCreate'])) {
    // Display the message using Alertify with position at top right
 
    echo "<script>alertify.success('{$_SESSION['ShiftCreate']}', { position: 'top-right' });</script>";

    // Unset the session ShiftCreate to remove it after displaying the message
    unset($_SESSION['ShiftCreate']);
}
?>



<?php require_once("./main_components/footer.php");?>