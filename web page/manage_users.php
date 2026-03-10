<?php
session_start();

$conn = mysqli_connect("localhost","root","","final_project");
if(!$conn){
    die("Database Connection Failed");
}

/* ===== ADMIN PROTECTION ===== */
if(!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin'){
    header("Location: ../login.php");
    exit();
}

/* ===== DELETE CUSTOMER ===== */
if(isset($_GET['delete'])){
    $delete_id = intval($_GET['delete']);

    mysqli_query($conn,"
        DELETE FROM users 
        WHERE id = $delete_id 
        AND role = 'customer'
    ");

    header("Location: manage_users.php");
    exit();
}

/* ===== FETCH ONLY CUSTOMERS ===== */
$result = mysqli_query($conn,"
    SELECT id,name,profile_pic 
    FROM users 
    WHERE role='customer'
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Customers</title>
<!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <link rel="icon" href="img/core-img/favicon.ico">
    <link rel="stylesheet" href="style.css">



<style>
body{
    background:#f3f3f3;
  
    padding:30px;
}

h2{
    margin-bottom:25px;
}

.card-container{
    display:grid;
    grid-template-columns: repeat(auto-fill,minmax(220px,1fr));
    gap:20px;
}

.user-card{
    background:white;
    border-radius:15px;
    padding:25px 20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    text-align:center;
    position:relative;
    transition:0.3s;
}

.user-card:hover{
    transform:translateY(-5px);
}

.user-img{
    width:100px;
    height:100px;
    border-radius:50%;
    object-fit:cover;
    margin-bottom:15px;
}

.user-name{
    font-weight:600;
    font-size:16px;
    margin-bottom:10px;
}

.delete-btn{
    background:red;
    color:white;
    border:none;
    padding:8px 12px;
    border-radius:6px;
    cursor:pointer;
    font-size:14px;
    transition:0.3s;
}

.delete-btn:hover{
    background:#c0392b;
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
<h2>👥 Manage Customers</h2>

<div class="card-container">

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<div class="user-card">

    <?php if($row['profile_pic']){ ?>
        <img src="uploads/<?php echo $row['profile_pic']; ?>" class="user-img">
    <?php } else { ?>
        <img src="img/core-img/leaf.png" class="user-img">
    <?php } ?>

    <div class="user-name"><?php echo $row['name']; ?></div>

    <a href="?delete=<?php echo $row['id']; ?>" 
       onclick="return confirm('Delete this customer?')">
        <button class="delete-btn">
            <i class="fa fa-trash"></i> Delete
        </button>
    </a>

</div>

<?php } ?>
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