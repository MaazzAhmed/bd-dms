<?php $TITLE = "Email Template 1"; ?>

<?php require_once("./main_components/header.php"); ?>

<!-- Include Summernote CSS -->

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css">



<!-- Include jQuery, Popper.js, and Bootstrap JS -->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>



<!-- Include Summernote JS -->

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>


<!--wrapper-->

<div class="wrapper">

    <!--sidebar wrapper -->

    <?php require_once("./main_components/sidebar.php"); ?>



    <!--end sidebar wrapper -->

    <!--start header -->

    <?php require_once("./main_components/navbar.php");



    // Retrieve the invoice ID from the URL
    $emailid = $_GET['emailid'];
    // Use the invoice ID as needed
    // echo "Client Email: " . $emailid;
    $emailid = isset($_GET['emailid']) ? $_GET['emailid'] : '';
    // Query to fetch client_email

    $result = mysqli_query($conn, "SELECT client_email FROM leads WHERE id = $emailid");

    // Check if the query was successful and if there are rows in the result set

    if ($result && mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        $clientEmail = $row['client_email'];
    } else {


        $clientEmail = ''; // or set a default value

    }
    $results = mysqli_query($conn, "SELECT description FROM email_setting where id=1");

    if ($results && mysqli_num_rows($results) > 0) {

        $row = mysqli_fetch_assoc($results);

        $emailDesc = $row['description'];
    }

    ?>



    <!--end header -->

    <?php
    // Check if session message is set
    if (isset($_SESSION['email1'])) {
        // Display the message using Alertify with position at top right

        echo "<script>alertify.success('{$_SESSION['email1']}', { position: 'top-right' });</script>";

        // Unset the session variable to remove it after displaying the message
        unset($_SESSION['email1']);
    }
    ?>
    <!--start page wrapper -->

    <div class="page-wrapper">

        <div class="page-content">


            <div class="row">

                <div class="col-xl-7 mx-auto">

                    <!-- <h6 class="mb-0 text-uppercase"></h6> -->

                    <hr />

                    <div class="card border-top border-0 border-4 border-white">

                        <div class="card-body p-5">

                            <div class="card-title d-flex align-items-center">

                                <div><i class="bx bxs-user me-1 font-22 text-white"></i>

                                </div>

                                <h5 class="mb-0 text-white">Template 1</h5>

                            </div>

                            <hr>

                            <form method="post" enctype="multipart/form-data" class="row g-3">

                                <div class="col-md-6">

                                    <label for="inputFirstName" class="form-label">Main Title</label>

                                    <input type="text" name="main_title" class="form-control" required id="inputFirstName">

                                </div>

                                <div class="col-md-6">

                                    <label for="inputEmail" class="form-label">Subject</label>

                                    <input type="text" class="form-control" name="subject" required id="inputEmail">

                                </div>

                                <div class="col-md-12">

                                    <textarea class="form-control" name="message" id="textsss" rows="2" required><?php echo $row['description'] ?></textarea>

                                </div>



                                <div class="col-md-6">
                                    <label for="inputEmail" class="form-label">Email</label>
                                    <select class="single-select form-control" name="employee[]" multiple="multiple" data-placeholder="Choose Email" required>
                                        <option selected value="<?php echo $clientEmail ?>"><?php echo $clientEmail ?></option>
                                    </select>
                                    <input type="text" class="form-control" id="newEmail" placeholder="Enter Email Optional" />
                                </div>





                                <div class="col-md-6">

                                    <label for="inputEmail" class="form-label">Upload File</label>

                                    <input type="file" name="attachment[]" multiple class="form-control" id="inputEmail">

                                </div>

                                <div class="col-12 text-center">

                                    <button type="submit" name="submit" class="btn btn-light px-5">Send Email</button>

                                </div>

                            </form>

                        </div>

                    </div>

                    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

                    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>





                    <script src="summernote"></script>

                    <script>
                        var $j = jQuery.noConflict();

                        $j(document).ready(function() {

                            $j('#textsss').summernote({

                                height: 200,



                            });

                        });
                    </script>





                    <?php require_once("./main_components/footer.php"); ?>