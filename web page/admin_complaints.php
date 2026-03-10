<?php
session_start();

/* Optional: Protect Admin */
if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","final_project");

/* JOIN tickets with users table */
$query = "SELECT helpdesk_tickets.*, 
                 users.name, 
                 users.email 
          FROM helpdesk_tickets
          JOIN users ON helpdesk_tickets.user_id = users.id
          ORDER BY helpdesk_tickets.id DESC";

$result = mysqli_query($conn,$query);
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
    padding:40px;
}

h2{
    margin-bottom:30px;
}

.complaint-container{
    display:grid;
    grid-template-columns: repeat(auto-fill,minmax(350px,1fr));
    gap:20px;
}

.card{
    background:white;
    border-radius:15px;
    padding:20px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    border-left:6px solid #70c745;
}

.card h3{
    margin:0 0 10px;
}

.badge{
    display:inline-block;
    padding:5px 10px;
    border-radius:20px;
    font-size:12px;
    font-weight:500;
}

.hardware{
    background:#ffe5e5;
    color:#c0392b;
}

.software{
    background:#e5f1ff;
    color:#2980b9;
}

.status{
    background:#fff3cd;
    color:#856404;
}

.small{
    font-size:13px;
    color:#777;
    margin-bottom:8px;
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

<h2>Help Desk Complaints</h2>

<div class="complaint-container">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<div class="card">

    <div class="small">
        Ticket ID: #<?php echo $row['id']; ?> |
        Date: <?php echo $row['created_at']; ?>
    </div>

    <h3><?php echo $row['subject']; ?></h3>

    <div class="small">
        👤 <?php echo $row['name']; ?> <br>
        📧 <?php echo $row['email']; ?>
    </div>

    <?php if($row['issue_type'] == "Hardware"){ ?>
        <span class="badge hardware">Hardware Issue</span>
    <?php } else { ?>
        <span class="badge software">Software Issue</span>
    <?php } ?>

    <p style="margin-top:10px;">
        <?php echo $row['description']; ?>
    </p>

    <span class="badge status">
        Status: <?php echo $row['status']; ?>
    </span>

</div>

<?php } ?>
<iv style="margin-top:20px;text-align:center;">
            <a href="admin/admin_dashboard.php">Home</a> |
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