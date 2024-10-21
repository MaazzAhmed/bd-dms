<?php  $TITLE = "Verification"; ?> 

<?php 
require_once('main_components/global.php');



$current_page = basename($_SERVER['PHP_SELF']);
$allowed_pages = array('login.php', 'signup.php', 'authentication-forgot-password.php'); // Add other allowed pages if needed

if (!isset($_SESSION['user']) && !in_array($current_page, $allowed_pages)) {
    header('Location: ./login');
    exit;
}  


?>

<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from codervent.com/dashtreme/demo/vertical/authentication-lock-screen.php by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 19 Oct 2022 15:11:38 GMT -->
<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!-- loader-->
	<!-- <link href="assets/css/pace.min.css" rel="stylesheet" />
	<script src="assets/js/pace.min.js"></script> -->
	<!-- Bootstrap CSS -->
	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
	<link href="assets/css/app.css" rel="stylesheet">
	<link href="assets/css/icons.css" rel="stylesheet">
	<title>DMS |<?php echo ucfirst(basename($_SERVER['PHP_SELF'], '.php'))?></title>


</head>

<style>
	.date-time{
		position: absolute;
		left : 20px ;
		bottom : 20px ;
	}
</style>

<body class="bg-theme bg-theme1">
	<!-- wrapper -->
	<script>
        function getRemainingTime() {
            let storedTime = localStorage.getItem('remainingTime');
            return storedTime ? parseInt(storedTime) : 15;
        }

        let timeLeft = getRemainingTime();
        let countdown = setInterval(function() {
            document.getElementById('timer').innerHTML = timeLeft + ' seconds remaining';
            timeLeft -= 1;

            localStorage.setItem('remainingTime', timeLeft);

            if (timeLeft < 0) {
                clearInterval(countdown);
                // Redirect to logout page after 15 seconds
                window.location.href = 'logout.php';
                localStorage.removeItem('remainingTime');
            }
        }, 1000); // 1 second in milliseconds
    </script>
	<div class="wrapper">
		<div class="authentication-lock-screen d-flex align-items-center justify-content-center">
			<div class="date-time">
				<h2 class="text-white"><span id="hour"></span>:<span id="minute"></span>:<span id="second"></span> <span id="ampm"></span></h2>
				<h5 class="text-white"><span id="day"></span> , <span id="month"></span> <span id="date"></span> , <span id="year"></span></h5>
			</div>
			<div class="card shadow-none bg-transparent">
				<div class="card-body p-md-5 text-center">
					<div class="">
						<img src="assets/images/icons/user.png" class="mt-2 mb-2" width="120" alt="" />
					</div>
					<div class="mb-3 mt-3">
						<p class="form-control" id="timer"></p>
					</div>
					<form method="post">
					<input type="hidden" name="id" value="<?php echo $_SESSION['id'] ?>" id="">
					<div class="mb-3 mt-3">
						<input type="password" name="key" required class="form-control" placeholder="Enter Your Passcode" />
					</div>
					<div class="d-grid">
						<button  type="submit" name="verify" class="btn btn-light">Login</button>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<p ></p>

	<!-- end wrapper -->


<!--plugins-->
<script src="assets/js/jquery.min.js"></script>

<script>
		const date = new Date();
	const weekday = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    
    const dateElement = document.getElementById("date");
    const dayElement = document.getElementById("day");
    const monthElement = document.getElementById("month");
    const yearElement = document.getElementById("year");
	
    dateElement.textContent = date.getDate();
    dayElement.textContent = weekday[date.getDay()];
    monthElement.textContent = months[date.getMonth()];
    yearElement.textContent = date.getFullYear();
	
    function updateDateTime() {
        const date = new Date();
        const hourElement = document.getElementById("hour");
        const minuteElement = document.getElementById("minute");
        const secondElement = document.getElementById("second");
        const ampmElement = document.getElementById("ampm");

        let hours = date.getHours();
        const minutes = date.getMinutes();
        const seconds = date.getSeconds();
        const ampm = hours >= 12 ? 'PM' : 'AM';

        hours = hours % 12 || 12;

        hourElement.textContent = hours;
        minuteElement.textContent = minutes < 10 ? '0' + minutes : minutes;
        secondElement.textContent = seconds < 10 ? '0' + seconds : seconds;
        ampmElement.textContent = ampm;
    }

    updateDateTime();

    setInterval(updateDateTime, 1000);

	document.addEventListener('contextmenu', (e) => e.preventDefault());

function ctrlShiftKey(e, keyCode) {
  return e.ctrlKey && e.shiftKey && e.keyCode === keyCode.charCodeAt(0);
}

document.onkeydown = (e) => {
  // Disable F12, Ctrl + Shift + I, Ctrl + Shift + J, Ctrl + U
  if (
    event.keyCode === 123 ||
    ctrlShiftKey(e, 'I') ||
    ctrlShiftKey(e, 'J') ||
    ctrlShiftKey(e, 'C') ||
    (e.ctrlKey && e.keyCode === 'U'.charCodeAt(0))
  )
    return false;
};
</script>

</body>


<!-- Mirrored from codervent.com/dashtreme/demo/vertical/authentication-lock-screen.php by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 19 Oct 2022 15:11:39 GMT -->
</html>