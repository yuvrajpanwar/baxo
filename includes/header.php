<?php
require_once("./classes/connect_pdo_emp.php");
require_once("./classes/utils.php");
$redirectPath_site=path();
$pdoConnect=new connect_pdo();
$db=$pdoConnect->connectToDB();
require_once("./models/common_db.php");
$categoryList=category_listing($db);
?>

<!DOCTYPE html>
<html lang="zxx">

<!-- Mirrored from templates.hibootstrap.com/baxo/default/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 28 Jun 2023 07:00:27 GMT -->

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/remixicon.css">
    <link rel="stylesheet" href="assets/css/uicons-regular-rounded.css">
    <link rel="stylesheet" href="assets/css/flaticon_baxo.css">
    <link rel="stylesheet" href="assets/css/swiper.bundle.min.css">
    <link rel="stylesheet" href="assets/css/aos.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/footer.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/css/dark-theme.css">
    <title>Baxo - Responsive Blog HTML Template</title>
    <link rel="icon" type="image/png" href="assets/img/favicon.webp">

    <style>
        .news-card-one .news-card-img
        {
            
            width: 100px; /* Adjust the size to your desired width and height */
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .news-card-one .news-card-img img
        {
            
            width: 100%;
            height:100%;
            object-fit: cover;
            object-position: center;
        }

        @media screen and (min-width:1200px){
            .small-img-cards-3col{
                width:120px;
                height:120px;
            }
            .small-img-cards-2col{
                width: 213px;
                height: 171px;
            }

            .news-card-two .news-card-img{
                width: 321px; /* Adjust the size to your desired width and height */
                height: 230px;
                overflow: hidden;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .news-card-two .news-card-img img
            {
                width: 100%;
                height:100%;
                object-fit: cover;
                object-position: center;
            }

            .news-card-three .news-card-img{
                width: 120px; /* Adjust the size to your desired width and height */
                height: 120px;
                overflow: hidden;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .news-card-three .news-card-img img
            {
                width: 100%;
                height:100%;
                object-fit: cover;
                object-position: center;
            }

            .news-card-four {
                width: 560px; /* Adjust the size to your desired width and height */
                height: 317px;
                overflow: hidden;
                display: flex;
                justify-content: center;
                align-items: center;
                margin: auto;
                margin-top: 30px;
                margin-bottom : 30px;
            }
            .news-card-four img
            {
                width: 100%;
                height:100%;
                object-fit: cover;
                object-position: center;
            }

            .news-card-five .news-card-img{
                width: 190px; /* Adjust the size to your desired width and height */
                height: 120px;
                overflow: hidden;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .news-card-five .news-card-img img
            {
                width: 100%;
                height:100%;
                object-fit: cover;
                object-position: center;
            }


            .news-card-six .news-card-img{
                overflow: hidden;
                height:153px;
                width:270px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .news-card-six .news-card-img img
            {
                width: 100%;
                height:100%;
                object-fit: cover;
                object-position: center
            }
            .news-card-seven .news-card-img{
                overflow: hidden;
                height:90px;
                width:160px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .news-card-seven .news-card-img img
            {
                width: 100%;
                height:100%;
                object-fit: cover;
                object-position: center;
            }

            .news-card-eight .news-card-img{
                overflow: hidden;
                height:317px;
                width:560px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .news-card-eight .news-card-img img
            {
                width: 100%;
                height:100%;
                object-fit: cover;
                object-position: center;
            }


            .news-card-nine {
                overflow: hidden;
                height:194px;
                width:347px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .news-card-nine img
            {
                width: 100%;
                height:100%;
                object-fit: cover;
                object-position: center;
            }

            .news-card-eleven .news-card-img{
                overflow: hidden;
                height:327px;
                width:577px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .news-card-eleven .news-card-img img
            {
                width: 100%;
                height:100%;
                object-fit: cover;
                object-position: center;
            }
            .news-card-thirteen .news-card-img{
                overflow: hidden;
                height:198px;
                width:352px;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .news-card-thirteen .news-card-img img
            {
                width: 100%;
                height:100%;
                object-fit: cover;
                object-position: center;
            }


            article .news-img{
                overflow: hidden;
                height:412px;
                width:700px;
                display: flex;
                flex-direction: row;
            }
            article .news-img img
            {
                flex: 1;
                width: 100%;
                height:auto;
            }

        }

        @media screen and (min-width: 480px) {
        .leftsidebar {width: 300px; float: left;}       
        }

       @media (min-width: 992px) {
        .sidebar-toggler {
            display: none;
        }
        }

        a.pagination-link {
            color: blue !important; /* Unclicked link color */
            text-decoration: none !important; /* Remove underline */
        }

        a.pagination-link:hover {
            color: red !important; /* Hovered link color */
        }

        a.pagination-link:visited {
            color: red !important; /* Visited link color */
        }

        a.pagination-link:focus {
            color: red !important; /* active link color */
        }

        @media screen and (max-width: 767px) {
            .news-card-two .news-card-img, .news-card-three .news-card-img, .news-card-four .news-card-img, .news-card-five .news-card-img, .news-card-six .news-card-img, .news-card-seven .news-card-img, .news-card-eight .news-card-img, .news-card-nine .news-card-img, .news-card-ten .news-card-img, .news-card-eleven .news-card-img,.news-card-twelve .news-card-img, .news-card-thirteen .news-card-img
            {
                width: 100%;
                height: 286px; 
                overflow: hidden;
                display: flex;
                justify-content: center;
                align-items: center;
            } 
            
            .news-card-img img
            {
                width: 100%;
                height:100%;
                object-fit: cover;
                object-position: center;
            }
        }
        @media screen and (max-width: 480px) {
            .news-card-two .news-card-img, .news-card-three .news-card-img, .news-card-four .news-card-img, .news-card-five .news-card-img, .news-card-six .news-card-img, .news-card-seven .news-card-img, .news-card-eight .news-card-img, .news-card-nine .news-card-img, .news-card-ten .news-card-img, .news-card-eleven .news-card-img,.news-card-twelve .news-card-img, .news-card-thirteen .news-card-img
            {
                width: 100%;
                height: 226px; 
                overflow: hidden;
                display: flex;
                justify-content: center;
                align-items: center;
            }

        }

    </style>

</head>

<body>

    <div class="loader-wrapper">
        <div class="loader"></div>
        <div class="loader-section section-left"></div>
        <div class="loader-section section-right"></div>
    </div>


    <div class="switch-theme-mode">
        <label id="switch" class="switch">
            <input type="checkbox" onchange="toggleTheme()" id="slider">
            <span class="slider round"></span>
        </label>
    </div>

    <!-- main nevbar  -->
    <div class="navbar-area header-one" id="navbar">

        
        <div class="header-top">
            <div class="container-fluid">                       
                <div class="row align-items-center justify-content-end ">

                    <!-- <div class="col-lg-4 col-md-6 col-5">
                        <button class="subscribe-btn" data-bs-toggle="modal"
                            data-bs-target="#newsletter-popup">Subscribe<i class="flaticon-right-arrow"></i></button>
                    </div> -->
                    <div class="col-lg-4 col-md-6 md-none offset-lg-4">
                        <a class="navbar-brand" href="index.php">
                            <img class="logo-light" src="assets/img/logo-white.webp" alt="logo">
                            <img class="logo-dark" src="assets/img/logo-white.webp" alt="logo">
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6 col-7 pr-4">
                        <ul class="social-profile list-style ">
                            <li>
                                <a href="https://www.fb.com/" target="_blank">
                                    <i class="ri-facebook-fill"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.twitter.com/" target="_blank">
                                    <i class="ri-twitter-fill"></i>
                                </a>
                            </li>
                            <li><a href="https://www.instagram.com/" target="_blank">
                                <i class="ri-instagram-line"></i>
                                </a>
                            </li>
                            <!-- <li>
                                <a href="https://www.linkedin.com/" target="_blank"><i class="ri-linkedin-fill"></i></a>
                            </li> -->
                        </ul>
                    </div>

                </div>                  
            </div>
        </div>

        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg">
                <a class="sidebar-toggler md-none" data-bs-toggle="offcanvas" href="#navbarOffcanvas" role="button"
                    aria-controls="navbarOffcanvas" style="width: 30px;">
                    <img src="assets/img/icons/menubar-white.svg" alt="Image">
                </a>

                <a class="navbar-brand d-lg-none" href="index.php">
                    <img class="logo-light" src="assets/img/logo-white.webp" alt="logo">
                    <img class="logo-dark" src="assets/img/logo-white.webp" alt="logo">
                </a>

                <button type="button" class="search-btn d-lg-none" data-bs-toggle="modal" data-bs-target="#searchModal">
                    <i class="flaticon-loupe"></i>
                
                </button>

                <a class="navbar-toggler" data-bs-toggle="offcanvas" href="#navbarOffcanvas" role="button"
                    aria-controls="navbarOffcanvas">
                    <span class="burger-menu">
                        <span class="top-bar"></span>
                        <span class="middle-bar"></span>
                        <span class="bottom-bar"></span>
                    </span>
                </a>

                <div class="collapse navbar-collapse">

                    <ul class="navbar-nav mx-auto">

                        <li class="nav-item">
                            <a href="index.php" class=" nav-link">
                                होम
                            </a>
                        </li>
                       
                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle" href="section-<?=base64_encode($categoryList[0]['id'])?>"><?=$categoryList[0]['name']?> </a>
                            <ul class="dropdown-menu">
                                    <?php
                                        $first_count=1;
                                        foreach($categoryList as $menu_category_second_index => $fetch_menu_category_second)
                                        {
                                            $menu_category_id =$fetch_menu_category_second ['id'];
                                            $menuencode_cat_id=base64_encode($menu_category_id);
                                            $menu_category_name =$fetch_menu_category_second ['name'];

                                            if($first_count==78 || $first_count==73|| $first_count==4 ||$first_count==81||$first_count==6||$first_count==51||$first_count==8||$first_count==63||$first_count==70||$first_count==34||$first_count==39||$first_count==13||$first_count==14||$first_count==84)
                                            {
                                                echo "<li class='nav-item'><a class='nav-link' href=\"$redirectPath_site/section-$menuencode_cat_id\">$menu_category_name</a></li>";
                                            }

                                            $first_count++;

                                        }
                                    ?>
							</ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link dropdown-toggle" href="section-<?=base64_encode($categoryList[14]['id'])?>"><?=$categoryList[14]['name']?></a>
                            <ul class="dropdown-menu">
                                <?php
                                        $second_count=1;
                                        foreach($categoryList as $menu_category_second_index => $fetch_menu_category_second)
                                        {
                                            $menu_category_id =$fetch_menu_category_second ['id'];
                                            $menuencode_cat_id=base64_encode($menu_category_id);
                                            $menu_category_name =$fetch_menu_category_second ['name'];

											if($second_count>=97)
                                            {
                                                echo "<li class='nav-item'><a class='nav-link' href=\"$redirectPath_site/section-$menuencode_cat_id\">$menu_category_name</a></li>";
                                            }
                                            if($second_count>101)
                                            {
                                            break;
                                            }
                    
                                        $second_count++;
                                   }
                                
                                ?> 
                             </ul>
                        </li>

                        <li class="nav-item"><a class="nav-link" href="section-<?=base64_encode($categoryList[16]['id'])?>"><?=$categoryList[16]['name']?></a></li>
                        
                        <li class="nav-item"><a class="nav-link" href="section-<?=base64_encode($categoryList[102]['id'])?>"><?=$categoryList[102]['name']?></a></li>

                        <li class="nav-item"><a class="nav-link" href="section-<?=base64_encode($categoryList[18]['id'])?>"><?=$categoryList[18]['name']?></a></li>

                        <li class="nav-item"><a class="nav-link" href="section-<?=base64_encode($categoryList[21]['id'])?>"><?=$categoryList[21]['name']?></a></li>

                        <li class="nav-item"><a class="nav-link" href="section-<?=base64_encode($categoryList[24]['id'])?>"><?=$categoryList[24]['name']?></a></li>

                        <li class="nav-item"><a class="nav-link" href="section-<?=base64_encode($categoryList[103]['id'])?>"><?=$categoryList[103]['name']?></a></li>

                        <li class="nav-item"><a class="nav-link" href="section-<?=base64_encode($categoryList[104]['id'])?>"><?=$categoryList[104]['name']?></a></li>
                       
                        <li class="nav-item"><a href="video-news.php" class=" nav-link">वीडियो</a></li>

                        <!-- <li class="nav-item">
                            <a href="javascript:void(0)" class="dropdown-toggle nav-link">
                                Pages
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item">
                                    <a href="about.html" class="nav-link">
                                        About Us
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="contact.html" class="nav-link">
                                        Contact Us
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="team.html" class="nav-link">
                                        Team
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="author.html" class="nav-link">
                                        Author
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="privacy-policy.html" class="nav-link">
                                        Privacy Policy
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="terms-conditions.html" class="nav-link">
                                        Terms & Conditions
                                    </a>
                                </li>
                            </ul>
                        </li> -->

                        <!-- <li class="nav-item">
                            <a class="nav-link dropdown-toggle" href="#">अन्य</a>
                            <ul class="dropdown-menu">
                                <?php
                                        $second_count=1;
                                        foreach($categoryList as $menu_category_second_index => $fetch_menu_category_second)
                                        {
                                            $menu_category_id =$fetch_menu_category_second ['id'];
                                            $menuencode_cat_id=base64_encode($menu_category_id);
                                            $menu_category_name =$fetch_menu_category_second ['name'];

											if($second_count==16 || $second_count==87 || $second_count==88 ||$second_count==89 ||$second_count==97 ||$second_count==100 )
                                            {
                                                echo "<li class='nav-item'><a class='nav-link' href=\"$redirectPath_site/section-$menuencode_cat_id\">$menu_category_name</a></li>";
                                            }
                                            if($second_count>101)
                                            {
                                            break;
                                            }
                    
                                        $second_count++;
                                   }
                                
                                ?> 
                             </ul>
                        </li> -->

                    </ul>

                    <!-- <div class="others-option d-flex align-items-center">

                        <div class="option-item">
                            <button type="button" class="search-btn" data-bs-toggle="modal"
                                data-bs-target="#searchModal">
                                <i class="flaticon-loupe"></i>
                            </button>
                        </div>

                        <div class="option-item">
                            <a href="login.html" class="btn-two">Sign In</a>
                        </div>
                    </div> -->

                </div>
            </nav>
        </div>

    </div>


    <!-- side nevbar  -->
    <div class="responsive-navbar offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="navbarOffcanvas">
        
        <div class="offcanvas-header">
            <a href="index.php" class="logo d-inline-block">
                <img class="logo-light" src="assets/img/logo.webp" alt="logo">
                <img class="logo-dark" src="assets/img/logo-white.webp" alt="logo">
            </a>
            <button type="button" class="close-btn" data-bs-dismiss="offcanvas" aria-label="Close">
                <i class="ri-close-line"></i>
            </button>
        </div>

        <div class="offcanvas-body">
            <div class="accordion" id="navbarAccordion">
                <div class="accordion-item">
                    <b><a href="index.php" class=" nav-link">
                        होम
                    </a><b>                    
                </div>
                <div class="accordion-item">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapbaxour" aria-expanded="false" aria-controls="collapbaxour">
                        <?=$categoryList[0]['name']?>
                    </button>
                    <div id="collapbaxour" class="accordion-collapse collapse" data-bs-parent="#navbarAccordion">
                        <div class="accordion-body">
                            <div class="accordion" id="navbarAccordion45">
                                <div class="accordion-item">
                                    <?php
                                        $first_count=1;
                                        foreach($categoryList as $menu_category_second_index => $fetch_menu_category_second)
                                        {
                                            $menu_category_id =$fetch_menu_category_second ['id'];
                                            $menuencode_cat_id=base64_encode($menu_category_id);
                                            $menu_category_name =$fetch_menu_category_second ['name'];

                                            if($first_count==78 || $first_count==73|| $first_count==4 ||$first_count==81||$first_count==6||$first_count==51||$first_count==8||$first_count==63||$first_count==70||$first_count==34||$first_count==39||$first_count==13||$first_count==14||$first_count==84)
                                            {
                                                echo "<div class='accordion-item'><a class='accordion-link' href=\"$redirectPath_site/section-$menuencode_cat_id\">$menu_category_name</a></div>";
                                            }

                                            $first_count++;

                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <?=$categoryList[14]['name']?>
                    </button>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#navbarAccordion">
                        <div class="accordion-body">
                            <div class="accordion" id="navbarAccordion7">

                                <?php
                                        $second_count=1;
                                        foreach($categoryList as $menu_category_second_index => $fetch_menu_category_second)
                                        {
                                            $menu_category_id =$fetch_menu_category_second ['id'];
                                            $menuencode_cat_id=base64_encode($menu_category_id);
                                            $menu_category_name =$fetch_menu_category_second ['name'];

											if($second_count>=97)
                                            {
                                                echo "<div class='accordion-item'><a class='accordion-link' href=\"$redirectPath_site/section-$menuencode_cat_id\">$menu_category_name</a></div>";
                                            }
                                            if($second_count>101)
                                            {
                                            break;
                                            }
                    
                                        $second_count++;
                                   }
                                
                                ?>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <b><a class="nav-link" href="section-<?=base64_encode($categoryList[16]['id'])?>"><?=$categoryList[16]['name']?></a></b>                   
                </div>
                <div class="accordion-item">
                    <b><a class="nav-link" href="section-<?=base64_encode($categoryList[102]['id'])?>"><?=$categoryList[102]['name']?></a></b>                   
                </div>
                <div class="accordion-item">
                    <a class="nav-link" href="section-<?=base64_encode($categoryList[18]['id'])?>"><?=$categoryList[18]['name']?></a>                    
                </div>
                <div class="accordion-item">
                    <a class="nav-link" href="section-<?=base64_encode($categoryList[21]['id'])?>"><?=$categoryList[21]['name']?></a>                    
                </div>
                <div class="accordion-item">
                    <a href="video-news.php" class=" nav-link">वीडियो</a>                    
                </div>
            </div>
            <div class="offcanvas-contact-info">
                <h4>Contact Info</h4>
                <ul class="contact-info list-style">
                    <li>
                        <i class="ri-map-pin-fill"></i>
                        <p>28/A Street, New York, USA</p>
                    </li>
                    <li>
                        <i class="ri-mail-fill"></i>
                        <a
                            href="https://templates.hibootstrap.com/cdn-cgi/l/email-protection#91f9f4fdfdfed1f3f0e9febff2fefc"><span
                                class="__cf_email__"
                                data-cfemail="f49c9198989bb496958c9bda979b99">[email&#160;protected]</span></a>
                    </li>
                    <li>
                        <i class="ri-phone-fill"></i>
                        <a href="tel:1800123456789">+1 800 123 456 789</a>
                    </li>
                </ul>
                <ul class="social-profile list-style">
                    <li><a href="https://www.fb.com/" target="_blank"><i class="ri-facebook-fill"></i></a></li>
                    <li><a href="https://www.instagram.com/" target="_blank"><i class="ri-instagram-line"></i></a></li>
                    <!-- <li><a href="https://www.linkedin.com/" target="_blank"><i class="ri-linkedin-fill"></i></a></li> -->
                    <li><a href="https://www.twitter.com/" target="_blank"><i class="ri-twitter-fill"></i></a></li>
                </ul>
            </div>
            <div class="others-option d-flex d-lg-none align-items-center">
                <div class="option-item">
                    <a href="login.html" class="btn-two">Sign In</a>
                </div>
            </div>
        </div>

    </div>

    <div class="modal fade searchModal" id="searchModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <input type="text" class="form-control" placeholder="Search here....">
                    <button type="submit"><i class="fi fi-rr-search"></i></button>
                </form>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                        class="ri-close-line"></i></button>
            </div>
        </div>
    </div>