<?php



$TITLE = "View Payments"; ?>

<?php require_once("./main_components/header.php");





if (
    !isset($_SESSION['role']) ||
    ($_SESSION['role'] !== 'Admin' &&
        $userPermissions['view_core_lead'] !== 'Allow' &&
        $userPermissions['add_core_lead'] !== 'Allow')
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
                                <tr>
                                   
                                    <td><?php echo htmlspecialchars($payment['pending_payment']); ?></td>
                                    <td><?php echo htmlspecialchars($payment['receive_payment']); ?></td>
                                    <td><?php echo htmlspecialchars($payment['month']); ?></td>
                                    <td><?php echo htmlspecialchars($payment['currency']); ?></td>
                                    <td><?php echo htmlspecialchars(date('d-m-Y', strtotime($payment['payment_date']))); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No payment records found for this order.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                    </div>
                </div>
            </div>





          
            <script>
                const tableContainer = document.querySelector('.table-responsive');

                let isDown = false;
                let startX;
                let scrollLeft;

                tableContainer.addEventListener('mousedown', (e) => {
                    isDown = true;
                    tableContainer.classList.add('active');
                    startX = e.pageX - tableContainer.offsetLeft;
                    scrollLeft = tableContainer.scrollLeft;
                });

                tableContainer.addEventListener('mouseleave', () => {
                    isDown = false;
                    tableContainer.classList.remove('active');
                });

                tableContainer.addEventListener('mouseup', () => {
                    isDown = false;
                    tableContainer.classList.remove('active');
                });

                tableContainer.addEventListener('mousemove', (e) => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - tableContainer.offsetLeft;
                    const walk = (x - startX) * 2;
                    tableContainer.scrollLeft = scrollLeft - walk;
                });
            </script>

            <?php require_once("./main_components/footer.php"); ?>