<?php
session_start();

/* ========== DATABASE ========== */
$conn = mysqli_connect("localhost","root","","final_project");

if(!$conn){
    die("DB Error");
}

/* ========== PHPMailer ========== */
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

$alert = "";

/* ========== REGISTER ========== */
if(isset($_POST['register'])){

    $name   = trim($_POST['name']);
    $email  = trim($_POST['email']);
    $serial = strtoupper(trim($_POST['serial_no']));
    $pass   = $_POST['password'];
    $con    = $_POST['confirm'];

    if(empty($name) || empty($email) || empty($pass) || empty($con) || empty($serial)){
        $alert = "Please fill all fields!";
    }
    elseif($pass != $con){
        $alert = "Passwords do not match!";
    }
    elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $alert = "Invalid Email Address!";
    }
    elseif(!preg_match("/^[A-Z0-9-]+$/", $serial)){
        $alert = "Invalid Serial Number Format!";
    }
    else{

        /* CHECK EMAIL */
        $checkEmail = mysqli_query($conn,"SELECT id FROM users WHERE email='$email'");
        if(mysqli_num_rows($checkEmail) > 0){
            $alert = "Email already registered!";
        }
        else{

            /* CHECK SERIAL EXISTS */
            $checkSerial = mysqli_query($conn,"SELECT id FROM sales WHERE serial_no='$serial'");
            if(mysqli_num_rows($checkSerial) == 0){
                $alert = "Invalid Serial Number!";
            }
            else{

                /* CHECK SERIAL NOT USED */
                $checkUsed = mysqli_query($conn,"SELECT id FROM users WHERE serial_no='$serial'");
                if(mysqli_num_rows($checkUsed) > 0){
                    $alert = "This Serial Number is already registered!";
                }
                else{

                    /* INSERT USER */
                    $hash = password_hash($pass,PASSWORD_DEFAULT);
                    $otp  = rand(100000,999999);

                    $insert = mysqli_query($conn,
                            "INSERT INTO users
                            (name,email,password,serial_no,otp,is_verified,role)
                            VALUES
                            ('$name','$email','$hash','$serial','$otp',0,'customer')");


                    if($insert){

                        $_SESSION['otp_email'] = $email;

                        /* SEND EMAIL */
                        try{

                            $mail = new PHPMailer(true);

                            $mail->isSMTP();
                            $mail->Host = "smtp.gmail.com";
                            $mail->SMTPAuth = true;
                            $mail->Username = "dinithabc2001@gmail.com";
                            $mail->Password = "fapqskoummfkjicy"; 
                            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                            $mail->Port = 587;

                            $mail->setFrom("dinithabc2001@gmail.com","Home Plantation");
                            $mail->addAddress($email);

                            $mail->isHTML(true);
                            $mail->Subject = "OTP Verification";
                            $mail->Body = "
                                Hello $name,<br><br>
                                Your OTP Code: <b>$otp</b><br><br>
                                Serial Number: <b>$serial</b><br><br>
                                Thank you for registering 🌿
                            ";

                            $mail->send();

                            echo "<script>
                            alert('OTP sent to your email');
                            window.location='verify.php';
                            </script>";
                            exit();

                        }catch(Exception $e){
                            $alert = "Email sending failed! Check App Password.";
                        }

                    }else{
                        $alert = "Registration failed!";
                    }
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Register</title>

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Segoe UI', sans-serif;
}

body{
    height:100vh;
    overflow:hidden;
    background:#f3f3f3;
}

/* Main Container */
.container{
    display:flex;
    width:100%;
    height:100vh;
}

/* ================= LEFT FORM SIDE ================= */

.form-section{
    width:50%;
    display:flex;
    justify-content:center;
    align-items:center;
    z-index:2;
    background:#f3f3f3;
}

.form-box{
    width:380px;
    padding:40px;
    background:#ffffff;
    border-radius:20px;
    box-shadow:0 15px 40px rgba(0,0,0,0.15);
    animation:fadeIn 1s ease;
}

.form-box h2{
    text-align:center;
    margin-bottom:25px;
    color:#333;
}

.input-group{
    margin-bottom:18px;
}

.input-group input{
    width:100%;
    padding:14px;
    border:none;
    background:#f1f1f1;
    border-radius:10px;
    font-size:14px;
    transition:0.3s;
}

.input-group input:focus{
    outline:none;
    background:#e8f5e9;
}

button{
    width:100%;
    padding:14px;
    background:#4f9f7d;
    border:none;
    color:white;
    font-size:16px;
    border-radius:10px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#3d8366;
}

.extra-text{
    text-align:center;
    margin-top:15px;
    font-size:14px;
}

.extra-text a{
    color:#000;
    font-weight:600;
    text-decoration:none;
}

/* ================= RIGHT CONTENT SIDE ================= */

.content-section{
    width:50%;
    background:linear-gradient(135deg,#5aa382,#3f8f6c);
    display:flex;
    justify-content:center;
    align-items:center;
    position:relative;

    border-top-left-radius:300px;
    border-bottom-left-radius:300px;

    animation:slideIn 1.2s ease;
}

.content-section h1{
    color:white;
    font-size:60px;
    font-weight:700;
    opacity:0;
    transform:translateX(40px);
    animation:textFade 1.5s ease forwards;
    animation-delay:0.5s;
}

/* ================= Animations ================= */

@keyframes slideIn{
    from{
        transform:translateX(100%);
    }
    to{
        transform:translateX(0);
    }
}

@keyframes textFade{
    to{
        opacity:1;
        transform:translateX(0);
    }
}

@keyframes fadeIn{
    from{
        opacity:0;
        transform:translateY(20px);
    }
    to{
        opacity:1;
        transform:translateY(0);
    }
}

/* ================= Responsive ================= */

@media(max-width:900px){
    .container{
        flex-direction:column;
    }

    .form-section,
    .content-section{
        width:100%;
        height:50vh;
    }

    .content-section{
        border-radius:0;
    }

    .content-section h1{
        font-size:40px;
    }
}
.form-links{
    margin-top:15px;
    text-align:center;
}



.signup-text{
    font-size:14px;
    color:#555;
}

.signup-link{
    color:#4f9f7d;
    font-weight:600;
    text-decoration:none;
    margin-left:5px;
    transition:0.3s;
}

.signup-link:hover{
    text-decoration:underline;
    color:#3d8366;
}

</style>
</head>

<body>

<div class="container">

    <!-- LEFT FORM -->
    <div class="form-section"method="POST">
        <div class="form-box">
            <h2>Sign Up</h2>
           <?php if($alert != ""){ ?>
    <div style="
        margin-bottom:15px;
        color:#b30000;
        border-radius:8px;
        text-align:center;">
        <?php echo $alert; ?>
    </div>
<?php } ?>

          <form method="POST">

    <div class="input-group">
        <input type="text" name="name" placeholder="Username" required>
    </div>

    <div class="input-group">
        <input type="email" name="email" placeholder="Email" required>
    </div>
    <div class="input-group">
       <input type="text" name="serial_no" placeholder="Product Serial Number" required>

    </div>

    <div class="input-group">
        <input type="password" name="password" placeholder="Password" required>
    </div>

    <div class="input-group">
        <input type="password" name="confirm" placeholder="Confirm password" required>
    </div>

    <button type="submit" name="register">
        Sign up
    </button>
    <div class="form-links">

   

    <p class="signup-text">
        Do you have an account?
        <a href="login.php" class="signup-link">
            Sign in here
        </a>
    </p>

</div>

</form>


        </div>
    </div>

    <!-- RIGHT GREEN CURVE CONTENT -->
    <div class="content-section">
        <h1>Join with us</h1>
    </div>

</div>

</body>
</html>