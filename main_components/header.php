<?php

require_once('main_components/global.php');

// Check if the key is not present in the session or is incorrect

if (!isset($_SESSION['key']) || $_SESSION['key'] !== $_SESSION['secret_key']) {

    // Redirect to the login page or any other designated page

    header('Location: login');

    exit;

    
}
 




$userId = $_SESSION['id'];

// Fetch user permissions from the database

$getPermissionsQuery = "SELECT * FROM permissions WHERE user_id = ?";

$stmtPermissions = mysqli_prepare($conn, $getPermissionsQuery);

mysqli_stmt_bind_param($stmtPermissions, "i", $userId);

mysqli_stmt_execute($stmtPermissions);

$result = mysqli_stmt_get_result($stmtPermissions);

$userPermissions = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmtPermissions);

$SITE_TITLE = "BD-DMS";

?>






<!doctype html>

<html lang="en">



<head>

    <!-- Required meta tags -->

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">



    <title> <?php echo "{$TITLE} | {$SITE_TITLE}"; ?> </title>
    <!--favicon-->

    <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />

    <!--plugins-->

    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />

    <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet" />

    <link href="assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />

    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />

    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />

    <link href="assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

    <!-- loader-->

    <link href="assets/css/pace.min.css" rel="stylesheet" />

    <script src="assets/js/pace.min.js"></script>



    <!-- Bootstrap CSS -->

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">

    <link href="assets/css/app.css" rel="stylesheet">

    <link href="assets/css/icons.css" rel="stylesheet">



    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>





    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>



    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js"></script>

    <script src="./assets/js/dropdown-menu.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" />







    <!-- Include Summernote CSS -->



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css">







    <!-- Include jQuery, Popper.js, and Bootstrap JS -->



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>







    <!-- Include Summernote JS -->



    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>





    <style>
        .note-editor .note-editing-area .note-editable {

            background-color: white !important;

        }



        .note-editor .dropdown-menu li>a {

            color: black !important;

        }



        input[type="time"]::-webkit-calendar-picker-indicator {

            filter: invert(100%);

        }



        input[type="date"]::-webkit-calendar-picker-indicator {

            filter: invert(100%);

        }



        input[type="datetime-local"]::-webkit-calendar-picker-indicator {

            filter: invert(100%);

        }

        
            input::-webkit-outer-spin-button,
            input::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            input[type="number"] {
                -moz-appearance: textfield;
            }
        
    </style>



    <script>
        // Set default position for Alertify notifications

        alertify.defaults = {

            notifier: {

                position: 'top-right'

            }

        };
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <script>
        window.addEventListener('load', function() {
            var dataTable = $('#example').DataTable(); // Assuming you're using DataTables
            if (dataTable) {
                dataTable.order([0, 'desc']).draw(); // Sort by the first column in ascending order
            }
        });
    </script>




    <script>
        // Inspect Blocking Code





        // var isCtrl = false;

        // document.onkeyup=function(e)

        // {

        // if(e.which == 17)

        // isCtrl=false;

        // }

        // document.onkeydown=function(e)

        // {

        // if(e.which == 123)

        // isCtrl=true;

        // if (((e.which == 85) || (e.which == 65) || (e.which == 88) || (e.which == 67) || (e.which == 86) || (e.which == 2) || (e.which == 3) || (e.which == 123) || (e.which == 83)) && isCtrl == true)

        // {



        // return false;

        // }

        // }

        // // right click code

        // var isNS = (navigator.appName == "Netscape") ? 1 : 0;

        // if(navigator.appName == "Netscape") document.captureEvents(Event.MOUSEDOWN||Event.MOUSEUP);

        // function mischandler(){



        // return false;

        // }

        // function mousehandler(e){

        // var myevent = (isNS) ? e : event;

        // var eventbutton = (isNS) ? myevent.which : myevent.button;

        // if((eventbutton==2)||(eventbutton==3)) return false;

        // }

        // document.oncontextmenu = mischandler;

        // document.onmousedown = mousehandler;

        // document.onmouseup = mousehandler;

        // //select content code disable  alok goyal

        // function killCopy(e){

        // return false

        // }

        // function reEnable(){

        // return true

        // }

        // document.onselectstart=new Function ("return false")

        // if (window.sidebar){

        // document.onmousedown=killCopy

        // document.onclick=reEnable

        // }

        // setInterval(function(){

        //     debugger;

        // },500);
    </script>

    <style>
        .badge-pinky {

            background: pink !important;

        }
    </style>

</head>


<body class="bg-theme-2 bg-theme2">
<?php 
// Check Work From HOme 
if( $_SESSION['email'] != ''){
	$email = $_SESSION['email'];
		
	$sql = "SELECT user.*, shift.start_timing, shift.end_timing 
			FROM user 
			JOIN shift ON user.shift_id = shift.shiftId 
			WHERE email = ?";
	
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("s", $email);
	$stmt->execute();
	$result = $stmt->get_result();
	
	$user = $result->fetch_assoc();
	
	date_default_timezone_set('Asia/Karachi');
	$current_time = date('H:i');
	$start_time = $user['start_timing'];
	$end_time = $user['end_timing'];
	
	// echo "<script>console.log('$current_time')</script>";
	// echo "<script>console.log('$start_time')</script>";
	// echo "<script>console.log('$end_time')</script>";
		
	if ($current_time >= $start_time && $current_time <= $end_time) {
		return;
	} elseif ($current_time > $end_time) {
		if ($user['wfh'] == 'Allow' || $_SESSION['role'] == 'Admin' ) {
			return;
		} else {          
            $_SESSION['endtiming'] = "Your Shift timing has ended, you cannot log in.";

			echo "<script>window.location.href = 'login';</script>";
			exit;
		}
		if ($_SESSION['role'] == 'Admin') {
			return;
		} 
	} else {
        $_SESSION['endtiming'] = "Your Shift timing has ended, you cannot log in.";

		echo "<script>window.location.href = 'login';</script>";

		exit;
	}
	}
	
	// Check Work From HOme
    ?>
