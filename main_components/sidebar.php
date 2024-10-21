<div class="sidebar-wrapper" data-simplebar="true">

	<div class="sidebar-header">

		<div>

			<img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">

		</div>

		<div>

			<a href="./">

				<h4 class="logo-text">BD-DMS</h4>

			</a>

		</div>

		<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>

		</div>

	</div>

	<!--navigation-->

	<ul class="metismenu" id="menu">



		<?php if ($userPermissions['view_lead'] == 'Allow' || $_SESSION['role'] == 'Admin' || $userPermissions['add_lead'] == 'Allow') : ?>
			<br>
			<p>Leads Management</p>
			<li>
				<a href="javascript:;" class="has-arrow">
					<div class="parent-icon"><i class="bx bx-folder"></i>
					</div>
					<div class="menu-title">Leads</div>
				</a>
				<ul class="mm-collapse">
					<?php if ($userPermissions['view_lead'] == 'Allow' || $_SESSION['role'] == 'Admin') : ?>
						<li><a href="view-leads"><i class="bx bx-right-arrow-alt"></i>View Live Leads</a></li>
					<?php endif; ?>
					<?php if ($userPermissions['view_core_lead'] == 'Allow'  || $_SESSION['role'] == 'Admin') : ?>
						<li><a href="view-core-leads"><i class="bx bx-right-arrow-alt"></i>View Core Leads</a></li>
						<!-- <li><a href="add-lead"><i class="bx bx-right-arrow-alt"></i>Add Lead</a></li> -->
					<?php endif; ?>
				</ul>
			</li>
		<?php endif; ?>


		<?php if ($userPermissions['view_order'] == 'Allow' || $_SESSION['role'] == 'Admin') : ?>
			<br>
			<p>Orders Management</p>
			<li>
				<a href="javascript:;" class="has-arrow">
					<div class="parent-icon"><i class="bx bx-folder"></i>
					</div>
					<div class="menu-title">Orders</div>
				</a>
				<ul class="mm-collapse">
					<li><a href="view-orders"><i class="bx bx-right-arrow-alt"></i>View Orders</a></li>

				</ul>
			</li>

		<?php endif; ?>
		<?php
		if ($_SESSION['role'] == 'Admin') {

		?>
			<br>
			<p>Currency Converter</p>
			<li>
				<a href="javascript:;" class="has-arrow">
					<div class="parent-icon"><i class="bx bx-folder"></i>
					</div>
					<div class="menu-title">Converter</div>
				</a>
				<ul class="mm-collapse">

					<li> <a href="converter"><i class="bx bx-right-arrow-alt"></i>Currency Converter</a>

					</li>


			</li>
	</ul>
<?php } ?>


<?php if ($userPermissions['view_users'] == 'Allow' || $_SESSION['role'] == 'Admin' || $userPermissions['Add_user'] == 'Allow') : ?>
	<br>
	<p>User Management</p>

	<li>
		<a href="javascript:;" class="has-arrow">
			<div class="parent-icon"><i class="bx bx-folder"></i>
			</div>
			<div class="menu-title">Users</div>
		</a>
		<ul class="mm-collapse">
			<?php if ($userPermissions['view_users'] == 'Allow' || $_SESSION['role'] == 'Admin') : ?>
				<li><a href="view-user"><i class="bx bx-right-arrow-alt"></i>View User</a></li>
			<?php endif; ?>
			<?php if ($userPermissions['Add_user'] == 'Allow' || $_SESSION['role'] == 'Admin') : ?>
				<li><a href="add-user"><i class="bx bx-right-arrow-alt"></i>Add User</a></li>
			<?php endif; ?>
		</ul>
	</li>
<?php endif; ?>



<?php if ($_SESSION['role'] == 'Admin') {
?>
	<br>
	<p>Permissions Management</p>
	<li>
		<a href="javascript:;" class="has-arrow">
			<div class="parent-icon"><i class="bx bx-folder"></i>
			</div>
			<div class="menu-title">Permissions</div>
		</a>
		<ul class="mm-collapse">

			<li> <a href="view-permission"><i class="bx bx-right-arrow-alt"></i>View Permission</a>

			</li>

		</ul>
	</li>

<?php } ?>

<?php if ($userPermissions['view_team'] == 'Allow' || $_SESSION['role'] == 'Admin' || $userPermissions['add_team'] == 'Allow') : ?>
	<br>
	<p>Team Management</p>
	<li>
		<a href="javascript:;" class="has-arrow">
			<div class="parent-icon"><i class="bx bx-folder"></i>
			</div>
			<div class="menu-title">Teams</div>
		</a>
		<ul class="mm-collapse">
			<?php if ($userPermissions['view_team'] == 'Allow' || $_SESSION['role'] == 'Admin') : ?>
				<li><a href="view-team"><i class="bx bx-right-arrow-alt"></i>View Team</a></li>
			<?php endif; ?>
			<?php if ($userPermissions['add_team'] == 'Allow' || $_SESSION['role'] == 'Admin') : ?>
				<li><a href="add-team"><i class="bx bx-right-arrow-alt"></i>Add Team</a></li>
			<?php endif; ?>
		</ul>
	</li>
