<?php

$TITLE = "View Leads"; ?>

<?php require_once("./main_components/header.php");

if (
    !isset($_SESSION['role']) ||
    ($_SESSION['role'] !== 'Admin' &&
        $userPermissions['view_lead'] !== 'Allow' &&
        $userPermissions['add_lead'] !== 'Allow')
) {
    echo "<script>window.location.href = 'index';</script>";
    exit();
}

?>
<style>
    .table-responsive {
        overflow: hidden;
        cursor: grab;
    }

    .table-responsive:active {
        cursor: grabbing;
    }
</style>
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


            <?php


            if (isset($_SESSION['elead'])) {

                echo "<script>alertify.success('{$_SESSION['elead']}', { position: 'top-right' });</script>";

                unset($_SESSION['elead']);
            }
            if (isset($_SESSION['dlead'])) {

                echo "<script>alertify.success('{$_SESSION['dlead']}', { position: 'top-right' });</script>";

                unset($_SESSION['dlead']);
            }
            ?>
            <div class="header-containerss">
                <h6 class="mb-0 text-uppercase">Live Leads</h6>
                <?php if ($userPermissions['add_lead'] == 'Allow'  || $_SESSION['role'] == 'Admin') : ?>

                    <a href="add-lead" class="btn btn-primary">Add New Lead</a>
                <?php endif; ?>
            </div>
            <div class="d-flex justify-content-end">
                <a href="import-live-lead" class="btn btn-primary" style="display:inline-block;">Import CSV</a>&nbsp;

                <!-- Export Button -->
                <form method="post" style="display:inline-block;">
                    <button type="submit" name="export_csv" class="btn btn-success">Export CSV</button>
                </form>

            </div>
            <hr />
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Camp ID</th>
                                    <th>Client Name</th>
                                    <th>Client Contact Number</th>
                                    <th>Client Country</th>
                                    <th>Client Email</th>
                                    <th>Lead Landing Date</th>
                                    <?php if ($_SESSION['role'] != 'Viewer') { ?>
                                        <th>Status</th>
                                        <th>Edit</th>
                                    <?php } ?>
                                    <?php if ($_SESSION['role'] == 'Admin') { ?>
                                        <th>Delete</th>
                                    <?php } ?>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                function getLeads($conn)
                                {
                                    $leads = array();
                                    $userid = $_SESSION['id'];
                                    $role = $_SESSION['role'];
                                    $teamId = $_SESSION['team_id'] ?? '';



                                    if ($role == 'Admin') {
                                        $query = "SELECT leads.id, leads.campId, leads.client_name, leads.client_contact_number, 
                         leads.lead_landing_date, leads.client_country, leads.client_email, 
                         leads.brand_name, leads.whatsapp_name, leads.whatsapp_number, 
                         leads.refer_client_name, user.name
                  FROM leads 
                  LEFT JOIN user ON leads.user_id = user.userId 
                  WHERE leads.del_status != 'Deleted' 
                  ORDER BY leads.id DESC";
                                    } else if ($role == 'Viewer') {
                                        $brands = getAllowedDisplayBrandsForUser($conn, $userid);



                                        if (!empty($brands)) {
                                            // Collect all brand permissions
                                            $brandNames = array();
                                            foreach ($brands as $brand) {
                                                $brandNames[] = "'" . $conn->real_escape_string($brand['brandpermission']) . "'";
                                            }

                                            $brandList = implode(',', $brandNames);



                                            $query = "SELECT leads.id, leads.campId, leads.client_name, leads.client_contact_number, 
                             leads.lead_landing_date, leads.client_country, leads.client_email, 
                             leads.brand_name, leads.whatsapp_name, leads.whatsapp_number, 
                             leads.refer_client_name, user.name
                            FROM leads
                      LEFT JOIN user ON leads.user_id = user.userId     
                      WHERE leads.brand_name IN ($brandList)  AND leads.del_status != 'Deleted'

                      ORDER BY leads.id DESC";
                                        } else {
                                            // If no brands are allowed for the user, return no leads
                                            die("No brands available for the Viewer.");
                                        }
                                    } else {
                                        $query = "SELECT leads.id, leads.campId, leads.client_name, leads.client_contact_number, 
                         leads.lead_landing_date, leads.client_country, leads.client_email, 
                         leads.brand_name, leads.whatsapp_name, leads.whatsapp_number, 
                         leads.refer_client_name, user.name
                  FROM leads
                  LEFT JOIN user ON leads.user_id = user.userId
                  LEFT JOIN `team` ON `user`.team_Id = team.teamId
                  WHERE leads.del_status != 'Deleted' And `user`.team_Id = $teamId
                  ORDER BY leads.id DESC";
                                    }


                                    $result = mysqli_query($conn, $query);

                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $leads[] = $row;
                                        }
                                    } else {
                                        die("Query failed: " . mysqli_error($conn));
                                    }


                                    return $leads;
                                }

                                $leads = getLeads($conn);
                                $orderSumQuery = "SELECT lead_id, COUNT(*) AS order_count FROM `order` GROUP BY lead_id";
                                $orderSumResult = mysqli_query($conn, $orderSumQuery);

                                $orderSum = [];
                                while ($row = mysqli_fetch_assoc($orderSumResult)) {
                                    $orderSum[$row['lead_id']] = $row['order_count'];
                                }

                                foreach ($leads as $lead) :
                                    $orderCount = isset($orderSum[$lead['id']]) ? $orderSum[$lead['id']] : 0;
                                    $orderLeadId = null;

                                    $orderQuery = "SELECT lead_id FROM `order` WHERE lead_id = " . $lead['id'];
                                    $sql = mysqli_query($conn, $orderQuery);

                                    if ($sql->num_rows > 0) {
                                        $orderRow = $sql->fetch_assoc();
                                        $orderLeadId = $orderRow['lead_id'];
                                    }
                                ?>
                                    <tr>
                                        <td><?php echo $lead['name']; ?></td>
                                        <td><?php echo $lead['campId']; ?></td>
                                        <td><?php echo $lead['client_name']; ?></td>
                                        <td><?php echo $lead['client_contact_number']; ?></td>
                                        <td><?php echo $lead['client_country']; ?></td>
                                        <td><?php echo $lead['client_email']; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($lead['lead_landing_date'])); ?></td>

                                        <?php if ($lead['id'] != $orderLeadId) { ?>
                                            <?php if ($_SESSION['role'] != 'Viewer') { ?>
                                                <form method="post" action="add-order">
                                                    <input type="hidden" name="l_id" value="<?php echo $lead['id']; ?>">
                                                    <td>
                                                        <button type="submit" name="add_lead_id" class="bg-secondary text-white px-3 rounded-pill">
                                                            <div class="col" tabindex="6">
                                                                <div class="d-flex bg-secondary align-items-center theme-icons shadow-sm cursor-pointer rounded-pill">
                                                                    <div class="text-white">
                                                                        <i class="fadeIn animated bx bx-pencil" style="font-size:17px;"></i>
                                                                    </div>
                                                                    <div class="ms-2">Convert order</div>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </td>
                                                </form>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <td>
                                                <?php if ($_SESSION['role'] != 'Viewer') { ?>
                                                    <form method="post" action="add-order">
                                                        <input type="hidden" name="l_id" value="<?php echo $lead['id']; ?>">
                                                        <button type="submit" name="add_lead_id" style="background-color: rgb(8 92 70);" class="text-white px-3 rounded-pill">
                                                            <div class="col" tabindex="6">
                                                                <div style="background-color: rgb(8 92 70);" class="d-flex align-items-center theme-icons shadow-sm cursor-pointer rounded-pill">
                                                                    <div class="text-white">
                                                                        <i class="fadeIn " style="font-size:17px;">
                                                                            <span class="position:relative translate-middle badge rounded-pill bg-danger"><?php echo $orderCount; ?></span>
                                                                        </i>
                                                                    </div>
                                                                    <div class="ms-2">Convert More</div>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </form>
                                                <?php } ?>
                                            </td>
                                        <?php } ?>

                                        <?php if ($_SESSION['role'] != 'Viewer') { ?>
                                            <form method="post" action="edit-lead">
                                                <input type="hidden" name="l_id" value="<?php echo $lead['id']; ?>">
                                                <td>
                                                    <button type="submit" name="edit_lead" class="btn btn-info text-white px-3 rounded-pill">
                                                        <div class="col" tabindex="6">
                                                            <div class="d-flex bg-info align-items-center theme-icons shadow-sm cursor-pointer rounded-pill">
                                                                <div class="text-white">
                                                                    <i class="fadeIn animated bx bx-pencil" style="font-size:17px;"></i>
                                                                </div>
                                                                <div class="ms-2">Edit</div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </td>
                                            </form>
                                        <?php } ?>

                                        <?php if ($_SESSION['role'] == 'Admin') { ?>
                                            <form method="post" action="" id="deleteLeadForm_<?php echo $lead['id']; ?>" onsubmit="return false;">
                                                <input type="hidden" name="l_id" value="<?php echo $lead['id']; ?>">
                                                <input type="hidden" name="creator_name" value="<?php echo $_SESSION['user']; ?>">
                                                <td>
                                                    <button type="button" class="bg-danger text-white px-3 rounded-pill" onclick="confirmKeyAndDelete('<?php echo $lead['id']; ?>')">
                                                        <div class="col">
                                                            <div class="d-flex bg-danger align-items-center theme-icons shadow-sm cursor-pointer rounded-pill">
                                                                <div class="text-white">
                                                                    <i class="fadeIn animated bx bx-trash" style="font-size:17px;"></i>
                                                                </div>
                                                                <div class="ms-2">Delete</div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </td>
                                            </form>
                                        <?php } ?>

                                        <td>
                                            <form action='view-all-leads' method='post'>
                                                <input type='hidden' name='detailleadid' value="<?php echo $lead['id'] ?>">
                                                <button type='submit' name='view-all-orders' class='btn btn-success'>View</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>





            <script>
                function confirmKeyAndDelete(leadId) {
                    Swal.fire({
                        title: 'Enter Deletion Key',
                        input: 'text',
                        inputLabel: 'Please enter the key to confirm deletion',
                        inputPlaceholder: 'Enter your key here',
                        showCancelButton: true,
                        confirmButtonText: 'Confirm',
                        preConfirm: (inputKey) => {
                            if (!inputKey) {
                                Swal.showValidationMessage('Key is required!');
                                return false;
                            } else {
                                return inputKey;
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const inputKey = result.value;
                            const formData = new FormData(document.getElementById('deleteLeadForm_' + leadId));
                            formData.append('inputKey', inputKey);
                            formData.append('action', 'delete_live_lead'); // Change the action here

                            $.ajax({
                                url: 'main_components/global.php',
                                type: 'POST',
                                data: formData,
                                processData: false,
                                contentType: false,
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status === 'success') {
                                        Swal.fire('Deleted!', response.message, 'success');
                                        location.reload(); // Reload page after deletion
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    Swal.fire('Error!', 'An error occurred during the deletion process.', 'error');
                                }
                            });
                        }
                    });
                }
            </script>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


            <script>
                const tableContainer = document.querySelector('.table-responsive');

                let isDown = false;
                let startX;
                let scrollLeft;

                tableContainer.addEventListener('mousedown', (e) => {
                    isDown = true;
                    tableContainer.classList.add('active');
                    startX = e.pageX - tableContainer.offsetLeft;
                    scrollLeft = tableContainer.scrollLeft;
                });

                tableContainer.addEventListener('mouseleave', () => {
                    isDown = false;
                    tableContainer.classList.remove('active');
                });

                tableContainer.addEventListener('mouseup', () => {
                    isDown = false;
                    tableContainer.classList.remove('active');
                });

                tableContainer.addEventListener('mousemove', (e) => {
                    if (!isDown) return; // Stop the function if not holding mouse
                    e.preventDefault();
                    const x = e.pageX - tableContainer.offsetLeft;
                    const walk = (x - startX) * 2; // Scroll-fast multiplier
                    tableContainer.scrollLeft = scrollLeft - walk;
                });
            </script>



            <?php require_once("./main_components/footer.php"); ?>