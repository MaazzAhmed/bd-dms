<?php 

require_once("configration.php");
session_start();

$ipFilter = isset($_POST['ipFilter']) ? $_POST['ipFilter'] : '';
$currentPage = isset($_POST['currentPage']) ? $_POST['currentPage'] : 1;
$recordsPerPage = isset($_POST['recordsPerPage']) ? $_POST['recordsPerPage'] : 25;

$month = isset($_POST['month']) ? $_POST['month'] : '';
$client_email = isset($_POST['client_email']) ? $_POST['client_email'] : '';
$offset = ($currentPage - 1) * $recordsPerPage;

$teamId = isset($_SESSION['team_id']) ? $_SESSION['team_id'] : '';


if ($_SESSION['role'] == 'Admin') {
$sql = "SELECT `order`.*, user.name, leads.campId, leads.client_name, leads.client_contact_number, 
leads.lead_landing_date,leads.client_email
FROM `order`
LEFT JOIN user ON `order`.user_id = user.userId
LEFT JOIN leads ON `order`.lead_id = leads.id
WHERE 1";
 }
    else {
        $sql = "SELECT `order`.*, user.name, leads.campId, leads.client_name, leads.client_contact_number, 
leads.lead_landing_date,leads.client_email
FROM `order`
LEFT JOIN user ON `order`.user_id = user.userId
LEFT JOIN leads ON `order`.lead_id = leads.id
                WHERE user.team_Id = '$teamId'";
             
    }
    

if (!empty($ipFilter)) {
    $sql .= " AND (`order`.order_id_input LIKE '%$ipFilter%' )";
}

if (!empty($month)) {
    $sql .= " AND (`order`.order_confirmation_month LIKE '%$month%')";
}
if (!empty($client_email)) {
    $sql .= " AND (`leads`.client_email LIKE '%$client_email%')";
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
        echo "<tr class='bold'>";
    
        echo "<td>{$idCounter}</td>";
        echo "<td>{$row['order_id_input']}</td>";
        echo "<td>{$row['campId']}</td>";
        echo "<td>{$row['order_title']}</td>";
       
        
        echo "<td>{$row['client_email']}</td>";
        echo "<td>" . date("j-F-Y", strtotime($row['order_confirmation_date'])) . "</td>";
        if ($row['order_status'] == 'Full Payment') {
            echo "<td style='background-color: Yellow; align-items:center;'><span class='badge' style='color: grey;'>{$row['order_status']}</span></td>";
        } 
        elseif($row['order_status'] == 'Follow up'){
            echo "<td style='background-color: #e6b8af;'><span class='badge' style='background-color: #e6b8af;'>{$row['order_status']}</span></td>";
        }
        elseif($row['order_status'] == 'Revision'){
            echo "<td style='background-color: #9bbb59;'><span class='badge' style='background-color: #9bbb59;'>{$row['order_status']}</span></td>";
        }
        elseif($row['order_status'] == 'File not received'){
            echo "<td style='background-color: #ff00ff;align-items:center;'><span class='badge' style='background-color: #ff00ff;'>{$row['order_status']}</span></td>";
        }
        elseif($row['order_status'] == 'Refund/Deadline'){
            echo "<td style='background-color: Red;'><span class='badge' style='background-color: Red;'>{$row['order_status']}</span></td>";
        }
        elseif($row['order_status'] == 'Half Payment'){
            echo "<td style='background-color: Black;'><span class='badge' style='background-color: Black;color:white;'>{$row['order_status']}</span></td>";
        }
        elseif($row['order_status'] == 'Converted'){
            echo "<td style='background-color: #320f99;'><span class='badge' style='background-color: #320f99;'>{$row['order_status']}</span></td>";
        }
        elseif($row['order_status'] == 'Delivered'){
            echo "<td style='background-color: #00ffff;'><span class='badge' style='background-color: #00ffff;'>{$row['order_status']}</span></td>";
        }
        else {
            echo "<td>{$row['order_status']}</td>";
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
