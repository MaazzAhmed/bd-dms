<?php
use PHPMailer\PHPMailer\PHPMailer;
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dms";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// ------------------------Email Sending------------------------------------
function sendEmail($to, $subject, $messages, $attachments, $smtpConfig, $main_title) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host =$smtpConfig['servername'];
        $mail->SMTPAuth = true;
        $mail->Username = $smtpConfig['email'];
        $mail->Password = $smtpConfig['password'];
        $mail->Port = $smtpConfig['port'];
        $mail->SMTPSecure = 'tls';
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->setFrom($smtpConfig['email'], "$main_title");
        $mail->addAddress($to);
        $mail->IsHTML(true); 

        $mail->Subject = $subject;
        $mail->Body = $messages; 

        if (!empty($attachments['name'][0])) {
            foreach ($attachments['name'] as $key => $attachment_name) {
                $attachment_path = $attachments['tmp_name'][$key];
                $mail->addAttachment($attachment_path, $attachment_name);
            }
        }
        $mail->send();        
    } catch (Exception $e) {
        $_SESSION['eset1'] = "Error sending email: " . $mail->ErrorInfo;
    }
}

if (isset($_POST['submittemplate3'])) {
$to = $_POST['employee'];
$subject = $_POST['subject'];
$main_title = $_POST['main_title'];
$messages = $conn->real_escape_string($_POST['message']);
$emailSettingId = $_POST['email-setting-id'];  

$smtpConfig = getSmtpConfigurationss($conn, $emailSettingId);

if (!is_array($to)) {
    $to = array($to);
}

foreach ($to as $recipient) {
    sendEmail($recipient, $subject, $messages, $_FILES['attachment'], $smtpConfig, $main_title);
}
$_SESSION['email1'] = "Email sent successfully to selected employees.";
}

function getSmtpConfigurationss($conn, $id) {
$queryFetch = "SELECT * FROM email_setting WHERE id = ?";
$stmt = $conn->prepare($queryFetch);
$stmt->bind_param("i", $id);  
$stmt->execute();
$resultFetch = $stmt->get_result();

if ($rowFetch = $resultFetch->fetch_assoc()) {
    return [
        'servername' => $rowFetch['servername'],
        'port' => $rowFetch['port'],
        'email' => $rowFetch['email'],
        'password' => $rowFetch['password'],
    ];
} else {
    return [];  
}
}

?>
