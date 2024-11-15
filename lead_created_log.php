<?php $TITLE = "Lead Created Log"; ?>

<?php require_once("./main_components/header.php");

if (
    !isset($_SESSION['role']) ||
    ($_SESSION['role'] !== 'Admin' &&
        $userPermissions['log_management'] !== 'Allow')
) {
    echo "<script>window.location.href = 'index';</script>";
    exit();
}
?>

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



            <div class="row">

                <div class="col-xl-12 mx-auto">

                    <hr />

                    <div class="card border-top border-0 border-4 border-white">

                        <div class="card-body p-5">

                            <div class="card-title d-flex align-items-center">

                                <div><i class="bx bxs-user me-1 font-22 text-white"></i>

                                </div>

                                <h5 class="mb-0 text-white">Lead Created Logs</h5>

                            </div>

                            <hr>

                            <form class="row g-3">

                                <div class="col-12">



                                    <?php

                                    $logFile = 'logs/lead_created_log.txt';



                                    if (file_exists($logFile)) {

                                        // Read the content of the log file

                                        $logContent = file_get_contents($logFile);



                                        // Split log content by new line

                                        $logRecords = explode(PHP_EOL, $logContent);



                                        // Reverse the order to display the latest log record first

                                        $logRecords = array_reverse($logRecords);



                                        // Display each log record in a separate <div> with an icon

                                        foreach ($logRecords as $logRecord) {

                                            // Split each log record into parts (date and message)

                                            $logParts = explode(' - ', $logRecord, 2);



                                            // Check if there are two parts (date and message)

                                            if (count($logParts) == 2) {

                                                // Parse the date and format it

                                                $dateTimeObject = DateTime::createFromFormat('Y-m-d H:i:s', trim($logParts[0]));

                                                if ($dateTimeObject !== false) {

                                                    $formattedDate = $dateTimeObject->format('M d, Y h:i a');



                                                    // Display the formatted date and log message

                                                    echo '<div class="d-flex align-items-center shadow-sm p-2 cursor-pointer rounded gap-3">';

                                                    echo '<div class="font-18 text-white"><i class="lni lni-checkmark-circle"></i></div>';

                                                    echo '<div>';

                                                    echo '<span class="font-14 text-secondary">' . htmlspecialchars($formattedDate) . '</span>';

                                                    echo '<p>' . htmlspecialchars($logParts[1]) . '</p>';

                                                    echo '</div>';

                                                    echo '</div>';
                                                } else {

                                                    // Handle invalid date format

                                                    echo '<div>Error: Invalid date format.</div>';
                                                }
                                            }
                                        }
                                    } else {

                                        echo '<div class="d-flex align-items-center theme-icons shadow-sm p-2 cursor-pointer rounded">';

                                        echo '<i class="lni lni-warning"></i>'; // Replace with your actual icon class for no log file

                                        echo '<span>No log file found.</span>';

                                        echo '</div>';
                                    }

                                    ?>

                                </div>











                            </form>

                        </div>

                    </div>







                    <?php require_once("./main_components/footer.php"); ?>