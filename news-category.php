<?php
require_once("./classes/connect_pdo_emp.php");
require_once("./classes/utils.php");
$redirectPath_site=path();
$pdoConnect=new connect_pdo();
$db=$pdoConnect->connectToDB();
require_once("./models/common_db.php");
// $breakingNews=breaking_news_list($db);
$categoryList=category_listing($db);
$sliderContent=slider_content($db);
$popularContent=get_popular_post($db);
// $videoPostContent=video_post_content($db,$offset);
$tid=isset($_REQUEST['tid'])?base64_decode($_REQUEST['tid']):0;

$categoryList=category_listing($db);
$sliderContent=slider_content($db);
$offset=isset($_GET['offset'])?$_GET['offset']:0;
$limit=8;
$count=1;
$postContent=post_content($db,$tid,$offset,$limit);
$postDetails="";
$categoryName="";
if(count($categoryList)>0)
{
	foreach($categoryList as $key=>$value)
	{
		if($value['id']==$tid)
		{
			$categoryName=$value['name'];
            break;
		}
	}
}
?>

    <?php
    require_once('includes/header.php');
    ?>
   
    <div class="breadcrumb-wrap" style="padding-top:30px;padding-bottom:30px;">
        <div class="container">
            <h2 class="breadcrumb-title"><?=$categoryName?></h2>
            <ul class="breadcrumb-menu list-style">
                <li><a href="index.php">Home</a></li>
                <li><?=$categoryName?></li>
            </ul>
        </div>
    </div>


    <div class="sports-wrap pb-100 pt-0">
        <div class="container">
            <div class="row gx-55 gx-5 ">
                <div class="col-lg-8">
                    <div class="row justify-content-left" id="posts_container">

                        <?php
                            if(count($postContent)>0)
                            {
	                            foreach($postContent as $key=>$value)
	                            {
                                    $img=$value['post_image'];
                                    $title=format_description(strip_tags($value['title']),20);                                  
                                    $id=base64_encode($value['id']);
                                    $date=date("d M Y",strtotime($value['created_on']));
                                    $author=$value['author'];
                                    $description=strip_tags($value['description']);
                                    if($description!="")
                                    {
                                        $description=format_description($description,$numberOfWords=20);
                                            
                                    }
                        ?>

                        <div class="col-md-6">
                            <div class="news-card-thirteen">
                                <div class="news-card-img">
                                    <img src="post_images/<?=$img?>" alt="Iamge">
                                    <!-- <a href="section-<?=base64_encode($tid)?>" class="news-cat"><?=$categoryName?></a> -->
                                </div>
                                <div class="news-card-info">
                                    <h3><a href="details-<?=$id?>"><?=$title?></a></h3>
                                    <ul class="news-metainfo list-style">
                                        <li><i class="fi fi-rr-calendar-minus"></i><a href="#"><?=$date?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <?php
                                
                                }
                            }
                        ?>

                    </div>

                    <ul class="page-nav list-style text-center mt-20">

                 

                        <!-- <li><a class="active" href="business.html">01</a></li>
                        <li><a href="business.html">02</a></li>
                        <li><a href="business.html">03</a></li> -->

                        <!-- <?php 
                            $next_posts=post_content($db,$tid,$offset+8,$limit);
                            if(!empty($next_posts))
                            {
                            echo '<a class="mx-4 px-2 pagination-link" href="news-category.php?offset='.($offset+8).'&tid='.base64_encode($tid).'" style="color: blue">Next Page</a>';
                            
                            }
                            
                            
                        ?> -->


                        <!-- <?php 
                            
                            $next_posts=post_content($db,$tid,$offset+8,$limit);
                            if(!empty($next_posts))
                            {
                            echo '<button data-offset="0" class="mx-4 px-2 pagination-link btn btn-danger" onclick="load_more();" id="load_more">Load More</button>';
                            
                            }
                            
                            
                        ?> -->

                        <button data-offset="8" class="mx-4 px-2 pagination-link btn btn-danger" onclick="load_more();" id="load_more">Load More</button>                        
                        
                        
                      

