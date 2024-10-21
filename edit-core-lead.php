<?php $TITLE = "Edit Core Lead"; ?>

<?php require_once("./main_components/global.php"); ?>

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

                                <h5 class="mb-0 text-white">Edit Core Lead</h5>

                            </div>

                            <hr>

                            <form method="post" class="row g-3">

                                <input type="hidden" name="l_id" value="<?php echo $leadSourceData['id'] ?>">

                                <input type="hidden" name="creator_name" value="<?php echo  $_SESSION['user'] ?>">





                                <div class="col-md-6">

                                    <label for="inputEmail" class="form-label">Client Name</label>

                                    <input type="text" name="client_name" value="<?php echo $leadSourceData['client_name'] ?>" type="text" class="form-control" required id="inputEmail">

                                </div>

                                <div class="col-md-6">

                                    <label for="inputContact" class="form-label">Contact Number</label>

                                    <input type="tel" name="client_contact_number" value="<?php echo $leadSourceData['client_contact_number'] ?>" class="form-control" required id="inputContact">

                                </div>

                                <div class="col-md-6">
                                    <label for="inputCountry" class="form-label">Client Country</label>
                                    <select name="client_country" class="form-select" required id="inputCountry">
                                        <?php
                                        $countries = [
                                            "Afghanistan",
                                            "Åland Islands",
                                            "Albania",
                                            "Algeria",
                                            "American Samoa",
                                            "Andorra",
                                            "Angola",
                                            "Anguilla",
                                            "Antarctica",
                                            "Antigua and Barbuda",
                                            "Argentina",
                                            "Armenia",
                                            "Aruba",
                                            "Australia",
                                            "Austria",
                                            "Azerbaijan",
                                            "Bahamas",
                                            "Bahrain",
                                            "Bangladesh",
                                            "Barbados",
                                            "Belarus",
                                            "Belgium",
                                            "Belize",
                                            "Benin",
                                            "Bermuda",
                                            "Bhutan",
                                            "Bolivia",
                                            "Bonaire, Sint Eustatius and Saba",
                                            "Bosnia and Herzegovina",
                                            "Botswana",
                                            "Bouvet Island",
                                            "Brazil",
                                            "British Indian Ocean Territory",
                                            "Brunei Darrussalam",
                                            "Bulgaria",
                                            "Burkina Faso",
                                            "Burundi",
                                            "Cambodia",
                                            "Cameroon",
                                            "Canada",
                                            "Cape Verde",
                                            "Cayman Islands",
                                            "Central African Republic",
                                            "Chad",
                                            "Chile",
                                            "China",
                                            "Christmas Island",
                                            "Cocos Islands",
                                            "Colombia",
                                            "Comoros",
                                            "Congo, Democratic Republic of the",
                                            "Congo, Republic of the",
                                            "Cook Islands",
                                            "Costa Rica",
                                            "Cote d'Ivoire",
                                            "Croatia",
                                            "Cuba",
                                            "Curaçao",
                                            "Cyprus",
                                            "Czech Republic",
                                            "Denmark",
                                            "Djibouti",
                                            "Dominica",
                                            "Dominican Republic",
                                            "Ecuador",
                                            "Egypt",
                                            "El Salvador",
                                            "Equatorial Guinea",
                                            "Eritrea",
                                            "Estonia",
                                            "Eswatini (Swaziland)",
                                            "Ethiopia",
                                            "Falkland Islands",
                                            "Faroe Islands",
                                            "Fiji",
                                            "Finland",
                                            "France",
                                            "French Guiana",
                                            "French Polynesia",
                                            "French Southern Territories",
                                            "Gabon",
                                            "Gambia",
                                            "Georgia",
                                            "Germany",
                                            "Ghana",
                                            "Gibraltar",
                                            "Greece",
                                            "Greenland",
                                            "Grenada",
                                            "Guadeloupe",
                                            "Guam",
                                            "Guatemala",
                                            "Guernsey",
                                            "Guinea",
                                            "Guinea-Bissau",
                                            "Guyana",
                                            "Haiti",
                                            "Heard and McDonald Islands",
                                            "Holy See",
                                            "Honduras",
                                            "Hong Kong",
                                            "Hungary",
                                            "Iceland",
                                            "India",
                                            "Indonesia",
                                            "Iran",
                                            "Iraq",
                                            "Ireland",
                                            "Isle of Man",
                                            "Israel",
                                            "Italy",
                                            "Jamaica",
                                            "Japan",
                                            "Jersey",
                                            "Jordan",
                                            "Kazakhstan",
                                            "Kenya",
                                            "Kiribati",
                                            "Kuwait",
                                            "Kyrgyzstan",
                                            "Lao People's Democratic Republic",
                                            "Latvia",
                                            "Lebanon",
                                            "Lesotho",
                                            "Liberia",
                                            "Libya",
                                            "Liechtenstein",
                                            "Lithuania",
                                            "Luxembourg",
                                            "Macau",
                                            "Macedonia",
                                            "Madagascar",
                                            "Malawi",
                                            "Malaysia",
                                            "Maldives",
                                            "Mali",
                                            "Malta",
                                            "Marshall Islands",
                                            "Martinique",
                                            "Mauritania",
                                            "Mauritius",
                                            "Mayotte",
                                            "Mexico",
                                            "Micronesia",
                                            "Moldova",
                                            "Monaco",
                                            "Mongolia",
                                            "Montenegro",
                                            "Montserrat",
                                            "Morocco",
                                            "Mozambique",
                                            "Myanmar",
                                            "Namibia",
                                            "Nauru",
                                            "Nepal",
                                            "Netherlands",
                                            "New Caledonia",
                                            "New Zealand",
                                            "Nicaragua",
                                            "Niger",
                                            "Nigeria",
                                            "Niue",
                                            "Norfolk Island",
                                            "North Korea",
                                            "Northern Mariana Islands",
                                            "Norway",
                                            "Oman",
                                            "Pakistan",
                                            "Palau",
                                            "Palestine, State of",
                                            "Panama",
                                            "Papua New Guinea",
                                            "Paraguay",
                                            "Peru",
                                            "Philippines",
                                            "Pitcairn",
                                            "Poland",
                                            "Portugal",
                                            "Puerto Rico",
                                            "Qatar",
                                            "Réunion",
                                            "Romania",
                                            "Russia",
                                            "Rwanda",
                                            "Saint Barthélemy",
                                            "Saint Helena",
                                            "Saint Kitts and Nevis",
                                            "Saint Lucia",
                                            "Saint Martin",
                                            "Saint Pierre and Miquelon",
                                            "Saint Vincent and the Grenadines",
                                            "Samoa",
                                            "San Marino",
                                            "Sao Tome and Principe",
                                            "Saudi Arabia",
                                            "Senegal",
                                            "Serbia",
                                            "Seychelles",
                                            "Sierra Leone",
                                            "Singapore",
                                            "Sint Maarten",
                                            "Slovakia",
                                            "Slovenia",
                                            "Solomon Islands",
                                            "Somalia",
                                            "South Africa",
                                            "South Georgia",
                                            "South Korea",
                                            "South Sudan",
                                            "Spain",
                                            "Sri Lanka",
                                            "Sudan",
                                            "Suriname",
                                            "Svalbard and Jan Mayen Islands",
                                            "Sweden",
                                            "Switzerland",
                                            "Syria",
                                            "Taiwan",
                                            "Tajikistan",
                                            "Tanzania",
                                            "Thailand",
                                            "Timor-Leste",
                                            "Togo",
                                            "Tokelau",
                                            "Tonga",
                                            "Trinidad and Tobago",
                                            "Tunisia",
                                            "Turkey",
                                            "Turkmenistan",
                                            "Turks and Caicos Islands",
                                            "Tuvalu",
                                            "Uganda",
                                            "Ukraine",
                                            "United Arab Emirates",
                                            "United Kingdom",
                                            "United States",
                                            "Uruguay",
                                            "US Minor Outlying Islands",
                                            "Uzbekistan",
                                            "Vanuatu",
                                            "Venezuela",
                                            "Vietnam",
                                            "Virgin Islands, British",
                                            "Virgin Islands, U.S.",
                                            "Wallis and Futuna",
                                            "Western Sahara",
                                            "Yemen",
                                            "Zambia",
                                            "Zimbabwe"
                                        ];

                                        foreach ($countries as $country) {
                                            $selected = ($leadSourceData['client_country'] == $country) ? 'selected' : '';
                                            echo "<option value='$country' $selected>$country</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="col-md-6">

                                    <label for="inputCountry" class="form-label">Client Email</label>

                                    <input type="email" name="client_email" value="<?php echo $leadSourceData['client_email'] ?>" class="form-control" required id="inputCountry">

                                </div>

                                <div class="col-md-6">

                                    <label for="inputFirstName" class="form-label">Campaign ID:</label>

                                    <input type="text" name="campId" value="<?php echo $leadSourceData['campId'] ?>" class="form-control" required id="inputFirstName">

                                </div>
                                <div class="col-md-6">
                                    <label for="inputContact" class="form-label">Client Status</label>
                                    <select name="client_info" class="form-select" required id="inputCountry">

                                        <?php
                                        $paymentStatuses = ['', 'New', 'Recurring', 'Referral']; // Define the payment statuses
                                        foreach ($paymentStatuses as $value) {
                                            $selected = ($leadSourceData['client_info'] == $value) ? 'selected' : '';
                                            echo "<option value='$value' $selected>$value</option>";
                                        } ?>
                                    </select>
                                </div>


                                <?php
                                $isAdmin = $_SESSION['role'] === 'Admin'; // Check if user is an admin
                                $userId = $_SESSION['id']; // Get the user ID

                                // Fetch brands based on user permissions
                                if ($isAdmin) {
                                    $brands = getAllBrands($conn);
                                ?>
                                    <div class="col-md-6">
                                        <label for="inputContact" class="form-label">Brand Name</label>
                                        <select name="brandname" class="form-select" required id="inputCountry">
                                            <option disabled selected>Choose....</option>
                                            <?php
                                            // Populate the select box with the brands
                                            if (isset($brands) && is_array($brands) && !empty($brands)) {
                                                foreach ($brands as $brand) {
                                                    if (isset($brand['brand_name'])) {
                                                        $selected = ($leadSourceData['brand_name'] == $brand['brand_name']) ? 'selected' : '';
                                                        echo "<option value='" . htmlspecialchars($brand['brand_name']) . "' $selected>" . htmlspecialchars($brand['brand_name']) . "</option>";
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
                                    $brands = getAllowedDisplayBrandsForUser($conn, $userId); // Fetch allowed brands for the user
                                ?>
                                    <div class="col-md-6">
                                        <label for="inputContact" class="form-label">Brand Name</label>
                                        <select name="brandname" class="form-select" required id="inputCountry">
                                            <option disabled selected>Choose....</option>
                                            <?php
                                            // Populate the select box with the brands
                                            if (isset($brands) && is_array($brands) && !empty($brands)) {
                                                foreach ($brands as $brand) {
                                                    if (isset($brand['brandpermission'])) {
                                                        $selected = ($leadSourceData['brand_name'] == $brand['brandpermission']) ? 'selected' : '';
                                                        echo "<option value='" . htmlspecialchars($brand['brandpermission']) . "' $selected>" . htmlspecialchars($brand['brandpermission']) . "</option>";
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
                                            // Combine the name and number into one string and trim any spaces
                                            $whatsappValue = trim($whatsappd['whatsapp_name'] . ' ' . $whatsappd['whatsapp_number']);
                                            $leadWhatsapp = trim($leadSourceData['whatsapp_name'] . ' ' . $leadSourceData['whatsapp_number']);

                                            // Extract the country code and number (assuming the format is "CountryName Number")
                                            if (preg_match('/^(.*?)(\d{4,})$/', $whatsappValue, $matches)) {
                                                // $matches[1] contains the country code and $matches[2] contains the number
                                                $countryCode = $matches[1];
                                                $number = $matches[2];

                                                // Mask all but the last 3 digits of the number
                                                $maskedNumber = str_repeat('*', strlen($number) - 3) . substr($number, -3);

                                                // Create the masked WhatsApp value
                                                $maskedWhatsappValue = $countryCode . ' ' . $maskedNumber;
                                            } else {
                                                // Fallback in case the format is unexpected
                                                $maskedWhatsappValue = $whatsappValue;
                                            }

                                            // Check if this option should be selected
                                            $selected = ($whatsappValue === $leadWhatsapp) ? 'selected' : '';

                                            // Output the option with the masked number
                                            echo "<option value='$whatsappValue' $selected>$maskedWhatsappValue</option>";
                                        }
                                        ?>
                                    </select>
                                </div>


                                <div class="col-md-6">
                                    <label for="inputContact" class="form-label">Lead Source</label>
                                    <select name="lsource" class="form-select" required id="inputLeadSource" onchange="checkLeadSource()">
                                        <?php
                                        $leadsource = getLeadSource($conn);

                                        foreach ($leadsource as $value) {
                                            $source = $value['source'];
                                            $selected = ($leadSourceData['lead_source'] == $source) ? 'selected' : '';
                                            echo "<option value='$source' $selected>$source</option>";
                                        } ?>
                                    </select>
                                </div>

                                <div class="col-md-6" id="clientNameField" style="display: none;">
                                    <label for="inputFirstName" class="form-label">Refer Client Name</label>
                                    <input type="text" value="<?php echo $leadSourceData['refer_client_name']; ?>" name="clientName" class="form-control" id="inputFirstName">
                                </div>
                                <div class="col-md-6" id="platformNameField" style="display: none;">
                                    <label for="inputFirstName" class="form-label">PlatForm</label>
                                    <input type="text" value="<?php echo $leadSourceData['platform']; ?>" name="platform" class="form-control" id="inputFirstName">
                                </div>




                                <div class="col-12 text-center">

                                    <button type="submit" name="update_core_lead" class="btn btn-light px-5">Save Changes</button>

                                </div>

                            </form>

                        </div>

                    </div>





                    <script>
                        function checkLeadSource() {
                            var leadSourceDropdown = document.getElementById("inputLeadSource");
                            var clientNameField = document.getElementById("clientNameField");
                            var platformNameField = document.getElementById("platformNameField");

                            // Get the selected option's text
                            var selectedText = leadSourceDropdown.options[leadSourceDropdown.selectedIndex].text;

                            // Show or hide fields based on the selected value
                            if (selectedText === "Refer") {
                                clientNameField.style.display = "block";
                                platformNameField.style.display = "none"; // Hide the platform field if "Refer" is selected
                            } else if (selectedText === "Social Media Marketing") {
                                platformNameField.style.display = "block";
                                clientNameField.style.display = "none"; // Hide the client name field if "Social Media Marketing" is selected
                            } else {
                                clientNameField.style.display = "none";
                                platformNameField.style.display = "none";
                            }
                        }

                        // Call checkLeadSource on page load to handle pre-selected options
                        window.onload = checkLeadSource;
                    </script>

                    <?php require_once("./main_components/footer.php"); ?>