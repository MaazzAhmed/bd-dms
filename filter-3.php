<?php $TITLE = "Filter 3"; ?>

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





            <hr />

            <div class="row mb-4">



                <div class="col-md-6">

                    <input type="text" class="form-control" id="ipFilter" placeholder="Enter Status, Month & Client Name:">

                </div>





                <div class="col-md-6">

                    <input type="text" class="form-control" id="secondfilter" placeholder="Enter  Month, LFC, Status, Client Number:">

                </div>



                <div class="col-12 text-center mt-2">

                    <button type="button" class="btn btn-light px-5" id="filterBtn">Apply Filter</button>

                </div>



            </div>

            <hr>

        </div>

        <div class="card">

            <div class="card-body">

                <div class="table-responsive">

                    <table id="analyticsDataTable" class="table table-striped table-bordered" style="width:100%">

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>LFC/Camp Id</th>

                                <th>Order Id</th>



                                <th>Order Title</th>

                                <th>Client Name</th>

                                <th>Client Contact Number</th>

                                <th>Order Confirmation Date</th>

                                <th>Order Status</th>

                                <th>Action</th>



                            </tr>

                        </thead>

                        <tbody>









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

        var secondfilter = '';

        var endDate = '';



        loadAnalyticsData();



        $('#ipFilter, #secondfilter, #endDate').on('input', function() {

            currentPage = 1;

        });



        $('#filterBtn').on('click', function() {

            secondfilter = $('#secondfilter').val();

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



        function loadAnalyticsData(ipFilter = '') {

            $.ajax({

                url: 'main_components/filter-data3.php',

                type: 'POST',

                data: {

                    ipFilter: ipFilter,

                    secondfilter: secondfilter,

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