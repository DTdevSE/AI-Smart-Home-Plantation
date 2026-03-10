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
    <title>Home - Gardening &amp; plantation HTML Template</title>

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

    <!-- ##### Hero Area Start ##### -->
    <section class="hero-area">
        <div class="hero-post-slides owl-carousel">

            <!-- Single Hero Post -->
            <div class="single-hero-post bg-overlay">
                <!-- Post Image -->
                <div class="slide-img bg-img" style="background-image: url(img/bg-img/1.jpg);"></div>
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-12">
                            <!-- Post Content -->
                            <div class="hero-slides-content text-center">
                                <h2>SmartPlant AI & IoT  Nurturing Plants with AI, Light, and Weather</h2>
                                <p>SmartPlant AI & IoT brings intelligence to your home garden. By combining AI technology with IoT sensors, it monitors light, temperature, and weather conditions, ensuring your plants receive the care they need to thrive</p>
                                <div class="welcome-btn-group">
                                <a href="Front%20end%20Assistant/Analize.html" class="btn alazea-btn mr-30">AI MODEL</a>
                                <a href="#" class="btn alazea-btn active">CONTACT US</a>
                            </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Single Hero Post -->
            <div class="single-hero-post bg-overlay">
                <!-- Post Image -->
                <div class="slide-img bg-img" style="background-image: url(img/bg-img/2.jpg);"></div>
                <div class="container h-100">
                    <div class="row h-100 align-items-center">
                        <div class="col-12">
                            <!-- Post Content -->
                            <div class="hero-slides-content text-center">
                                 <h2>SmartPlant AI & IoT  Nurturing Plants with AI, Light, and Weather</h2>
                                <p>SmartPlant AI & IoT brings intelligence to your home garden. By combining AI technology with IoT sensors, it monitors light, temperature, and weather conditions, ensuring your plants receive the care they need to thrive</p>
                                <div class="welcome-btn-group">
                                <a href="Front%20end%20Assistant/Analize.html" class="btn alazea-btn mr-30">AI MODEL</a>
                                    <a href="#" class="btn alazea-btn active">CONTACT US</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    

    </section>
    <!-- ##### Hero Area End ##### -->

    <!-- ##### Service Area Start ##### -->
    <section class="our-services-area bg-gray section-padding-100-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Section Heading -->
                    <div class="section-heading text-center">
                        <h2>OUR SERVICES</h2>
                        <p>We provide the perfect service for you.</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-between">
                <div class="col-12 col-lg-5">
                    <div class="alazea-service-area mb-100">

                        <!-- Single Service Area -->
                        <div class="single-service-area d-flex align-items-center wow fadeInUp" data-wow-delay="100ms">
                            <!-- Icon -->
                            <div class="service-icon mr-30">
                                <img src="img/core-img/s1.png" alt="">
                            </div>
                            <!-- Content -->
                            <div class="service-content">
                                <h5>Al Assistant</h5>
                                <p>In Aenean purus, pretium sito amet sapien denim moste consectet sedoni urna placerat sodales.service its.</p>
                            </div>
                        </div>

                        <!-- Single Service Area -->
                        <div class="single-service-area d-flex align-items-center wow fadeInUp" data-wow-delay="300ms">
                            <!-- Icon -->
                            <div class="service-icon mr-30">
                                <img src="img/core-img/s2.png" alt="">
                            </div>
                            <!-- Content -->
                            <div class="service-content">
                                <h5>Plants Care</h5>
                                <p>In Aenean purus, pretium sito amet sapien denim moste consectet sedoni urna placerat sodales.service its.</p>
                            </div>
                        </div>

                        <!-- Single Service Area -->
                        <div class="single-service-area d-flex align-items-center wow fadeInUp" data-wow-delay="500ms">
                            <!-- Icon -->
                            <div class="service-icon mr-30">
                                <img src="img/core-img/s3.png" alt="">
                            </div>
                            <!-- Content -->
                            <div class="service-content">
                                <h5>Real-Time  &amp;Plant Monitoring </h5>
                                <p>In Aenean purus, pretium sito amet sapien denim moste consectet sedoni urna placerat sodales.service its.</p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="alazea-video-area bg-overlay mb-100">
                        <img src="img/bg-img/23.jpg" alt="">
                        <a href="http://www.youtube.com/watch?v=7HKoqNJtMTQ" class="video-icon">
                            <i class="fa fa-play" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Service Area End ##### -->

    <!-- ##### About Area Start ##### -->
