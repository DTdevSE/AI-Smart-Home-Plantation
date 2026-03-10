<?php
session_start();

/* ===== Must Login ===== */
if(!isset($_SESSION['user_id'])){
    echo "
    <script>
        alert('Please login first! Redirecting in 5 seconds...');
        setTimeout(function(){
            window.location.href = 'login.php';
        }, 5000);
    </script>
    ";
    exit();
}

/* ===== Extra Safety Check ===== */
if(!isset($_SESSION['role'])){
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Alazea - Gardening &amp; Landscaping HTML Template</title>

    <!-- Favicon -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <!-- Preloader -->
    <div class="preloader d-flex align-items-center justify-content-center">
        <div class="preloader-circle"></div>
        <div class="preloader-img">
            <img src="img/core-img/leaf.png" alt="">
        </div>
    </div>

        <!-- ##### Header Area Start ##### -->
    <header class="header-area">

        <!-- ***** Top Header Area ***** -->
        <div class="top-header-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="top-header-content d-flex align-items-center justify-content-between">
                            <!-- Top Header Content -->
                            <div class="top-header-meta">
                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="infodeercreative@gmail.com"><i class="fa fa-envelope-o" aria-hidden="true"></i> <span>Email: infodinitha@gmail.com</span></a>
                                <a href="#" data-toggle="tooltip" data-placement="bottom" title="+1 234 122 122"><i class="fa fa-phone" aria-hidden="true"></i> <span>Call Us: +94 75 924 874</span></a>
                            </div>

                            <!-- Top Header Content -->
                            <div class="top-header-meta d-flex">
                                <!-- Language Dropdown -->
                                <div class="language-dropdown">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle mr-30" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Language</button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="#">USA</a>
                                            <a class="dropdown-item" href="#">UK</a>
                                            <a class="dropdown-item" href="#">Bangla</a>
                                            <a class="dropdown-item" href="#">Hindi</a>
                                            <a class="dropdown-item" href="#">Spanish</a>
                                            <a class="dropdown-item" href="#">Latin</a>
                                        </div>
                                    </div>
                                </div>
                                                        <!-- Login -->
                                <div class="login dropdown">

                                <?php if(isset($_SESSION['user_id'])){ ?>

                                    <!-- User Button -->
                                    <a href="#" 
                                    class="dropdown-toggle d-flex align-items-center"
                                    id="userDropdown"
                                    data-toggle="dropdown"
                                    aria-haspopup="true"
                                    aria-expanded="false"
                                    style="text-decoration:none;">

                                        <i class="fa fa-user mr-2"></i>
                                        <span><?php echo $_SESSION['user_name']; ?></span>
                                    </a>

                                    <!-- Dropdown Menu -->
                                            <div class="dropdown-menu dropdown-menu-right shadow-lg rounded"
                                               style="background:#70c745; border:none;">

                                               
                                                <!-- User Info Header -->
                                                <div class="px-3 py-2 text-center border-bottom">
                                                    <i class="fa fa-user-circle fa-2x text-secondary"></i>
                                                    <div class="mt-2 font-weight-bold">
                                                        <?php echo $_SESSION['user_name']; ?>
                                                    </div>
                                                </div>

                                                <!-- Home -->
                                                <a class="dropdown-item" href="index.php">
                                                    <i class="fa fa-home mr-2 text-primary"></i> Home
                                                </a>

                                                <!-- Profile -->
                                                <a class="dropdown-item" href="profile.php">
                                                    <i class="fa fa-user mr-2 text-success"></i> My Profile
                                                </a>

                                                <!-- Users (Admin only example) 
                                                <a class="dropdown-item" href="add_member.php">
                                                    <i class="fa fa-users mr-2 text-info"></i> Users
                                                </a>-->
                                                <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'customer'){ ?>
                                                    <a class="dropdown-item" href="add_member.php">
                                                        <i class="fa fa-users mr-2 text-info"></i> Users
                                                    </a>
                                                <?php } ?>
                                                  <!--IT Help Desk-->
                                                  <a class="dropdown-item" href="helpdesk.php">
                                                    <i class="fa fa-laptop mr-2 text-danger"></i> Help Desk
                                                </a>


                                                <div class="dropdown-divider"></div>
                                              

                                                <!-- Logout -->
                                                <a class="dropdown-item text-danger" href="logout.php">
                                                    <i class="fa fa-sign-out mr-2"></i> Logout
                                                </a>

                                            </div>


                                    </div>

                                <?php } else { ?>

                                    <a href="login.php">
                                        <i class="fa fa-user"></i>
                                        <span>Login</span>
                                    </a>

                                <?php } ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ***** Navbar Area ***** -->
        <div class="alazea-main-menu">
            <div class="classy-nav-container breakpoint-off">
                <div class="container">
                    <!-- Menu -->
                    <nav class="classy-navbar justify-content-between" id="alazeaNav">

                        <!-- Nav Brand -->
                        <img src="img/core-img/logo.png" alt="Smart plantationLogo" style="max-height:150px; width:auto;">


                        <!-- Navbar Toggler -->
                        <div class="classy-navbar-toggler">
                            <span class="navbarToggler"><span></span><span></span><span></span></span>
                        </div>

                        <!-- Menu -->
                        <div class="classy-menu">

                            <!-- Close Button -->
                            <div class="classycloseIcon">
                                <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                            </div>

                            <!-- Navbar Start -->
                            <div class="classynav">
                                <ul>
                                    <li><a href="index.php">Home</a></li>
                                    <li><a href="Dashboard.php">Dashboard</a></li>
                                    <li><a href="about.php">About</a></li>                              
                                    <li><a href="contact.php">Contact</a></li>
                                </ul>

                                <!-- Search Icon -->
                                <div id="searchIcon">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </div>

                            </div>
                            <!-- Navbar End -->
                        </div>
                    </nav>

                    <!-- Search Form -->
                    <div class="search-form">
                        <form action="#" method="get">
                            <input type="search" name="search" id="search" placeholder="Type keywords &amp; press enter...">
                            <button type="submit" class="d-none" title="Search"></button>
                        </form>
                        <!-- Close Icon -->
                        <div class="closeIcon"><i class="fa fa-times" aria-hidden="true"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->


    <!-- ##### Breadcrumb Area Start ##### -->
    <div class="breadcrumb-area">
        <!-- Top Breadcrumb Area -->
        <div class="top-breadcrumb-area bg-img bg-overlay d-flex align-items-center justify-content-center" style="background-image: url(img/bg-img/24.jpg);">
            <h2>Contact US</h2>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Contact</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcrumb Area End ##### -->

    <!-- ##### Contact Area Info Start ##### -->
    <div class="contact-area-info section-padding-0-100">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <!-- Contact Thumbnail -->
                <div class="col-12 col-md-6">
                    <div class="contact--thumbnail">
                        <img src="img/bg-img/25.jpg" alt="">
                    </div>
                </div>

                <div class="col-12 col-md-5">
                    <!-- Section Heading -->
                    <div class="section-heading">
                        <h2>CONTACT US</h2>
                        <p>We are improving our services to serve you better.</p>
                    </div>
                    <!-- Contact Information -->
                    <div class="contact-information">
                        <p><span>Address:</span> 999 Main Rd, colombo 02 </p>
                        <p><span>Phone:</span> +94 75 924 874</p>
                        <p><span>Email:</span> info.smartplant@gmail.com</p>
                        <p><span>Open hours:</span> Mon - Sun: 8 AM to 9 PM</p>
                        <p><span>Happy hours:</span> Sat: 2 PM to 4 PM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Contact Area Info End ##### -->

    <!-- ##### Contact Area Start ##### -->
    <section class="contact-area">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-12 col-lg-5">
                    <!-- Section Heading -->
                    <div class="section-heading">
                        <h2>GET IN TOUCH</h2>
                        <p>Send us a message, we will call back later</p>
                    </div>
                    <!-- Contact Form Area -->
                    <div class="contact-form-area mb-100">
                        <form action="#" method="post">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="contact-name" placeholder="Your Name">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="contact-email" placeholder="Your Email">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="contact-subject" placeholder="Subject">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <textarea class="form-control" name="message" id="message" cols="30" rows="10" placeholder="Message"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn alazea-btn mt-15">Send Message</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <!-- Google Maps -->
                    <div class="map-area mb-100">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d22236.40558254599!2d-118.25292394686001!3d34.057682914027104!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2c75ddc27da13%3A0xe22fdf6f254608f4!2z4Kay4Ka4IOCmj-CmnuCnjeCmnOCnh-CmsuCnh-CmuCwg4KaV4KeN4Kav4Ka-4Kay4Ka_4Kar4KeL4Kaw4KeN4Kao4Ka_4Kav4Ka84Ka-LCDgpq7gpr7gprDgp43gppXgpr_gpqgg4Kav4KeB4KaV4KeN4Kak4Kaw4Ka-4Ka34KeN4Kaf4KeN4Kaw!5e0!3m2!1sbn!2sbd!4v1532328708137" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Contact Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
   <!-- ##### Footer Area Start ##### -->
