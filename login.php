<?php require_once("./main_components/global.php");
$current_page = basename($_SERVER['PHP_SELF']);
$allowed_pages = array('login.php', 'signup.php', 'authentication-forgot-password.php'); // Add other allowed pages if needed
?>


<!doctype html>
<html lang="en">


<!-- Mirrored from codervent.com/dashtreme/demo/vertical/authentication-signin.php by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 19 Oct 2022 15:11:36 GMT -->

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!-- loader-->
	<link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<title><?php echo ucfirst(basename($_SERVER['PHP_SELF'], '.php')) ?> | BD-DMS </title>
</head>

<body class="bg-theme-2 bg-theme2">
	<!--wrapper-->
	<div class="wrapper">
		<div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
			<div class="container-fluid">
				<div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
					<div class="col mx-auto">
						<div class="mb-4 text-center">
							<img src="assets/images/logo-img.png" width="180" alt="" />
						</div>
						<div class="card">
							<div class="card-body">
								<div class="border p-4 rounded">
									<div class="text-center">
										<h3 class="">Welcome to BDMS</h3>
										<h3 class="">Sign in</h3>
									</div>
									<?php if (!empty($error)) : ?>
										<div class="alert alert-danger alert-icon"><em class="icon ni ni-cross-circle"></em> <strong>Unable to Login </strong> <?php echo $error; ?></div>


									<?php endif; ?>

									<?php if (!empty($system)) : ?>
										<div class="alert alert-danger alert-icon "><em class="icon ni ni-cross-circle"></em> <strong>Unable to Login </strong> <?php echo $error; ?></div>
									<?php endif; ?>
									<?php if (!empty($_SESSION['endtiming'])) {
										$endtiming = $_SESSION['endtiming'];
										echo "<div class='alert alert-danger text-white alert-icon'><em class='icon ni ni-cross-circle'></em> <strong>Unable to Login </strong> $endtiming</div>";
										unset($_SESSION['endtiming']); // Clear the message after displaying
									}
									?>
									<div class="form-body">
										<form method="post" class="row g-3">
											<div class="col-12">
												<label for="inputEmailAddress" class="form-label">Email Address</label>
												<input type="email" name="email" class="form-control" id="inputEmailAddress" placeholder="Email Address">
											</div>
											<div class="col-12">
												<label for="inputChoosePassword" class="form-label">Enter Password</label>
												<div class="input-group" id="show_hide_password">
													<input type="password" name="password" class="form-control border-end-0" id="inputChoosePassword" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
												</div>
											</div>
											<!-- <div class="col-md-6">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
													<label class="form-check-label" for="flexSwitchCheckChecked">Remember Me</label>
												</div>
											</div> -->
											<!-- <div class="col-md-6 text-end">	<a href="authentication-forgot-password.php">Forgot Password ?</a>
											</div> -->
											<div class="col-12">
												<div class="d-grid">
													<button type="submit" name="login" class="btn btn-light"><i class="bx bxs-lock-open"></i>Sign in</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->
			</div>
		</div>
	</div>
	<!--end wrapper-->

	<!--plugins-->
	<script src="assets/js/jquery.min.js"></script>
	<!--Password show & hide js -->
	<script>
		$(document).ready(function() {
			$("#show_hide_password a").on('click', function(event) {
				event.preventDefault();
				if ($('#show_hide_password input').attr("type") == "text") {
					$('#show_hide_password input').attr('type', 'password');
					$('#show_hide_password i').addClass("bx-hide");
					$('#show_hide_password i').removeClass("bx-show");
				} else if ($('#show_hide_password input').attr("type") == "password") {
					$('#show_hide_password input').attr('type', 'text');
					$('#show_hide_password i').removeClass("bx-hide");
					$('#show_hide_password i').addClass("bx-show");
				}
			});
		});
	</script>
</body>


<!-- Mirrored from codervent.com/dashtreme/demo/vertical/authentication-signin.php by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 19 Oct 2022 15:11:37 GMT -->

</html>