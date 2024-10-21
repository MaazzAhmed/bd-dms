<?php  $TITLE = "Home"; ?> 

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

			<div class="card radius-10">
				<div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 row-group g-0">
					<div class="col">
						<div class="card-body">
							<div class="d-flex align-items-center">

								<?php
								// total count of users
								$totalCountSql = "SELECT COUNT(*) as totalusers FROM user where role != 'Admin'";
								$totalCountResultUsers = $conn->query($totalCountSql);
								$totalusers = $totalCountResultUsers->fetch_assoc()['totalusers'];
								?>
								<?php if ($totalusers > 0) : ?>
									<h5 class="mb-0"><?= $totalusers ?></h5>
								<?php else : ?>
									<h5 class="mb-0">0</h5>
								<?php endif; ?>

								<div class="ms-auto">

									<i class='bx bx-group fs-3 text-white'></i>
									<!-- <i class='bx bx-cart fs-3 text-white'></i> -->
								</div>
							</div>

							<div class="d-flex align-items-center text-white">
								<p class="mb-0">Total Users</p>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<?php
								// total count of Leads
								$totalCountSql = "SELECT COUNT(*) as totalusers FROM leads ";
								$totalCountResultUsers = $conn->query($totalCountSql);
								$totalleads = $totalCountResultUsers->fetch_assoc()['totalusers'];
								?>
								<?php if ($totalleads > 0) : ?>
									<h5 class="mb-0"><?= $totalleads ?></h5>
								<?php else : ?>
									<h5 class="mb-0">0</h5>
								<?php endif; ?>
								<div class="ms-auto">
									<i class='bx bx-dollar fs-3 text-white'></i>
								</div>
							</div>

							<div class="d-flex align-items-center text-white">
								<p class="mb-0">Total Leads</p>
								<!-- <p class="mb-0 ms-auto">+1.2%<span><i class='bx bx-up-arrow-alt'></i></span></p> -->
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card-body">
							<div class="d-flex align-items-center">
								<?php
								// total count of Leads
								$totalCountSql = "SELECT COUNT(*) as totalorders FROM `order`";
								$totalCountResultOrders = $conn->query($totalCountSql);

								if ($totalCountResultOrders !== false) {
									$totalorder = $totalCountResultOrders->fetch_assoc()['totalorders'];
								} else {
									// Handle the error, e.g., display an error message or log the error.
									$totalorder = 0;
								}
								?>

								<h5 class="mb-0"><?= $totalorder ?></h5>
								<div class="ms-auto">
									<i class='bx bx-group fs-3 text-white'></i>
								</div>
							</div>

							<div class="d-flex align-items-center text-white">
								<p class="mb-0">Total orders</p>
								<!-- <p class="mb-0 ms-auto">+5.2%<span><i class='bx bx-up-arrow-alt'></i></span></p> -->
							</div>
						</div>
					</div>
						<div class="col">
						<div class="card-body">
							<div class="d-flex align-items-center">
							
								<h5 class="mb-0">Last Login Ip  ||  Time</h5>
								<div class="ms-auto">
								</div>
							</div>
							
							<div class="d-flex align-items-center text-white">
							<?php if(isset($_SESSION['last_id_address']) && !empty($_SESSION['last_id_address'])): ?>
        <p class="mb-0"><?php echo $_SESSION['last_id_address']; ?> || <?php echo date("j-F-Y h:i a", strtotime($_SESSION['last_login'])); ?></p>
    <?php else: ?>
        <p class="mb-0">No address available</p>
    <?php endif; ?>
								<div class="progress my-3" style="height:4px;">
							</div>
							
								<!-- <p class="mb-0 ms-auto">+2.2%<span><i class='bx bx-up-arrow-alt'></i></span></p> -->
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>


		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © <span id="year"></span>. All right reserved.</p>
		</footer>
	</div>
	<!--end wrapper-->
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="assets/plugins/chartjs/chart.min.js"></script>
	<script src="assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
	<script src="assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js"></script>
	<script src="assets/plugins/sparkline-charts/jquery.sparkline.min.js"></script>
	<script src="assets/plugins/jquery-knob/excanvas.js"></script>
	<script src="assets/plugins/jquery-knob/jquery.knob.js"></script>
	<script>
		$(function() {
			$(".knob").knob();
		});
	</script>
	<script src="assets/js/index.js"></script>
	<!--app JS-->
	<script src="assets/js/app.js"></script>
	<script>
		const currentYear = new Date().getUTCFullYear();
		const year = document.getElementById("year");
		year.textContent = currentYear;
	</script>
	</body>


	</html>