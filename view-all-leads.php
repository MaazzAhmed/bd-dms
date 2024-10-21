<?php $TITLE = "Live Lead Details"; ?>

<?php require_once("./main_components/header.php"); ?>

<div class="wrapper">

    <?php require_once("./main_components/sidebar.php"); ?>

    <?php require_once("./main_components/navbar.php");

    if (isset($_POST['view-all-orders'])) {

        $leadid = $_POST['detailleadid'];

        $leads = getDetailsForSelectedleads($conn, $leadid);

        if ($leads) {

    ?>

            <!--end header -->

            <!--start page wrapper -->

            <div class="page-wrapper">

                <div class="page-content">

                    <div class="row">

                        <div class="col-xl-12 mx-auto">


                            <!-- <hr /> -->

                            <div class="card border-top border-0 border-4 border-white">

                                <div class="card-body p-5">

                                    <div class="card-title d-flex align-items-center">

                                        <div><i class="bx bxs-user me-1 font-22 text-white"></i>

                                        </div>

                                        <h5 class="mb-0 text-white">Live Lead Details</h5>

                                    </div>

                                    <hr>

                                    <form class="row g-3">

                                        <div class="col-md-4">

                                            <h5 style="font-size: 16px;">Camp Id</h5>

                                        </div>

                                        <div class="col-md-8">

                                            <h5 style="font-size: 16px;"><?php echo $leads['campId']; ?></h5>

                                        </div>

                                        <div class="col-md-4">

                                            <h5 style="font-size: 16px;">Client Name</h5>

                                        </div>

                                        <div class="col-md-8">

                                            <h5 style="font-size: 16px;"><?php echo $leads['client_name']; ?></h5>

                                        </div>

                                        <div class="col-md-4">

                                            <h5 style="font-size: 16px;">Client Contact Number</h5>

                                        </div>

                                        <div class="col-md-8">

                                            <h5 style="font-size: 16px;"><?php echo $leads['client_contact_number']; ?></h5>

                                        </div>

                                        <div class="col-md-4">

                                            <h5 style="font-size: 16px;">Client Email</h5>

                                        </div>

                                        <div class="col-md-8">

                                            <h5 style="font-size: 16px;"><?php echo $leads['client_email']; ?></h5>

                                        </div>

                                        <div class="col-md-4">

                                            <h5 style="font-size: 16px;">Client Country</h5>

                                        </div>

                                        <div class="col-md-8">

                                            <h5 style="font-size: 16px;"><?php echo $leads['client_country']; ?></h5>

                                        </div>

                                        <div class="col-md-4">

                                            <h5 style="font-size: 16px;">Client Info</h5>

                                        </div>

                                        <div class="col-md-8">

                                            <h5 style="font-size: 16px;"><?php echo $leads['client_info']; ?></h5>

                                        </div>

                                        <div class="col-md-4">

                                            <h5 style="font-size: 16px;">Lead Source</h5>

                                        </div>

                                        <div class="col-md-8">

                                            <h5 style="font-size: 16px;"><?php echo $leads['lead_source']; ?></h5>

                                        </div>

                                        <div class="col-md-4">

                                            <h5 style="font-size: 16px;">Brand Name</h5>

                                        </div>

                                        <div class="col-md-8">

                                            <h5 style="font-size: 16px;"><?php echo $leads['brand_name']; ?></h5>

                                        </div>



                                        <!-- <div class="col-md-4">

                                            <h5 style="font-size: 16px;">Whatsapp Name</h5>

                                        </div>

                                        <div class="col-md-8">

                                            <h5 style="font-size: 16px;"><?php echo $leads['whatsapp_name']; ?></h5>

                                        </div> -->
                                        <div class="col-md-4">
                                            <h5 style="font-size: 16px;">Whatsapp Name</h5>
                                        </div>

                                        <div class="col-md-8">
                                            <h5 style="font-size: 16px;">
                                                <?php
                                                // Get the WhatsApp name
                                                $whatsappName = $leads['whatsapp_name'];

                                                if (preg_match('/^(.*?)(\d{4,})$/', $whatsappName, $matches)) {
                                                    $countryCode = $matches[1];
                                                    $number = $matches[2];

                                                    $maskedNumber = str_repeat('*', strlen($number) - 3) . substr($number, -3);

                                                    echo $countryCode . ' ' . $maskedNumber;
                                                } else {
                                                    echo $whatsappName;
                                                }
                                                ?>
                                            </h5>
                                        </div>




                                        <?php
                                        if ($leads['refer_client_name'] != '') {
                                        ?>



                                            <div class="col-md-4">

                                                <h5 style="font-size: 16px;">Refer Client Name</h5>

                                            </div>

                                            <div class="col-md-8">

                                                <h5 style="font-size: 16px;"><?php echo $leads['refer_client_name']; ?></h5>

                                            </div>

                                        <?php } ?>
                                        <?php
                                        if ($leads['platform'] != '') {
                                        ?>
                                            <div class="col-md-4">

                                                <h5 style="font-size: 16px;">PlatForm</h5>

                                            </div>

                                            <div class="col-md-8">

                                                <h5 style="font-size: 16px;"><?php echo $leads['platform']; ?></h5>

                                            </div>
                                        <?php } ?>

                                        <div class="col-md-4">

                                            <h5 style="font-size: 16px;">Lead Landing Date</h5>

                                        </div>

                                        <div class="col-md-8">

                                            <h5 style="font-size: 16px;"><?php echo date('d-M-Y h:i a', strtotime($leads['lead_landing_date'])); ?></h5>


                                        </div>







                                        <div class="col-md-4">

                                            <h5 style="font-size: 16px;">Lead Creater Name</h5>

                                        </div>

                                        <div class="col-md-8">

                                            <h5 style="font-size: 16px;"><?php echo $leads['name']; ?></h5>

                                        </div>
                                        <div class="col-md-4">

                                            <h5 style="font-size: 16px;">Lead Type</h5>

                                        </div>

                                        <div class="col-md-8">

                                            <h5 style="font-size: 16px;"><?php echo $leads['lead_type']; ?></h5>

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