<?php


$TITLE = "View Payments"; ?>

<?php require_once("./main_components/header.php");

if (
    !isset($_SESSION['role']) ||
    ($_SESSION['role'] !== 'Admin' &&
        $userPermissions['view_order'] !== 'Allow')
) {
    echo "<script>window.location.href = 'index';</script>";
    exit();
}
?>
<style>
    .table-responsive {
        overflow: hidden;
        /* Hide scroll initially */
        cursor: grab;
        /* Change cursor to grab when hovering */
    }

    .table-responsive:active {
        cursor: grabbing;
        /* Change cursor when active (dragging) */
    }
</style>

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



                <div class="header-containerss">
                    <h6 class="mb-0 text-uppercase">Payments</h6>
                </div>
                <hr>
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>

                                        <th>Pending Payment</th>
                                        <th>Received Payment</th>
                                        <th>Month</th>
                                        <th>Currency</th>
                                        <th>Payment Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($paymentDetails) > 0): ?>
                                        <?php foreach ($paymentDetails as $payment): ?>
                                            <form method="POST" action="">
                                                <tr>
                                                    <input type="hidden" name="payment_id" value="<?php echo htmlspecialchars($payment['id']); ?>">
                                                    <input type="hidden" name="orderId" value="<?php echo htmlspecialchars($payment['order_id']); ?>">

                                                    <td><input class="form-control" type="text" name="pending_payment" value="<?php echo htmlspecialchars($payment['pending_payment']); ?>"></td>
                                                    <td><input class="form-control" type="text" name="receive_payment" value="<?php echo htmlspecialchars($payment['receive_payment']); ?>"></td>
                                                    <td><input class="form-control" type="text" name="month" value="<?php echo htmlspecialchars($payment['month']); ?>"></td>
                                                    <td><input class="form-control" type="text" name="currency" value="<?php echo htmlspecialchars($payment['currency']); ?>"></td>
                                                    <td><input class="form-control" type="date" name="payment_date" value="<?php echo htmlspecialchars(date('Y-m-d', strtotime($payment['payment_date']))); ?>"></td>

                                                    <td>
                                                        <button class="btn btn-dark px-5" type="submit" name="update_payment">Save</button>
                                                    </td>
                                                </tr>
                                            </form>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6">No payment records found for this order.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>

                            </table>

                            <center><h4 style="background-color: black;">Upsale</h4></center>

                    <?php if (empty($paymentDetails[0]['upscale'])): ?>
                        <!-- Show Add Upscale Button if upscale is NULL -->
                        <form method="POST" action="">
                            <input type="hidden" name="orderId" value="<?php echo htmlspecialchars($paymentDetails[0]['order_id']); ?>">
                            <input type="hidden" name="before_upscale" value="<?php echo htmlspecialchars($paymentDetails[0]['total_payment']); ?>">
                            
                           
                                <input class="form-control" type="hidden" name="upscale" value="upsale">
                           
                            <div class="col-md-6">
                           
                                <label class="form-label">Upsale Payment</label>
                                <input class="form-control" type="text" name="total_payment" placeholder="Enter new total payment">
                            </div>
                      
                            <button class="btn btn-dark px-5 mt-2" type="submit" name="add_upscale">Save Upscale</button>
                         
                        </form>
                    <?php else: ?>
                        <!-- Show Editable Form if upscale is already present -->
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Before Upsale</th>
                                    <th>Total Payment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <form method="POST" action="">
                                        <input type="hidden" name="orderId" value="<?php echo htmlspecialchars($paymentDetails[0]['order_id']); ?>">
                                        <input class="form-control" type="text" name="before_upscale" value="<?php echo htmlspecialchars($paymentDetails[0]['total_payment']); ?>">
                                        <td><input class="form-control" type="text" value="<?php echo htmlspecialchars($paymentDetails[0]['before_upscale']); ?>" disabled></td>
                                        <td><input class="form-control" type="text" name="total_payment" value="<?php echo htmlspecialchars($paymentDetails[0]['total_payment']); ?>"></td>
                                        <td>
                                            <button class="btn btn-dark px-5" type="submit" name="update_upsale">Save</button>
                                        </td>
                                    </form>
                                </tr>
                            </tbody>
                        </table>
                    <?php endif; ?>
                      
                      
                      
                          </div>
                    </div>
                </div>


            <?php require_once("./main_components/footer.php"); ?>