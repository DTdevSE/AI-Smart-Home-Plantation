<?php
session_start();

/* ========== DATABASE ========== */

$conn = mysqli_connect("localhost","root","","final_project");

if(!$conn){
    die("Database Connection Failed");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$msg = "";

if(isset($_POST['save_sale'])){

    // Secure inputs
    $name    = trim($_POST['customer_name']);
    $email   = trim($_POST['email']);
    $mobile  = trim($_POST['mobile']);
    $product = trim($_POST['product_name']);
    $serial  = trim($_POST['serial_no']);
    $price   = trim($_POST['price']);

    /* ================= VALIDATIONS ================= */

    // Email validation
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $msg = "Invalid Email Address!";
    }

    // Mobile validation (Sri Lanka format)
    elseif(!preg_match("/^07[0-9]{8}$/", $mobile)){
        $msg = "Invalid Mobile Number! Use format 07XXXXXXXX";
    }

    else{

        /* ===== CHECK DUPLICATE SERIAL NUMBER ===== */

        $check = $conn->prepare("SELECT serial_no FROM sales WHERE serial_no=?");
        $check->bind_param("s",$serial);
        $check->execute();
        $result = $check->get_result();

        if($result->num_rows > 0){

            $msg = "This Serial Number already exists!";

        }else{

            /* ===== INSERT SALE ===== */

            $stmt = $conn->prepare("INSERT INTO sales
            (customer_name,email,mobile,product_name,serial_no,selling_price)
            VALUES (?,?,?,?,?,?)");

            $stmt->bind_param("sssssd",
                $name,
                $email,
                $mobile,
                $product,
                $serial,
                $price
            );

            if($stmt->execute()){

                /* ================= SEND EMAIL ================= */

                $mail = new PHPMailer(true);

                try{

                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;

                    // Gmail
                    $mail->Username   = 'dinithabc2001@gmail.com';
                    $mail->Password   = 'fapqskoummfkjicy';

                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = 587;

                    $mail->setFrom('dinithabc2001@gmail.com','Home Plantation');
                    $mail->addAddress($email,$name);

                    $mail->isHTML(true);
                    $mail->Subject = "Your Product Purchase Details";

                    $mail->Body = "
                    <h3>Hello $name,</h3>

                    <p>Thank you for purchasing our product.</p>

                    <b>Product:</b> $product <br>
                    <b>Serial No:</b> $serial <br>
                    <b>Price:</b> Rs. $price <br>
                    <b>Date:</b> ".date("Y-m-d H:i:s")."<br>

                    <br>
                    Please register your product using this link:
                    <br><br>

                    <a href='http://yourwebsite.com/register.php'>
                    Click Here to Register
                    </a>

                    <br><br>
                    Thank you for choosing Home Plantation 🌿
                    ";

                    $mail->send();

                    $msg = "Sale Saved & Email Sent Successfully!";

                }
                catch(Exception $e){

                    $msg = "Sale Saved, but Email Failed!";
                }

            }else{

                $msg = "Database Error!";
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Profile</title>

<!-- Favicon -->
<link rel="icon" href="img/core-img/favicon.ico">

<!-- Main Theme CSS -->
<link rel="stylesheet" href="style.css">

<!-- Font Awesome -->
<link rel="stylesheet" 
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    body{
        margin:0;
        
        background:#f3f3f3;
        display:flex;
        align-items:center;
        justify-content:center;
        min-height:100vh;
    }

    .sale-wrapper{
        width:850px;
        background:white;
        border-radius:20px;
        box-shadow:0 20px 40px rgba(0,0,0,0.1);
        display:flex;
        overflow:hidden;
    }

    .sale-left{
        width:40%;
        background:#70c745;
        color:white;
        display:flex;
        flex-direction:column;
        justify-content:center;
        align-items:center;
        padding:40px;
        text-align:center;
    }

    .sale-left i{
        font-size:70px;
        margin-bottom:20px;
    }

    .sale-right{
        width:60%;
        padding:40px;
    }

    .sale-right h2{
        margin-bottom:20px;
    }

    .sale-right input{
        width:100%;
        padding:10px;
        margin-bottom:15px;
        border-radius:8px;
        border:1px solid #ccc;
    }

    .sale-right input:focus{
        border-color:#70c745;
        outline:none;
    }

    .sale-right button{
        width:100%;
        padding:12px;
        background:#70c745;
        color:white;
        border:none;
        border-radius:8px;
        cursor:pointer;
    }

    .sale-right button:hover{
        background:#5fb13c;
    }

    .message{
        margin-bottom:15px;
        font-weight:500;
        color:green;
    }

    @media(max-width:768px){
        .sale-wrapper{
            flex-direction:column;
        }
        .sale-left,
        .sale-right{
            width:100%;
        }
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

<div class="sale-wrapper">

    <!-- LEFT SIDE (Green Panel like Profile) -->
    <div class="sale-left">
        <i class="fa fa-credit-card"></i>
        <h3>Add Product</h3>
        <p>Home Plantation System</p>
    </div>

    <!-- RIGHT SIDE -->
    <div class="sale-right">

        <h2>Save Sale</h2>

        <?php if(!empty($msg)){ ?>
            <div class="message"><?php echo $msg; ?></div>
        <?php } ?>

        <form method="POST">

            <input type="text" name="customer_name" placeholder="Customer Name" required>

            <input type="email" name="email" placeholder="Customer Email" required>

            <input type="text" name="mobile" maxlength="10" pattern="07[0-9]{8}" required>

            <input type="text" name="product_name" placeholder="Product Name" required>

            <input type="text" name="serial_no" placeholder="Serial Number" required>

            <input type="number" step="0.01" name="price" placeholder="Selling Price (Rs.)" required>

            <button type="submit" name="save_sale">
                Save Sale & Send Email
            </button>

        </form>
<div style="margin-top:20px;text-align:center;">
            <a href="admin/admin_dashboard.php">Home</a> |
            <a href="logout.php" style="color:red;">Logout</a>
        </div>
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