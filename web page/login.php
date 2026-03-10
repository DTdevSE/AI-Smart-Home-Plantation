<?php
session_start();

$conn = mysqli_connect("localhost","root","","final_project");
if(!$conn){
    die("Database Error");
}

$msg = "";

/* ===== Prevent Access If Already Logged In ===== */
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true){
    if($_SESSION['role'] === 'admin'){
        header("Location: admin/admin_dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit();
}

/* ===== LOGIN PROCESS ===== */
if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $pass  = $_POST['password'];

    if(empty($email) || empty($pass)){
        $msg = "<span style='color:#b30000'>Please fill all fields!</span>";
    } else {

        $query = mysqli_query($conn,"
            SELECT * FROM users
            WHERE email='$email'
            AND is_verified=1
            LIMIT 1
        ");

        if(mysqli_num_rows($query) === 1){

            $row = mysqli_fetch_assoc($query);

            if(password_verify($pass, $row['password'])){

                // 🔐 Regenerate Session ID (Security)
                session_regenerate_id(true);

                $_SESSION['logged_in'] = true;
                $_SESSION['user_id']   = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['role']      = strtolower($row['role']);
                $_SESSION['login_time'] = time();

                if($_SESSION['role'] === 'admin'){
                    header("Location: admin/admin_dashboard.php");
                } else {
                    header("Location: index.php");
                }
                exit();

            } else {
                $msg = "<span style='color:#b30000'>Incorrect Credentials!</span>";
            }

        } else {
            $msg = "<span style='color:#b30000'>Email not verified or not registered!</span>";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI',sans-serif;
}

body{
    height:100vh;
    overflow:hidden;
    background:#f3f3f3;
}

/* Main Layout */
.container{
    display:flex;
    width:100%;
    height:100vh;
}

/* LEFT GREEN CURVED SECTION */
.left-section{
    width:55%;
    background:linear-gradient(135deg,#5aa382,#3f8f6c);
    display:flex;
    justify-content:center;
    align-items:center;
    border-top-right-radius:300px;
    border-bottom-right-radius:300px;
    animation:slideIn 1s ease;
}

.left-section h1{
    color:white;
    font-size:70px;
    font-weight:700;
    opacity:0;
    transform:translateX(-40px);
    animation:textFade 1.5s ease forwards;
    animation-delay:0.5s;
}

/* RIGHT LOGIN SECTION */
.right-section{
    width:45%;
    display:flex;
    justify-content:center;
    align-items:center;
}

.login-container{
    background:#ffffff;
    padding:40px;
    width:360px;
    border-radius:20px;
    box-shadow:0 15px 40px rgba(0,0,0,0.2);
    animation:fadeIn 1s ease;
}

.login-container h2{
    text-align:center;
    margin-bottom:25px;
    color:#333;
}

.login-container input{
    width:100%;
    padding:14px;
    margin-bottom:18px;
    border:none;
    background:#f1f1f1;
    border-radius:10px;
    font-size:14px;
}

.login-container input:focus{
    outline:none;
    background:#e8f5e9;
}

.login-container button{
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

.login-container button:hover{
    background:#3d8366;
}

.message{
    text-align:center;
    margin-bottom:15px;
    font-size:14px;
}

/* Animations */
@keyframes slideIn{
    from{ transform:translateX(-100%); }
    to{ transform:translateX(0); }
}

@keyframes textFade{
    to{
        opacity:1;
        transform:translateX(0);
    }
}

@keyframes fadeIn{
    from{opacity:0; transform:translateY(20px);}
    to{opacity:1; transform:translateY(0);}
}

/* Responsive */
@media(max-width:900px){
    .container{
        flex-direction:column;
    }

    .left-section,
    .right-section{
        width:100%;
        height:50vh;
    }

    .left-section{
        border-radius:0;
    }

    .left-section h1{
        font-size:40px;
    }
}
.form-links{
    margin-top:15px;
    text-align:center;
}

.forgot-link{
    display:block;
    font-size:14px;
    margin-bottom:12px;
    color:#4f9f7d;
    text-decoration:none;
    transition:0.3s;
}

.forgot-link:hover{
    text-decoration:underline;
    color:#3d8366;
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

    <!-- LEFT GREEN PANEL -->
    <div class="left-section">
        <h1>Welcome</h1>
    </div>

    <!-- RIGHT LOGIN FORM -->
    <div class="right-section">
        <div class="login-container">

            <h2>Sign In</h2>

            <div class="message">
                <?php echo $msg; ?>
            </div>

            <form method="POST">

                <input type="email" name="email" placeholder="Email" required>

                <input type="password" name="password" placeholder="Password" required>

                <button type="submit" name="login">
                    Sign in
                </button>
               <div class="form-links">

                    <a href="forgot_password.php" class="forgot-link">
                        Forgot password?
                    </a>

                    <p class="signup-text">
                        Don’t have an account?
                        <a href="Register.php" class="signup-link">
                            Sign up here
                        </a>
                    </p>

                </div>

            </form>

        </div>
    </div>

</div>

</body>
</html>
