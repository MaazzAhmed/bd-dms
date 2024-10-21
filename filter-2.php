<?php  $TITLE = "Filter 2"; ?> 

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

            

           

            <hr />

            <div class="row mb-4">



                <div class="col-md-4 ">

                    <label for="inputEmail" class="form-label">Order ID</label>

                    <input type="text" class="form-control" id="ipFilter" placeholder="Enter Order Id">

                </div>



                <div class="col-md-4 ">

                    <label for="inputEmail" class="form-label">Month</label>

                    <select id="month" class="form-select">

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





                <div class="col-md-4 ">
                <label for="inputEmail" class="form-label">Client Emails</label>

                <?php
$result = mysqli_query($conn, "SELECT client_email FROM leads");
$emails = mysqli_fetch_all($result, MYSQLI_ASSOC);
if ($emails) {
?>
<select id="client_email" class="form-select">
    <?php foreach ($emails as $email) { ?>
        <option value="<?php echo $email['client_email']?>"><?php echo $email['client_email']?></option>
    <?php } ?>
</select>
<?php } ?>

                </div>



                <div class="col-12 text-center mt-2">

                    <button type="button" id="filterBtn" class="btn btn-light px-5">Apply Filter</button>

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

                                <th>Order Id</th>

                                <th>LFC/Camp Id</th>

                                <th>Order Title</th>

                                <th>Client Email</th>

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

        var month = '';

        var client_email = '';



        loadAnalyticsData();



        $('#ipFilter, #month, #client_email').on('input', function() {

            currentPage = 1;

        });



        $('#filterBtn').on('click', function() {

            month = $('#month').val();

            client_email = $('#client_email').val();

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

                url: 'main_components/filter-data2.php',

                type: 'POST',

                data: {

                    ipFilter: ipFilter,

                    month: month,

                    client_email: client_email,

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



<?php require_once("./main_components/footer.php");?>