<section class="about-us-area section-padding-100-0">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-lg-5">
                <!-- Section Heading -->
                <div class="section-heading">
                    <h2>ABOUT US</h2>
                    <p>Leading the way in smart home plantation solutions.</p>
                </div>
                <p>
                    SmartPlant AI & IoT combines artificial intelligence and IoT technology to monitor and nurture your plants at home. 
                    From sunlight exposure to soil moisture and weather conditions, we provide automated insights for healthier plant growth.
                </p>

                <!-- Progress Bar Content Area -->
                <div class="alazea-progress-bar mb-50">
                    <!-- Single Progress Bar -->
                    <div class="single_progress_bar">
                        <p>Indoor Plant Monitoring</p>
                        <div id="bar1" class="barfiller">
                            <div class="tipWrap"><span class="tip"></span></div>
                            <span class="fill" data-percentage="90"></span>
                        </div>
                    </div>

                    <!-- Single Progress Bar -->
                    <div class="single_progress_bar">
                        <p>Automated Care Suggestions</p>
                        <div id="bar2" class="barfiller">
                            <div class="tipWrap"><span class="tip"></span></div>
                            <span class="fill" data-percentage="85"></span>
                        </div>
                    </div>

                    <!-- Single Progress Bar -->
                    <div class="single_progress_bar">
                        <p>Smart Home Integration</p>
                        <div id="bar3" class="barfiller">
                            <div class="tipWrap"><span class="tip"></span></div>
                            <span class="fill" data-percentage="80"></span>
                        </div>
                    </div>

                    <!-- Single Progress Bar -->
                    <div class="single_progress_bar">
                        <p>Growth Analytics</p>
                        <div id="bar4" class="barfiller">
                            <div class="tipWrap"><span class="tip"></span></div>
                            <span class="fill" data-percentage="75"></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="alazea-benefits-area">
                    <div class="row">
                        <!-- Single Benefits Area -->
                        <div class="col-12 col-sm-6">
                            <div class="single-benefits-area">
                                <img src="img/core-img/b1.png" alt="">
                                <h5>Real-Time Monitoring</h5>
                                <p>Track light, temperature, humidity, and soil moisture continuously with IoT sensors.</p>
                            </div>
                        </div>

                        <!-- Single Benefits Area -->
                        <div class="col-12 col-sm-6">
                            <div class="single-benefits-area">
                                <img src="img/core-img/b2.png" alt="">
                                <h5>AI-Powered Insights</h5>
                                <p>Receive smart suggestions to optimize watering, lighting, and plant care for maximum growth.</p>
                            </div>
                        </div>

                        <!-- Single Benefits Area -->
                        <div class="col-12 col-sm-6">
                            <div class="single-benefits-area">
                                <img src="img/core-img/b3.png" alt="">
                                <h5>Smart Home Integration</h5>
                                <p>Control smart lights, irrigation, and climate adjustments automatically for ideal conditions.</p>
                            </div>
                        </div>

                        <!-- Single Benefits Area -->
                        <div class="col-12 col-sm-6">
                            <div class="single-benefits-area">
                                <img src="img/core-img/b4.png" alt="">
                                <h5>Eco-Friendly & Sustainable</h5>
                                <p>Promote healthy plant growth while conserving water and energy through intelligent automation.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="border-line"></div>
            </div>
        </div>
    </div>
