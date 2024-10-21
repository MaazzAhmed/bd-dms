<?php $TITLE = "Add Core Lead"; ?>

<?php require_once("./main_components/global.php"); ?>

<?php require_once("./main_components/header.php");


if (
    !isset($_SESSION['role']) ||
    ($_SESSION['role'] !== 'Admin' &&
        $userPermissions['add_core_lead'] !== 'Allow')
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


                    <?php
                    if (isset($_SESSION['adCorelead'])) {
                        echo "<script>alertify.success('{$_SESSION['adCorelead']}', { position: 'top-right' });</script>";
                        unset($_SESSION['adCorelead']);
                    }
                    ?>

                    <div class="card border-top border-0 border-4 border-white">

                        <div class="card-body p-5">

                            <div class="card-title d-flex align-items-center">

                                <div><i class="bx bxs-user me-1 font-22 text-white"></i>

                                </div>

                                <h5 class="mb-0 text-white">Add Core Lead</h5>

                            </div>

                            <hr>

                            <form method="post" class="row g-3">


                                <div class="col-md-6">

                                    <label for="inputEmail" class="form-label">Client Name</label>

                                    <input type="text" name="client_name" class="form-control" required id="inputEmail">

                                </div>

                                <div class="col-md-6">

                                    <label for="inputEmail" class="form-label">Client Email</label>

                                    <input type="email" name="client_email" class="form-control" required id="inputEmail">

                                </div>

                                <div class="col-md-6">

                                    <label for="inputContact" class="form-label">Contact Number</label>

                                    <input type="tel" name="client_contact_number" class="form-control" required id="inputContact">

                                </div>
                                <div class="col-md-6">

                                    <label for="inputCountry" class="form-label">Client Country</label>

                                    <select name="client_country" class="form-select" required id="inputCountry">

                                        <option value="Afghanistan">Afghanistan</option>

                                        <option value="Åland Islands">Åland Islands</option>

                                        <option value="Albania">Albania</option>

                                        <option value="Algeria">Algeria</option>

                                        <option value="American Samoa">American Samoa</option>

                                        <option value="Andorra">Andorra</option>

                                        <option value="Angola">Angola</option>

                                        <option value="Anguilla">Anguilla</option>

                                        <option value="Antarctica">Antarctica</option>

                                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>

                                        <option value="Argentina">Argentina</option>

                                        <option value="Armenia">Armenia</option>

                                        <option value="Aruba">Aruba</option>

                                        <option value="Australia">Australia</option>

                                        <option value="Austria">Austria</option>

                                        <option value="Azerbaijan">Azerbaijan</option>

                                        <option value="Bahamas">Bahamas</option>

                                        <option value="Bahrain">Bahrain</option>

                                        <option value="Bangladesh">Bangladesh</option>

                                        <option value="Barbados">Barbados</option>

                                        <option value="Belarus">Belarus</option>

                                        <option value="Belgium">Belgium</option>

                                        <option value="Belize">Belize</option>

                                        <option value="Benin">Benin</option>

                                        <option value="Bermuda">Bermuda</option>

                                        <option value="Bhutan">Bhutan</option>

                                        <option value="Bolivia">Bolivia</option>

                                        <option value="Bonaire, Sint Eustatius and Saba">Bonaire, Sint Eustatius and Saba</option>

                                        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>

                                        <option value="Botswana">Botswana</option>

                                        <option value="Bouvet Island">Bouvet Island</option>

                                        <option value="Brazil">Brazil</option>

                                        <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>

                                        <option value="Brunei Darrussalam">Brunei Darrussalam</option>

                                        <option value="Bulgaria">Bulgaria</option>

                                        <option value="Burkina Faso">Burkina Faso</option>

                                        <option value="Burundi">Burundi</option>

                                        <option value="Cambodia">Cambodia</option>

                                        <option value="Cameroon">Cameroon</option>

                                        <option value="Canada">Canada</option>

                                        <option value="Cape Verde">Cape Verde</option>

                                        <option value="Cayman Islands">Cayman Islands</option>

                                        <option value="Central African Republic">Central African Republic</option>

                                        <option value="Chad">Chad</option>

                                        <option value="Chile">Chile</option>

                                        <option value="China">China</option>

                                        <option value="Christmas Island">Christmas Island</option>

                                        <option value="Cocos Islands">Cocos Islands</option>

                                        <option value="Colombia">Colombia</option>

                                        <option value="Comoros">Comoros</option>

                                        <option value="Congo, Democratic Republic of the">Congo, Democratic Republic of the</option>

                                        <option value="Congo, Republic of the">Congo, Republic of the</option>

                                        <option value="Cook Islands">Cook Islands</option>

                                        <option value="Costa Rica">Costa Rica</option>

                                        <option value="Cote divoire">Cote divoire</option>

                                        <option value="Croatia">Croatia</option>

                                        <option value="Cuba">Cuba</option>

                                        <option value="Curaçao">Curaçao</option>

                                        <option value="Cyprus">Cyprus</option>

                                        <option value="Czech Republic">Czech Republic</option>

                                        <option value="Denmark">Denmark</option>

                                        <option value="Djibouti">Djibouti</option>

                                        <option value="Dominica">Dominica</option>

                                        <option value="Dominican Republic">Dominican Republic</option>

                                        <option value="Ecuador">Ecuador</option>

                                        <option value="Egypt">Egypt</option>

                                        <option value="El Salvador">El Salvador</option>

                                        <option value="Equatorial Guinea">Equatorial Guinea</option>

                                        <option value="Eritrea">Eritrea</option>

                                        <option value="Estonia">Estonia</option>

                                        <option value="Eswatini (Swaziland)">Eswatini (Swaziland)</option>

                                        <option value="Ethiopia">Ethiopia</option>

                                        <option value="Falkland Islands">Falkland Islands</option>

                                        <option value="Faroe Islands">Faroe Islands</option>

                                        <option value="Fiji">Fiji</option>

                                        <option value="Finland">Finland</option>

                                        <option value="France">France</option>

                                        <option value="French Guiana">French Guiana</option>

                                        <option value="French Polynesia">French Polynesia</option>

                                        <option value="French Southern Territories">French Southern Territories</option>

                                        <option value="Gabon">Gabon</option>

                                        <option value="Gambia">Gambia</option>

                                        <option value="Georgia">Georgia</option>

                                        <option value="Germany">Germany</option>

                                        <option value="Ghana">Ghana</option>

                                        <option value="Gibraltar">Gibraltar</option>

                                        <option value="Greece">Greece</option>

                                        <option value="Greenland">Greenland</option>

                                        <option value="Grenada">Grenada</option>

                                        <option value="Guadeloupe">Guadeloupe</option>

                                        <option value="Guam">Guam</option>

                                        <option value="Guatemala">Guatemala</option>

                                        <option value="Guernsey">Guernsey</option>

                                        <option value="Guinea">Guinea</option>

                                        <option value="Guinea-Bissau">Guinea-Bissau</option>

                                        <option value="Guyana">Guyana</option>

                                        <option value="Haiti">Haiti</option>

                                        <option value="Heard and McDonald Islands">Heard and McDonald Islands</option>

                                        <option value="Holy See">Holy See</option>

                                        <option value="Honduras">Honduras</option>

                                        <option value="Hong Kong">Hong Kong</option>

                                        <option value="Hungary">Hungary</option>

                                        <option value="Iceland">Iceland</option>

                                        <option value="India">India</option>

                                        <option value="Indonesia">Indonesia</option>

                                        <option value="Iran">Iran</option>

                                        <option value="Iraq">Iraq</option>

                                        <option value="Ireland">Ireland</option>

                                        <option value="Isle of Man">Isle of Man</option>

                                        <option value="Israel">Israel</option>

                                        <option value="Italy">Italy</option>

                                        <option value="Jamaica">Jamaica</option>

                                        <option value="Japan">Japan</option>

                                        <option value="Jersey">Jersey</option>

                                        <option value="Jordan">Jordan</option>

                                        <option value="Kazakhstan">Kazakhstan</option>

                                        <option value="Kenya">Kenya</option>

                                        <option value="Kiribati">Kiribati</option>

                                        <option value="Kuwait">Kuwait</option>

                                        <option value="Kyrgyzstan">Kyrgyzstan</option>

                                        <option value="Lao Peoples Democratic Republic">Lao Peoples Democratic Republic</option>

                                        <option value="Latvia">Latvia</option>

                                        <option value="Lebanon">Lebanon</option>

                                        <option value="Lesotho">Lesotho</option>

                                        <option value="Liberia">Liberia</option>

                                        <option value="Libya">Libya</option>

                                        <option value="Liechtenstein">Liechtenstein</option>

                                        <option value="Lithuania">Lithuania</option>

                                        <option value="Luxembourg">Luxembourg</option>

                                        <option value="Macau">Macau</option>

                                        <option value="Macedonia">Macedonia</option>

                                        <option value="Madagascar">Madagascar</option>

                                        <option value="Malawi">Malawi</option>

                                        <option value="Malaysia">Malaysia</option>

                                        <option value="Maldives">Maldives</option>

                                        <option value="Mali">Mali</option>

                                        <option value="Malta">Malta</option>

                                        <option value="Marshall Islands">Marshall Islands</option>

                                        <option value="Martinique">Martinique</option>

                                        <option value="Mauritania">Mauritania</option>

                                        <option value="Mauritius">Mauritius</option>

                                        <option value="Mayotte">Mayotte</option>

                                        <option value="Mexico">Mexico</option>

                                        <option value="Micronesia">Micronesia</option>

                                        <option value="Moldova">Moldova</option>

                                        <option value="Monaco">Monaco</option>

                                        <option value="Mongolia">Mongolia</option>

                                        <option value="Montenegro">Montenegro</option>

                                        <option value="Montserrat">Montserrat</option>

                                        <option value="Morocco">Morocco</option>

                                        <option value="Mozambique">Mozambique</option>

                                        <option value="Myanmar">Myanmar</option>

                                        <option value="Namibia">Namibia</option>

                                        <option value="Nauru">Nauru</option>

                                        <option value="Nepal">Nepal</option>

                                        <option value="Netherlands">Netherlands</option>

                                        <option value="New Caledonia">New Caledonia</option>

                                        <option value="New Zealand">New Zealand</option>

                                        <option value="Nicaragua">Nicaragua</option>

                                        <option value="Niger">Niger</option>

                                        <option value="Nigeria">Nigeria</option>

                                        <option value="Niue">Niue</option>

                                        <option value="Norfolk Island">Norfolk Island</option>

                                        <option value="North Korea">North Korea</option>

                                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>

                                        <option value="Norway">Norway</option>

                                        <option value="Oman">Oman</option>

                                        <option value="Pakistan" selected="">Pakistan</option>

                                        <option value="Palau">Palau</option>

                                        <option value="Palestine, State of">Palestine, State of</option>

                                        <option value="Panama">Panama</option>

                                        <option value="Papua New Guinea">Papua New Guinea</option>

                                        <option value="Paraguay">Paraguay</option>

                                        <option value="Peru">Peru</option>

                                        <option value="Philippines">Philippines</option>

                                        <option value="Pitcairn">Pitcairn</option>

                                        <option value="Poland">Poland</option>

                                        <option value="Portugal">Portugal</option>

                                        <option value="Puerto Rico">Puerto Rico</option>

                                        <option value="Qatar">Qatar</option>

                                        <option value="Réunion">Réunion</option>

                                        <option value="Romania">Romania</option>

                                        <option value="Russia">Russia</option>

                                        <option value="Rwanda">Rwanda</option>

                                        <option value="Saint Barthélemy">Saint Barthélemy</option>

                                        <option value="Saint Helena">Saint Helena</option>

                                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>

                                        <option value="Saint Lucia">Saint Lucia</option>

                                        <option value="Saint Martin">Saint Martin</option>

                                        <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>

                                        <option value="Saint Vincent and the Grenadines">Saint Vincent and the Grenadines</option>

                                        <option value="Samoa">Samoa</option>

                                        <option value="San Marino">San Marino</option>

                                        <option value="Sao Tome and Principe">Sao Tome and Principe</option>

                                        <option value="Saudi Arabia">Saudi Arabia</option>

                                        <option value="Senegal">Senegal</option>

                                        <option value="Serbia">Serbia</option>

                                        <option value="Seychelles">Seychelles</option>

                                        <option value="Sierra Leone">Sierra Leone</option>

                                        <option value="Singapore">Singapore</option>

                                        <option value="Sint Maarten">Sint Maarten</option>

                                        <option value="Slovakia">Slovakia</option>

                                        <option value="Slovenia">Slovenia</option>

                                        <option value="Solomon Islands">Solomon Islands</option>

                                        <option value="Somalia">Somalia</option>

                                        <option value="South Africa">South Africa</option>

                                        <option value="South Georgia">South Georgia</option>

                                        <option value="South Korea">South Korea</option>

                                        <option value="South Sudan">South Sudan</option>

                                        <option value="Spain">Spain</option>

                                        <option value="Sri Lanka">Sri Lanka</option>

                                        <option value="Sudan">Sudan</option>

                                        <option value="Suriname">Suriname</option>

                                        <option value="Svalbard and Jan Mayen Islands">Svalbard and Jan Mayen Islands</option>

                                        <option value="Sweden">Sweden</option>

                                        <option value="Switzerland">Switzerland</option>

                                        <option value="Syria">Syria</option>

                                        <option value="Taiwan">Taiwan</option>

                                        <option value="Tajikistan">Tajikistan</option>

                                        <option value="Tanzania">Tanzania</option>

                                        <option value="Thailand">Thailand</option>

                                        <option value="Timor-Leste">Timor-Leste</option>

                                        <option value="Togo">Togo</option>

                                        <option value="Tokelau">Tokelau</option>

                                        <option value="Tonga">Tonga</option>

                                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>

                                        <option value="Tunisia">Tunisia</option>

                                        <option value="Turkey">Turkey</option>

                                        <option value="Turkmenistan">Turkmenistan</option>

                                        <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>

                                        <option value="Tuvalu">Tuvalu</option>

                                        <option value="Uganda">Uganda</option>

                                        <option value="Ukraine">Ukraine</option>

                                        <option value="United Arab Emirates">United Arab Emirates</option>

                                        <option value="United Kingdom">United Kingdom</option>

                                        <option value="United States">United States</option>

                                        <option value="Uruguay">Uruguay</option>

                                        <option value="US Minor Outlying Islands">US Minor Outlying Islands</option>

                                        <option value="Uzbekistan">Uzbekistan</option>

                                        <option value="Vanuatu">Vanuatu</option>

                                        <option value="Venezuela">Venezuela</option>

                                        <option value="Vietnam">Vietnam</option>

                                        <option value="Virgin Islands, British">Virgin Islands, British</option>

                                        <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>

                                        <option value="Wallis and Futuna">Wallis and Futuna</option>

                                        <option value="Western Sahara">Western Sahara</option>

                                        <option value="Yemen">Yemen</option>

                                        <option value="Zambia">Zambia</option>

                                        <option value="Zimbabwe">Zimbabwe</option>

                                    </select>

                                </div>
                                <div class="col-md-6">

                                    <label for="inputFirstName" class="form-label">Campaign ID:</label>
                                    <input type="text" name="campId" class="form-control" required id="inputFirstName">

                                </div>


                                <div class="col-md-6">

                                    <label for="inputContact" class="form-label">Client Status</label>

                                    <select name="client_info" class="form-select" required id="inputCountry">

                                        <option disabled selected></option>
                                        <option value="New">New</option>
                                        <option value="Recurring">Recurring</option>
                                        <option value="Referral">Referral</option>

                                    </select>

                                </div>


                                <?php
                                $isAdmin = $_SESSION['role'] === 'Admin';
                                $userId = $_SESSION['id']; // Get the user ID

                                if ($isAdmin) {
                                    $brands = getAllBrands($conn);

                                ?>
                                    <div class="col-md-6">
                                        <label for="inputContact" class="form-label">Brand Name</label>
                                        <select name="brandname" class="form-select" required id="inputCountry">
                                            <option disabled selected>Choose....</option>
                                            <?php
                                            if (isset($brands) && is_array($brands) && !empty($brands)) {
                                                foreach ($brands as $brand) {
                                                    if (isset($brand['brand_name'])) {
                                                        echo "<option value='" . htmlspecialchars($brand['brand_name']) . "'>" . htmlspecialchars($brand['brand_name']) . "</option>";
                                                    }
                                                }
                                            } else {
                                                echo "<option disabled>No brands available</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                <?php
                                } else {
                                    $brands = getAllowedDisplayBrandsForUser($conn, $userId);
                                ?>
                                    <div class="col-md-6">
                                        <label for="inputContact" class="form-label">Brand Name</label>
                                        <select name="brandname" class="form-select" required id="inputCountry">
                                            <option disabled selected>Choose....</option>
                                            <?php
                                            if (isset($brands) && is_array($brands) && !empty($brands)) {
                                                foreach ($brands as $brand) {
                                                    if (isset($brand['brandpermission'])) {
                                                        echo "<option value='" . htmlspecialchars($brand['brandpermission']) . "'>" . htmlspecialchars($brand['brandpermission']) . "</option>";
                                                    }
                                                }
                                            } else {
                                                echo "<option disabled>No brands available</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                <?php } ?>


                                <div class="col-md-6">
                                    <label for="inputContact" class="form-label">Whatsapp Name</label>
                                    <select name="whatsappname" class="form-select" required id="inputCountry">
                                        <option disabled selected>Choose....</option>

                                        <?php
                                        $whatsapp = getWhatsapp($conn);

                                        foreach ($whatsapp as $whatsappd) {
                                            $whatsappValue = trim($whatsappd['whatsapp_name'] . ' ' . $whatsappd['whatsapp_number']);

                                            if (preg_match('/^(.*?)(\d{4,})$/', $whatsappValue, $matches)) {
                                                $countryCode = $matches[1];
                                                $number = $matches[2];
                                                $maskedNumber = str_repeat('*', strlen($number) - 3) . substr($number, -3);
                                                $maskedWhatsappValue = $countryCode . ' ' . $maskedNumber;
                                            } else {
                                                $maskedWhatsappValue = $whatsappValue;
                                            }
                                            $leadWhatsapp = isset($leadSourceData) ? trim($leadSourceData['whatsapp_name'] . ' ' . $leadSourceData['whatsapp_number']) : '';
                                            $selected = ($whatsappValue === $leadWhatsapp) ? 'selected' : '';
                                            echo "<option value='$whatsappValue' $selected>$maskedWhatsappValue</option>";
                                        }
                                        ?>
                                    </select>
                                </div>


                                <div class="col-md-6">
                                    <label for="inputContact" class="form-label">Lead Source</label>
                                    <select name="lsource" class="form-select" required id="inputLeadSource" onchange="checkLeadSource()">
                                        <option disabled selected>Choose....</option>
                                        <?php
                                        $leadsource = getLeadSource($conn);
                                        foreach ($leadsource as $leadsources) {
                                            echo "<option value='" . $leadsources['source'] . "'>" . $leadsources['source'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6" id="clientNameField" style="display: none;">
                                    <label for="inputFirstName" class="form-label">Refer Client Name</label>
                                    <input type="text" name="clientName" class="form-control" id="inputFirstName">
                                </div>

                                <div class="col-md-6" id="platformNameField" style="display: none;">
                                    <label for="inputFirstName" class="form-label">Platform</label>
                                    <input type="text" name="platform" class="form-control" id="inputPlatformName">
                                </div>


                                <input type="hidden" name="user_id" value="<?php echo $_SESSION['id'] ?>" class="form-control" required id="inputUserId">

                                <input type="hidden" name="creator_name" value="<?php echo $_SESSION['user'] ?>" class="form-control" required id="inputUserId">


                                <div class="col-12 text-center">

                                    <button type="submit" name="create_core_lead" class="btn btn-light px-5">Create Lead</button>

                                </div>

                            </form>

                        </div>

                    </div>

                    <script>
                        function checkLeadSource() {
                            var leadSourceDropdown = document.getElementById("inputLeadSource");
                            var clientNameField = document.getElementById("clientNameField");
                            var platformNameField = document.getElementById("platformNameField");

                            var selectedText = leadSourceDropdown.options[leadSourceDropdown.selectedIndex].text;

                            if (selectedText === "Refer") {
                                clientNameField.style.display = "block";
                                platformNameField.style.display = "none";
                            } else if (selectedText === "Social Media Marketing") {
                                platformNameField.style.display = "block";
                                clientNameField.style.display = "none";
                            } else {
                                clientNameField.style.display = "none";
                                platformNameField.style.display = "none";
                            }
                        }
                    </script>

                    <?php require_once("./main_components/footer.php"); ?>