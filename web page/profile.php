<?php
session_start();


if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","final_project");
if(!$conn){
    die("Database Connection Failed");
}

$user_id = $_SESSION['user_id'];

/* ================= UPDATE PROFILE ================= */
if(isset($_POST['update_profile'])){

    // ✅ Required field validation
    if(empty($_POST['mobile']) || empty($_POST['address'])){
        die("Mobile and Address are required.");
    }

    $mobile  = trim($_POST['mobile']);
    $address = trim($_POST['address']);

    // ✅ Mobile validation (10 digits)
    if(!preg_match('/^[0-9]{10}$/', $mobile)){
        die("Invalid mobile number. Must be 10 digits.");
    }

    // ✅ Escape input
    $mobile  = mysqli_real_escape_string($conn, $mobile);
    $address = mysqli_real_escape_string($conn, $address);

    // ✅ Update profile details
    mysqli_query($conn, "UPDATE users 
                         SET mobile='$mobile', address='$address'
                         WHERE id='$user_id'");

    /* ===== Image Upload Validation ===== */
    if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0){

        $allowed_ext = ['jpg','jpeg','png','webp'];
        $file_name = $_FILES['profile_pic']['name'];
        $file_tmp  = $_FILES['profile_pic']['tmp_name'];
        $file_size = $_FILES['profile_pic']['size'];
        $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // ✅ Extension check
        if(!in_array($file_ext, $allowed_ext)){
            die("Only JPG, JPEG, PNG, WEBP allowed.");
        }

      // ✅ File size limit (2MB)
            if ($file_size > 2 * 1024 * 1024) {
                echo "<script>
                        alert('File too large. Maximum file size is 2MB.');
                        window.history.back();
                    </script>";
                exit();
            }

        // ✅ MIME type check (ensure real image)
        $image_info = getimagesize($file_tmp);
        if($image_info === false){
            die("Invalid image file.");
        }

        // ✅ Safe file rename
        $new_name = "profile_" . $user_id . "_" . time() . "." . $file_ext;
        $upload_path = "uploads/" . $new_name;

        if(move_uploaded_file($file_tmp, $upload_path)){
            mysqli_query($conn, "UPDATE users 
                                 SET profile_pic='$new_name'
                                 WHERE id='$user_id'");
        }
    }
// ✅ Set success message
    // ✅ Set success message using session
$_SESSION['success'] = "Profile updated successfully!";

    header("Location: profile.php");
    exit();
}

/* ================= GET USER ================= */
$query = mysqli_query($conn,"SELECT * FROM users WHERE id='$user_id'");
$user  = mysqli_fetch_assoc($query);
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
.profile-wrapper{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:#f3f3f3;
}

.profile-card{
    width:850px;
    height:520px;
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
    padding:40px 20px;
}

.profile-left img{
    width:150px;
    height:150px;
    border-radius:50%;
    object-fit:cover;
    border:4px solid white;
    cursor:pointer;
}

.profile-right{
    width:60%;
    padding:40px;
}

.profile-right input,
.profile-right textarea{
    width:100%;
    padding:10px;
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
}

.profile-right button:hover{
    background:#5fb13c;
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

    <!-- LEFT SIDE -->
    <div class="profile-left">

        <form method="POST" enctype="multipart/form-data">

            <label for="fileUpload">

                <?php if(!empty($user['profile_pic'])){ ?>
                    <img src="uploads/<?php echo $user['profile_pic']; ?>">
                <?php } else { ?>
                    <img src="img/core-img/leaf.png">
                <?php } ?>

            </label>

            <input type="file" name="profile_pic" id="fileUpload" hidden>

            <h3 style="margin-top:20px;"><?php echo $user['name']; ?></h3>
            <p><?php echo $user['email']; ?></p>

            <p>
                <?php if($user['is_verified']==1){ ?>
                    <span style="color:#fff;">Verified ✔</span>
                <?php } else { ?>
                    <span style="color:#ffdddd;">Not Verified</span>
                <?php } ?>
            </p>

    </div>

    <!-- RIGHT SIDE -->
    <div class="profile-right">

        <h2>Edit Profile</h2>
       <?php if(isset($_SESSION['success'])): ?>
            <div id="success-msg" style="background:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px; text-align:center;">
                <?php 
                    echo $_SESSION['success']; 
                    unset($_SESSION['success']); // remove after showing
                ?>
            </div>

            <script>
                // Remove the success message after 3 seconds (3000 milliseconds)
                setTimeout(function() {
                    var msg = document.getElementById('success-msg');
                    if(msg){
                        msg.style.display = 'none';
                    }
                }, 3000);
            </script>
        <?php endif; ?>


        <label>Mobile Number</label>
        <input type="text" name="mobile"
               value="<?php echo $user['mobile']; ?>">

        <label>Address</label>
        <textarea name="address" rows="4"><?php echo $user['address']; ?></textarea>

        <button type="submit" name="update_profile">
            Update Profile
        </button>

        </form>

        <div style="margin-top:20px;text-align:center;">
            <a href="index.php">Home</a> |
            <a href="logout.php" style="color:red;">Logout</a>
        </div>

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