<!-- to load more content -->
<script>
    tid = <?=$tid?> ;
  function load_more() {
    var load_more_button = document.getElementById("load_more");
    load_more_button.innerText = "Loading....";

    // Get the current offset value from the button's data-offset attribute
    var currentOffset = parseInt(load_more_button.getAttribute("data-offset"));

    // Send an AJAX request to load_more_posts.php to get the next set of posts
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // Parse the response JSON and update the offset
          var next_posts = JSON.parse(xhr.responseText);
          var posts_container = document.getElementById("posts_container");

          if (next_posts.length === 0) {
            // Hide the button if there are no more posts to load
            load_more_button.style.display = "none";
          } else {
            // Append new posts and update the offset value on the button
            for (var i = 0; i < next_posts.length; i++) {
              // Create the HTML for the new post and append it to the container
              var new_post =
                '<div class="col-md-6"><div class="news-card-thirteen"><div class="news-card-img"><img src="post_images/' +
                next_posts[i].post_image +
                '" alt="Image"></div><div class="news-card-info"><h3><a href="details-' +
                next_posts[i].id +
                '">' +
                next_posts[i].title +
                '</a></h3><ul class="news-metainfo list-style"><li><i class="fi fi-rr-calendar-minus"></i><a href="#">' +
                next_posts[i].created_on +
                '</a></li> </ul></div></div></div>';
              posts_container.innerHTML += new_post;
              setDefaultImg();
            }

            // Update the offset value on the button
            var newOffset = currentOffset + 8;
            load_more_button.setAttribute("data-offset", newOffset);
          }

          // Change the button text back to "Load More"
          load_more_button.innerText = "Load More";
        } else {
          console.error("Error loading more posts:", xhr.status, xhr.statusText);
          load_more_button.innerText = "Load More"; // Change the button text back to "Load More" in case of error
        }
      }
    };

    // Construct the URL for the AJAX request with updated offset and tid parameters
    var tid = <?=$tid?>; // You need to pass the PHP value to the JavaScript context
    var url = "load_more_posts.php?tid=" + tid + "&offset=" + currentOffset;

    // Send the AJAX request
    xhr.open("GET", url, true);
    xhr.send();
  }
</script>




                        <!-- <script>
                            function load_more()
                            {
                                    load_more_button = document.getElementById("load_more");
                                    load_more_button.innerText = "Loading...."; 

                                    <?php 
                                        echo "console.log(". $offset    .");";
                                        $offset = $offset + 8 ;
                                        $next_posts = post_content($db,$tid,$offset,$limit);
                                        echo "console.log(". $offset    .");";
                                    ?>
                                    
                                    var next_posts = <?=json_encode($next_posts)?>;
                                    posts_container = document.getElementById("posts_container");

                                    for(i=0;i<next_posts.length;i++)
                                    {
                                        new_post = '<div class="col-md-6"><div class="news-card-thirteen"><div class="news-card-img"><img src="post_images/' + next_posts[i].post_image + '" alt="Iamge"></div><div class="news-card-info"><h3><a href="details-' + next_posts[i].id + '">'+ next_posts[i].title+'</a></h3><ul class="news-metainfo list-style"><li><i class="fi fi-rr-calendar-minus"></i><a href="#">'+ next_posts[i].created_on+'</a></li> </ul></div></div></div>'
                                        posts_container.innerHTML+=new_post;
                                    }
                                    // load_more_button.innerHTML = "Load More"; 
                            }

                        </script> -->
                        

                    </ul>

                </div>
                <div class="col-lg-4 ">
                    <div class="sidebar">


                        <!-- sidebar-widget-category  -->
                        <?php include('includes/sidebar_categories.php');?>

                        <!-- sidebar-widget-recent_posts  -->
                        <?php include_once('includes/sidebar_recent_posts.php');?>

                        

                    </div>
                </div>
            </div>
        </div>
    </div>


      
        <?php include('./includes/footer.php') ?>



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
                            allowfullscreen></iframe>
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


<!-- for default img  -->
<script>
    document.addEventListener('DOMContentLoaded',setDefaultImg);

    function setDefaultImg()
    {

        const images = document.getElementsByTagName('img');      
        for (let i = 0; i < images.length; i++) {  
            const img = new Image();
            img.src = images[i].getAttribute("src");

            img.onerror = () => {
            // images[i].setAttribute("src","/baxo/default_img.jpg");
            images[i].setAttribute("src","/default_img.jpg");

            };      
        }

    }

</script>

</body>

<!-- Mirrored from templates.hibootstrap.com/baxo/default/business.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 28 Jun 2023 07:00:53 GMT -->

</html>