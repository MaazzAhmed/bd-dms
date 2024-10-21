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

										<div class="col-md-4">

											<h5 style="font-size: 16px;">Client Status</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['client_info']; ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Client Name</h5>

										</div>
										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['client_name']; ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Client Email</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['client_email']; ?></h5>

										</div>

										<div class="col-md-4">

											<h5 style="font-size: 16px;">Contact Number</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['client_contact_number']; ?></h5>

										</div>

										<div class="col-md-4">

											<h5 style="font-size: 16px;">Order Date</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo date('d-M-Y h:i a', strtotime($order['order_confirmation_date'])); ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Portal Due Date</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo date('d-M-Y h:i a', strtotime($order['portal_due_date'])); ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Final Deadline Time</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo date('d-M-Y h:i a', strtotime($order['final_deadline_time'])); ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Order ID</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['order_id_input']; ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Order Title</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['order_title']; ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Order Status</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['order_status']; ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Word Count</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['word_count']; ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Pending Payment</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['pending_payment']; ?></h5>

										</div>



										<div class="col-md-4">

											<h5 style="font-size: 16px;">Recieved Payment</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['receive_payment']; ?></h5>

										</div>



										<div class="col-md-4">

											<h5 style="font-size: 16px;">Currency</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['currency']; ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">WhatsApp Account</h5>

										</div>

										<div class="col-md-8">
											<?php
											$whatsappName = $order['whatsapp_name'];

											if (preg_match('/^(.*?)(\d{4,})$/', $whatsappName, $matches)) {
												$countryCode = $matches[1];
												$number = $matches[2];

												$maskedNumber = str_repeat('*', strlen($number) - 3) . substr($number, -3);
											?>
												<h5 style="font-size: 16px;"><?php echo $countryCode . ' ' . $maskedNumber;
																			} else {
																				echo $whatsappName;
																			} ?></h5>

										</div>

										<div class="col-md-4">

											<h5 style="font-size: 16px;">Payment Account</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['payment_account']; ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Brand Name</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['brand_name']; ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Client's Country</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['client_country']; ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Shift Name</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['shift_type']; ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Team Name</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['team_name']; ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Writer's Team</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['writers_team']; ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Plan</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['plan']; ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Assign To</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['assigned_to']; ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Year</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['years']; ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Client Requirments</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['client_requirements']; ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Comments</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['comment']; ?></h5>

										</div>
										<div class="col-md-4">

											<h5 style="font-size: 16px;">Order Creater Name</h5>

										</div>

										<div class="col-md-8">

											<h5 style="font-size: 16px;"><?php echo $order['name']; ?></h5>

										</div>


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