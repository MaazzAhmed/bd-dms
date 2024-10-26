<?php $TITLE = "Add Order"; ?>

<?php

require_once("./main_components/header.php"); ?>

<!--wrapper-->

<div class="wrapper">

    <!--sidebar wrapper -->

    <?php require_once("./main_components/sidebar.php"); ?>



    <!--end sidebar wrapper -->

    <!--start header -->

    <?php require_once("./main_components/navbar.php"); ?>

    <?php if (isset($_POST['add_lead_id'])) {

        $leadid = $_POST['l_id'];



        $query = "SELECT * from leads where id = $leadid";
        $result = mysqli_query($conn, $query);

        $row = mysqli_fetch_assoc($result);

    
    




    ?>

        <!--end header -->

        <!--start page wrapper -->

        <div class="page-wrapper">

            <div class="page-content">

                <!--breadcrumb-->



                <!--end breadcrumb-->

                <div class="row">

                    <div class="col-xl-10 mx-auto">

                        <!-- <h6 class="mb-0 text-uppercase">Add Order</h6> -->

                        <hr />

                        <div class="card border-top border-0 border-4 border-white">

                            <div class="card-body p-5">

                                <div class="card-title d-flex align-items-center">

                                    <div><i class="bx bxs-user me-1 font-22 text-white"></i>

                                    </div>

                                    <h5 class="mb-0 text-white">Add Order</h5>

                                </div>

                                <hr>

                                <form method="post" class="row g-3">

                                    <input type="hidden" name="leadid" id="leadid" value="<?php echo $leadid ?>" required><br>



                                    <div class="col-md-6">

                                        <label for="inputFirstName" class="form-label">camp Id</label>

                                        <input type="text" disabled value="<?php echo $row['campId'] ?>" class="form-control" placeholder="Order Id" required id="inputFirstName">

                                    </div>
                                    <div class="col-md-6">

                                        <label for="inputFirstName" class="form-label">Client Name</label>

                                        <input type="text" disabled value="<?php echo $row['client_name'] ?>" class="form-control" placeholder="Order Id" required id="inputFirstName">

                                    </div>
                                    <div class="col-md-6">

                                        <label for="inputFirstName" class="form-label">Client Email</label>

                                        <input type="text" disabled value="<?php echo $row['client_email'] ?>" class="form-control" placeholder="Order Id" required id="inputFirstName">

                                    </div>
                                    <div class="col-md-6">

                                        <label for="inputFirstName" class="form-label">Client Contact Number</label>

                                        <input type="text" disabled value="<?php echo $row['client_contact_number'] ?>" class="form-control" placeholder="Order Id" required id="inputFirstName">

                                    </div>
                                    <div class="col-md-6">

                                        <label for="inputFirstName" class="form-label">Order Id</label>

                                        <input type="number" name="order_id_input" class="form-control" placeholder="Order Id" required id="inputFirstName">

                                    </div>

                                    <div class="col-md-6">

                                        <label for="inputFirstName" class="form-label">Order Title</label>

                                        <input type="text" name="order_title" class="form-control" placeholder="Order Title" required id="inputFirstName">

                                    </div>

                                    <div class="col-md-6">

                                        <label for="inputState" class="form-label">Order Status:</label>

                                        <select name="order_status" required id="inputState" class="form-select">

                                            <?php

                                            // Assume $conn is your database connection

                                            $enumValues = getEnumValues($conn, 'order', 'order_status');



                                            foreach ($enumValues as $value) {

                                                echo "<option value=\"$value\">$value</option>";
                                            }

                                            ?>

                                        </select>

                                    </div>



                                    <div class="col-md-6">

                                        <label for="inputState" class="form-label">Payment Status:</label>

                                        <select name="payment_status" id="inputState" class="form-select">



                                            <option value="payment_status" disabled selected>Select Payment Status</option>

                                            <option value="----	">No Payment</option>
                                            <option value="Half Payment">Half Payment</option>

                                            <option value="Full Payment">Full Payment</option>





                                        </select>

                                    </div>

                                    <div class="col-md-6">

                                        <label for="inputWordCount" class="form-label">Word Count:</label>

                                        <input type="number" name="word_count" class="form-control" placeholder="Word Count" required id="inputWordCount">

                                    </div>

                                    <div class="col-md-6">

                                        <label for="inputPendingPayment" class="form-label">Pending Payment:</label>

                                        <input type="number" name="pending_payment" class="form-control" placeholder="Pending Payment" required id="inputPendingPayment">

                                    </div>

                                    <div class="col-md-6">

                                        <label for="inputRecievePayment" class="form-label">Recieve Payment:</label>

                                        <input type="number" name="receive_payment" class="form-control" placeholder="Recieve Payment" required id="inputRecievePayment">

                                    </div>

                                    

                                    <div class="col-md-6">

                                        <label for="inputCurrency" class="form-label">Currency:</label>

                                        <select name="currency" class="form-select" placeholder="Currency" required id="inputCurrency">

                                            <option value="USD" selected="selected" disabled>Select Currency</option>

                                            <option value="USD">USD</option>

                                            <option value="EUR">EUR</option>

                                            <option value="JPY">JPY</option>

                                            <option value="GBP">GBP</option>

                                            <option value="AED">AED</option>

                                            <option value="AFN">AFN</option>

                                            <option value="ALL">ALL</option>

                                            <option value="AMD">AMD</option>

                                            <option value="ANG">ANG</option>

                                            <option value="AOA">AOA</option>

                                            <option value="ARS">ARS</option>

                                            <option value="AUD">AUD</option>

                                            <option value="AWG">AWG</option>

                                            <option value="AZN">AZN</option>

                                            <option value="BAM">BAM</option>

                                            <option value="BBD">BBD</option>

                                            <option value="BDT">BDT</option>

                                            <option value="BGN">BGN</option>

                                            <option value="BHD">BHD</option>

                                            <option value="BIF">BIF</option>

                                            <option value="BMD">BMD</option>

                                            <option value="BND">BND</option>

                                            <option value="BOB">BOB</option>

                                            <option value="BRL">BRL</option>

                                            <option value="BSD">BSD</option>

                                            <option value="BTN">BTN</option>

                                            <option value="BWP">BWP</option>

                                            <option value="BYN">BYN</option>

                                            <option value="BZD">BZD</option>

                                            <option value="CAD">CAD</option>

                                            <option value="CDF">CDF</option>

                                            <option value="CHF">CHF</option>

                                            <option value="CLP">CLP</option>

                                            <option value="CNY">CNY</option>

                                            <option value="COP">COP</option>

                                            <option value="CRC">CRC</option>

                                            <option value="CUC">CUC</option>

                                            <option value="CUP">CUP</option>

                                            <option value="CVE">CVE</option>

                                            <option value="CZK">CZK</option>

                                            <option value="DJF">DJF</option>

                                            <option value="DKK">DKK</option>

                                            <option value="DOP">DOP</option>

                                            <option value="DZD">DZD</option>

                                            <option value="EGP">EGP</option>

                                            <option value="ERN">ERN</option>

                                            <option value="ETB">ETB</option>

                                            <option value="EUR">EUR</option>

                                            <option value="FJD">FJD</option>

                                            <option value="FKP">FKP</option>

                                            <option value="GBP">GBP</option>

                                            <option value="GEL">GEL</option>

                                            <option value="GGP">GGP</option>

                                            <option value="GHS">GHS</option>

                                            <option value="GIP">GIP</option>

                                            <option value="GMD">GMD</option>

                                            <option value="GNF">GNF</option>

                                            <option value="GTQ">GTQ</option>

                                            <option value="GYD">GYD</option>

                                            <option value="HKD">HKD</option>

                                            <option value="HNL">HNL</option>

                                            <option value="HRK">HRK</option>

                                            <option value="HTG">HTG</option>

                                            <option value="HUF">HUF</option>

                                            <option value="IDR">IDR</option>

                                            <option value="ILS">ILS</option>

                                            <option value="IMP">IMP</option>

                                            <option value="INR">INR</option>

                                            <option value="IQD">IQD</option>

                                            <option value="IRR">IRR</option>

                                            <option value="ISK">ISK</option>

                                            <option value="JEP">JEP</option>

                                            <option value="JMD">JMD</option>

                                            <option value="JOD">JOD</option>

                                            <option value="JPY">JPY</option>

                                            <option value="KES">KES</option>

                                            <option value="KGS">KGS</option>

                                            <option value="KHR">KHR</option>

                                            <option value="KID">KID</option>

                                            <option value="KMF">KMF</option>

                                            <option value="KPW">KPW</option>

                                            <option value="KRW">KRW</option>

                                            <option value="KWD">KWD</option>

                                            <option value="KYD">KYD</option>

                                            <option value="KZT">KZT</option>

                                            <option value="LAK">LAK</option>

                                            <option value="LBP">LBP</option>

                                            <option value="LKR">LKR</option>

                                            <option value="LRD">LRD</option>

                                            <option value="LSL">LSL</option>

                                            <option value="LYD">LYD</option>

                                            <option value="MAD">MAD</option>

                                            <option value="MDL">MDL</option>

                                            <option value="MGA">MGA</option>

                                            <option value="MKD">MKD</option>

                                            <option value="MMK">MMK</option>

                                            <option value="MNT">MNT</option>

                                            <option value="MOP">MOP</option>

                                            <option value="MRU">MRU</option>

                                            <option value="MUR">MUR</option>

                                            <option value="MVR">MVR</option>

                                            <option value="MWK">MWK</option>

                                            <option value="MXN">MXN</option>

                                            <option value="MYR">MYR</option>

                                            <option value="MZN">MZN</option>

                                            <option value="NAD">NAD</option>

                                            <option value="NGN">NGN</option>

                                            <option value="NIO">NIO</option>

                                            <option value="NOK">NOK</option>

                                            <option value="NPR">NPR</option>

                                            <option value="NZD">NZD</option>

                                            <option value="OMR">OMR</option>

                                            <option value="PAB">PAB</option>

                                            <option value="PEN">PEN</option>

                                            <option value="PGK">PGK</option>

                                            <option value="PHP">PHP</option>

                                            <option value="PKR">PKR</option>

                                            <option value="PLN">PLN</option>

                                            <option value="PRB">PRB</option>

                                            <option value="PYG">PYG</option>

                                            <option value="QAR">QAR</option>

                                            <option value="RON">RON</option>

                                            <option value="RSD">RSD</option>

                                            <option value="RUB">RUB</option>

                                            <option value="RWF">RWF</option>

                                            <option value="SAR">SAR</option>

                                            <option value="SEK">SEK</option>

                                            <option value="SGD">SGD</option>

                                            <option value="SHP">SHP</option>

                                            <option value="SLL">SLL</option>

                                            <option value="SLS">SLS</option>

                                            <option value="SOS">SOS</option>

                                            <option value="SRD">SRD</option>

                                            <option value="SSP">SSP</option>

                                            <option value="STN">STN</option>

                                            <option value="SYP">SYP</option>

                                            <option value="SZL">SZL</option>

                                            <option value="THB">THB</option>

                                            <option value="TJS">TJS</option>

                                            <option value="TMT">TMT</option>

                                            <option value="TND">TND</option>

                                            <option value="TOP">TOP</option>

                                            <option value="TRY">TRY</option>

                                            <option value="TTD">TTD</option>

                                            <option value="TVD">TVD</option>

                                            <option value="TWD">TWD</option>

                                            <option value="TZS">TZS</option>

                                            <option value="UAH">UAH</option>

                                            <option value="UGX">UGX</option>

                                            <option value="USD">USD</option>

                                            <option value="UYU">UYU</option>

                                            <option value="UZS">UZS</option>

                                            <option value="VES">VES</option>

                                            <option value="VND">VND</option>

                                            <option value="VUV">VUV</option>

                                            <option value="WST">WST</option>

                                            <option value="XAF">XAF</option>

                                            <option value="XCD">XCD</option>

                                            <option value="XOF">XOF</option>

                                            <option value="XPF">XPF</option>

                                            <option value="ZAR">ZAR</option>

                                            <option value="ZMW">ZMW</option>

                                            <option value="ZWB">ZWB</option>

                                        </select>

                                    </div>

                                    <div class="col-md-6">

                                        <label for="inputAccount" class="form-label">WhatsApp Account:</label>

                                        <input type="text" name="whatsapp_account" class="form-control" placeholder="WhatsApp Account" required id="inputAccount">

                                    </div>



                                    <div class="col-md-6">
                                        <label for="inputPaymentAccount" class="form-label">Payment Account:</label>
                                        <select name="payment_account" required id="inputPaymentAccount" class="form-select">
                                            <option selected disabled>Choose..... </option>
                                            <?php
                                            // Assume $conn is your database connection
                                            $sql = "SELECT DISTINCT account_name FROM bank_accounts";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $account_name = $row["account_name"];
                                                    echo "<option value=\"$account_name\">$account_name</option>";
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>



                                    <div class="col-md-6">

                                        <label for="inputPortalDueDate" class="form-label">Portal Due Date:</label>

                                        <input type="date" name="portal_due_date" class="form-control" required id="inputPortalDueDate">

                                    </div>



                                    <div class="col-md-6">

                                        <label for="inputFinalDeadline" class="form-label">Final Deadline Time:</label>

                                        <input type="datetime-local" name="final_deadline_time" class="form-control" required id="inputFinalDeadline">

                                    </div>



                                    <div class="col-md-6">

                                        <label for="inputOrderConfirmation" class="form-label">Order Confirmation
                                            Date:</label>

                                        <input type="date" name="order_confirmation_date" class="form-control" required id="inputOrderConfirmation">

                                    </div>



                                    <div class="col-md-6">

                                        <label for="inputWriterTeam" class="form-label">Writer Team:</label>

                                        <input type="text" name="writers_team" class="form-control" placeholder="Writer Team" required id="inputWriterTeam">

                                    </div>





                                    <div class="col-md-6">

                                        <label for="inputPlan" class="form-label">Plan:</label>

                                        <!-- <input type="text" name="plan" class="form-control" placeholder="plan" required id="inputPlan"> -->
                                        <select id="monthFilter" name="plan" class="form-select">
                                            <option value selected disabled>Select Plan</option>
                                            <?php
                                            // Assume $conn is your database connection
                                            $sql = "SELECT DISTINCT plan FROM plan";
                                            $result = $conn->query($sql);
                                            if ($result->num_rows > 0) {
                                                while ($row = $result->fetch_assoc()) {
                                                    $plan = $row["plan"];
                                                    echo "<option value=\"$plan\">$plan</option>";
                                                }
                                            }
                                            ?>
                                        </select>

                                    </div>



                                    <div class="col-md-6">

                                        <label for="inputAssignTo" class="form-label">Assign To:</label>

                                        <input type="text" name="assigned_to" class="form-control" placeholder="Assign To" required id="inputAssignTo">

                                    </div>



                                    <!-- <div class="col-md-6">

                                        <label for="inputYear" class="form-label">Year:</label>

                                        <select name="years" class="form-select">
                                            <option value="">Select Year</option>
                                            <option value="2015">2010</option>
                                            <option value="2015">2011</option>
                                            <option value="2015">2012</option>
                                            <option value="2015">2013</option>
                                            <option value="2015">2014</option>
                                            <option value="2015">2015</option>
                                            <option value="2016">2016</option>
                                            <option value="2017">2017</option>
                                            <option value="2018">2018</option>
                                            <option value="2019">2019</option>
                                            <option value="2020">2020</option>
                                            <option value="2021">2021</option>
                                            <option value="2022">2022</option>
                                            <option value="2023">2023</option>
                                            <option value="2024">2024</option>
                                            <option value="2025">2025</option>
                                            <option value="2026">2026</option>
                                            <option value="2027">2027</option>
                                            <option value="2028">2028</option>
                                            <option value="2029">2029</option>
                                            <option value="2030">2030</option>
                                        </select>

                                    </div> -->

                                    <div class="col-md-6">

                                        <label for="inputAssignTo" class="form-label">Comment:</label>

                                        <input type="text" name="comment" class="form-control" placeholder="Comment" required id="inputAssignTo">

                                    </div>


                                    <div class="col-md-6">

                                        <label for="inputClientRequirements" class="form-label">Client Requirements:</label>

                                        <textarea name="client_requirements" class="form-control" placeholder="Client Requirements" required id="inputClientRequirements"></textarea>

                                    </div>

                                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['id'] ?>" class="form-control">

                                    <input type="hidden" name="creator_name" value="<?php echo $_SESSION['user'] ?>" class="form-control" id="inputId">

                                    <div class="col-12 text-center">

                                        <button type="submit" name="create-order" class="btn btn-light px-5">Create
                                            order</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                    }                
                    else {
                        echo "<script>window.location.href='view-leads'</script>" . mysqli_error($conn);
                    }
                    ?>
                <?php require_once("./main_components/footer.php"); ?>