<footer class="footer-area bg-img" style="background-image: url(img/bg-img/3.jpg);">
    <!-- Main Footer Area -->
    <div class="main-footer-area">
        <div class="container">
            <div class="row">

                <!-- Footer Widget: Logo & About -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-footer-widget">
                        <div class="footer-logo mb-30">
                            <a href="index.html" title="SmartPlant AI & IoT Logo">
                                <img src="img/core-img/logo.png" 
                                    alt="SmartPlant AI & IoT"
                                    style="max-height:150px; width:auto; margin-top:-35px;">

                            </a>
                        </div>
                        <p>
                            SmartPlant AI & IoT uses advanced AI and IoT technology to monitor and nurture plants 
                            in your home, ensuring healthy growth and optimal care.
                        </p>
                        <div class="social-info">
                            <a href="#" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#" title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            <a href="#" title="LinkedIn"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>

             <!-- Footer Widget: Quick Links -->
<div class="col-12 col-sm-6 col-lg-3 mb-4">
    <div class="single-footer-widget">
        <div class="widget-title mb-3">
            <h5>QUICK LINKS</h5>
        </div>
        <nav class="widget-nav">
            <ul class="footer-list">
                <li><a href="#">Home</a></li>
                <li><a href="#">Services</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Portfolio</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </div>
