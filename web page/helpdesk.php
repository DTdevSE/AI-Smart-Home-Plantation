<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","final_project");
if(!$conn){
    die("Database Error");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$user_id = $_SESSION['user_id'];
$msg = "";

/* ===== GET USER EMAIL FROM DATABASE ===== */
$user_query = mysqli_query($conn,"SELECT name,email FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($user_query);
$customer_name = $user['name'];
$customer_email = $user['email'];

if(isset($_POST['submit_ticket'])){

    $issue_type = mysqli_real_escape_string($conn,$_POST['issue_type']);
    $subject = mysqli_real_escape_string($conn,$_POST['subject']);
    $description = mysqli_real_escape_string($conn,$_POST['description']);

    $query = "INSERT INTO helpdesk_tickets
              (user_id, issue_type, subject, description)
              VALUES
              ('$user_id','$issue_type','$subject','$description')";

    if(mysqli_query($conn,$query)){

        /* ================= EMAIL SECTION ================= */

        $mail = new PHPMailer(true);

        try{

            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'dinithabc2001@gmail.com';   // CHANGE
            $mail->Password   = 'fapqskoummfkjicy';     // CHANGE
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            /* ===== SEND TO CUSTOMER ===== */
            $mail->setFrom('dinithabc2001@gmail.com','Home Plantation Support');
            $mail->addAddress($customer_email, $customer_name);

            $mail->isHTML(true);
            $mail->Subject = "Your Help Desk Request Has Been Received";

            $mail->Body = "
            <h2>Hello $customer_name,</h2>

            <p>Thank you for contacting <b>Home Plantation Support Team</b>.</p>

            <p><b>Issue Type:</b> $issue_type</p>
            <p><b>Subject:</b> $subject</p>

            <p>Your complaint has been successfully submitted. Our support team will contact you shortly.</p>

            <hr>

            <h3>Support Contact Information</h3>
            <p><b>Email:</b> dinithabc2001@gmail.com</p>
            <p><b>Mobile:</b> +94 7509248744</p>
            <p><b>Zoom Support Link:</b><br>
            <a href='https://zoom.us/j/yourmeetingid'>Join Zoom Meeting</a></p>

            <br>
            Thank you for choosing Home Plantation 🌿
            ";

            $mail->send();

            /* ===== SEND TO ADMIN ===== */
            $mail->clearAddresses();
            $mail->addAddress("dinithabc2001@gmail.com","Admin");

            $mail->Subject = "New Help Desk Complaint Submitted";

            $mail->Body = "
            <h3>New Complaint Received</h3>

            <p><b>Customer Name:</b> $customer_name</p>
            <p><b>Email:</b> $customer_email</p>
            <p><b>Issue Type:</b> $issue_type</p>
            <p><b>Subject:</b> $subject</p>
            <p><b>Description:</b><br>$description</p>

            <br>
            Please login to admin panel to respond.
            ";

            $mail->send();

            $msg = "Complaint Submitted Successfully & Email Sent!";

        }catch(Exception $e){
            $msg = "Complaint Submitted, but Email Failed!";
        }

    } else {
        $msg = "Error Submitting Complaint!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Help Desk</title>
<!-- Favicon -->
<link rel="icon" href="img/core-img/favicon.ico">

<!-- Main Theme CSS -->
<link rel="stylesheet" href="style.css">

<!-- Font Awesome -->
<link rel="stylesheet" 
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
body{
    font-family:Poppins;
    background:#f3f3f3;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}
.card{
    width:600px;
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 20px 40px rgba(0,0,0,0.1);
}
input, select, textarea{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border-radius:8px;
    border:1px solid #ccc;
}
button{
    background:#70c745;
    color:white;
    padding:12px;
    border:none;
    border-radius:8px;
    width:100%;
}
</style>
</head>
<body>
  <!-- Preloader -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-circle"></div>
        <div class="preloader-img">
            <img src="img/core-img/leaf.png" alt="">
        </div>
       
    </div>

    <div class="leaf-wrapper">
    <img src="img/core-img/leaf.png" class="leaf-img" alt="Leaf">
</div>

<div class="card">

<h2>Help Desk - Submit Complaint</h2>

<?php if(!empty($msg)) echo "<p style='color:green;'>$msg</p>"; ?>

<form method="POST">

<select name="issue_type" required>
    <option value="">Select Issue Type</option>
    <option value="Hardware">Hardware Issue</option>
    <option value="Software">Software Issue</option>
</select>

<input type="text" name="subject" placeholder="Issue Subject" required>

<textarea name="description" rows="4" placeholder="Describe your issue..." required></textarea>

<button type="submit" name="submit_ticket">
Submit Complaint
</button>

</form>
 <div style="margin-top:20px;text-align:center;">
            <a href="index.php">Home</a> |
            <a href="logout.php" style="color:red;">Logout</a>
        </div>

</div>
<!-- JS Files -->
<script src="js/jquery/jquery-2.2.4.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/plugins/plugins.js"></script>
<script src="js/active.js"></script>
<!-- ##### Footer Area End ##### -->


    <!-- ##### All Javascript Files ##### -->
    <!-- jQuery-2.2.4 js -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/bootstrap/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap/bootstrap.min.js"></script>
    <!-- All Plugins js -->
    <script src="js/plugins/plugins.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>

</body>
</html>