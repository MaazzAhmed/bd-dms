<?php $TITLE = "Add User"; ?>

<?php require_once("./main_components/header.php");



if (
    !isset($_SESSION['role']) ||
    ($_SESSION['role'] !== 'Admin' &&
        $userPermissions['Add_user'] !== 'Allow')
) {
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

            <!--breadcrumb-->



            <!--end breadcrumb-->

            <div class="row">

                <div class="col-xl-10 mx-auto">

                    <!-- <h6 class="mb-0 text-uppercase">Basic Form</h6> -->

                    <hr />

                    <div class="card border-top border-0 border-4 border-white">

                        <div class="card-body p-5">



                            <div class="card-title d-flex align-items-center">

                                <div><i class="bx bxs-user me-1 font-22 text-white"></i>

                                </div>

                                <h5 class="mb-0 text-white">Add user</h5>

                            </div>

                            <?php





                            // Check if session message is set

                            if (isset($_SESSION['message'])) {

                                // Display the message using Alertify with position at top right

                                echo "<script>console.log('{$_SESSION['message']}');</script>";

                                echo "<script>alertify.success('{$_SESSION['message']}', { position: 'top-right' });</script>";



                                // Unset the session variable to remove it after displaying the message

                                unset($_SESSION['message']);
                            }

                            ?>

                            <hr>

                            <?php if (!empty($erroradduser)) : ?>

                                <div class="alert alert-danger alert-icon bg-danger text-white"><em class="icon ni ni-cross-circle"></em> <strong><?php echo $erroradduser ?> </strong> <?php echo $error; ?></div>





                            <?php endif; ?>

                            <form method="post" class="row g-3">

                                <div class="col-md-6">

                                    <label for="inputFirstName" class="form-label">Name</label>

                                    <input type="text" class="form-control" name="name" required id="inputFirstName">

                                </div>

                                <div class="col-md-6">

                                    <label for="inputEmail" class="form-label">Email</label>

                                    <input type="email" name="email" class="form-control" required id="inputEmail">

                                </div>



                                <div class="col-md-6">

                                    <label for="inputChoosePassword" class="form-label">Password</label>

                                    <div class="input-group" id="show_hide_password">

                                        <input type="password" name="password" class="form-control border-end-0" id="inputChoosePassword" placeholder="Enter Password">

                                        <a href="javascript:;" class="input-group-text bg-transparent" onclick="togglePasswordVisibility()">

                                            <i class='bx' id="password_toggle_icon"></i>

                                        </a>

                                    </div>

                                </div>



                                <div class="col-md-6">

                                    <label for="inputChoosePassword2" class="form-label">Secret Key:</label>

                                    <div class="input-group" id="show_hide_password2">

                                        <input type="password" name="secret_key" class="form-control border-end-0" id="inputChoosePassword2" placeholder="Enter Secret Key">

                                        <a href="javascript:;" class="input-group-text bg-transparent" onclick="togglePasswordVisibilityTwo()">

                                            <i class='bx' id="password_toggle_icon2"></i>

                                        </a>

                                    </div>

                                </div>





                                <div class="col-md-6">

                                    <label for="inputRole" class="form-label">Role</label>

                                    <select id="inputRole" name="role" required class="form-select">

                                        <option selected disabled>Choose...</option>



                                        <?php

                                        // Display roles in dropdown

                                        $roles = getRoles($conn);
                                        if ($_SESSION['role'] == 'Admin') {

                                            foreach ($roles as $role) {

                                                echo "<option value='$role'>$role</option>";
                                            }
                                        } else {
                                            echo "<option value='Executive'>Executive</option>";
                                        }
                                        ?>

                                    </select>

                                </div>

                                <div class="col-md-6">

                                    <label for="inputTeam" class="form-label" name="teamId">Team</label>

                                    <select id="inputTeam" name="teamId" class="form-select">

                                        <option selected disabled>Choose...</option>
                                        <?php

                                        if ($_SESSION['role'] == 'Admin') {
                                            $teams = getTeams($conn);
                                        } else {
                                            $teamId = $_SESSION['team_id'];
                                            $query = "SELECT team_name FROM team WHERE teamId = ?";
                                            $stmt = mysqli_prepare($conn, $query);

                                            mysqli_stmt_bind_param($stmt, 'i', $teamId);
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);


                                            $userTeam = mysqli_fetch_assoc($result);
                                        }
                                        ?>

                                        <?php if ($_SESSION['role'] == 'Admin') : ?>
                                            <!-- Show all teams for Admin -->
                                            <?php foreach ($teams as $team) : ?>
                                                <option value="<?php echo $team['teamId']; ?>"><?php echo $team['team_name']; ?></option>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <!-- Show only the specific team for non-admin users -->
                                            <option value="<?php echo $_SESSION['team_id']; ?>"><?php echo $userTeam['team_name']; ?></option>
                                        <?php endif; ?>

                                    </select>

                                </div>

                                <div class="col-md-6">

                                    <label for="inputShift" class="form-label" name="shift">Shift</label>

                                    <select id="inputShift" name="shift" class="form-select">

                                        <option selected disabled>Choose...</option>

                                        <?php

                                        $shifts = getShift($conn);

                                        foreach ($shifts as $shift) {

                                            echo "<option value='" . $shift['shiftId'] . "'>" . $shift['shift_type'] . "" . "</option>";
                                        }

                                        ?>

                                    </select>

                                </div>

                                <div class="col-md-6">

                                    <label for="inputBlock" class="form-label" name="system_status">Status</label>

                                    <select id="inputBlock" name="system_status" class="form-select">

                                        <option selected disabled>Choose...</option>

                                        <?php

                                        // Assume $conn is your database connection

                                        $enumValues = getEnumValues($conn, 'user', 'system_status');



                                        foreach ($enumValues as $value) {

                                            echo "<option value=\"$value\">$value</option>";
                                        }

                                        ?>

                                    </select>

                                </div>
                                <div class="col-md-6">
                                    <label for="inputContact" class="form-label">Brand Permission</label>

                                    <select name="brandname[]" class="single-select form-control form-select" required id="inputCountry" multiple="multiple">

                                        <option disabled>Choose....</option>

                                        <?php
                                        $brands = getBrands($conn);
                                        foreach ($brands as $brand) {
                                            echo "<option value='" . $brand['brand_name'] . "'>" . $brand['brand_name'] . "</option>";
                                        }
                                        ?>

                                    </select>
                                </div>

                                <div class="col-12">

                                    <label for="inputState" class="form-label">Permission</label>



                                    <div class="form-check">

                                        <input class="form-check-input" type="checkbox" id="checkLogManagement" name='permissions[]' value='log_management'>

                                        <label class="form-check-label" for="checkLogManagement">Log Management</label>

                                    </div>



                                    <div class="form-check">

                                        <input type="checkbox" class="form-check-input" id="viewUser" name='permissions[]' value='view_users'>

                                        <label class="form-check-label" for="viewUser">view Users</label>

                                    </div>



                                    <div class="form-check">

                                        <input class="form-check-input" type="checkbox" id="checkLogManagement" name='permissions[]' value='add_user'>

                                        <label class="form-check-label" for="checkLogManagement">Add users</label>

                                    </div>

                                    <div class="form-check">

                                        <input class="form-check-input" type="checkbox" id="checkLogManagement" name='permissions[]' value='add_shift'>

                                        <label class="form-check-label" for="checkLogManagement">Add Bank Accounts</label>

                                    </div>

                                    <div class="form-check">

                                        <input class="form-check-input" type="checkbox" id="checkLogManagement" name='permissions[]' value='view_shift'>

                                        <label class="form-check-label" for="checkLogManagement">View Bank Accounts</label>

                                    </div>

                                    <div class="form-check">

                                        <input class="form-check-input" type="checkbox" id="checkLogManagement" name='permissions[]' value='view_team'>

                                        <label class="form-check-label" for="checkLogManagement">View team</label>

                                    </div>

                                    <div class="form-check">

                                        <input class="form-check-input" type="checkbox" id="checkLogManagement" name='permissions[]' value='add_team'>

                                        <label class="form-check-label" for="checkLogManagement">Add team</label>

                                    </div>

                                    <div class="form-check">

                                        <input class="form-check-input" type="checkbox" id="checkLogManagement" name='permissions[]' value='add_lead'>

                                        <label class="form-check-label" for="checkLogManagement">Add lead</label>

                                    </div>

                                    <div class="form-check">

                                        <input class="form-check-input" type="checkbox" id="checkLogManagement" name='permissions[]' value='view_lead'>

                                        <label class="form-check-label" for="checkLogManagement">View lead</label>

                                    </div>

                                    <div class="form-check">

                                        <input class="form-check-input" type="checkbox" id="checkLogManagement" name='permissions[]' value='add_core_lead'>

                                        <label class="form-check-label" for="checkLogManagement">Add core lead</label>

                                    </div>
                                    <div class="form-check">

                                        <input class="form-check-input" type="checkbox" id="checkLogManagement" name='permissions[]' value='view_core_lead'>

                                        <label class="form-check-label" for="checkLogManagement">View core lead</label>

                                    </div>

                                    <div class="form-check">

                                        <input class="form-check-input" type="checkbox" id="checkLogManagement" name='permissions[]' value='view_order'>

                                        <label class="form-check-label" for="checkLogManagement">View order</label>

                                    </div>

                                   

                                </div>



                                <div class="col-12 text-center">

                                    <button type="submit" class="btn btn-light px-5" name="create">Create User</button>

                                </div>

                            </form>

                        </div>

                    </div>





                    <script>
                        function togglePasswordVisibility() {

                            var passwordInput = document.getElementById("inputChoosePassword");

                            var passwordToggleIcon = document.getElementById("password_toggle_icon");



                            if (passwordInput.type === "password") {

                                passwordInput.type = "text";

                                passwordToggleIcon.classList.remove('bx-hide');

                                passwordToggleIcon.classList.add('bx-show');

                            } else {

                                passwordInput.type = "password";

                                passwordToggleIcon.classList.remove('bx-show');

                                passwordToggleIcon.classList.add('bx-hide');

                            }

                        }

                        function togglePasswordVisibilityTwo() {

                            var passwordInput = document.getElementById("inputChoosePassword2");

                            var passwordToggleIcon = document.getElementById("password_toggle_icon2");



                            if (passwordInput.type === "password") {

                                passwordInput.type = "text";

                                passwordToggleIcon.classList.remove('bx-hide');

                                passwordToggleIcon.classList.add('bx-show');

                            } else {

                                passwordInput.type = "password";

                                passwordToggleIcon.classList.remove('bx-show');

                                passwordToggleIcon.classList.add('bx-hide');

                            }

                        }
                    </script>



                    <?php require_once("./main_components/footer.php"); ?>