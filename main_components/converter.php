<?php 

require_once("configration.php");
session_start();


function getUserData($conn, $tableName, $userIdColumn, $userId){
    $query = "Select * from $tableName where $userIdColumn = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $userData = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    return $userData;

}

$ipFilter = isset($_POST['ipFilter']) ? $_POST['ipFilter'] : '';
$currentPage = isset($_POST['currentPage']) ? $_POST['currentPage'] : 1;
$recordsPerPage = isset($_POST['recordsPerPage']) ? $_POST['recordsPerPage'] : 25;

$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : '';
$endDate = isset($_POST['endDate']) ? $_POST['endDate'] : '';
$offset = ($currentPage - 1) * $recordsPerPage;


$teamId = isset($_SESSION['team_id']) ? $_SESSION['team_id'] : '';
$userid = $_SESSION['id'] ?? '';


$userDetails = getUserData($conn, 'user', 'userId', $_SESSION['id']);

global $userDetails;

if ($_SESSION['role'] == 'Admin') {
    $sql = "
        SELECT 
            `order`.*,  
            leads.client_email, 
            leads.client_name, 
            recent_payments.receive_payment AS latest_received, 
            recent_payments.pending_payment AS latest_pending, 
            recent_payments.currency AS currency
        FROM 
            `order`
        LEFT JOIN 
            leads ON `order`.lead_id = leads.id
        LEFT JOIN (
            SELECT 
                op1.order_id, 
                op1.receive_payment, 
                op1.pending_payment, 
                op1.currency
            FROM 
                order_payments op1
            INNER JOIN (
                SELECT 
                    order_id, 
                    MAX(timestamp) AS max_timestamp
                FROM 
                    order_payments
                WHERE 
                    del_status != 'Deleted'
                GROUP BY 
                    order_id
            ) op2 ON op1.order_id = op2.order_id 
            AND op1.timestamp = op2.max_timestamp
            WHERE 
                op1.del_status != 'Deleted'
        ) AS recent_payments ON `order`.orderId = recent_payments.order_id
    ";
}
else if($_SESSION['role'] == 'Manager' || $_SESSION['role'] == 'Executive' && isset($userDetails['leads_order_view']) && $userDetails['leads_order_view'] != 'Deny' ) {
    $sql = "
        SELECT 
            `order`.*, 
            user.name, 
            leads.client_email, 
            leads.client_name, 
            recent_payments.receive_payment AS latest_received, 
            recent_payments.pending_payment AS latest_pending, 
            recent_payments.currency AS currency
        FROM 
            `order`
        LEFT JOIN 
            leads ON `order`.lead_id = leads.id
        LEFT JOIN 
            user ON `order`.user_id = user.userId
        LEFT JOIN (
            SELECT 
                op1.order_id, 
                op1.receive_payment, 
                op1.pending_payment, 
                op1.currency
            FROM 
                order_payments op1
            INNER JOIN (
                SELECT 
                    order_id, 
                    MAX(timestamp) AS max_timestamp
                FROM 
                    order_payments
                WHERE 
                    del_status != 'Deleted'
                GROUP BY 
                    order_id
            ) op2 ON op1.order_id = op2.order_id 
            AND op1.timestamp = op2.max_timestamp
            WHERE 
                op1.del_status != 'Deleted'
        ) AS recent_payments ON `order`.orderId = recent_payments.order_id
        WHERE 
            user.team_Id = '$teamId'
    ";
}else{
    $sql = "
    SELECT 
        `order`.*, 
        user.name, 
        leads.client_email, 
        leads.client_name, 
        recent_payments.receive_payment AS latest_received, 
        recent_payments.pending_payment AS latest_pending, 
        recent_payments.currency AS currency
    FROM 
        `order`
    LEFT JOIN 
        leads ON `order`.lead_id = leads.id
    LEFT JOIN 
        user ON `order`.user_id = user.userId
    LEFT JOIN (
        SELECT 
            op1.order_id, 
            op1.receive_payment, 
            op1.pending_payment, 
            op1.currency
        FROM 
            order_payments op1
        INNER JOIN (
            SELECT 
                order_id, 
                MAX(timestamp) AS max_timestamp
            FROM 
                order_payments
            WHERE 
                del_status != 'Deleted'
            GROUP BY 
                order_id
        ) op2 ON op1.order_id = op2.order_id 
        AND op1.timestamp = op2.max_timestamp
        WHERE 
            op1.del_status != 'Deleted'
    ) AS recent_payments ON `order`.orderId = recent_payments.order_id
    WHERE 
        user.userId = '$userid'
";
}




if (!empty($ipFilter)) {
    $sql .= " AND (order_confirmation_month LIKE '%$ipFilter%' OR order_status LIKE '%$ipFilter%')";
}

$sql .= " ORDER BY orderId DESC";

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
        echo "<td>{$row['client_name']}</td>";
        echo "<td>{$row['client_email']}</td>";

        echo "<td>{$row['order_title']}</td>";
        if ($row['order_status'] == 'Full Payment') {
            echo "<td><span class='badge' style='background-color: Yellow;'>{$row['order_status']}</span></td>";
        } 
        elseif($row['order_status'] == 'Follow up'){
            echo "<td><span class='badge' style='background-color: #e6b8af;'>{$row['order_status']}</span></td>";
        }
        elseif($row['order_status'] == 'Revision'){
            echo "<td><span class='badge' style='background-color: #9bbb59;'>{$row['order_status']}</span></td>";
        }
        elseif($row['order_status'] == 'File not received'){
            echo "<td><span class='badge' style='background-color: #ff00ff;'>{$row['order_status']}</span></td>";
        }
        elseif($row['order_status'] == 'Refund/Deadline'){
            echo "<td><span class='badge' style='background-color: Red;'>{$row['order_status']}</span></td>";
        }
        elseif($row['order_status'] == 'Half Payment'){
            echo "<td><span class='badge' style='background-color: Black;color:white;'>{$row['order_status']}</span></td>";
        }
        elseif($row['order_status'] == 'Converted'){
            echo "<td><span class='badge' style='background-color: #320f99;'>{$row['order_status']}</span></td>";
        }
        elseif($row['order_status'] == 'Delivered'){
            echo "<td><span class='badge' style='background-color: #00ffff;'>{$row['order_status']}</span></td>";
        }
        else {
            echo "<td>{$row['order_status']}</td>";
        }
        echo "<td>{$row['word_count']}</td>";
        echo "<td  data-bs-toggle='tooltip' data-bs-placement='top' title='{$row['pending_payment_status']}'>{$row['latest_pending']}</td>";
        echo "<td>{$row['latest_received']}</td>";
        echo "<td>{$row['currency']}</td>";
        echo "<td>" . date("j-F-Y", strtotime($row['order_confirmation_date'])) . "</td>";
        // if($_SESSION['role'] == 'Admin'){
        echo "<td> <button class='btn btn-info convertButton' data-receive-payment='{$row['latest_received']}' data-currency='{$row['currency']}'>Convert</button></td>";
        // }
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
