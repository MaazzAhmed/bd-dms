<?php $TITLE = "View Payment Accounts"; ?>

<?php require_once("./main_components/header.php"); 




if (!isset($_SESSION['role']) || 
    ($_SESSION['role'] !== 'Admin')) {
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



            <h6 class="mb-0 text-uppercase">Payment Account</h6>

            <hr />

            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="example" class="table table-striped table-bordered" style="width:100%">

                            <thead>

                                <tr>

                                    <th>ID</th>

                                    <th>Account Name</th>
                                    <?php
                                    if ($_SESSION['role'] == 'Admin') {

                                    ?>

                                        <th>Edit</th>

                                        <th>Delete</th>
                                    <?php } ?>

                                </tr>

                            </thead>

                            <tbody>





                                <?php
                                $sql = "SELECT id, account_name FROM bank_accounts ORDER BY id DESC ";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                ?>

                                        <tr>

                                            <td><?php echo  $row["id"]; ?></td>

                                            <td><?php echo $row["account_name"]; ?></td>
                                            <?php
                                            if ($_SESSION['role'] == 'Admin') {

                                            ?>
                                                <td>

                                                    <form method='post' action='edit-payment.php'>
                                                        <input type="hidden" name="payment_id" value="<?php echo $row['id']; ?>">

                                                        <button type="submit" name='edit_payments' class="bg-secondary text-white px-3 rounded-pill">

                                                            <div class="col" tabindex="6">

                                                                <div class="d-flex bg-secondary align-items-center theme-icons shadow-sm cursor-pointer rounded-pill">

                                                                    <div class="text-white"><i class="fadeIn animated bx bx-pencil" style="font-size:17px;"></i>

                                                                    </div>

                                                                    <div class="ms-2">Edit</div>

                                                                </div>

                                                            </div>

                                                        </button>


                                                    </form>
                                                </td>

                                                <td>

                                                    <form method="post" onsubmit="return confirm('Are you sure you want to delete this Payment Account?');">

                                                        <input type="hidden" name="payment_id" value="<?php echo $row['id']; ?>">

                                                        <button type="submit" name="delete_payment" class="bg-danger text-white px-3 rounded-pill">

                                                            <div class="col" tabindex="6">

                                                                <div class="d-flex bg-danger align-items-center theme-icons shadow-sm cursor-pointer rounded-pill">

                                                                    <div class="text-white"><i class="fadeIn animated bx bx-trash" style="font-size:17px;"></i>

                                                                    </div>

                                                                    <div class="ms-2">Delete</div>

                                                                </div>

                                                            </div>

                                                        </button>

                                                    </form>

                                                </td>
                                            <?php } ?>


                                        </tr>



                                <?php
                                    }
                                } else {
                                    echo "0 results";
                                }
                                ?>






                            </tbody>



                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php


if (isset($_SESSION['up_payment_account'])) {


    echo "<script>alertify.success('{$_SESSION['up_payment_account']}', { position: 'top-right' });</script>";
    unset($_SESSION['up_payment_account']);
}

if (isset($_SESSION['delpayment'])) {

    echo "<script>alertify.success('{$_SESSION['delpayment']}', { position: 'top-right' });</script>";
    unset($_SESSION['delpayment']);
}

?>


<?php require_once("./main_components/footer.php"); ?>