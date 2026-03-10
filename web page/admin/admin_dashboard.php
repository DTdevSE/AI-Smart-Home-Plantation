<?php
session_start();

$conn = mysqli_connect("localhost","root","","final_project");
if(!$conn){
    die("Database Connection Failed");
}

/* ===== STRICT ADMIN PROTECTION ===== */
if(!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php");
    exit();
}

/* ===== Session Timeout (30 minutes) ===== */
if(time() - $_SESSION['login_time'] > 1800){
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit();
}

/* Refresh session time */
$_SESSION['login_time'] = time();

/* Get admin info */
$user_id = $_SESSION['user_id'];
$user_query = mysqli_query($conn,"SELECT name FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($user_query);

/* Count new complaints */
$count_query = mysqli_query($conn,"
    SELECT COUNT(*) AS total 
    FROM helpdesk_tickets 
    WHERE admin_seen = 0
");
$count_data = mysqli_fetch_assoc($count_query);
$new_count = $count_data['total'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <!-- Favicon -->
    <link rel="icon" href="../img/core-img/favicon.ico">


    <link rel="icon" href="img/core-img/favicon.ico">
    <link rel="stylesheet" href="../style.css">
</head>

<body>

<!-- Preloader -->
<div class="preloader d-flex align-items-center justify-content-center">
    <div class="preloader-circle"></div>
    <div class="preloader-img">
        <img src="img/core-img/leaf.png">
    </div>
</div>

<!-- ===== Dashboard Content ===== -->

<div class="container mt-5">
    <h2>
    Welcome, 
    <small style="font-size:16px;color:gray;">
        (<?php echo $_SESSION['role']; ?>)
    </small>
</h2>
    <hr>

    <div class="row mt-4">

    <!-- Manage Products -->
    <div class="col-md-3">
        <div class="card dashboard-card text-center">
            <h4>📦 Manage Products</h4>
            <a href="../manage_products.php" class="btn btn-success mt-3">Open</a>
        </div>
    </div>

    <!-- Add Product -->
    <div class="col-md-3">
        <div class="card dashboard-card text-center">
            <h4>➕ Add Product</h4>
            <a href="../Product_Sales.php" class="btn btn-success mt-3">Add</a>
        </div>
    </div>

    <!-- Help Desk -->
    <div class="col-md-3">
    <div class="card dashboard-card text-center position-relative">
        <h4>
            🎧 Help Desk

            <?php if($new_count > 0){ ?>
                <span class="badge badge-danger notification-badge">
                    <?php echo $new_count; ?>
                </span>
            <?php } ?>

        </h4>

        <a href="../admin_complaints.php" class="btn btn-success mt-3">
            View
        </a>
    </div>
</div>
    <!-- Manage Users -->
    <div class="col-md-3">
        <div class="card dashboard-card text-center">
            <h4>👥 Manage Users</h4>
            <a href="../manage_users.php" class="btn btn-success mt-3">Manage</a>
        </div>
    </div>

</div>
<div style="margin-top:20px;text-align:center;">
            <a href="admin_dashboard.php">Home</a> |
            <a href="../logout.php" style="color:red;">Logout</a>
        </div>
    </div>
</div>
</div>
<style>
    .helpdesk-card{
    width:250px;
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    text-align:center;
    position:relative;
}

.helpdesk-card .icon{
    font-size:40px;
    margin-bottom:10px;
    color:#70c745;
}

.helpdesk-card h3{
    position:relative;
    display:inline-block;
}

.badge{
    position:absolute;
    top:-8px;
    right:-20px;
    background:red;
    color:white;
    font-size:12px;
    padding:4px 8px;
    border-radius:50px;
    font-weight:600;
    animation:pulse 1.5s infinite;
}

@keyframes pulse{
    0%{transform:scale(1);}
    50%{transform:scale(1.1);}
    100%{transform:scale(1);}
}

.view-btn{
    display:block;
    margin-top:15px;
    padding:10px;
    background:#28a745;
    color:white;
    text-decoration:none;
    border-radius:6px;
}
</style>
<!-- JS -->
<script src="../js/jquery/jquery-2.2.4.min.js"></script>
<script src="../js/bootstrap/popper.min.js"></script>
<script src="../js/bootstrap/bootstrap.min.js"></script>
<script src="../js/plugins/plugins.js"></script>
<script src="../js/active.js"></script>

</body>
</html>