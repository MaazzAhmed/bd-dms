<?php $TITLE = "Refunds Payment"; ?>
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

    .dm .dmd {
        vertical-align: middle;
        font-size: 16px;
        color: white;
        font-weight: bold;
    }

  

    th  {
        white-space: nowrap; /* Prevent wrapping of text */
    }
    td  {
        white-space: nowrap; /* Prevent wrapping of text */
    }


</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- Include SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<!--wrapper-->

<div class="wrapper">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


    <!--sidebar wrapper -->

    <?php require_once("./main_components/sidebar.php"); ?>



    <!--end sidebar wrapper -->

    <!--start header -->


    <?php require_once("./main_components/navbar.php"); ?>


    <!--end header -->

    <?php
    if (isset($_SESSION['Createpayment'])) {
        echo "<script>alertify.success('{$_SESSION['Createpayment']}', { position: 'top-right' });</script>";
        unset($_SESSION['Createpayment']);
    }

    if (isset($_SESSION['payUpd'])) {
        echo "<script>alertify.success('{$_SESSION['payUpd']}', { position: 'top-right' });</script>";
        unset($_SESSION['payUpd']);
    }
    ?>

    <!--start page wrapper -->

    <div class="page-wrapper">

        <div class="page-content">



            <h6 class="mb-0 text-uppercase">Refund Orders</h6>

            <hr />




            <!-- <div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                aria-labelledby="filterModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="filterModalLabel">Apply Filters</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            

                            <div class="row">
                               

                                <div class="col-md-4 mb-3">
                                    <label for="brandname" class="form-label">Brand Name</label>
                                    <select id="brandname" class="form-select">
                                        <option disabled selected>Choose...</option>
                                        <?php
                                        $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'Admin';
                                        $userId = $_SESSION['id'] ?? null;

                                        if ($isAdmin) {
                                            $brands = getAllBrands($conn);
                                        } else {
                                            $brands = getAllowedDisplayBrandsForUser($conn, $userId);
                                        }
                                        if (isset($brands) && is_array($brands) && !empty($brands)) {
                                            foreach ($brands as $brand) {
                                                $brandName = $isAdmin ? $brand['brand_name'] : $brand['brandpermission'];
                                                echo "<option value='" . htmlspecialchars($brandName) . "'>" . htmlspecialchars($brandName) . "</option>";
                                            }
                                        } else {
                                            echo "<option disabled>No brands available</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                

                                <div class="col-md-4 mb-3">
                                    <label for="paymentStatus" class="form-label">Final Deadline Time</label>
                                    <input type="date" class="form-control" id="finaldeadlinetime">
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="paymentStatus" class="form-label">Order Confirmation Date</label>
                                    <input type="date" class="form-control" id="orderconfirmationdate">
                                </div>


                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Filter</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->




            <div class="row mb-4">

            <div class="col-md-4 mb-3">
                                    <label for="month" class="form-label">Month</label>
                                    <select class="form-select" id="month" name="month">
                                        <?php
                                        $currentMonth = date('F'); // Get the current month (e.g., "October")
                                        $months = [
                                            "January",
                                            "February",
                                            "March",
                                            "April",
                                            "May",
                                            "June",
                                            "July",
                                            "August",
                                            "September",
                                            "October",
                                            "November",
                                            "December"
                                        ];

                                        // Loop through months and set the current month as selected
                                        foreach ($months as $month) {
                                            $selected = ($month == $currentMonth) ? 'selected' : '';
                                            echo "<option value='$month' $selected>$month</option>";
                                        }
                                        ?>
                                    </select>

                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="dateTo" class="form-label">Year</label>
                                    <!-- <input type="date" class="form-control" id="dateTo"> -->
                                    <select class="form-select" name="year" id="dateTo">
                                        <?php
                                        $currentYear = date('Y'); // Get the current year
                                        for ($year = 2020; $year <= 2035; $year++) {
                                            $selected = ($year == $currentYear) ? 'selected' : '';
                                            echo "<option value='$year' $selected>$year</option>";
                                        }
                                        ?>
                                    </select>
                                </div>



                <div class="col-md-4">
                <label for="dateTo" class="form-label">Search</label>
                    <input type="text" class="form-control" id="ipFilter" placeholder="Enter Title, Order ID, Client Email,Client Name,Client C_No,  :">

                </div>
                <!-- <div class="col-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                        Open Filter Bar
                    </button>
                </div> -->
                <div class="col-2">
                    <button type="button" class="btn btn-warning" id="resetFiltersBtn">Reset Filters</button>

                </div>


                

            </div>


            <?php


            if (isset($_SESSION['CreateOrder'])) {
                echo "<script>alertify.success('{$_SESSION['CreateOrder']}', { position: 'top-right' });</script>";
                unset($_SESSION['CreateOrder']);
            }


            if (isset($_SESSION['eorder'])) {
                echo "<script>alertify.success('{$_SESSION['eorder']}', {position: 'top-right' });</script>";
                unset($_SESSION['eorder']);
            }

            if (isset($_SESSION['dorder'])) {
                echo "<script>alertify.success('{$_SESSION['dorder']}', {position: 'top-right' });</script>";
                unset($_SESSION['dorder']);
            }

            ?>

            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped table-bordered" id="analyticsDataTable">

                            <thead>

                                <tr>

                                    <th>ID</th>

                                    <th>Client Status</th>
                                    <th>Client Name</th>
                                    <th>Client Email</th>
                                    <th>Contact Number</th>
                                    <th>Refund Reason</th>
                                    <th>Refund Amount</th>
                                    <th>Refund Date</th>

                                    <th style="width: 150px !important;">Order Date</th> <!-- Adjusted Width -->
                                    <th>Order Id</th>
                                    <th>Order Title</th>
                                    <th>Order Status</th>
                                    <th>Word Count</th>
                                    <th>Lead Source</th>
                                    <th>Payment Status</th>
                                    <th>Pending Payment</th>
                                    <th>Receive Payment</th>
                                    <th>Total Amount</th>
                                    <th>Currency</th>
                                    <th>Brand Name</th>
                                    <!-- <th>Add</th> -->
                                    <th colspan="2" style="text-align: center;">View</th>
                                    <!-- <th>Email</th> -->
                                    <!-- <th>Edit</th> -->

                                    <?php if ($_SESSION['role'] == 'Admin') { ?>

                                        <!-- <th>Delete</th> -->

                                    <?php } ?>

                                    <!-- <th>View</th> -->

                                </tr>

                            </thead>

                            <tbody>
                                <tr>
                                </tr>
                            </tbody>



                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- Modal Box -->

<div class="modal fade" id="invoiceModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceModalLabel">Email Templates</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body" id="invoiceTableContainer">
                <p><span id="invoiceIdSpan"></span></p>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT file_name, brandname FROM email_setting ";
                        $stmt = $conn->prepare($query);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        $output = '';
                        if ($result->num_rows > 0) {
                            $counter = 1;
                            while ($row = $result->fetch_assoc()) {
                                $fileName = $row['file_name'];
                                $brandname = $row['brandname'];
                        ?>
                                <tr>
                                    <th scope="row"><?php echo $counter ?></th>
                                    <td><?php echo $brandname ?></td>
                                    <td><a href="<?php echo $fileName ?>" class="invoiceLink btn btn-success">Used this template</a></td>
                                </tr>
                        <?php
                                $counter++;
                            }
                        } else {
                            $output .= "<tr><td colspan='3'>No templates found for this brand.</td></tr>";
                        }
                        ?>

                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<!-- End Modal Box -->


<!--  -->
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
        if (!isDown) return; // Stop the function if not holding mouse
        e.preventDefault();
        const x = e.pageX - tableContainer.offsetLeft;
        const walk = (x - startX) * 2; // Scroll-fast multiplier
        tableContainer.scrollLeft = scrollLeft - walk;
    });