</section>
<!-- ##### About Area End ##### -->


    <!-- ##### Testimonial Area Start ##### -->
    <section class="testimonial-area section-padding-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="testimonials-slides owl-carousel">

                        <!-- Single Testimonial Slide -->
                        <div class="single-testimonial-slide">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-6">
                                    <div class="testimonial-thumb">
                                        <img src="img/bg-img/13.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="testimonial-content">
                                        <!-- Section Heading -->
                                        <div class="section-heading">
                                            <h2>TESTIMONIAL</h2>
                                            <p>Some kind words from clients about Smart Plant</p>
                                        </div>
                                        <p>Smart Plant is a pleasure to work with. Their ideas are creative, they came up with imaginative solutions to some tricky issues, their landscaping and planting contacts are equally excellent we have a beautiful but also manageable garden as a result. Thank you!”</p>
                                        <div class="testimonial-author-info">
                                            <h6>Mr. Nick Jonas</h6>
                                            <p>CEO of smart plant</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Single Testimonial Slide -->
                        <div class="single-testimonial-slide">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-6">
                                    <div class="testimonial-thumb">
                                        <img src="img/bg-img/14.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="testimonial-content">
                                        <!-- Section Heading -->
                                        <div class="section-heading">
                                            <h2>TESTIMONIAL</h2>
                                            <p>Some kind words from clients about Smart Plant</p>
                                        </div>
                                        <p>Smart Plant is a pleasure to work with. Their ideas are creative, they came up with imaginative solutions to some tricky issues, their landscaping and planting contacts are equally excellent we have a beautiful but also manageable garden as a result. Thank you!”</p>
                                        <div class="testimonial-author-info">
                                            <h6>Mr. Nazrul Islam</h6>
                                            <p>CEO of Smart Plant</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Single Testimonial Slide -->
                        <div class="single-testimonial-slide">
                            <div class="row align-items-center">
                                <div class="col-12 col-md-6">
                                    <div class="testimonial-thumb">
                                        <img src="img/bg-img/15.jpg" alt="">
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="testimonial-content">
                                        <!-- Section Heading -->
                                        <div class="section-heading">
                                            <h2>TESTIMONIAL</h2>
                                            <p>Some kind words from clients about Smart Plant</p>
                                        </div>
                                            <p>Some kind words from clients about Smart Plant</p>
                                        <p>“Smart Plant is a pleasure to work with. Their ideas are creative, they came up with imaginative solutions to some tricky issues, their landscaping and planting contacts are equally excellent we have a beautiful but also manageable garden as a result. Thank you!”</p>
                                        <div class="testimonial-author-info">
                                            <h6>Mr. Jonas Nick</h6>
                                            <p>CEO of Smart Plant</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Testimonial Area End ##### -->


    <!-- ##### Blog Area Start ##### -->
    <section class="alazea-blog-area section-padding-100-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <!-- Section Heading -->
                    <div class="section-heading text-center">
                        <h2>LATEST NEWS</h2>
                        <p>The breaking news about Gardening &amp; House plants</p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">

                <!-- Single Blog Post Area -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-blog-post mb-100">
                        <div class="post-thumbnail mb-30">
                            <a href="single-post.html" title="Garden designers across the country forecast ideas shaping the gardening world in 2018"><img src="img/bg-img/6.jpg" alt=""></a>
                        </div>
                        <div class="post-content">
                            <a href="single-post.html" class="post-title">
                                <h5>Garden designers across the country forecast ideas shaping the gardening world in 2018</h5>
                            </a>
                            <div class="post-meta">
                                <a href="#"><i class="fa fa-clock-o" aria-hidden="true"></i> 20 Jun 2018</a>
                                <a href="#"><i class="fa fa-user" aria-hidden="true"></i> Alan Jackson</a>
                            </div>
                            <p class="post-excerpt">Integer luctus diam ac scerisque consectetur. Vimus ottawas nec lacus sit amet. Aenean interdus mid vitae.</p>
                        </div>
                    </div>
                </div>

                <!-- Single Blog Post Area -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-blog-post mb-100">
                        <div class="post-thumbnail mb-30">
                            <a href="single-post.html" title="2018 Midwest Tree and Shrub Conference: Resilient Plants for a Lasting Landscape"><img src="img/bg-img/7.jpg" alt=""></a>
                        </div>
                        <div class="post-content">
                            <a href="single-post.html" class="post-title">
                                <h5>2018 Midwest Tree and Shrub Conference: Resilient Plants for a Lasting Landscape</h5>
                            </a>
                            <div class="post-meta">
                                <a href="#"><i class="fa fa-clock-o" aria-hidden="true"></i> 20 Jun 2018</a>
                                <a href="#"><i class="fa fa-user" aria-hidden="true"></i> Christina Aguilera</a>
                            </div>
                            <p class="post-excerpt">Integer luctus diam ac scerisque consectetur. Vimus ottawas nec lacus sit amet. Aenean interdus mid vitae.</p>
                        </div>
                    </div>
                </div>

                <!-- Single Blog Post Area -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="single-blog-post mb-100">
                        <div class="post-thumbnail mb-30">
                            <a href="single-post.html" title="The summer coming up, it's time for both us and the flowers to soak up the sunshine"><img src="img/bg-img/8.jpg" alt=""></a>
                        </div>
                        <div class="post-content">
                            <a href="single-post.html" class="post-title">
                                <h5>The summer coming up, it’s time for both us and the flowers to soak up the sunshine</h5>
                            </a>
                            <div class="post-meta">
                                <a href="#"><i class="fa fa-clock-o" aria-hidden="true"></i> 19 Jun 2018</a>
                                <a href="#"><i class="fa fa-user" aria-hidden="true"></i> Mason Jenkins</a>
                            </div>
                            <p class="post-excerpt">Integer luctus diam ac scerisque consectetur. Vimus ottawas nec lacus sit amet. Aenean interdus mid vitae.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- ##### Blog Area End ##### -->

    <!-- ##### Subscribe Area Start ##### -->
    <section class="subscribe-newsletter-area">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-12 col-lg-5">
                    <!-- Section Heading -->
                    <div class="section-heading mb-0">
                        <h2>Join the Newsletter</h2>
                        <p>Subscribe to our newsletter and get 10% off your first purchase</p>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="subscribe-form">
                        <form action="#" method="get">
                            <input type="email" name="subscribe-email" id="subscribeEmail" placeholder="Enter your email">
                            <button type="submit" class="btn alazea-btn">SUBSCRIBE</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Subscribe Side Thumbnail -->
        <div class="subscribe-side-thumb wow fadeInUp" data-wow-delay="500ms">
            <img class="first-img" src="img/core-img/leaf.png" alt="">
        </div>
    </section>
    <!-- ##### Subscribe Area End ##### -->

    <!-- ##### Contact Area Start ##### -->
    <section class="contact-area section-padding-100-0">
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
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="contact-name" placeholder="Your Name">
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
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
                        
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31685.563892459635!2d79.84113123476563!3d6.926955700000019!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae253dad238768d%3A0x9f84a86408df6200!2sColombo!5e0!3m2!1sen!2slk!4v1764993759872!5m2!1sen!2slk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Contact Area End ##### -->

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
                            <p><span>Address:</span> 999 Main Rd, colombo 02</p>
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
<a href="http://localhost/Final%20Project/web%20page/Agribot/templates/aiindex.html"
   id="agribot-icon">

  <lottie-player
    src="https://assets.lottiefiles.com/packages/lf20_3vbOcw.json"
    background="transparent"
    speed="1"
    loop
    autoplay>
  </lottie-player>

</a>
<style>
  #agribot-icon {
    position: fixed;
    bottom: 20px;
    right: 20px;   /* Left sidebar style */
    width: 200px;
    height: 200px;
    z-index: 9999;
    cursor: pointer;
  }
  #agribot-icon:hover {
  transform: scale(1.1);}
</style>
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
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</body>

</html>