<?php $TITLE = "Order Details"; ?>

<?php require_once("./main_components/header.php"); ?>

<!--wrapper-->

<div class="wrapper">

	<!--sidebar wrapper -->

	<?php require_once("./main_components/sidebar.php"); ?>



	<!--end sidebar wrapper -->

	<!--start header -->

	<?php require_once("./main_components/navbar.php");



	// Check if the form is submitted

	if (isset($_POST['view-all-orders'])) {

		$orderId = $_POST['allordersid'];



		// Fetch details of the selected order based on $orderId

		$order = getDetailsForSelectedOrder($conn, $orderId);



		// Check if the order details are available

		if ($order) {

			date_default_timezone_set('Asia/Karachi');

			$currentDate = date("Y-m-d");

			$deadlineDate = date("Y-m-d", strtotime($order['final_deadline_time']));

			$isTodayDeadline = ($currentDate == $deadlineDate);

	?>

			<!--end header -->

			<!--start page wrapper -->

			<div class="page-wrapper">

				<div class="page-content">



					<div class="row">

						<div class="col-xl-12 mx-auto">


							<div class="card border-top border-0 border-4 border-white">

								<div class="card-body p-5">

									<div class="card-title d-flex align-items-center">

										<div><i class="bx bxs-user me-1 font-22 text-white"></i>

										</div>

										<h5 class="mb-0 text-white">Order Details</h5>

									</div>

									<hr>

									<form class="row g-3">
										<center>
											<h4 style="background-color: black;">Client Details</h4>
										</center>

										<table class="table table-bordered table-striped">
											<tbody>
												<tr>
													<th style="width: 30%;">Client Status</th>
													<td><?php echo $order['client_info']; ?></td>
												</tr>
												<tr>
													<th>Client Name</th>
													<td><?php echo $order['client_name']; ?></td>
												</tr>
												<tr>
													<th>Client Email</th>
													<td><?php echo $order['client_email']; ?></td>
												</tr>
												<tr>
													<th>Contact Number</th>
													<td><?php echo $order['client_contact_number']; ?></td>
												</tr>
												<tr>
													<th>Client's Country</th>
													<td><?php echo $order['client_country']; ?></td>
												</tr>

											</tbody>
										</table>

										<center>
											<h4 style="background-color: black;">Order Details</h4>
										</center>

										<table class="table table-bordered table-striped">
											<tbody>
												<tr>
													<th style="width: 30%;">Order Date</th>
													<td><?php echo date('d-M-Y h:i a', strtotime($order['order_confirmation_date'])); ?></td>
												</tr>
												<tr>
													<th>Portal Due Date</th>
													<td><?php echo date('d-M-Y h:i a', strtotime($order['portal_due_date'])); ?></td>
												</tr>
												<tr>
													<th>Final Deadline Time</th>
													<td><?php echo date('d-M-Y h:i a', strtotime($order['final_deadline_time'])); ?></td>
												</tr>
												<tr>
													<th>Order ID</th>
													<td><?php echo $order['order_id_input']; ?></td>
												</tr>
												<tr>
													<th>Order Title</th>
													<td><?php echo $order['order_title']; ?></td>
												</tr>
												<tr>
													<th>Order Status</th>
													<td><?php echo $order['order_status']; ?></td>
												</tr>
												<tr>
													<th>Word Count</th>
													<td><?php echo $order['word_count']; ?></td>
												</tr>
												<tr>
													<th>Plan</th>
													<td><?php echo $order['plan']; ?></td>
												</tr>
												<tr>
													<th>Client Requirements</th>
													<td><?php echo $order['client_requirements']; ?></td>
												</tr>
												<tr>
													<th>Comments</th>
													<td><?php echo $order['comment']; ?></td>
												</tr>



											</tbody>
										</table>

										<center>
											<h4 style="background-color: black;">Payments</h4>
										</center>


										<table class="table table-striped table-bordered" id="analyticsDataTable">
											<thead>
												<tr>
													<th style="width: 25%;">Payment Date</th>
													<th style="width: 25%;">Pending Payment</th>
													<th style="width: 25%;">Received Payment</th>
													<th style="width: 25%;">Currency</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sql = "SELECT * FROM `order_payments` WHERE order_id = '$orderId'";
												$query = mysqli_query($conn, $sql);

												if ($query && mysqli_num_rows($query) > 0) {
													while ($row = mysqli_fetch_assoc($query)) {
												?>
														<tr>
															<td><?php echo date('d-M-Y h:i A', strtotime($row['payment_date'])); ?></td>
															<td><?php echo number_format($row['pending_payment'], 2); ?></td>
															<td><?php echo number_format($row['receive_payment'], 2); ?></td>
															<td><?php echo htmlspecialchars($row['currency']); ?></td>
														</tr>
												<?php
													}
												} else {
													echo "<tr><td colspan='4' class='text-center'>No payment details found for this order.</td></tr>";
												}
												?>
											</tbody>
										</table>



										

										<center>
											<h4 style="background-color: black;">Lead Source & Lead Owner Info</h4>
										</center>
										<table class="table table-bordered table-striped">
											<tbody>
												<tr>
													<th style="width: 30%;">WhatsApp Account</th>
													<td>
														<?php
														$whatsappName = $order['whatsapp_name'];
														if (preg_match('/^(.*?)(\d{4,})$/', $whatsappName, $matches)) {
															$countryCode = $matches[1];
															$number = $matches[2];
															$maskedNumber = str_repeat('*', strlen($number) - 3) . substr($number, -3);
															echo $countryCode . ' ' . $maskedNumber;
														} else {
															echo $whatsappName;
														}
														?>
													</td>
												</tr>
												<tr>
													<th>Payment Account</th>
													<td><?php echo $order['payment_account']; ?></td>
												</tr>
												<tr>
													<th>Brand Name</th>
													<td><?php echo $order['brand_name']; ?></td>
												</tr>
												<tr>
													<th>Shift Name</th>
													<td><?php echo $order['shift_type']; ?></td>
												</tr>
												<tr>
													<th>Team Name</th>
													<td><?php echo $order['team_name']; ?></td>
												</tr>
												<tr>
													<th>Writer's Team</th>
													<td><?php echo $order['writers_team']; ?></td>
												</tr>
												<tr>
													<th>Assign To</th>
													<td><?php echo $order['assigned_to']; ?></td>
												</tr>
												<tr>
													<th>Order Creator Name</th>
													<td><?php echo $order['name']; ?></td>
												</tr>
											</tbody>
										</table>


									</form>

								</div>

							</div>



					<?php

				} else {

					echo "<div class='col-md-12'><h5>Order details not found.</h5></div>";
				}
			}

					?>



					<?php require_once("./main_components/footer.php"); ?>