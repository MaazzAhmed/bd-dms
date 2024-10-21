<?php $TITLE = "Order Payment"; ?>

<?php

// if (isset($_POST['edit_order'])) {

//     $leadid = $_POST['order_id'];





require_once("./main_components/header.php"); ?>

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

                <div class="col-xl-10 mx-auto">

                    <!-- <h6 class="mb-0 text-uppercase">Basic Form</h6> -->

                    <hr />

                    <div class="card border-top border-0 border-4 border-white">

                        <div class="card-body p-5">

                            <div class="card-title d-flex align-items-center">

                                <div><i class="bx bxs-user me-1 font-22 text-white"></i>

                                </div>

                                <h5 class="mb-0 text-white">Order Payment</h5>

                            </div>

                            <hr>

                            <form method="post" class="row g-3">



                                <input type="hidden" name="leadid" value="<?php echo $orderValues['lead_id']; ?>">
                                <input type="hidden" name="order_id" value="<?php echo $orderValues['orderId']; ?>">

                                <input type="hidden" name="creator_name" value="<?php echo $Session['name']; ?>">

                                <div class="col-md-6">

                                    <label for="inputFirstName" class="form-label">Order Id</label>

                                    <input type="text" name="order_id_input" value="<?php echo $orderValues['order_id_input']; ?>" class="form-control" placeholder="Order Id" required id="inputFirstName">

                                </div>

                                <div class="col-md-6">

                                    <label for="inputFirstName" class="form-label">Order Title</label>

                                    <input type="text" name="order_title" class="form-control" value="<?php echo $orderValues['order_title']; ?>" required id="inputFirstName">

                                </div>

                                <div class="col-md-6">

                                    <label for="inputState" class="form-label">Order Status:</label>

                                    <select name="order_status" required id="inputState" class="form-select">

                                        <?php

                                        // Assume $conn is your database connection

                                        $enumValues = getEnumValues($conn, 'order', 'order_status');



                                        foreach ($enumValues as $value) {

                                            echo "<option value='$value'" . ($orderValues['order_status'] == $value ? ' selected' : '') . ">$value</option>";
                                        }

                                        ?>

                                    </select>

                                </div>

                                <div class="col-md-6">

                                    <label for="inputState" class="form-label">Payment Status:</label>

                                    <select name="payment_status" required id="inputState" class="form-select">

                                        <!-- Assume $orderValues['payment_status'] contains the current payment status -->

                                        <?php

                                        $paymentStatuses = ['----', 'Half Payment', 'Full Payment']; // Define the payment statuses

                                        foreach ($paymentStatuses as $value) {

                                            $selected = ($orderValues['payment_status'] == $value) ? 'selected' : '';

                                            echo "<option value='$value' $selected>$value</option>";
                                        }

                                        ?>

                                    </select>

                                </div>

                                <div class="col-md-6">

                                    <label for="inputWordCount" class="form-label">Word Count:</label>

                                    <input type="text" name="word_count" class="form-control" value="<?php echo $orderValues['word_count']; ?>" required id="inputWordCount">

                                </div>

                                <div class="col-md-6">

                                    <label for="inputPendingPayment" class="form-label">Pending Payment:</label>

                                    <input type="tel" name="pending_payment" class="form-control" value="<?php echo $orderValues['pending_payment']; ?>" required id="inputPendingPayment">

                                </div>

                                <div class="col-md-6">

                                    <label for="inputRecievePayment" class="form-label">Recieve Payment:</label>

                                    <input type="tel" name="receive_payment" class="form-control" value="<?php echo $orderValues['receive_payment']; ?>" placeholder="Recieve Payment" required id="inputRecievePayment">

                                </div>

                                <div class="col-md-6">

                                    <label for="inputCurrency" class="form-label">Currency:</label>

                                    <input type="text" name="currency" class="form-control" value="<?php echo $orderValues['currency']; ?>" placeholder="Currency" required id="inputCurrency">

                                </div>

                                <div class="col-md-6">

                                    <label for="inputAccount" class="form-label">WhatsApp Account:</label>

                                    <input type="text" name="whatsapp_account" class="form-control" value="<?php echo $orderValues['whatsapp_account']; ?>" placeholder="WhatsApp Account" required id="inputAccount">

                                </div>



                                <div class="col-md-6">
                                    <label for="inputPaymentAccount" class="form-label">Payment Account:</label>
                                    <select name="payment_account" required id="inputPaymentAccount" class="form-select">
                                        <?php
                                        // Assume $conn is your database connection
                                        $sql = "SELECT DISTINCT account_name FROM bank_accounts";
                                        $result = $conn->query($sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $account_name = $row["account_name"];
                                                $selected = ($account_name == $current_payment_account) ? 'selected' : '';
                                                echo "<option value=\"$account_name\" $selected>$account_name</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>




                                <div class="col-md-6">

                                    <label for="inputPortalDueDate" class="form-label">Portal Due Date:</label>

                                    <input type="date" name="portal_due_date" value="<?php echo $orderValues['portal_due_date']; ?>" class="form-control" required id="inputPortalDueDate">

                                </div>



                                <div class="col-md-6">

                                    <label for="inputFinalDeadline" class="form-label">Final Deadline Time:</label>

                                    <?php

                                    // Assuming $orderValues['final_deadline_time'] contains the date and time in a valid format

                                    $formattedDateTime = date('Y-m-d\TH:i', strtotime($orderValues['final_deadline_time']));

                                    ?>

                                    <input type="datetime-local" name="final_deadline_time" value="<?php echo $formattedDateTime; ?>" class="form-control" required id="inputFinalDeadline">

                                </div>



                                <div class="col-md-6">

                                    <label for="inputOrderConfirmation" class="form-label">Order Confirmation Date:</label>

                                    <input type="date" name="order_confirmation_date" class="form-control" value="<?php echo $orderValues['order_confirmation_date']; ?>" required id="inputOrderConfirmation">

                                </div>



                                <div class="col-md-6">

                                    <label for="inputWriterTeam" class="form-label">Writer Team:</label>

                                    <input type="text" name="writers_team" class="form-control" value="<?php echo $orderValues['writers_team']; ?>" placeholder="Writer Team" required id="inputWriterTeam">

                                </div>





                                <div class="col-md-6">

                                    <label for="inputPlan" class="form-label">Plan:</label>

                                    <!-- <input type="text" name="plan" class="form-control" placeholder="plan" value="<?php echo $orderValues['plan']; ?>"  required id="inputPlan"> -->

                                    <select name="plan" class="form-select" required>
                                        <?php
                                        $enumValues = ['Standard', 'Premium']; // Example array of plan options
                                        foreach ($enumValues as $plan) {
                                            echo "<option value='$plan'" . ($orderValues['plan'] == $plan ? ' selected' : '') . ">$plan</option>";
                                        }
                                        ?>
                                    </select>



                                </div>



                                <div class="col-md-6">

                                    <label for="inputAssignTo" class="form-label">Assign To:</label>

                                    <input type="text" name="assigned_to" class="form-control" placeholder="Assign To" value="<?php echo $orderValues['assigned_to']; ?>" required id="inputAssignTo">

                                </div>



                                <div class="col-md-6">

                                    <label for="inputYear" class="form-label">Year:</label>

                                    <select name="years" class="form-select" required id="inputYear">
                                        <?php
                                        $currentYear = date("Y");
                                        for ($year = $currentYear; $year >= $currentYear - 5; $year--) {
                                            echo "<option value='$year'" . ($orderValues['years'] == $year ? ' selected' : '') . ">$year</option>";
                                        }
                                        ?>
                                    </select>



                                </div>

                                <div class="col-md-6">

                                    <label for="inputAssignTo" class="form-label">Comment:</label>

                                    <input type="text" name="comment" class="form-control" placeholder="Assign To" value="<?php echo $orderValues['comment']; ?>" required id="inputAssignTo">

                                </div>


                                <div class="col-md-6">

                                    <label for="inputClientRequirements" class="form-label">Client Reuirements:</label>

                                    <textarea name="client_requirements" class="form-control" placeholder="Client Reuirements" required id="inputClientRequirements"><?php echo $orderValues['client_requirements']; ?></textarea>

                                </div>
                          




                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['id'] ?>" class="form-control" required id="inputId">

                                <input type="hidden" name="editor-name" value="<?php echo $_SESSION['name'] ?>" class="form-control" required id="inputId">





                                <div class="col-12 text-center">

                                    <button type="submit" name="order-payment" class="btn btn-light px-5">Update order</button>

                                </div>

                            </form>

                        </div>

                    </div>







                    <?php require_once("./main_components/footer.php"); ?>

                    <?php

                    //  }

                    // else{

                    //     header("Location: view-orders");

                    // } 

                    ?>