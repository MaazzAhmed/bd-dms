<?php $TITLE = "View Teams"; ?>

<?php require_once("./main_components/header.php"); 



if (!isset($_SESSION['role']) || 
    ($_SESSION['role'] !== 'Admin' && 
    $userPermissions['view_team'] !== 'Allow')) {
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



            <h6 class="mb-0 text-uppercase">Teams</h6>

            <hr />

            <div class="card">

                <div class="card-body">

                    <div class="table-responsive">

                        <table id="example" class="table table-striped table-bordered" style="width:100%">

                            <thead>

                                <tr>

                                    <th>Team ID</th>

                                    <th>Team Name</th>

                                    <th>Team Lead</th>
                                    <?php
                                    if ($_SESSION['role'] == 'Admin') {

                                    ?>

                                        <th>Edit</th>

                                        <th>Delete</th>
                                    <?php } ?>

                                </tr>

                            </thead>

                            <tbody>





                                <?php

                                $teams = getTeamsRecords($conn);



                                foreach ($teams as $team) : ?>

                                    <tr>

                                        <td><?php echo $team['teamId']; ?></td>

                                        <td><?php echo $team['team_name']; ?></td>

                                        <td><?php echo $team['team_lead_name']; ?></td>
                                        <?php
                                        if ($_SESSION['role'] == 'Admin') {

                                        ?>

                                            <form method='post' action='edit-team'>

                                                <input type='hidden' name='team_id' value='<?php echo $team['teamId']; ?>'>

                                                <td>

                                                    <button type="submit" name='edit_team' class="bg-secondary text-white px-3 rounded-pill">

                                                        <div class="col" tabindex="6">

                                                            <div class="d-flex bg-secondary align-items-center theme-icons shadow-sm cursor-pointer rounded-pill">

                                                                <div class="text-white"><i class="fadeIn animated bx bx-pencil" style="font-size:17px;"></i>

                                                                </div>

                                                                <div class="ms-2">Edit</div>

                                                            </div>

                                                        </div>

                                                    </button>

                                                </td>

                                            </form>

                                            <td>

                                                <form method="post" onsubmit="return confirm('Are you sure you want to delete this Team?');">

                                                    <input type="hidden" name="team_id" value="<?php echo $team['teamId']; ?>">

                                                    <button type="submit" name="delete_team" class="bg-danger text-white px-3 rounded-pill">

                                                        <div class="col" tabindex="6">

                                                            <div class="d-flex bg-danger align-items-center theme-icons shadow-sm cursor-pointer rounded-pill">

                                                                <div class="text-white"><i class="fadeIn animated bx bx-trash" style="font-size:17px;"></i>

                                                                </div>

                                                                <div class="ms-2">Delete</div>

                                                            </div>

                                                        </div>

                                                    </button>

                                                </form>
                                            <?php } ?>

                                            </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php

if (isset($_SESSION['up_team'])) {
    echo "<script>alertify.success('{$_SESSION['up_team']}', { position: 'top-right' });</script>";
    unset($_SESSION['up_team']);
}



if (isset($_SESSION['delteam'])) {
    echo "<script>alertify.success('{$_SESSION['delteam']}', { position: 'top-right' });</script>";
    unset($_SESSION['delteam']);
}

?>

<?php require_once("./main_components/footer.php"); ?>