<?php endif; ?>





<!-- <?php if ($userPermissions['filter1'] == 'Allow' || $_SESSION['role'] == 'Admin' || $userPermissions['filter2'] == 'Allow' || $userPermissions['filter3'] == 'Allow') : ?>
	<br>
	<p>Filters Management</p>
	<li>
		<a href="javascript:;" class="has-arrow">
			<div class="parent-icon"><i class="bx bx-folder"></i>
			</div>
			<div class="menu-title">Filters</div>
		</a>
		<ul class="mm-collapse">
			<?php if ($userPermissions['filter1'] == 'Allow' || $_SESSION['role'] == 'Admin') : ?>
				<li><a href="filter-1"><i class="bx bx-right-arrow-alt"></i>Filter 1</a></li>
			<?php endif; ?>
			<?php if ($userPermissions['filter2'] == 'Allow' || $_SESSION['role'] == 'Admin') : ?>
				<li><a href="filter-2"><i class="bx bx-right-arrow-alt"></i>Filter 2</a></li>
			<?php endif; ?>
			<?php if ($userPermissions['filter3'] == 'Allow' || $_SESSION['role'] == 'Admin') : ?>
				<li><a href="filter-3"><i class="bx bx-right-arrow-alt"></i>Filter 3</a></li>
			<?php endif; ?>
		</ul>
	</li>

<?php endif; ?> -->


<?php

if ($_SESSION['role'] == 'Admin') {

?>
	<br>
	<p>Email Management</p>
	<li>
		<a href="javascript:;" class="has-arrow">
			<div class="parent-icon"><i class="bx bx-folder"></i></div>
			<div class="menu-title">Email Settings</div>
		</a>
		<ul class="mm-collapse">

			<?php

			// Correct SQL query
			$query = "SELECT `id`, `file_name`, `brandname` FROM `email_setting`";
			$queryResult = $conn->query($query);
			// Loop through the result to display data
			if ($queryResult->num_rows > 0) {
				while ($row = $queryResult->fetch_assoc()) {
			?>

					<li>
						<!-- <a href="<?php echo htmlspecialchars($row['file_name']); ?>">
                        <i class="bx bx-right-arrow-alt"></i>
                        <?php echo htmlspecialchars($row['brandname']); ?>
                    </a> -->

						<form method="POST" action="email-setting">
							<input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
							<input type="hidden" name="title" value="Email Settings <?php echo htmlspecialchars($row['brandname']); ?>">
							<button type="submit" style="background: none; border: rgb(255 255 255 / 15%); width: 100%; text-align: left; color: #ffffff; padding: 6px 15px 6px 15px; font-size: 15px; border: 0;">

								<i class="bx bx-right-arrow-alt"></i>
								<?php echo htmlspecialchars($row['brandname']); ?>
							</button>
						</form>
					</li>
			<?php
				}
			} else {
				echo "<li><i class='bx bx-right-arrow-alt'></i>No email settings.</li>";
			}
			?>
		</ul>
	</li>

	</li>


<?php } ?>

<?php if ($_SESSION['role'] == 'Admin') : ?>
	<br>
	<p>Bank Payment Module</p>
	<li>
		<a href="javascript:;" class="has-arrow">
			<div class="parent-icon"><i class="bx bx-folder"></i>
			</div>
			<div class="menu-title">Payment</div>
		</a>
		<ul class="mm-collapse">

			<li><a href="view-payment-account"><i class="bx bx-right-arrow-alt"></i>View Bank Accounts</a></li>
			<li><a href="add_payment_accounts"><i class="bx bx-right-arrow-alt"></i>Add Bank Accounts</a></li>
		</ul>
	</li>
<?php endif; ?>
<?php if ($userPermissions['view_shift'] == 'Allow' || $_SESSION['role'] == 'Admin' || $userPermissions['add_shift'] == 'Allow') : ?>
	<br>
	<p>Shifts Module</p>
	<li>
		<a href="javascript:;" class="has-arrow">
			<div class="parent-icon"><i class="bx bx-folder"></i>
			</div>
			<div class="menu-title">Shifts</div>
		</a>
		<ul class="mm-collapse">
			<?php if ($userPermissions['view_shift'] == 'Allow' || $_SESSION['role'] == 'Admin') : ?>
				<li><a href="view-shift"><i class="bx bx-right-arrow-alt"></i>View Shift</a></li>
			<?php endif; ?>
			<!-- <?php if ($userPermissions['add_shift'] == 'Allow' || $_SESSION['role'] == 'Admin') : ?>
				<li><a href="add-shift"><i class="bx bx-right-arrow-alt"></i>Add Shift</a></li>
			<?php endif; ?> -->
		</ul>
	</li>
<?php endif; ?>


