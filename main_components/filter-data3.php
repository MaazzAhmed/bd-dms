<?php 

require_once("configration.php");
session_start();
$ipFilter = isset($_POST['ipFilter']) ? $_POST['ipFilter'] : '';
$currentPage = isset($_POST['currentPage']) ? $_POST['currentPage'] : 1;
$recordsPerPage = isset($_POST['recordsPerPage']) ? $_POST['recordsPerPage'] : 25;

$secondfilter = isset($_POST['secondfilter']) ? $_POST['secondfilter'] : '';
$client_email = isset($_POST['client_email']) ? $_POST['client_email'] : '';
$offset = ($currentPage - 1) * $recordsPerPage;

$teamId = isset($_SESSION['team_id']) ? $_SESSION['team_id'] : '';

if ($_SESSION['role'] == 'Admin') {
$sql = "SELECT `order`.*, user.name,user.team_Id, leads.campId, leads.client_name, leads.client_contact_number, 
leads.lead_landing_date,leads.client_email, leads.client_info, leads.lead_source
FROM `order`
LEFT JOIN user ON `order`.user_id = user.userId
LEFT JOIN leads ON `order`.lead_id = leads.id
WHERE 1 ";
}

else {
    $sql = "SELECT `order`.*, user.name,user.team_Id, leads.campId, leads.client_name, leads.client_contact_number, 
leads.lead_landing_date,leads.client_email, leads.client_info, leads.lead_source
FROM `order`
LEFT JOIN user ON `order`.user_id = user.userId
LEFT JOIN leads ON `order`.lead_id = leads.id
            WHERE user.team_Id = '$teamId'";
         
}

if (!empty($ipFilter)) {
    $sql .= " AND (`leads`.client_email LIKE '%$ipFilter%' OR `order`.order_id_input LIKE '%$ipFilter%' OR  order.order_title LIKE '%$ipFilter%'  OR  leads.client_contact_number LIKE '%$ipFilter%'  OR  leads.client_name LIKE '%$ipFilter%')";
}


if (!empty($secondfilter)) {
    $sql .= " AND (`leads`.client_email LIKE '%$secondfilter%' OR `order`.order_id_input LIKE '%$secondfilter%' OR  order.order_title LIKE '%$secondfilter%'  OR  leads.client_contact_number LIKE '%$secondfilter%'  OR  leads.client_name LIKE '%$secondfilter%')";
}


$sql .= " ORDER BY `order`.orderId DESC ";

echo "Debug: SQL Query: $sql";

$totalRecordsQuery = "SELECT COUNT(*) as total FROM ($sql) AS subquery";


$totalRecordsResult = $conn->query($totalRecordsQuery);

if ($totalRecordsResult === false) {
    echo "Debug: MySQL Error: " . $conn->error;
    exit; 
}

$totalRecords = $totalRecordsResult->fetch_assoc()['total'];

$sql .= " LIMIT $offset, $recordsPerPage";

$result = $conn->query($sql);
$idCounter = 1;

