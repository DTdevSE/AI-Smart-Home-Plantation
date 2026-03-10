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

/* ===== DELETE SALE ===== */
if(isset($_GET['delete'])){
    $delete_id = intval($_GET['delete']);

    mysqli_query($conn,"
        DELETE FROM sales 
        WHERE id = $delete_id
    ");

    header("Location: manage_sales.php");
    exit();
}

/* ===== FETCH SALES DATA ===== */
$result = mysqli_query($conn,"
    SELECT * FROM sales 
    ORDER BY id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Manage Sales</title>

<!-- Favicon -->
<link rel="icon" href="img/core-img/favicon.ico">

<!-- Main Theme CSS -->
<link rel="stylesheet" href="style.css">

<!-- Font Awesome -->
<link rel="stylesheet" 
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
body{
    background:#f3f3f3;
    font-family:Poppins;
    padding:30px;
}

h2{
    margin-bottom:25px;
}

.card-container{
    display:grid;
    grid-template-columns: repeat(auto-fill,minmax(300px,1fr));
    gap:20px;
}

.sale-card{
    background:white;
    border-radius:15px;
    padding:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    position:relative;
    transition:0.3s;
}

.sale-card:hover{
    transform:translateY(-5px);
}

.sale-title{
    font-weight:600;
    font-size:18px;
    margin-bottom:10px;
}

.sale-info{
    font-size:14px;
    margin-bottom:5px;
    color:#555;
}

.price{
    font-weight:600;
    color:#28a745;
    margin-top:8px;
}

.date{
    font-size:12px;
    color:gray;
    margin-top:10px;
}

.delete-icon{
    position:absolute;
    top:15px;
    right:15px;
    color:red;
    font-size:18px;
    text-decoration:none;
}
.delete-icon:hover{
    color:#c0392b;
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
<h2>📊 Manage Registered Products</h2>

<div class="card-container">

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<div class="sale-card">

<a href="?delete=<?php echo $row['id']; ?>" 
   onclick="return confirm('Delete this sale record?')"
   class="delete-icon">
   <i class="fa fa-trash"></i>
</a>

<div class="sale-title">
    <?php echo $row['customer_name']; ?>
</div>

<div class="sale-info">
    📧 <?php echo $row['email']; ?>
</div>

<div class="sale-info">
    📱 <?php echo $row['mobile']; ?>
</div>

<div class="sale-info">
    📦 <?php echo $row['product_name']; ?>
</div>

<div class="sale-info">
    🔢 Serial: <?php echo $row['serial_no']; ?>
</div>

<div class="price">
    Rs. <?php echo $row['selling_price']; ?>
</div>

<div class="date">
    🕒 <?php echo $row['sold_at']; ?>
</div>

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