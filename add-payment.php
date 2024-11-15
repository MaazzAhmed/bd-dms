<?php $TITLE = "Add Payment"; ?>

<?php require_once("./main_components/header.php");


if (
    !isset($_SESSION['role']) ||
    ($_SESSION['role'] !== 'Admin' &&
        $userPermissions['filter2'] !== 'Allow')
) {
    echo "<script>window.location.href = 'index';</script>";
    exit();
}

$order_id = $_GET['order_id'] ?? $_POST['order_id'] ?? null;

$query = "SELECT `pending_payment`, `receive_payment`, `currency`, `payment_date`, `total_payment` 
FROM `order_payments` 
WHERE `order_id` = '$order_id' 
ORDER BY `timestamp` DESC 
LIMIT 1";

$result = $conn->query($query);
if ($result && $result->num_rows > 0) {
    $pendingPayment = $result->fetch_assoc(); // Fetch data as an associative array
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

            <!--breadcrumb-->



            <!--end breadcrumb-->

            <div class="row">

                <div class="col-xl-10 mx-auto">

                    <!-- <h6 class="mb-0 text-uppercase">Basic Form</h6> -->

                    <hr />

                    <div class="card border-top border-0 border-4 border-white">

                        <div class="card-body p-5">

                            <div class="card-title d-flex align-items-center">

                                <div><i class="bx bxs-user me-1 font-22 text-white"></i>

                                </div>

                                <h5 class="mb-0 text-white">Add Payment</h5>

                            </div>

                            <hr>

                            <form method="post" class="row g-3">
                                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                <input type="hidden" name="pending_payment" value="<?php echo $pendingPayment['pending_payment'] ?? ''; ?>">
                                <input type="hidden" name="total_payment" value="<?php echo $pendingPayment['total_payment']?>">

                                <div class="col-md-6">

                                    <label for="inputFirstName" class="form-label">Pending Payment</label>

                                    <input type="text" disabled name="pending_payment" value="<?php echo $pendingPayment['pending_payment'] ?? ''; ?>"
                                        class="form-control" required id="inputFirstName">

                                </div>
                                <div class="col-md-6">

                                    <label for="inputFirstName" class="form-label">Receive Payment</label>

                                    <input type="text" name="receive_payment" class="form-control" required id="inputFirstName">

                                </div>
                                <div class="col-md-6">

                                    <label for="inputCurrency" class="form-label">Currency</label>

                                    <select name="currency" class="form-select" required id="inputCurrency">
                                        <option value="" disabled>Select Currency</option>
                                        <?php
                                        $currencies = ['USD', 'EUR', 'JPY', 'GBP', 'AED', 'AFN', 'ALL', 'AMD', 'ANG', 'AOA', 'ARS', 'AUD', 'AWG', 'AZN', 'BAM', 'BBD', 'BDT', 'BGN', 'BHD', 'BIF', 'BMD', 'BND', 'BOB', 'BRL', 'BSD', 'BTN', 'BWP', 'BYN', 'BZD', 'CAD', 'CDF', 'CHF', 'CLP', 'CNY', 'COP', 'CRC', 'CUC', 'CUP', 'CVE', 'CZK', 'DJF', 'DKK', 'DOP', 'DZD', 'EGP', 'ERN', 'ETB', 'EUR', 'FJD', 'FKP', 'GBP', 'GEL', 'GGP', 'GHS', 'GIP', 'GMD', 'GNF', 'GTQ', 'GYD', 'HKD', 'HNL', 'HRK', 'HTG', 'HUF', 'IDR', 'ILS', 'IMP', 'INR', 'IQD', 'IRR', 'ISK', 'JEP', 'JMD', 'JOD', 'JPY', 'KES', 'KGS', 'KHR', 'KID', 'KMF', 'KPW', 'KRW', 'KWD', 'KYD', 'KZT', 'LAK', 'LBP', 'LKR', 'LRD', 'LSL', 'LYD', 'MAD', 'MDL', 'MGA', 'MKD', 'MMK', 'MNT', 'MOP', 'MRU', 'MUR', 'MVR', 'MWK', 'MXN', 'MYR', 'MZN', 'NAD', 'NGN', 'NIO', 'NOK', 'NPR', 'NZD', 'OMR', 'PAB', 'PEN', 'PGK', 'PHP', 'PKR', 'PLN', 'PRB', 'PYG', 'QAR', 'RON', 'RSD', 'RUB', 'RWF', 'SAR', 'SEK', 'SGD', 'SHP', 'SLL', 'SLS', 'SOS', 'SRD', 'SSP', 'STN', 'SYP', 'SZL', 'THB', 'TJS', 'TMT', 'TND', 'TOP', 'TRY', 'TTD', 'TVD', 'TWD', 'TZS', 'UAH', 'UGX', 'USD', 'UYU', 'UZS', 'VES', 'VND', 'VUV', 'WST', 'XAF', 'XCD', 'XOF', 'XPF', 'ZAR', 'ZMW', 'ZWB'];

                                        foreach ($currencies as $currency) {
                                            $selected = (isset($pendingPayment['currency']) && $pendingPayment['currency'] === $currency) ? 'selected' : '';
                                            echo "<option value=\"$currency\" $selected>$currency</option>";
                                        }
                                        ?>
                                    </select>

                                </div>
                                <div class="col-md-6">

                                    <label for="inputOrderConfirmation" class="form-label">Payment Date:</label>

                                    <input type="date" value="<?php echo date('Y-m-d'); ?>" name="order_confirmation_date" class="form-control" required id="inputOrderConfirmation">

                                </div>
                                <?php
                                if($pendingPayment['pending_payment'] !== "0")
                                {
                                ?>

                                <div class="col-12 ">

                                    <button type="submit" name="add_payment" class="btn btn-light px-5">Add Payment</button>

                                </div>
<?php } ?>
                            </form>

                        </div>

                    </div>


                    <?php require_once("./main_components/footer.php"); ?>