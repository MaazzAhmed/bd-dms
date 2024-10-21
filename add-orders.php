<?php $TITLE = "Add Order"; ?>

<?php

require_once("./main_components/header.php"); ?>

<!--wrapper-->

<div class="wrapper">

    <!--sidebar wrapper -->

    <?php require_once("./main_components/sidebar.php"); ?>



    <!--end sidebar wrapper -->

    <!--start header -->

    <?php require_once("./main_components/navbar.php"); ?>

    <?php 
    // if (isset($_POST['add_core_lead_id'])){

// $leadid = $_POST['l_id'];
// $query = "SELECT * from core_leads where id = $leadid";
// $result = mysqli_query($conn, $query);

// $row = mysqli_fetch_assoc($result); ?>



     

                                <!-- <form method="post" class="row g-3">

                                    <input type="hidden" name="leadid" id="leadid" value="<?php echo $leadid ?>" required><br>



                                   <input type="text" value="<?php echo $row['campId'] ?>" name="campId">
                                   <input type="text" value="<?php echo $row['client_name'] ?>" name="client_name">
                                   <input type="text" value="<?php echo $row['client_contact_number'] ?>" name="client_contact_number">
                                   <input type="text" value="<?php echo $row['lead_landing_date'] ?>" name="landing_date">
                                   <input type="text" value="<?php echo $row['client_country'] ?>" name="client_country">
                                   <input type="text" value="<?php echo $row['client_email'] ?>" name="client_email">
                                   <input type="text" value="<?php echo $row['client_info'] ?>" name="client_info">
                                   <input type="text" value="<?php echo $row['lead_source'] ?>" name="lsource">
                                   <input type="text" value="<?php echo $row['brand_name'] ?>" name="brandname">
                                   <input type="text" value="<?php echo $row['whatsapp_name'] ?>" name="whatsappname">
                                   <input type="text" value="<?php echo $row['refer_client_name'] ?>" name="clientName">
                                   
                                    <input type="hidden" name="user_id" value="<?php echo $_SESSION['id'] ?>" class="form-control">

                                    <input type="hidden" name="creator_name" value="<?php echo $_SESSION['user'] ?>" class="form-control" id="inputId">





                                    <div class="col-12 text-center">

                                        <button type="submit" name="create-corelead-order" class="btn btn-light px-5">Create
                                            order</button>

                                    </div>

                                </form>

                            </div>

                        </div>

 -->





                    <?php 
                //     require_once("./main_components/footer.php");
                // } else {
                //     echo "<script>window.location.href='view-core-leads'</script>" . mysqli_error($conn);
                // }

                    ?>