<?php  $TITLE = "Edit Payment Accounts"; ?> 

<?php require_once("./main_components/header.php");?>

	<!--wrapper-->

	<div class="wrapper">

		<!--sidebar wrapper -->

		<?php require_once("./main_components/sidebar.php");?>



		<!--end sidebar wrapper -->

		<!--start header -->

		<?php require_once("./main_components/navbar.php");?>



		<!--end header -->

		<!--start page wrapper -->

		<div class="page-wrapper">

			<div class="page-content">

				<!--breadcrumb-->

				

				<!--end breadcrumb-->

				<div class="row">

					<div class="col-xl-10 mx-auto">

						<!-- <h6 class="mb-0 text-uppercase">Basic Form</h6> -->

						<hr/>

        <div class="card border-top border-0 border-4 border-white">

            <div class="card-body p-5">

                <div class="card-title d-flex align-items-center">

                    <div><i class="bx bxs-user me-1 font-22 text-white"></i>

                    </div>

                    <h5 class="mb-0 text-white">Edit bank</h5>

                </div>

                <hr>

                <form method="post"  class="row g-3">
<?php 
if (isset($_POST['edit_payments'])) {
    $id = $_POST['payment_id'];
    // Fetch the record based on ID
    $sql = "SELECT id, account_name FROM bank_accounts WHERE id='$id'";

    $resultedit_payments = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $resultedit_payments->fetch_assoc();
?>


                        <div class="col-md-6">

                        <label for="inputFirstName" class="form-label">Bank Name</label>
                        <input type="text" class="form-control"  name="account_name" value="<?php echo $row['account_name']; ?>"><br>
                    
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                    </div>

         <?php       } else {
                    echo "Record not found";
                }
            } else {
                echo "Invalid request";
            }
            ?>
                    <div class="col-12 ">

                        <button type="submit" name="edit-payment-account" class="btn btn-light px-5">Edit</button>

                    </div>
                

                </form>

            </div>

        </div>





<!-- Add this modal code at the end of your HTML body -->

<div class="modal fade" id="notificationModalC" tabindex="-1" role="dialog" aria-labelledby="notificationModalLabel" aria-hidden="true">

    <div class="modal-dialog" role="document">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title" id="notificationModalLabel">Notification</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true">&times;</span>

                </button>

            </div>

            <div class="modal-body">

                <?php echo $_SESSION['Createbank']?? $_SESSION['CreatebankError']; ?>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

            </div>

        </div>

    </div>

</div>





<?php require_once("./main_components/footer.php");?>