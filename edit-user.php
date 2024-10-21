<?php $TITLE = "Edit User"; ?>

<?php require_once("./main_components/header.php");



// Fetch roles, teams, and shifts

$roles = getRoles($conn);

$teams = getTeams($conn);

$shifts = getShift($conn); ?>

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



            <div class="row">

                <div class="col-xl-10 mx-auto">

                    <div class="card border-top border-0 border-4 border-white">

                        <div class="card-body p-5">

                            <div class="card-title d-flex align-items-center">

                                <div><i class="bx bxs-user me-1 font-22 text-white"></i>

                                </div>

                                <h5 class="mb-0 text-white">Edit</h5>

                            </div>

                            <hr>

                            <form method="post" class="row g-3">

                                <div class="col-md-6">

                                    <input type="hidden" name="userId" value="<?php echo $editUserData['userId']; ?>">



                                    <label for="inputFirstName" class="form-label">Name</label>

                                    <input type="text" class="form-control" required name="name" value="<?php echo $editUserData['name']; ?>" id="inputFirstName">

                                </div>

                                <div class="col-md-6">

                                    <label for="inputEmail" class="form-label">Email</label>

                                    <input type="email" name="email" value="<?php echo $editUserData['email']; ?>" class="form-control" required id="inputEmail">

                                </div>



                                <div class="col-md-6">

                                    <label for="inputChoosePassword2" class="form-label">Secret Key:</label>

                                    <div class="input-group" id="show_hide_password2">

                                        <input type="password" value="<?php echo $editUserData['secret_key']; ?>" name="secret_key" class="form-control border-end-0" id="inputChoosePassword2" placeholder="Enter Secret Key">

                                        <a href="javascript:;" class="input-group-text bg-transparent" onclick="togglePasswordVisibilityTwo()">

                                            <i class='bx' id="password_toggle_icon2"></i>

                                        </a>

                                    </div>

                                </div>



                                <div class="col-md-6">

                                    <label for="inputState" class="form-label">Role</label>

                                    <select id="inputState" name="role" required class="form-select">



                                        <?php foreach ($roles as $role) : ?>

                                            <option value="<?php echo $role; ?>" <?php echo ($editUserData['role'] == $role) ? 'selected' : ''; ?>><?php echo $role; ?></option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>

                                <div class="col-md-6">

                                    <label for="inputTeam" class="form-label">Team</label>

                                    <select id="inputTeam" name="team_Id" class="form-select">

                                        <?php foreach ($teams as $team) : ?>

                                            <option value="<?php echo $team['teamId']; ?>" <?php echo ($editUserData['team_Id'] == $team['teamId']) ? 'selected' : ''; ?>><?php echo $team['team_name']; ?></option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>

                                <div class="col-md-6">

                                    <label for="inputShift" class="form-label">Shift</label>

                                    <select id="inputShift" name="shift_id" class="form-select">

                                        <?php foreach ($shifts as $shift) : ?>

                                            <option value="<?php echo $shift['shiftId']; ?>" <?php echo ($editUserData['shift_id'] == $shift['shiftId']) ? 'selected' : ''; ?>>

                                                <?php echo $shift['shift_type']; ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>

                                <div class="col-md-6">

                                    <label for="inputShift" class="form-label">Status</label>

                                    <select id="inputShift" name="stytem_status" class="form-select">

                                        <?php
                                        $enumValues = getEnumValues($conn, 'user', 'system_status');
                                        foreach ($enumValues as $value) {
                                            echo "<option value='$value'" . ($editUserData['system_status'] == $value ? ' selected' : '') . ">$value</option>";
                                        }

                                        ?>

                                    </select>

                                </div>
                                <div class="col-md-6">
                                    <label for="inputShift" class="form-label">Allow Login Except Shift Timing</label>
                                    <select id="inputShift" name="wfh" class="form-select">
                                        <?php
                                        $options = ['Allow', 'Deny'];

                                        foreach ($options as $value) {
                                            $selected = ($editUserData['wfh'] == $value) ? 'selected' : '';

                                            echo "<option value='$value' $selected>$value</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6">

                                    <label for="inputChoosePassword" class="form-label">Password</label>

                                    <div class="input-group" id="show_hide_password">

                                        <input type="password" name="password" class="form-control border-end-0" id="inputChoosePassword" placeholder="Optional">

                                        <a href="javascript:;" class="input-group-text bg-transparent" onclick="togglePasswordVisibility()">

                                            <i class='bx' id="password_toggle_icon"></i>

                                        </a>

                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <label for="inputBrand" class="form-label">Brand Permissions</label>
                                    <select name="brandname[]" class="single-select form-control form-select " multiple required>
                                        <option disabled>Select Brands</option>

                                        <?php
                                        $allBrands = getBrands($conn);

                                        foreach ($allBrands as $brand) {
                                            $brandName = $brand['brand_name'];

                                            $isSelected = in_array($brandName, $brandPermissions) ? 'selected' : '';

                                            echo "<option value='$brandName' $isSelected>$brandName</option>";
                                        }
                                        ?>
                                    </select>
                                </div>


                                <div class="col-12 text-center">

                                    <button type="submit" name="update_user" class="btn btn-light px-5">Update User</button>

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