</div>

<!-- Footer Widget: Services -->
<div class="col-12 col-sm-6 col-lg-3 mb-4">
    <div class="single-footer-widget">
        <div class="widget-title mb-3">
            <h5>SERVICES</h5>
        </div>
        <nav class="widget-nav">
            <ul class="footer-list">
                <li><a href="#">Real-Time Monitoring</a></li>
                <li><a href="#">AI-Powered Insights</a></li>
                <li><a href="#">Smart Home Integration</a></li>
                <li><a href="#">Growth Analytics</a></li>
                <li><a href="#">Eco-Friendly Automation</a></li>
            </ul>
        </nav>
    </div>
</div>

                <!-- Footer Widget: Contact Info -->
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="single-footer-widget">
                        <div class="widget-title">
                            <h5>CONTACT US</h5>
                        </div>
                        <div class="contact-information">
                            <p><span>Address:</span> 999 Main Rd, colombo 01Y</p>
                            <p><span>Phone:</span> +94 75 924 874</p>
                            <p><span>Email:</span> info@smartplantaiot.com</p>
                            <p><span>Open Hours:</span> Mon - Sun: 8 AM - 9 PM</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Footer Bottom Area -->
    <div class="footer-bottom-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="border-line"></div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="copywrite-text">
                        <p>&copy; <script>document.write(new Date().getFullYear());</script> All rights reserved | 
                        Designed by <a href="#" target="_blank" rel="noopener">Dinitha Thewmika</a></p>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="footer-nav">
                        <nav>
                            <ul>
                               <li><a href="#">Home</a></li>
                                <li><a href="#">Dashboard</a></li>
                                <li><a href="#">About</a></li>
                                <li><a href="#">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
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