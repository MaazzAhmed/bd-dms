<?php $TITLE = "Filter 1"; ?>

<?php require_once("./main_components/header.php"); ?>

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

                <div class="row mb-4 w-100">

                    <div class="col-md-6 ">
                        <!-- <input type="text" class="form-control" id="ipFilter" placeholder="Enter Status and Month"> -->
                        <select id="ipFilter" class="form-select">
                            <option value="">Select Status</option>
                            <option value="Follow up">Follow up</option>
                            <option value="Revision">Revision</option>
                            <option value="File not received">File not received</option>
                            <option value="Refund/Deadline">Refund/Deadline</option>
                            <option value="Half Payment">Half Payment</option>
                            <option value="Converted">Converted</option>
                            <option value="Delivered">Delivered</option>
                        </select>

                    </div>

                    <div class="col-md-6 ">
                        <select id="ipFilterMonth" class="form-select">

                            <option value="">Select Month</option>
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


                    <div class="col-4">

                        <button type="button" id="filterBtn" class="btn btn-light px-3 mt-2">Apply Filter</button>

                    </div>



                </div>

                <!-- <?php if ($_SESSION['role'] == 'Admin') { ?>

                <div class="row w-100">



                    <div class="col-md-8 ">



                        <input type="text" id="monthFilter" placeholder="Enter Month" class="form-control">

                    </div>



                    <div class="col-4">

                        <button type="button" id="sumAndConvertBtn" class="btn btn-light px-3">Total Amount</button>

                    </div>



                </div>

                <?php } ?> -->

            </div>







            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="analyticsDataTable" class="table table-striped table-bordered" style="width:100%">

                            <thead>

                                <tr>

                                    <th>ID</th>

                                    <th>Order Title</th>

                                    <th>Order Status</th>

                                    <th>Word Count</th>

                                    <th>Pending Payment</th>

                                    <th>Recieve Payment</th>

                                    <th>Currency</th>

                                    <th>Order Confirmation Date</th>

                                    <!-- <?php if ($_SESSION['role'] == 'Admin') { ?>

                                    <th>Converter</th>

                                    <?php } ?> -->

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



        $('#ipFilter, #ipFilterMonth, #startDate, #endDate').on('input', function() {

            currentPage = 1;

        });



        $('#filterBtn').on('click', function() {

            startDate = $('#startDate').val();

            ipFilterMonth = $('#ipFilterMonth').val();

            endDate = $('#endDate').val();

            loadAnalyticsData($('#ipFilter').val(), ipFilterMonth); // Pass selected month to loadAnalyticsData function

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

                    // Display the conversion result

                    alert(response); // You can modify this to update the UI as needed

                },

                error: function() {

                    alert('Error converting currency.');

                }

            });

        });



        // 

        $(document).on('click', '#sumAndConvertBtn', function() {

            var ipFilter = $('#ipFilter').val(); // Assuming ipFilter is the month value

            var monthFilter = $('#monthFilter').val(); // Get the value from the month input

            console.log('Clicked sumAndConvertBtn');



            // Call the function to sum and convert currency

            sumAndConvertCurrency(ipFilter, monthFilter);

        });




        function loadAnalyticsData(ipFilter, ipFilterMonth = '') {

            $.ajax({

                url: 'main_components/filter-data.php',

                type: 'POST',

                data: {

                    ipFilter: ipFilter,

                    ipFilterMonth: ipFilterMonth,

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



<?php require_once("./main_components/footer.php"); ?>