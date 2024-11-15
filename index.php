<?php $TITLE = "Home"; ?>

<?php require_once("./main_components/header.php"); ?>
<!--wrapper-->
<div class="wrapper">
	<!--sidebar wrapper -->
	<?php require_once("./main_components/sidebar.php"); ?>

	<!--end sidebar wrapper -->
	<!--start header -->
	<?php require_once("./main_components/navbar.php"); ?>
	<style>
		.available {
			color: black !important;
		}

		.ranges {
			color: black !important;
			font-weight: bolder;
		}

		th.month {
			color: black !important;
		}

		.daterangepicker td.in-range {
			background-color: #caeeff;
			border-color: transparent;
			color: #000;
			border-radius: 0;
		}

		.daterangepicker .calendar-table th,
		.daterangepicker .calendar-table td {

			color: black !important;
		}

		.daterangepicker td.off,
		.daterangepicker td.off.in-range,
		.daterangepicker td.off.start-date,
		.daterangepicker td.off.end-date {
			background-color: #f4f4f4 !important;
			color: #9b9797 !important;
		}
	</style>
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
									<h5 class="mb-0 text-2xl"><?= $totalusers ?></h5>
								<?php else : ?>
									<h5 class="mb-0 text-2xl">0</h5>
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
									<h5 class="mb-0 text-2xl"><?= $totalleads ?></h5>
								<?php else : ?>
									<h5 class="mb-0 text-2xl">0</h5>
								<?php endif; ?>
								<div class="ms-auto">
									<i class='bx bx-dollar fs-3 text-white'></i>
								</div>
							</div>

							<div class="d-flex align-items-center text-white">
								<p class="mb-0">Total Leads</p>
								<!-- <p class="mb-0 text-2xl ms-auto">+1.2%<span><i class='bx bx-up-arrow-alt'></i></span></p> -->
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

								<h5 class="mb-0 text-2xl"><?= $totalorder ?></h5>
								<div class="ms-auto">
									<i class='bx bx-group fs-3 text-white'></i>
								</div>
							</div>

							<div class="d-flex align-items-center text-white">
								<p class="mb-0">Total orders</p>
								<!-- <p class="mb-0 text-2xl ms-auto">+5.2%<span><i class='bx bx-up-arrow-alt'></i></span></p> -->
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card-body">
							<div class="d-flex align-items-center">

								<h5 class="mb-0">Last Login Ip || Time</h5>
								<div class="ms-auto">
								</div>
							</div>

							<div class="d-flex align-items-center text-white">
								<?php if (isset($_SESSION['last_id_address']) && !empty($_SESSION['last_id_address'])): ?>
									<p class="mb-0 text-xl"><?php echo $_SESSION['last_id_address']; ?> || <?php echo date("j-F-Y h:i a", strtotime($_SESSION['last_login'])); ?></p>
								<?php else: ?>
									<p class="mb-0 text-xl">No address available</p>
								<?php endif; ?>
								<div class="progress my-3" style="height:4px;">
								</div>

								<!-- <p class="mb-0 text-2xl ms-auto">+2.2%<span><i class='bx bx-up-arrow-alt'></i></span></p> -->
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
			<!-- Filters -->
			<hr>
			<script src="https://cdn.tailwindcss.com"></script>


			<div class="card-title d-flex align-items-center">

				<div><i class="bx bxs-search me-1 font-22 text-white"></i>

				</div>

				<h5 class="mb-0 text-2xl text-white">Filters</h5>

			</div>


			<div id="reportrange" class="form-control" style="cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 33%">
				<i class="fa fa-calendar"></i>&nbsp;
				<span></span> <i class="fa fa-caret-down"></i>
			</div>
		</div>
	</div>

	<div class="wrapper">
    <div class="page-wrapper" style="margin-top: 0px !important;">
        <div class="page-content">
            <div class="grid grid-cols-1 gap-4 px-1 mt-0 mb-[90px] sm:grid-cols-3 sm:px-8">
                
                <!-- Total Payment -->
                <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
                    <div class="p-4 bg-green-400">
                        <!-- Updated to a dollar sign for Total Payment -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 1C5.935 1 1 5.935 1 12s4.935 11 11 11 11-4.935 11-11S18.065 1 12 1zm.5 17h-1v-1h1v1zm1.1-3.8c-.9.3-1.5.5-1.5 1.3v.5h-1v-.5c0-1 .8-1.5 1.5-1.8.6-.2.9-.4.9-.7 0-.5-.4-.8-.9-.8s-.9.3-.9.8h-1c0-1 .8-1.7 1.9-1.7s1.9.7 1.9 1.7c0 .7-.5 1.1-1.4 1.4z"/>
                        </svg>
                    </div>
                    <div class="px-4 text-gray-700">
                        <h3 class="text-sm tracking-wider text-zinc-800">Total Payment</h3>
                        <p class="text-3xl" id="total_payment">0</p>
                    </div>
                </div>

                <!-- Pending Payment -->
                <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
                    <div class="p-4 bg-blue-400">
                        <!-- Updated to a clock icon for Pending Payment -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 1.5A10.5 10.5 0 1 0 22.5 12 10.511 10.511 0 0 0 12 1.5zm0 19a8.5 8.5 0 1 1 8.5-8.5 8.51 8.51 0 0 1-8.5 8.5zm.75-12H12a.5.5 0 0 0-.5.5v4.25a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-2.25V9a.5.5 0 0 0-.5-.5z"/>
                        </svg>
                    </div>
                    <div class="px-4 text-gray-700">
                        <h3 class="text-sm tracking-wider text-zinc-800">Pending Payment</h3>
                        <p class="text-3xl" id="pending_payment">0</p>
                    </div>
                </div>

                <!-- Total No Of Orders -->
                <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
                    <div class="p-4 bg-indigo-400">
                        <!-- Updated to a package/box icon for Total No Of Orders -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21 6.21l-9-5-9 5L12 11.5l9-5.29zM2.03 8.46L11 13.63v8.92L2 17.38zm9.97 13.09v-8.92L21.97 8.46 13 13.63z"/>
                        </svg>
                    </div>
                    <div class="px-4 text-gray-700">
                        <h3 class="text-sm tracking-wider text-zinc-800">Total No Of Orders</h3>
                        <p class="text-3xl" id="total_orders">0</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

	<!-- end table -->
















	<!--end page wrapper -->
	<!--start overlay-->
	<div class="overlay toggle-icon"></div>
	<a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>

	<footer class="page-footer">
		<p class="mb-0">Copyright © <span id="year"></span>. All right reserved.</p>
	</footer>
	<!--end wrapper-->



	
	<script type="text/javascript">
	$(function() {
		var start = moment();
		var end = moment();

		function cb(start, end) {
			$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			// Send the date range to the server via AJAX
			$.ajax({
				url: 'main_components/dashboard_orders.php',
				type: 'POST',
				data: {
					start_date: start.format('YYYY-MM-DD'),
					end_date: end.format('YYYY-MM-DD')
				},
				success: function(response) {
					console.log("Response from server:", response); // Log raw response for debugging
					try {
						let data = JSON.parse(response);
						
						// Check if the data contains the necessary fields
						const receivePayment = data.receive_payment ?? '0';
						const pendingPayment = data.pending_payment ?? '0';
						const totalOrders = data.total_orders ?? '0';

						// Display data on the page
						$('#total_payment').text('$' + receivePayment); // Change this line to display receive_payment
						$('#pending_payment').text('$' + pendingPayment);
						$('#total_orders').text(totalOrders);
					} catch (e) {
						console.error("Error parsing JSON response: ", e, response);
						alert("There was an error processing the data. Check console for details.");
					}
				},
				error: function(xhr, status, error) {
					console.error("AJAX error:", error);
					alert("AJAX request failed. Check console for details.");
				}
			});
		}

		$('#reportrange').daterangepicker({
			startDate: start,
			endDate: end,
			ranges: {
				'Today': [moment(), moment()],
				'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'Last 7 Days': [moment().subtract(6, 'days'), moment()],
				'Last 30 Days': [moment().subtract(29, 'days'), moment()],
				'This Month': [moment().startOf('month'), moment().endOf('month')],
				'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
			}
		}, cb);

		cb(start, end);
	});
</script>



	
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
	<!-- Bootstrap JS -->
	<script src="assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<!-- <script src="assets/js/jquery.min.js"></script> -->
	<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>

	<script src="assets/plugins/jquery-knob/jquery.knob.js"></script>
	<script>
		$(function() {
			$(".knob").knob();
		});
	</script>

	<script>
		const currentYear = new Date().getUTCFullYear();
		const year = document.getElementById("year");
		year.textContent = currentYear;
	</script>
	</body>


	</html>