<?php if ($userPermissions['filter1'] == 'Allow' || $_SESSION['role'] == 'Admin' || $userPermissions['filter2'] == 'Allow' || $userPermissions['filter3'] == 'Allow') : ?>
	<br>
	<p>Plan Module</p>
	<li>
		<a href="javascript:;" class="has-arrow">
			<div class="parent-icon"><i class="bx bx-folder"></i>
			</div>
			<div class="menu-title">Plan</div>
		</a>
		<ul class="mm-collapse">
			<?php if ($userPermissions['filter1'] == 'Allow' || $_SESSION['role'] == 'Admin') : ?>
				<li><a href="view-plan"><i class="bx bx-right-arrow-alt"></i>View Plan</a></li>
			<?php endif; ?>
			<?php if ($userPermissions['filter2'] == 'Allow' || $_SESSION['role'] == 'Admin') : ?>
				<li><a href="add-plan"><i class="bx bx-right-arrow-alt"></i>Add</a></li>
			<?php endif; ?>

		</ul>
	</li>

<?php endif; ?>

<?php if ($_SESSION['role'] == 'Admin') : ?>
	<br>
	<p>Lead Source</p>
	<li>
		<a href="javascript:;" class="has-arrow">
			<div class="parent-icon"><i class="bx bx-folder"></i>
			</div>
			<div class="menu-title">Source</div>
		</a>
		<ul class="mm-collapse">

			<li><a href="view-lead-source"><i class="bx bx-right-arrow-alt"></i>View Leads Source</a></li>


			<li><a href="add-lead-source"><i class="bx bx-right-arrow-alt"></i>Add Lead Source</a></li>

		</ul>
	</li>
<?php endif; ?>

<?php if ($_SESSION['role'] == 'Admin') : ?>
	<br>
	<p>Brands</p>
	<li>
		<a href="javascript:;" class="has-arrow">
			<div class="parent-icon"><i class="bx bx-folder"></i>
			</div>
			<div class="menu-title">Brands Name</div>
		</a>
		<ul class="mm-collapse">

			<li><a href="view-brand"><i class="bx bx-right-arrow-alt"></i>View Brand</a></li>


			<li><a href="add-brand"><i class="bx bx-right-arrow-alt"></i>Add Brand</a></li>

		</ul>
	</li>
<?php endif; ?>

<?php if ($_SESSION['role'] == 'Admin') : ?>
	<br>
	<p>Whatsapp</p>
	<li>
		<a href="javascript:;" class="has-arrow">
			<div class="parent-icon"><i class="bx bx-folder"></i>
			</div>
			<div class="menu-title">Whatsapp Details</div>
		</a>
		<ul class="mm-collapse">

			<li><a href="view-whatsapp-details"><i class="bx bx-right-arrow-alt"></i>View Whatsapp Details</a></li>


			<li><a href="add-whatsapp"><i class="bx bx-right-arrow-alt"></i>Add Whatsapp Details</a></li>

		</ul>
	</li>
<?php endif; ?>
<?php if ($_SESSION['role'] == 'Admin') : ?>
	<br>
	<p>Whatsapp</p>
	<li>
		<a href="javascript:;" class="has-arrow">
			<div class="parent-icon"><i class="bx bx-folder"></i>
			</div>
			<div class="menu-title">Delete Keys</div>
		</a>
		<ul class="mm-collapse">

			<li><a href="delete-keys"><i class="bx bx-right-arrow-alt"></i>Delete Keys</a></li>

		</ul>
	</li>
<?php endif; ?>

<?php

if ($userPermissions['log_management'] == 'Allow' || $_SESSION['role'] == 'Admin') {

?>



	<p>Logs Management</p>
	<li>
		<a href="javascript:;" class="has-arrow">
			<div class="parent-icon"><i class="bx bx-folder"></i>
			</div>
			<div class="menu-title">Logs</div>
		</a>

		<ul class="mm-collapse">
			<li> <a href="created-user-log"><i class="bx bx-right-arrow-alt"></i>User Created Log</a>

			</li>

			<li> <a href="user-update-log"><i class="bx bx-right-arrow-alt"></i>User Update Log</a></li>
			<li> <a href="user_deleted_log"><i class="bx bx-right-arrow-alt"></i>User Delete Log</a></li>

			<li> <a href="lead_created_log"><i class="bx bx-right-arrow-alt"></i>Lead Created Log</a></li>

			<li> <a href="lead_update_log"><i class="bx bx-right-arrow-alt"></i>Lead Update Log</a></li>

			<li> <a href="lead_deleted_log"><i class="bx bx-right-arrow-alt"></i>Lead Deleted Log</a></li>
			<li> <a href="core_lead_created_log"><i class="bx bx-right-arrow-alt"></i>Core Lead Created Log</a></li>
			<li> <a href="core_lead_update_log"><i class="bx bx-right-arrow-alt"></i>Core Lead Updated Log</a></li>
			<li> <a href="core_lead_deleted_log"><i class="bx bx-right-arrow-alt"></i>Core Lead Deleted Log</a></li>


			<li> <a href="order_created_log"><i class="bx bx-right-arrow-alt"></i>Order Created Log</a></li>

			<li> <a href="order_delete_log"><i class="bx bx-right-arrow-alt"></i>Order Delete Log</a></li>

			<li> <a href="order_update_log"><i class="bx bx-right-arrow-alt"></i>Update Order Log</a>

			</li>
		</ul>
	</li>

<?php

} ?>





</ul>

<!--end navigation-->

</div>