if ($result === false) {
    echo "Debug: MySQL Error: " . $conn->error;
    exit; 
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        
        date_default_timezone_set('Asia/Karachi');
        $currentDate = date("Y-m-d");
    
        $deadlineDate = date("Y-m-d", strtotime($row['final_deadline_time']));
    
        $isTodayDeadline = ($currentDate == $deadlineDate);
        
        echo "<tr class='bold'>";
        echo "<td>{$idCounter}</td>";
        echo "<td>{$row['client_info']}</td>";
        echo "<td>{$row['lead_source']}</td>";
        echo "<td>{$row['order_id_input']}</td>";
        echo "<td>{$row['client_name']}</td>";
        echo "<td>{$row['client_email']}</td>";
        echo "<td>{$row['client_contact_number']}</td>";
        echo "<td>{$row['order_title']}</td>"; 
        if($row['order_status'] == 'Follow up'){
            echo "<td style='background-color: #e6b8af;'><span class='badge' style='background-color: #e6b8af;'>{$row['order_status']}</span></td>";
        }
        elseif($row['order_status'] == 'Revision'){
            echo "<td style='background-color: #9bbb59;'><span class='badge' style='background-color: #9bbb59;'>{$row['order_status']}</span></td>";
        }
        elseif($row['order_status'] == 'File not received'){
            echo "<td style='background-color: #ff00ff;'><span class='badge' style='background-color: #ff00ff;'>{$row['order_status']}</span></td>";
        }
        elseif($row['order_status'] == 'Refund/Deadline'){
            echo "<td style='background-color: Red;'><span class='badge' style='background-color: Red;'>{$row['order_status']}</span></td>";
        }
        elseif($row['order_status'] == 'Half Payment'){
            echo "<td style='background-color: Black;color:white;'><span class='badge' style='background-color: Black;color:white;'>{$row['order_status']}</span></td>";
        }
        elseif($row['order_status'] == 'Converted'){
            echo "<td  style='background-color: #320f99;'><span class='badge' style='background-color: #320f99;'>{$row['order_status']}</span></td>";
        }
        elseif($row['order_status'] == 'Delivered'){
            echo "<td style='background-color: #00ffff;'><span class='badge' style='background-color: #00ffff;'>{$row['order_status']}</span></td>";
        }
        else {
            echo "<td>{$row['order_status']}</td>";
        }
        if ($row['payment_status'] == 'Full Payment') {
            echo "<td style='background-color: Yellow;'><span class='badge' style='color: grey ;'>{$row['payment_status']}</span></td>";
        } 
        elseif($row['payment_status'] == 'Half Payment'){
            echo "<td style='background-color: Black;color:white;'><span class='badge' style='background-color: Black;color:white;'>{$row['payment_status']}</span></td>";
        }
        else {
            echo "<td>{$row['payment_status']}</td>";
        }
        echo "<td>{$row['pending_payment']}</td>";
        echo "<td>{$row['receive_payment']}</td>";
        echo "<td>{$row['currency']}</td>";
        echo '<td' . ($isTodayDeadline ? ' style="background-color: red;"' : '') . '>' . date('d-M-Y h:i a', strtotime($row['final_deadline_time'])) . '</td>';
        echo "<td>" . date("j-F-Y", strtotime($row['order_confirmation_date'])) . "</td>";
        echo "<td class='mt-4'><a href='#invoiceModal' class='open-invoice btn btn-secondary' data-invoice-id='{$row['lead_id']}' data-toggle='modal'>Open Template</a>

        </td>";

        echo "<td>
         <form method='post' action='edit-order'>
        <input type='hidden' name='order_id' value='{$row['orderId']}'>
        <button type='submit' class='btn btn-info ' name='edit_order'>Edit</button>
    </form> </td>";
     if ( $_SESSION['role'] == 'Admin'){
         echo "<td>
         <form method='post' onsubmit='return confirm('Are you sure you want to delete this order?');'>
        <input type='hidden' name='order_id' value='{$row['orderId']}'>
        <input type='hidden' name='deleted_name' value='{$Session['name']}'>
        <input type='hidden' name='order_title' value='{$row['order_title']}'>
        <button type='submit' class='btn btn-danger ' name='delete_order'>Delete</button>
    </form> </td>";
     }
        echo "<td>
        <form action='view-all-orders' method='post'>
        <input type='hidden' name='allordersid' value='{$row['orderId']}'>
        <button type='submit' name='view-all-orders' class='btn btn-success'>View</button>
        </form>
        </td>";
        echo "</tr>";
        $idCounter++; 
    }
} else {
    echo "<tr><td colspan='4'>No records found</td></tr>";
}

$conn->close();

$totalPages = ceil($totalRecords / $recordsPerPage);

echo '<tr><td colspan="4"><nav aria-label="Page navigation example"><ul class="pagination">';

if ($currentPage > 1) {
    echo "<li class='page-item'><a class='page-link pagination-link' href='#' data-page='" . ($currentPage - 1) . "'>Previous</a></li>";
}
for ($i = 1; $i <= $totalPages; $i++) {
    echo "<li class='page-item " . ($i == $currentPage ? 'active' : '') . "'><a class='page-link pagination-link' href='#' data-page='$i'>$i</a></li>";
}
if ($currentPage < $totalPages) {
    echo "<li class='page-item'><a class='page-link pagination-link' href='#' data-page='" . ($currentPage + 1) . "'>Next</a></li>";
}
echo '</ul></nav></td></tr>';
?>