</script>

<!--  -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        let currentPage = 1;
        let recordsPerPage = 25;

        // Load analytics data initially
        loadAnalyticsData();

        // Monitor changes in filters
        $('#ipFilter, #orderStatus, #month, #dateTo, #leadsource, #currency, #creatorName, #orderconfirmationdate, #finaldeadlinetime, #brandname')
            .on('input change', function() {
                currentPage = 1; // Reset to first page when filters change
                updateActiveFilters();
                toggleResetButton();
                loadAnalyticsData();
            });

        // Reset filters on button click
        $('#resetFiltersBtn').on('click', function() {
            resetFilters();
            updateActiveFilters();
            toggleResetButton();
            loadAnalyticsData();
        });

        // Handle pagination click
        $(document).on('click', '.pagination-link', function(e) {
            e.preventDefault();
            currentPage = $(this).data('page'); // Update the current page
            loadAnalyticsData();
        });

        // Show or hide the reset button
        function toggleResetButton() {
            const hasActiveFilters = Object.values(getFilterValues()).some(
                value => value && value.trim() !== '' // Check if any filter is active
            );

            console.log('Has active filters:', hasActiveFilters); // Debugging

            if (hasActiveFilters) {
                $('#resetFiltersBtn').fadeIn(); // Show reset button
            } else {
                $('#resetFiltersBtn').fadeOut(); // Hide reset button
            }
        }

        // Reset all filters to default
        function resetFilters() {
            $('#ipFilter, #orderStatus, #month, #dateTo, #leadsource, #currency, #creatorName, #orderconfirmationdate, #finaldeadlinetime, #brandname').val('');
            currentPage = 1; // Reset to first page
        }

        // Get current filter values
        function getFilterValues() {
            return {
                ipFilter: $('#ipFilter').val(),
                orderStatus: $('#orderStatus').val(),
                month: $('#month').val(),
                year: $('#dateTo').val(),
                leadsource: $('#leadsource').val(),
                currency: $('#currency').val(),
                creatorName: $('#creatorName').val(),
                orderconfirmationdate: $('#orderconfirmationdate').val(),
                finaldeadlinetime: $('#finaldeadlinetime').val(),
                brandname: $('#brandname').val()
            };
        }

        // Update active filters display
        function updateActiveFilters() {
            const filterValues = getFilterValues();
            const activeFilters = [];

            for (const [key, value] of Object.entries(filterValues)) {
                if (value && value.trim() !== '') {
                    const formattedKey = formatFilterName(key);
                    activeFilters.push(`${formattedKey}: ${value}`);
                }
            }

            $('#filterList').empty(); // Clear previous filters

            if (activeFilters.length > 0) {
                $('#activeFilters').show(); // Show active filters section
                activeFilters.forEach(filter => {
                    $('#filterList').append('<li>' + filter + '</li>'); // Add each filter
                });
            } else {
                $('#activeFilters').hide(); // Hide section if no filters
            }
        }

        // Format filter names (e.g., 'orderStatus' to 'Order Status')
        function formatFilterName(name) {
            return name
                .replace(/([A-Z])/g, ' $1') // Add space before capital letters
                .replace(/^./, str => str.toUpperCase()); // Capitalize first letter
        }

        // Load analytics data via Ajax
        function loadAnalyticsData() {
            $.ajax({
                url: 'main_components/refunds-payments.php',
                type: 'POST',
                data: {
                    ...getFilterValues(),
                    currentPage,
                    recordsPerPage
                },
                success: function(response) {
                    $('#analyticsDataTable tbody').html(response); // Update table

                    const recordCount = $('#analyticsDataTable tbody tr').length;
                    $('#recordCountBadge').text(recordCount - 1); // Update record count badge
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', status, error);
                    alert('Error fetching data.');
                }
            });
        }
    });
</script>







<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php require_once("./main_components/footer.php"); ?>