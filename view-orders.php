<?php $TITLE = "View Orders"; ?>
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
    overflow: hidden; /* Hide scroll initially */
    cursor: grab; /* Change cursor to grab when hovering */
}
.table-responsive:active {
    cursor: grabbing; /* Change cursor when active (dragging) */
}

</style>

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



    <!--start page wrapper -->

    <div class="page-wrapper">

        <div class="page-content">



            <h6 class="mb-0 text-uppercase">Orders</h6>

            <hr />




            <div class="modal fade" id="filterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
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
                                    <label for="orderStatus" class="form-label">Order Status</label>
                                    <select class="form-select" id="orderStatus">
                                        <option disabled selected>Select Status</option>
                                        <option value="Revision">Revision</option>
                                        <option value="Converted">Converted</option>
                                        <option value="Delivered">Delivered</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="paymentStatus" class="form-label">Order Creater Name</label>
                                    <input type="text" class="form-control" id="creatorName">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="leadsource" class="form-label">Lead Source</label>
                                    <select id="leadsource" class="form-select">
                                        <option disabled selected>Choose....</option>
                                        <?php
                                        // Display roles in dropdown
                                        $leadsource = getLeadSource($conn);
                                        foreach ($leadsource as $leadsources) {
                                            echo "<option value='" . $leadsources['source'] . "'>" . $leadsources['source'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <!-- <select class="form-control" id="paymentStatus"> -->

                            <div class="row">
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
                                
                                <div class="col-md-4 mb-3">
                                    <label for="currency" class="form-label">Currency</label>
                                    <select name="currency" class="form-select" placeholder="Currency" id="currency">

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
                            </div>

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
            </div>




            <div class="row mb-4">



                <div class="col-md-8">

                    <input type="text" class="form-control" id="ipFilter" placeholder="Enter Title, Order ID, Client Email,Client Name,Client C_No,  :">

                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                        Open Filter Bar
                    </button>
                </div>
                <div class="col-2">
                    <button type="button" class="btn btn-warning" id="resetFiltersBtn">Reset Filters</button>

                </div>

                
                <div id="activeFilters" style="display: none;">
    <h4>Active Filters:</h4>
    <ul id="filterList"></ul>
<!-- </div><span id="recordCountBadge"></span> -->


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
                                <th>Order Date</th>
                                <th>Portal's Due Deadline</th>
                                <th>Final DeadLine/ Time</th>
                                <th>Order Id</th>
                                <th>Order Title</th>
                                <th>Order Status</th>
                                <th>Word Count</th>
                                <th>Lead Source</th>
                                <th>Payment Status</th>
                                <th>Pending Payment</th>
                                <th>Receive Payment</th>
                                <th>Currency</th>
                                <th>Email</th>
                                <th>Edit</th>

                                <?php if ($_SESSION['role'] == 'Admin') { ?>

                                    <th>Delete</th>

                                <?php } ?>

                                <th>View</th>

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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
    $(document).ready(function () {
    let currentPage = 1;
    let recordsPerPage = 25;

    // Load analytics data initially
    loadAnalyticsData();

    // Monitor changes in filters
    $('#ipFilter, #orderStatus, #month, #dateTo, #leadsource, #currency, #creatorName, #orderconfirmationdate, #finaldeadlinetime, #brandname')
        .on('input change', function () {
            currentPage = 1;  // Reset to first page when filters change
            updateActiveFilters();
            toggleResetButton();
            loadAnalyticsData();
        });

    // Reset filters on button click
    $('#resetFiltersBtn').on('click', function () {
        resetFilters();
        updateActiveFilters();
        toggleResetButton();
        loadAnalyticsData();
    });

    // Handle pagination click
    $(document).on('click', '.pagination-link', function (e) {
        e.preventDefault();
        currentPage = $(this).data('page');  // Update the current page
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
            url: 'main_components/view-orders.php',
            type: 'POST',
            data: {
                ...getFilterValues(),
                currentPage,
                recordsPerPage
            },
            success: function (response) {
                $('#analyticsDataTable tbody').html(response); // Update table

                const recordCount = $('#analyticsDataTable tbody tr').length;
                $('#recordCountBadge').text(recordCount - 1); // Update record count badge
            },
            error: function (xhr, status, error) {
                console.error('Error fetching data:', status, error);
                alert('Error fetching data.');
            }
        });
    }
});

</script>

<script>
//   $(document).ready(function () {
//     let currentPage = 1;
//     let recordsPerPage = 25;

//     // Load analytics data initially
//     loadAnalyticsData();

//     // Monitor changes in filters
//     $('#ipFilter, #orderStatus, #month, #dateTo, #leadsource, #currency, #creatorName, #orderconfirmationdate, #finaldeadlinetime, #brandname')
//         .on('input change', function () {
//             updateActiveFilters();   // Update active filters list
//             toggleResetButton();     // Check and toggle reset button
//             loadAnalyticsData();     // Reload data with filters
//         });

//     // Reset filters on button click
//     $('#resetFiltersBtn').on('click', function () {
//         resetFilters(); // Clear all filters
//         updateActiveFilters(); // Update active filters list
//         toggleResetButton();  // Hide reset button if no filters
//         loadAnalyticsData();  // Reload data without filters
//     });

//     // Show or hide the reset button based on filter values
//     function toggleResetButton() {
//         const hasActiveFilters = Object.values(getFilterValues()).some(
//             value => value && value.trim() !== ''  // Check if any filter has value
//         );

//         console.log('Has active filters:', hasActiveFilters); // Debugging output

//         if (hasActiveFilters) {
//             $('#resetFiltersBtn').fadeIn();  // Show reset button
//         } else {
//             $('#resetFiltersBtn').fadeOut(); // Hide reset button
//         }
//     }

//     // Reset all filters to default values
//     function resetFilters() {
//         $('#ipFilter, #orderStatus, #month, #dateTo, #leadsource, #currency, #creatorName, #orderconfirmationdate, #finaldeadlinetime, #brandname').val('');
//         currentPage = 1; // Reset to first page
//     }

//     // Get current filter values
//     function getFilterValues() {
//         return {
//             ipFilter: $('#ipFilter').val(),
//             orderStatus: $('#orderStatus').val(),
//             month: $('#month').val(),
//             dateTo: $('#dateTo').val(),
//             leadsource: $('#leadsource').val(),
//             currency: $('#currency').val(),
//             creatorName: $('#creatorName').val(),
//             orderconfirmationdate: $('#orderconfirmationdate').val(),
//             finaldeadlinetime: $('#finaldeadlinetime').val(),
//             brandname: $('#brandname').val()
//         };
//     }

//     // Update active filters display
//     function updateActiveFilters() {
//         const filterValues = getFilterValues();
//         const activeFilters = [];

//         for (const [key, value] of Object.entries(filterValues)) {
//             if (value && value.trim() !== '') {  // Safely check for non-empty values
//                 const formattedKey = formatFilterName(key);
//                 activeFilters.push(`${formattedKey}: ${value}`);
//             }
//         }

//         $('#filterList').empty(); // Clear previous filters

//         if (activeFilters.length > 0) {
//             $('#activeFilters').show(); // Show active filters section
//             activeFilters.forEach(filter => {
//                 $('#filterList').append('<li>' + filter + '</li>'); // Add each filter
//             });
//         } else {
//             $('#activeFilters').hide(); // Hide section if no active filters
//         }
//     }

//     // Format filter names (e.g., 'orderStatus' to 'Order Status')
//     function formatFilterName(name) {
//         return name
//             .replace(/([A-Z])/g, ' $1') // Add space before capital letters
//             .replace(/^./, str => str.toUpperCase()); // Capitalize the first letter
//     }

//     // Load analytics data via Ajax
//     function loadAnalyticsData() {
//         $.ajax({
//             url: 'main_components/view-orders.php',
//             type: 'POST',
//             data: {
//                 ...getFilterValues(), // Send filter values as data
//                 currentPage,
//                 recordsPerPage
//             },
//             success: function (response) {
//                 $('#analyticsDataTable tbody').html(response); // Update table

//                 const recordCount = $('#analyticsDataTable tbody tr').length;
//                 $('#recordCountBadge').text(recordCount - 1); // Update record count badge
//             },
//             error: function (xhr, status, error) {
//                 console.error('Error fetching data:', status, error);
//                 alert('Error fetching data.');
//             }
//         });
//     }
// });




</script>

<!-- <script>
    $(document).ready(function() {
        let currentPage = 1;
        let recordsPerPage = 25;
        let ipFilter = '';
        let orderStatus = '';

        let month = '';
        let year = '';
        let leadsource = '';
        let currency = '';
        let creatorName = '';
        let orderconfirmationdate = '';
        let finaldeadlinetime = '';
        let brandname = '';
        
        
        // Load initial analytics data
        loadAnalyticsData();

        // Automatically apply filters on input change
        $('#ipFilter, #orderStatus, #month, #dateTo, #leadsource, #currency, #creatorName, #orderconfirmationdate, #finaldeadlinetime, #brandname ').on('input change', function() {
            updateFilters();
            loadAnalyticsData();
        });

        // Reset filters on button click
        $('#resetFiltersBtn').on('click', function() {
            resetFilters();
            loadAnalyticsData();
        });

        // Handle pagination click events
        $(document).on('click', '.pagination-link', function() {
            currentPage = $(this).data('page');
            loadAnalyticsData();
        });

        // Update filter values
        function updateFilters() {
            ipFilter = $('#ipFilter').val();
            orderStatus = $('#orderStatus').val();
             month = $('#month').val();
             year = $('#dateTo').val();
             leadsource = $('#leadsource').val();
             currency = $('#currency').val();
             creatorName = $('#creatorName').val();
             orderconfirmationdate = $('#orderconfirmationdate').val();
             finaldeadlinetime = $('#finaldeadlinetime').val();
             brandname = $('#brandname').val();
            
            
            currentPage = 1; // Reset to the first page when filters change
        }

        // Reset all filter inputs
        function resetFilters() {
            $('#ipFilter, #orderStatus, #month, #dateTo, #leadsource, #currency, #creatorName, #orderconfirmationdate, #finaldeadlinetime, #brandname ').val('');
            ipFilter = orderStatus = month = year = leadsource = currency = creatorName = orderconfirmationdate = finaldeadlinetime = brandname = ''; // Clear variables
            currentPage = 1; // Reset page to 1
        }

        // Main function to load data via AJAX
        function loadAnalyticsData() {
            console.log('Fetching data with filters:', {
                ipFilter,
                orderStatus,
                month: month,
                     year,
                     leadsource,
                     currency,
                     creatorName,
                     orderconfirmationdate,
                     finaldeadlinetime,
                     brandname,
               
                currentPage,
                recordsPerPage,
            });

            $.ajax({
                url: 'main_components/view-orders.php',
                type: 'POST',
                data: {
                    ipFilter: ipFilter,
                    orderStatus: orderStatus,

                    month: month,
                    year: year,
                    leadsource: leadsource,
                    currency: currency,
                    creatorName: creatorName,
                    orderconfirmationdate: orderconfirmationdate,
                    finaldeadlinetime: finaldeadlinetime,
                    brandname: brandname,

                    currentPage: currentPage,
                    recordsPerPage: recordsPerPage,
                },
                success: function(response) {
                    console.log('Data fetched successfully:', response);
                    $('#analyticsDataTable tbody').html(response);

                    const recordCount = $('#analyticsDataTable tbody tr').length;
                    console.log('Number of rows:', recordCount);
                    $('#recordCountBadge').text(recordCount - 1);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', status, error);
                    alert('Error fetching data.');
                },
            });
        }
    });
</script> -->

<!-- Include jQuery before this script -->
<script>
    $(document).ready(function() {
        $(document).on('click', '.open-invoice', function(e) {
            e.preventDefault(); // Prevent the default action of the link
            var invoiceId = $(this).data('invoice-id');


            $('.invoiceLink').each(function() {
                var link = $(this);
                var templateName = link.attr('href');
                var linkHref = templateName + '?emailid=' + invoiceId;
                link.attr('href', linkHref);
            });
            $('#invoiceModal').modal('show');

        });
    });
</script>



<script>
    $(document).ready(function() {

        <?php

        if (isset($_SESSION['CreateOrder']) || isset($_SESSION['CreateteamError'])) {

            echo "$('#notificationModalC').modal('show');";

            unset($_SESSION['CreateOrder']);

            unset($_SESSION['CreateteamError']);
        }

        ?>
    });
</script>
<script>
    function confirmKeyAndDeleteOrder(orderId) {
        Swal.fire({
            title: 'Enter Deletion Key',
            input: 'text',
            inputLabel: 'Please enter the key to confirm order deletion',
            inputPlaceholder: 'Enter your key here',
            showCancelButton: true,
            confirmButtonText: 'Confirm',
            preConfirm: (inputKey) => {
                if (!inputKey) {
                    Swal.showValidationMessage('Key is required!');
                    return false;
                } else {
                    return inputKey;
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const inputKey = result.value;
                const formData = new FormData(document.getElementById('deleteOrderForm_' + orderId));
                formData.append('inputKey', inputKey);
                formData.append('action', 'delete_order');

                $.ajax({
                    url: 'main_components/global.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire('Deleted!', response.message, 'success');
                            setTimeout(() => {
                                Swal.close(); // Close the alert
                                location.reload(); // Reload the page after closing the alert
                            }, 5000); // 5000 milliseconds = 5 seconds
                        } else {
                            Swal.fire('Error!', response.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error!', 'An error occurred during the deletion process.', 'error');
                    }
                });
            }
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php require_once("./main_components/footer.php"); ?>