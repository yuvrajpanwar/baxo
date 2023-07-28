<?php
include('includes/header.php');
$sliderContent=slider_content($db);
$popularContent=get_popular_post($db);

$offset=isset($_GET['offset'])?$_GET['offset']:0;
$videoPostContent=video_post_content($db,$offset);


?>

    <div class="breadcrumb-wrap">
        <div class="container">
            <h2 class="breadcrumb-title">Video News</h2>
            <ul class="breadcrumb-menu list-style">
                <li><a href="index.php">Home</a></li>
                <li>Video News</li>
            </ul>
        </div>
    </div>

    <div class="sports-wrap ptb-100">
        <div class="container">
            <div class="row gx-55 gx-5">

                <div class="col-lg-8">

                    <div class="popular-news-wrap">

                        <?php
                            
							$count=1;
                            if(count($videoPostContent)>0)
                            {
                                foreach($videoPostContent as $key=>$value)
                                {
                                    									
                                    $catImg=$value['post_image'];
                                    $catTitle=strip_tags($value['title']);
                                    $catId=base64_encode($value['id']);
                                    $catDate=date("d M Y",strtotime($value['created_on']));
                                    $catAuthor=$value['author'];
                                    $videoLink=$value['video_link'];							                                    
									$pattern = "/(?:www\.|)(?:youtube\.com|m\.youtube\.com|youtu\.|youtube-nocookie\.com)/i";
									
									if($count<=10)
									{

										//<iframe  id='#$catId' src=\"https://www.youtube.com/embed/$vidcode \" class=\"thumb\" height=\"400px\" width=\"750px\"><img src=\"./post_images/$catImg\"  alt=\"\"></iframe>		
                                        //<video id='#$catId' controls poster=' ./post_images/$catImg' height=\"400px\" width=\"650px\">   <source src='$videoLink' type='video/mp4' target='_blank'></video>
                                        
                                        if(preg_match($pattern, $videoLink)) 
									    {

									        preg_match('/(?:http|https)*?:\/\/(?:www\.|)(?:youtube\.com|m\.youtube\.com|youtu\.|youtube-nocookie\.com).*(?:v=|v%3D|v\/|(?:a|p)\/(?:a|u)\/\d.*\/|watch\?|vi(?:=|\/)|\/embed\/|oembed\?|be\/|e\/)([^&?%#\/\n]*)/', $videoLink, $matches, PREG_OFFSET_CAPTURE);
									        $vidcode = $matches[1][0];
                                            
											echo"
                                                    <div class='news-card-five'>
                                                        <div class='news-card-img' >
                                                            <img src='post_images/".$catImg."' alt='Image' >
                                                            <a class='play-now-two' href='#quickview-modal' data-bs-toggle='modal' onclick='change_link(\"".$vidcode."\");'>
                                                                <i class='flaticon-play-button'></i>
                                                            </a>
                                                        </div>
                                                        <div class='news-card-info'>
                                                            <h3><a href='#quickview-modal' data-bs-toggle='modal' onclick='change_link(\"".$vidcode."\");'>".$catTitle."</a></h3>
                                                            
                                                            <ul class='news-metainfo list-style'>
                                                                <li class='author'>                                                                                                       
                                                                    <span>".$catAuthor."</span>
                                                                </li>
                                                                <li><i class='fi fi-rr-calendar-minus'></i><a href='#'>".$catDate."</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                            
                                                ";
                                                

									    }
										else
										{

											echo"";

										}
									}
											
									$count++;
										
						        }
					        }
					    ?>
                      
                    </div>

                    <ul class="page-nav list-style text-center mt-20">
                        <?php if($offset>=10){
                            echo '<a class="mx-4 px-4 pagination-link" href="video-news.php?offset='.($offset-10).' " style="color: blue">Previous Page</a> ';
                        }?>

                        <!-- <li><a class="active" href="business.html">01</a></li>
                        <li><a href="business.html">02</a></li>
                        <li><a href="business.html">03</a></li> -->

                        <?php
                            $temp_offset = $offset + 10;                            
                            $next_videos = video_post_content($db,$temp_offset);                                                      
                            if(!empty($next_videos))
                            {
                            echo '<a class="mx-4 px-4 pagination-link" href="video-news.php?offset='.($offset+10).'" style="color: blue">Next Page</a>';                           
                            }
                            
                        ?>
                    </ul>

                </div>

                <div class="col-lg-4 position-relative">

                <div class="sidebar scrollscreen position-absolute" style="height:100%;max-height:100%">

                    
                        <!-- <div class="sidebar-widget-two">
                            <form action="#" class="search-box-widget">
                                <input type="search" placeholder="Search">
                                <button type="submit">
                                    <i class="fi fi-rr-search"></i>
                                </button>
                            </form>
                        </div> -->
                        
                        <!-- sidebar-widget-category  -->
                        <?php include('includes/sidebar_categories.php');?>

                        <!-- sidebar-widget-recent_posts  -->
                        <?php include('includes/sidebar_recent_posts.php');?>

                        <!-- sidebar-widget-popular_tags  -->
                        <!-- <div class="sidebar-widget">
                            <h3 class="sidebar-widget-title">Popular Tags</h3>
                            <ul class="tag-list list-style">
                                <li><a href="news-by-tags.html">BUSINESS</a></li>
                                <li><a href="news-by-tags.html">FOOD</a></li>
                                <li><a href="news-by-tags.html">SCIENCE</a></li>
                                <li><a href="news-by-tags.html">LIFESTYLE</a></li>
                                <li><a href="news-by-tags.html">SPORTS</a></li>
                                <li><a href="news-by-tags.html">PHOTO</a></li>
                                <li><a href="news-by-tags.html">TECHNOLOGY</a></li>
                                <li><a href="news-by-tags.html">CONTENT</a></li>
                                <li><a href="news-by-tags.html">FEATURED</a></li>
                                <li><a href="news-by-tags.html">AUDIO</a></li>
                                <li><a href="news-by-tags.html">FASHION</a></li>
                            </ul>
                        </div> -->

                </div>

            </div>

            </div>
        </div>
    </div>

        <?php include('./includes/footer.php'); ?>



    <button type="button" id="backtotop" class="position-fixed text-center border-0 p-0">
        <i class="ri-arrow-up-line"></i>
    </button>

    <!-- <div class="modal fade" id="newsletter-popup" tabindex="-1" aria-labelledby="newsletter-popup" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fi fi-rr-cross"></i>
                </button>
                <div class="modal-body">
                    <div class="newsletter-bg bg-f"></div>
                    <div class="newsletter-content">
                        <img src="assets/img/newsletter-icon.webp" alt="Image" class="newsletter-icon">
                        <h2>Join Our Newsletter & Read The New Posts First</h2>
                        <form action="#" class="newsletter-form">
                            <input type="email" placeholder="Email Address">
                            <button type="button" class="btn-one">Subscribe<i class="flaticon-arrow-right"></i></button>
                        </form>
                        <div class="form-check checkbox">
                            <input class="form-check-input" type="checkbox" id="test_21">
                            <label class="form-check-label" for="test_21">
                                I've read and accept <a href="privacy-policy.html">Privacy Policy</a>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="modal fade" id="quickview-modal" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="quickview-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ri-close-line"></i>
                </button>
                <div class="modal-body">
                    <div class="video-popup">
                        <iframe width="885" height="498" src="https://www.youtube.com/embed/3FjT7etqxt8"
                            title="How to Design an Elvis Movie Poster in Photoshop"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen id="video-popup-iframe"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/swiper.bundle.min.js"></script>
    <script src="assets/js/aos.js"></script>
    <script src="assets/js/main.js"></script>

     <!-- for changing link in popup iframe  -->
    <script>
                                function change_link(vidcode)
                                {
                                    
                                    document.getElementById("video-popup-iframe").setAttribute("src","https://www.youtube.com/embed/".concat(vidcode) ); 
                                }
    </script>

     


</body>

<!-- Mirrored from templates.hibootstrap.com/baxo/default/featured-video.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 28 Jun 2023 07:00:55 GMT -->

</html>

<div class="modal fade" id="quickview-modal" data-bs-keyboard="false" tabindex="-1" aria-labelledby="quickview-modal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <button type="button" class="btn_close" data-bs-dismiss="modal" aria-label="Close">
                <i class="ri-close-line"></i>
            </button>
            <div class="modal-body">
                <div class="video-popup">
                    <iframe width="885" height="498" src="https://www.youtube.com/embed/3FjT7etqxt8"
                        title="How to Design an Elvis Movie Poster in Photoshop"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>