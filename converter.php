<?php $TITLE = "Converter"; ?>
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



            <div class="d-flex justify-space-between">



                <?php if ($_SESSION['role'] == 'Admin') { ?>

                    <div class="row w-75">
                        <div class="col-md-4">
                            <select id="monthFilter" class="form-select">
                                <!-- Month options will be dynamically selected using JavaScript -->
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <select id="yearFilter" name="yearFilter" class="form-select">
                                <!-- Year options will be dynamically selected using JavaScript -->
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
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="sumAndConvertBtn" class="btn btn-light px-3 w-100">Month Converter</button>
                        </div>

                        <!-- <div class="col-6">
                            <button type="button" id="sumAndConvertBtn" class="btn btn-light px-3 mt-2">Month Converter</button>
                        </div> -->
                    </div>

                <?php } ?>

            </div>

            <br>
            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="analyticsDataTable" class="table table-striped table-bordered" style="width:100%">

                            <thead>

                                <tr>

                                    <th>ID</th>

                                    <th>CLient Name</th>
                                    <th>Client Email</th>
                                    <th>Order Title</th>

                                    <th>Order Status</th>

                                    <th>Word Count</th>

                                    <th>Pending Payment</th>

                                    <th>Recieve Payment</th>

                                    <th>Currency</th>

                                    <th>Order Confirmation Date</th>

                                    <?php if ($_SESSION['role'] == 'Admin') { ?>

                                        <th>Converter</th>

                                    <?php } ?>

                                    <th>Action</th>

                                </tr>

                            </thead>

                            <tbody>

                                <!-- Display data using AJAX -->



                            </tbody>





                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $(document).ready(function() {
        var currentPage = 1;
        var recordsPerPage = 10;
        var startDate = '';
        var endDate = '';

        loadAnalyticsData();
        $('#ipFilter, #startDate, #endDate').on('input', function() {
            currentPage = 1;
        });
        $('#filterBtn').on('click', function() {
            startDate = $('#startDate').val();
            endDate = $('#endDate').val();
            loadAnalyticsData($('#ipFilter').val());
        });
        // Set up AJAX poll every 10 seconds
        setInterval(function() {
            loadAnalyticsData($('#ipFilter').val());
        }, 10000);
        $(document).on('click', '.pagination-link', function() {
            currentPage = $(this).data('page');
            loadAnalyticsData($('#ipFilter').val());
        });
        // Add the following code to handle the currency conversion
        $(document).on('click', '.convertButton', function() {
            var receivePayment = $(this).data('receive-payment');
            var currency = $(this).data('currency');
            // Call the API
            $.ajax({
                url: 'main_components/currency-api.php',
                type: 'POST',
                data: {
                    receivePayment: receivePayment,
                    currency: currency
                },
                success: function(response) {
                    Swal.fire({
                        title: 'Currency Conversion Success',
                        html: `<p>Converted Amount: ${response}</p>`,
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#3085d6'
                    });

                },
                error: function() {
                    Swal.fire({
                        title: 'Error',
                        text: 'Error converting currency.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d33'
                    });
                }
            });
        });

        // 

        // Total Month Received Currency

        $(document).on('click', '#sumAndConvertBtn', function() {

            var ipFilter = $('#ipFilter').val(); // Assuming ipFilter is the month value

            var monthFilter = $('#monthFilter').val(); // Get the value from the month input

            var yearFilter = $('#yearFilter').val(); // Get the value from the year input

            console.log('Clicked sumAndConvertBtn');



            // Call the function to sum and convert currency

            sumAndConvertCurrency(ipFilter, monthFilter, yearFilter);

        });



        // TOtal PEnding MOnth Currency
        $(document).on('click', '#sumAndConvertBtn', function() {
            var ipFilter = $('#ipFilter').val(); // Assuming ipFilter is some filter value
            var monthFilter = $('#monthFilter').val(); // Get the value from the month input
            var yearFilter = $('#yearFilter').val(); // Get the value from the year input

            console.log('Clicked sumAndConvertBtn');

            sumAndConvertCurrency(ipFilter, monthFilter, yearFilter);
        });

        function sumAndConvertCurrency(ipFilter, monthFilter, yearFilter) {
            console.log('Inside sumAndConvertCurrency function');

            $.ajax({
                url: 'main_components/totalmonthcurrency.php',
                type: 'POST',
                data: {
                    ipFilter: ipFilter,
                    month: monthFilter,
                    year: yearFilter
                },
                success: function(response) {
                    console.log('Currency conversion success:', response);

                    // Parse the JSON response
                    var data = JSON.parse(response);

                    // Display the result for both received and pending payments
                    displayCombinedConversionResult(data);
                },
                error: function(xhr, status, error) {
                    console.log('Currency conversion error:', status, error);
                    alert('Error summing and converting currency.');
                }
            });
        }

        function displayCombinedConversionResult(data) {
            var conversionResultTable = $('#conversionResultTable tbody');
            conversionResultTable.empty();

            var totalReceivedSum = 0;
            var totalPendingSum = 0;

            data.forEach(function(entry) {
                var row = '<tr>';
                row += '<td>' + entry.currency + '</td>';
                row += '<td>' + entry.received_amount + '</td>';
                row += '<td>' + entry.pending_amount + '</td>';
                row += '<td>' + entry.converted_received + '</td>';
                row += '<td>' + entry.converted_pending + '</td>';
                row += '</tr>';
                conversionResultTable.append(row);

                // Add the amounts to total sums
                totalReceivedSum += parseFloat(entry.converted_received);
                totalPendingSum += parseFloat(entry.converted_pending);
            });

            Swal.fire({
                title: 'Total Converted Amounts',
                html: `
            <p><strong>Total Received Amount:</strong> ${totalReceivedSum.toFixed(2)}</p>
            <p><strong>Total Pending Amount:</strong> ${totalPendingSum.toFixed(2)}</p>
        `,
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            });
        }
        // TOtal PEnding MOnth Currency





        function loadAnalyticsData(ipFilter = '') {
            $.ajax({
                url: 'main_components/converter.php',
                type: 'POST',
                data: {
                    ipFilter: ipFilter,
                    startDate: startDate,
                    endDate: endDate,
                    currentPage: currentPage,
                    recordsPerPage: recordsPerPage
                },
                success: function(response) {
                    $('#analyticsDataTable tbody').html(response);
                    // Update the record count badge
                    var recordCount = $('#analyticsDataTable tbody tr').length;
                    console.log('Number of rows:', recordCount);
                    $('#recordCountBadge').text(recordCount - 1);
                },
                error: function() {
                    alert('Error fetching data.');
                }
            });
        }
    });
</script>
<!-- Current MOnth & Yeear For Drop Down -->
<script>
    $(document).ready(function () {
        // Get current month and year
        var currentMonth = new Date().toLocaleString('default', { month: 'long' });
        var currentYear = new Date().getFullYear();

        // Set the current month and year as selected by default
        $('#monthFilter').val(currentMonth);
        $('#yearFilter').val(currentYear);
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php require_once("./main_components/footer.php"); ?>