<?php  $TITLE = "Edit Permission"; ?> 

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

						

						<hr/>

        <div class="card border-top border-0 border-4 border-white">

            <div class="card-body p-5">

                <div class="card-title d-flex align-items-center">

                    <div><i class="bx bxs-user me-1 font-22 text-white"></i>

                    </div>

                    <h5 class="mb-0 text-white">Edit Permission</h5>

                </div>

                <hr>

                <form  method="post" class="row g-3">

				<input type="hidden" name="permissionId" value="<?php echo $editPermissionData['permissionid']; ?>">



                <div class="col-12">

    <!-- <label for="username" class="form-label">Username</label> -->

    <p type="text" id="username" class="form-control" >You are edited <?php echo $editPermissionData['name']; ?> account permissions</p>

</div>

                    <div class="col-12">



                <div class="form-check">

                    <input  name="permissions[]" value="log_management" <?php echo ($editPermissionData['log_management'] == 'Allow') ? 'checked' : ''; ?> class="form-check-input" type="checkbox" id="checkLogManagement">

                    <label class="form-check-label" for="checkLogManagement">Log Management</label>

                </div>

                <div class="form-check">

                    <input  name="permissions[]" value="view_users" <?php echo ($editPermissionData['view_users'] == 'Allow') ? 'checked' : ''; ?> class="form-check-input" type="checkbox" id="checkLogManagement">

                    <label class="form-check-label" for="checkLogManagement">View Users</label>

                </div>

                <div class="form-check">

                    <input  name="permissions[]" value="Add_user" <?php echo ($editPermissionData['Add_user'] == 'Allow') ? 'checked' : ''; ?> class="form-check-input" type="checkbox" id="checkLogManagement">

                    <label class="form-check-label" for="checkLogManagement">Add Users</label>

                </div>

                <div class="form-check">

                    <input  name="permissions[]" value="add_shift" <?php echo ($editPermissionData['add_shift'] == 'Allow') ? 'checked' : ''; ?> class="form-check-input" type="checkbox" id="checkLogManagement">

                    <label class="form-check-label" for="checkLogManagement">Add Bank Accounts</label>

                </div>

                <div class="form-check">

                    <input  name="permissions[]" value="view_shift" <?php echo ($editPermissionData['view_shift'] == 'Allow') ? 'checked' : ''; ?> class="form-check-input" type="checkbox" id="checkLogManagement">

                    <label class="form-check-label" for="checkLogManagement">View Bank Accounts</label>

                </div>

                <div class="form-check">

                    <input  name="permissions[]" value="view_team" <?php echo ($editPermissionData['view_team'] == 'Allow') ? 'checked' : ''; ?> class="form-check-input" type="checkbox" id="checkLogManagement">

                    <label class="form-check-label" for="checkLogManagement">View Team</label>

                </div>

                <div class="form-check">

                    <input  name="permissions[]" value="add_team" <?php echo ($editPermissionData['add_team'] == 'Allow') ? 'checked' : ''; ?> class="form-check-input" type="checkbox" id="checkLogManagement">

                    <label class="form-check-label" for="checkLogManagement">Add Team</label>

                </div>

                <div class="form-check">

                    <input  name="permissions[]" value="add_lead" <?php echo ($editPermissionData['add_lead'] == 'Allow') ? 'checked' : ''; ?> class="form-check-input" type="checkbox" id="checkLogManagement">

                    <label class="form-check-label" for="checkLogManagement">Add Lead</label>

                </div>

                <div class="form-check">

                    <input  name="permissions[]" value="view_lead" <?php echo ($editPermissionData['view_lead'] == 'Allow') ? 'checked' : ''; ?> class="form-check-input" type="checkbox" id="checkLogManagement">

                    <label class="form-check-label" for="checkLogManagement">View Leads(Add Orders)
                    </label>

                </div>
                <div class="form-check">

                    <input  name="permissions[]" value="add_core_lead" <?php echo ($editPermissionData['add_core_lead'] == 'Allow') ? 'checked' : ''; ?> class="form-check-input" type="checkbox" id="checkLogManagement">

                    <label class="form-check-label" for="checkLogManagement">Add Core Lead</label>

                </div>

                <div class="form-check">

                    <input  name="permissions[]" value="view_core_lead" <?php echo ($editPermissionData['view_core_lead'] == 'Allow') ? 'checked' : ''; ?> class="form-check-input" type="checkbox" id="checkLogManagement">

                    <label class="form-check-label" for="checkLogManagement">View Core Leads
                    </label>

                </div>

                <div class="form-check">

                    <input  name="permissions[]" value="view_order" <?php echo ($editPermissionData['view_order'] == 'Allow') ? 'checked' : ''; ?> class="form-check-input" type="checkbox" id="checkLogManagement">

                    <label class="form-check-label" for="checkLogManagement">View Order</label>

                </div>

                <div class="form-check">

                    <input  name="permissions[]" value="filter1" <?php echo ($editPermissionData['filter1'] == 'Allow') ? 'checked' : ''; ?> class="form-check-input" type="checkbox" id="checkLogManagement">

                    <label class="form-check-label" for="checkLogManagement">View Plan</label>

                </div>

                <div class="form-check">

                    <input  name="permissions[]" value="filter2" <?php echo ($editPermissionData['filter2'] == 'Allow') ? 'checked' : ''; ?> class="form-check-input" type="checkbox" id="checkLogManagement">

                    <label class="form-check-label" for="checkLogManagement">Add Plan</label>

                </div>

                <!-- <div class="form-check">

                    <input  name="permissions[]" value="filter3" <?php echo ($editPermissionData['filter3'] == 'Allow') ? 'checked' : ''; ?> class="form-check-input" type="checkbox" id="checkLogManagement">

                    <label class="form-check-label" for="checkLogManagement">Filter 3</label>

                </div> -->

                    </div>

                    <div class="col-12 text-center">

                        <button  name="update_permissions" type="submit" class="btn btn-light px-5">Update Permission</button>

                    </div>

                </form>

            </div>

        </div>







<?php require_once("./main_components/footer.php");?>