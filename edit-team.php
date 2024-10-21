<?php  $TITLE = "Edit Team"; ?> 

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

						<!-- <h6 class="mb-0 text-uppercase">Basic Form</h6> -->

						<hr/>

        <div class="card border-top border-0 border-4 border-white">

            <div class="card-body p-5">

                <div class="card-title d-flex align-items-center">

                    <div><i class="bx bxs-user me-1 font-22 text-white"></i>

                    </div>

                    <h5 class="mb-0 text-white">Edit Team</h5>

                </div>

                <hr>

                <form  method="post" class="row g-3">

				<input type="hidden" name="team_id" value="<?php echo $teamId; ?>">

                    <div class="col-md-6">

                        <label for="inputFirstName" class="form-label">Team Name</label>

                        <input type="text" name="team_name" value="<?php echo $teamDetails['team_name']; ?>" required class="form-control" required id="inputFirstName">

                    </div>

                    <div class="col-md-6">

                        <label for="inputState" class="form-label">Team Lead</label>

                        <select  name="team_lead" id="inputState" class="form-select">

						<?php

            // Display user names in dropdown

            $users = getName($conn);

            foreach ($users as $user) {

                echo "<option value='" . $user['userId'] . "'";

                if ($user['userId'] == $teamDetails['team_lead']) {

                    echo " selected";

                }

                echo ">" . $user['name'] . "</option>";

            }

            ?>

                        </select>

                    </div>

                    <div class="col-12 text-center">

                        <button type="submit" name="update_team" class="btn btn-light px-5">Update Team</button>

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

            <?php echo $_SESSION['up_team'] ?? $_SESSION['up_teamError']; ?>

            </div>

            <div class="modal-footer">

                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->

            </div>

        </div>

    </div>

</div>





<?php require_once("./main_components/footer.php");?>