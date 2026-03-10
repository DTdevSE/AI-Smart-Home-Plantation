<?php
session_start();
$conn = mysqli_connect("localhost","root","","final_project");
if(!$conn){ die("DB Error"); }
if(!isset($_SESSION['user_id'])){ header("Location: login.php"); exit(); }

$user_id = $_SESSION['user_id'];

/* GET LOGGED USER */
$userQuery = mysqli_query($conn,"SELECT * FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($userQuery);

/* COUNT EXISTING MEMBERS */
$countQuery = mysqli_query($conn,"SELECT COUNT(*) as total FROM users WHERE parent_id='$user_id'");
$countData = mysqli_fetch_assoc($countQuery);
$totalMembers = $countData['total'];

/* ADD MEMBER */
if(isset($_POST['add'])){
    $name     = trim($_POST['name'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if(empty($name) || empty($email) || empty($password)){
        $_SESSION['error'] = "All fields are required!";
    }
    elseif($totalMembers >= 3){
        $_SESSION['error'] = "You can only add maximum 3 members!";
    }
    else{
        $check = mysqli_query($conn,"SELECT id FROM users WHERE email='$email'");
        if(mysqli_num_rows($check) > 0){
            $_SESSION['error'] = "Email already exists!";
        } else {
            $hash = password_hash($password,PASSWORD_DEFAULT);
            mysqli_query($conn,
            "INSERT INTO users (name,email,password,role,parent_id,is_verified)
             VALUES ('$name','$email','$hash','member','$user_id',1)");
            $_SESSION['success'] = "Member Added Successfully!";
            $totalMembers++;
        }
    }
    header("Location: add_member.php");
    exit();
}

/* DELETE MEMBER */
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    mysqli_query($conn,"DELETE FROM users WHERE id='$id' AND parent_id='$user_id'");
    $_SESSION['success'] = "Member Deleted Successfully!";
    header("Location: add_member.php");
    exit();
}

/* GET FAMILY MEMBERS */
$membersQuery = mysqli_query($conn,"SELECT id,name,profile_pic FROM users WHERE parent_id='$user_id'");
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Family Member</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Favicon -->
<link rel="icon" href="img/core-img/favicon.ico">

<!-- Main Theme CSS -->
<link rel="stylesheet" href="style.css">

<!-- Font Awesome -->
<link rel="stylesheet" 
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="style.css">
<link rel="stylesheet" 
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
.profile-wrapper{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#f3f3f3;
}

.profile-card{
    width:900px;
    min-height:550px;
    background:white;
    border-radius:20px;
    box-shadow:0 20px 40px rgba(0,0,0,0.1);
    display:flex;
    overflow:hidden;
}

.profile-left{
    width:40%;
    background:#70c745;
    color:white;
    text-align:center;
    padding:60px 20px;
}

.profile-right{
    width:60%;
    padding:50px;
}

.profile-right input{
    width:100%;
    padding:12px;
    margin-bottom:15px;
    border-radius:8px;
    border:1px solid #ccc;
}

.profile-right button{
    width:100%;
    padding:12px;
    background:#70c745;
    color:white;
    border:none;
    border-radius:8px;
    cursor:pointer;
}

.profile-right button:hover{
    background:#5fb13c;
}

.family-list{
    display:flex;
    flex-wrap:wrap;
    gap:20px;
    margin-top:25px;
}

.member-card{
    width:110px;
    text-align:center;
    background:#f8f8f8;
    padding:12px;
    border-radius:12px;
    box-shadow:0 5px 10px rgba(0,0,0,0.05);
}

.member-card img{
    width:70px;
    height:70px;
    border-radius:50%;
    object-fit:cover;
}

.member-name{
    margin-top:8px;
    font-size:14px;
    font-weight:600;
}

.member-actions{
    margin-top:6px;
}

.member-actions i{
    margin:0 6px;
    cursor:pointer;
}

.heart{
    color:#ccc;
}

.delete{
    color:#888;
}

.delete:hover{
    color:red;
}

.links{
    margin-top:20px;
}

.logout{
    color:red;
}
.leaf-wrapper{
    position:absolute;
    left:120px;
    top:300px;
}

.leaf-img{
    width:120px;
}

/* Tablet */
@media (max-width: 992px){
    .leaf-wrapper{
        left:60px;
        top:250px;
    }

    .leaf-img{
        width:90px;
    }
}

/* Mobile */
@media (max-width: 576px){
    .leaf-wrapper{
        position:relative;
        left:0;
        top:0;
        text-align:center;
        margin-top:20px;
    }

    .leaf-img{
        width:70px;
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

<div class="profile-wrapper">
<div class="profile-card">

<!-- LEFT -->
<div class="profile-left">
    <h2><?php echo $user['name']; ?></h2>
    <p><?php echo $user['email']; ?></p>

    <?php if($user['is_verified']==1){ ?>
        <p>Verified ✔</p>
    <?php } ?>
</div>

<!-- RIGHT -->
<div class="profile-right">

    <h2>Add Family Member</h2>

   <?php if(isset($_SESSION['success'])): ?>
    <div id="flash-msg" style="background:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px; text-align:center;">
        <?php 
            echo $_SESSION['success']; 
            unset($_SESSION['success']); 
        ?>
    </div>
<?php endif; ?>

<?php if(isset($_SESSION['error'])): ?>
    <div id="flash-msg" style="background:#f8d7da; color:#721c24; padding:10px; border-radius:5px; margin-bottom:15px; text-align:center;">
        <?php 
            echo $_SESSION['error']; 
            unset($_SESSION['error']); 
        ?>
    </div>
<?php endif; ?>

<script>
// Auto-hide after 3 seconds
setTimeout(function(){
    var msg = document.getElementById('flash-msg');
    if(msg) msg.style.display = 'none';
}, 3000);
</script>

    <form method="POST">
        <input type="text" name="name" placeholder="Member Name" required>
        <input type="email" name="email" placeholder="Member Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="add">Add Member</button>
    </form>

    <h3>Family Members</h3>

    <div class="family-list">

    <?php while($member = mysqli_fetch_assoc($membersQuery)){ ?>

        <div class="member-card">

            <?php if(!empty($member['profile_pic'])){ ?>
                <img src="uploads/<?php echo $member['profile_pic']; ?>">
            <?php } else { ?>
                <img src="img/core-img/leaf.png">
            <?php } ?>

            <div class="member-name">
                <?php echo $member['name']; ?>
            </div>

            <div class="member-actions">
                <i class="fa fa-heart heart"></i>
                <a href="?delete=<?php echo $member['id']; ?>">
                    <i class="fa fa-trash delete"></i>
                </a>
            </div>

        </div>

    <?php } ?>

    </div>

   <div style="margin-top:20px;text-align:center;">
            <a href="index.php">Home</a> |
            <a href="logout.php" style="color:red;">Logout</a>
        </div>

</div>
</div>
</div>

<script>
document.querySelectorAll('.heart').forEach(function(icon){
    icon.addEventListener('click', function(){
        this.classList.toggle('liked');
        this.style.color = this.classList.contains('liked') ? 'red' : '#ccc';
    });
});
</script>
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
