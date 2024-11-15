<?php



$TITLE = "View Core Leads"; ?>

<?php require_once("./main_components/header.php");





if (
    !isset($_SESSION['role']) ||
    ($_SESSION['role'] !== 'Admin' &&
        $userPermissions['view_core_lead'] !== 'Allow' &&
        $userPermissions['add_core_lead'] !== 'Allow')
) {
    echo "<script>window.location.href = 'index';</script>";
    exit();
}

?>

<style>
    .table-responsive {
        overflow: hidden;
        /* Hide scroll initially */
        cursor: grab;
        /* Change cursor to grab when hovering */
    }

    .table-responsive:active {
        cursor: grabbing;
        /* Change cursor when active (dragging) */
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


            if (isset($_SESSION['ecorelead'])) {

                echo "<script>alertify.success('{$_SESSION['ecorelead']}', { position: 'top-right' });</script>";

                unset($_SESSION['ecorelead']);
            }
            if (isset($_SESSION['dlead'])) {

                echo "<script>alertify.success('{$_SESSION['dlead']}', { position: 'top-right' });</script>";
                unset($_SESSION['dlead']);
            }
            ?>
            <div class="header-containerss">
                <h6 class="mb-0 text-uppercase">Core Leads</h6>
                <?php if ($userPermissions['add_core_lead'] == 'Allow'  || $_SESSION['role'] == 'Admin') : ?>

                    <a href="add-core-leads" class="btn btn-primary">Add New Lead</a>
                <?php endif; ?>

            </div>
            <div class="d-flex justify-content-end">
                <a href="import-core-leads" class="btn btn-primary" style="display:inline-block;">Import CSV</a> &nbsp;

                <!-- Export Button -->
                <form method="post" style="display:inline-block;">
                    <button type="submit" name="export_csv_core_lead" class="btn btn-success">Export CSV</button>
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
                                    <th>View </th>
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
                                        $query = "SELECT core_leads.id, core_leads.campId, core_leads.client_name, core_leads.client_contact_number, core_leads.lead_landing_date, core_leads.client_country, core_leads.client_email, core_leads.brand_name, core_leads.whatsapp_name, core_leads.whatsapp_number, core_leads.refer_client_name, user.name
                  FROM core_leads
                  LEFT JOIN user ON core_leads.user_id = user.userId WHERE core_leads.del_status != 'Deleted'
                  ORDER BY core_leads.id DESC";
                                    } else if ($role == 'Viewer') {
                                        $brands = getAllowedDisplayBrandsForUser($conn, $_SESSION['id']);



                                        if (!empty($brands)) {
                                            $brandNames = array();
                                            foreach ($brands as $brand) {
                                                $brandNames[] = "'" . $conn->real_escape_string($brand['brandpermission']) . "'";
                                            }

                                            $brandList = implode(',', $brandNames);



                                            $query = "SELECT core_leads.id, core_leads.campId, core_leads.client_name, core_leads.client_contact_number, core_leads.lead_landing_date, core_leads.client_country, core_leads.client_email, core_leads.brand_name, core_leads.whatsapp_name, core_leads.whatsapp_number, core_leads.refer_client_name, user.name
                      FROM core_leads
                      LEFT JOIN user ON core_leads.user_id = user.userId     
                      WHERE core_leads.brand_name IN ($brandList) AND core_leads.del_status != 'Deleted'
                      ORDER BY core_leads.id DESC";
                                        } else {
                                            die("No brands available for the Viewer.");
                                        }
                                    } else {
                                        $query = "SELECT core_leads.id, core_leads.campId, core_leads.client_name, core_leads.client_contact_number, core_leads.lead_landing_date, core_leads.client_country, core_leads.client_email, core_leads.brand_name, core_leads.whatsapp_name, core_leads.whatsapp_number, core_leads.refer_client_name, user.name
                  FROM core_leads
                  LEFT JOIN user ON core_leads.user_id = user.userId
                  LEFT JOIN `team` ON `user`.team_Id = team.teamId

                  WHERE core_leads.del_status != 'Deleted' And `user`.team_Id = $teamId
                  ORDER BY core_leads.id DESC";
                                    }



                                    $result = mysqli_query($conn, $query);

                                    if (!$result) {
                                        die("Query failed: " . mysqli_error($conn));
                                    }

                                    if ($result) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $leads[] = $row;
                                        }
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

                                        <?php if ($_SESSION['role'] != 'Viewer') { ?>
                                            <form method="post">
                                                <input type="hidden" name="l_id" value="<?php echo $lead['id']; ?>">
                                                <td>
                                                    <button type="submit" name="create-corelead-order" class="bg-secondary text-white px-3 rounded-pill">
                                                        <div class="col" tabindex="6">
                                                            <div class="d-flex bg-secondary align-items-center theme-icons shadow-sm cursor-pointer rounded-pill">
                                                                <div class="text-white">
                                                                    <i class="fadeIn animated bx bx-recycle" style="font-size:17px;"></i>
                                                                </div>
                                                                <div class="ms-2">Convert Leads</div>
                                                            </div>
                                                        </div>
                                                    </button>
                                                </td>
                                            </form>
                                        <?php } ?>



                                        <?php if ($_SESSION['role'] != 'Viewer') { ?>
                                            <form method="post" action="edit-core-lead">
                                                <input type="hidden" name="l_id" value="<?php echo $lead['id']; ?>">
                                                <td>
                                                    <button type="submit" name="edit_core_lead" class="btn btn-info text-white px-3 rounded-pill">
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
                                                    <button type="button" class="bg-danger text-white px-3 rounded-pill" onclick="confirmKeyAndDelete('<?php echo $lead['id']; ?>', '<?php echo $_SESSION['user']; ?>')">
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
                                            <form action='view-all-core-leads' method='post'>
                                                <input type='hidden' name='allleadid' value="<?php echo $lead['id'] ?>">
                                                <button type='submit' name='view-all-core-leads' class='btn btn-success'>View</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>





            <!-- SweetAlert Modal -->
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                function confirmKeyAndDelete(leadId, creatorName) {
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
                            $.ajax({
                                url: 'main_components/global.php',
                                type: 'POST',
                                data: {
                                    action: 'delete_lead',
                                    l_id: leadId,
                                    creator_name: creatorName,
                                    inputKey: inputKey
                                },
                                dataType: 'json',
                                success: function(response) {
                                    console.log("AJAX Response:", response);
                                    if (response.status === 'success') {
                                        Swal.fire('Deleted!', response.message, 'success');
                                        location.reload();
                                    } else {
                                        Swal.fire('Error!', response.message, 'error');
                                    }
                                },
                                error: function(xhr, status, error) {
                                    console.error("AJAX Error:", xhr.responseText);
                                    Swal.fire('Error!', 'An error occurred during the deletion process.', 'error');
                                }
                            });
                        }
                    });
                }
            </script>

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
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - tableContainer.offsetLeft;
                    const walk = (x - startX) * 2;
                    tableContainer.scrollLeft = scrollLeft - walk;
                });
            </script>

            <?php require_once("./main_components/footer.php"); ?>