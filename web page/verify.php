<?php
session_start();

/* ===== DATABASE CONNECTION ===== */

$conn = mysqli_connect("localhost","root","","final_project");

if(!$conn){
    die("Database Error");
}

/* ===== CHECK SESSION ===== */

if(!isset($_SESSION['otp_email'])){
    header("Location: register.php");
    exit();
}

$msg = "";
$type = "";

/* ===== VERIFY OTP ===== */

if(isset($_POST['verify'])){

    $otp   = trim($_POST['otp']);
    $email = $_SESSION['otp_email'];

    if(empty($otp)){

        $msg = "Please enter OTP!";
        $type = "warn";

    }else{

        $check = mysqli_query($conn,
        "SELECT id FROM users
         WHERE email='$email'
         AND otp='$otp'
         AND is_verified=0");

        if(mysqli_num_rows($check)==1){

            // ✅ UPDATE USER AS VERIFIED
            mysqli_query($conn,
            "UPDATE users SET
             is_verified=1,
             otp=NULL
             WHERE email='$email'");

            unset($_SESSION['otp_email']);

            echo "<script>
            alert('Email Verified Successfully!');
            window.location='login.php';
            </script>";
            exit();

        }else{

            $msg = "Invalid OTP!";
            $type = "error";
        }
    }
}
?>


<!DOCTYPE html>
<html>
<head>
<title>Verify OTP</title>

<style>
body{
    background:#f3f3f3;
    font-family:Segoe UI;
}

.box{
    width:350px;
    background:white;
    margin:100px auto;
    padding:30px;
    border-radius:12px;
    text-align:center;
    box-shadow:0 0 15px rgba(0,0,0,.2);
}

input{
    width:100%;
    padding:12px;
    margin:15px 0;
    border:none;
    background:#f1f1f1;
    border-radius:8px;
}

button{
    width:100%;
    padding:12px;
    background:#4f9f7d;
    border:none;
    color:white;
    border-radius:8px;
    cursor:pointer;
}

.msg{
    padding:10px;
    margin-bottom:10px;
    border-radius:6px;
    font-size:14px;
}

.error{
    background:#ffe6e6;
    color:#b30000;
}

.warn{
    background:#fff7e6;
    color:#92400e;
}
</style>

</head>
<body>
    

<div class="box">

<h2>Verify OTP</h2>

<?php if($msg!=""){ ?>
<div class="msg <?php echo $type; ?>">
<?php echo $msg; ?>
</div>
<?php } ?>

<form method="POST">

<input type="text"
 name="otp"
 placeholder="Enter OTP"
 maxlength="6"
 required>

<button name="verify">
Verify
</button>

</form>

</div>

</body>
</html>
