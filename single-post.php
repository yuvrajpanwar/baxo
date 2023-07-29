<?php
require_once("./classes/connect_pdo_emp.php");
require_once("./classes/utils.php");
$redirectPath_site=path();
$pdoConnect=new connect_pdo();
$db=$pdoConnect->connectToDB();
require_once("./models/common_db.php");

$tid=isset($_REQUEST['tid'])?base64_decode($_REQUEST['tid']):0;
// $breakingNews=breaking_news_list($db);
//$popularContent=get_popular_post($db);
//$videoPostContent=video_post_content($db,$offset);
$categoryid=category_of_news($db,$tid);
$categoryList=category_listing($db);

$categoryName="";
if(count($categoryList)>0)
{
	foreach($categoryList as $key=>$value)
	{
		if($value['id']==$categoryid)
		{
			$categoryName=$value['name'];
            break;
		}
	}
}
$sliderContent=slider_content($db);
$countRecord=get_news_count($db,$tid);
$newsCount="";
if($countRecord){
  
	$newsCount=$countRecord['counts'];
	$newsId=$countRecord['id'];
	$newsCount++;
	update_count($db,$newsCount,$newsId);

}

if($tid>0)
{
  
	$getPostDetails=get_post_details($db,$tid);
	$postTitle=$getPostDetails['title'];
	$title_for_meta=strip_tags($postTitle);
	$slug_Title=str_replace(" ","_",$getPostDetails['slug_title']);
	$postDescription=$getPostDetails['description'];
	$replace_tag_description=strip_tags($postDescription);
    $data=format_description($replace_tag_description,10);
    $description_for_meta=strip_tags($data);

	$postAuthor=$getPostDetails['author'];
	$postDate=date("d M Y",strtotime($getPostDetails['created_on']));
    $postImage=$getPostDetails['post_image'];
	$image_path="$redirectPath_site/"."post_images/$postImage";
	$full_path="$redirectPath_site/"."post_images/$postImage";
	$meta_url="$redirectPath_site"."/details-".base64_encode($tid);
	$sel_seo_details=$db->query("select * from khabarnewindia_post_seo_details where post_id='$tid' limit 1");
    $sel_post_details=$db->query("select * from khabarnewindia_post_records where id='$tid' limit 1");
    $fetch_post_details=$sel_post_details->fetch(PDO::FETCH_ASSOC);
 
    $description=$fetch_post_details['description'];
    $tags=$fetch_post_details['tag_line'];
  
	$meta_description=strip_tags($description);

    $num_seo_details=$sel_seo_details->rowCount();
    
    if($num_seo_details)
    {
        $fetch_seo_details=$sel_seo_details->fetch(PDO::FETCH_ASSOC);

        $meta_title=$fetch_seo_details['seo_title'];

        
        $seo_keywords=$fetch_seo_details['meta_keywords'];
    }
    else
    {
        $meta_title=$title_for_meta;

        $meta_discription=$description_for_meta;
        $seo_keywords="";
    }
}
 
$prevPostId=$tid-1;
if($prevPostId>0)
{
	$getPrevPostDetails=get_post_details($db,$prevPostId);		 
}

$nextPostId=$tid+1;
if($nextPostId>0)
{
	$getNextPostDetails=get_post_details($db,$nextPostId);

}

?>

<?php include('./includes/header.php'); ?>

<div class="breadcrumb-wrap" style="padding-top:30px;padding-bottom:30px;">
    <div class="container">
        <h2 class="breadcrumb-title"><?= format_description($postTitle,10)?></h2>
        <ul class="breadcrumb-menu list-style">
            <li><a href="index.php">Home</a></li>
            <li><a href="section-<?=base64_encode($categoryid)?>"><?=$categoryName?></a></li>
            <li>समाचार विवरण</li>
        </ul>
    </div>
</div>


<div class="news-details-wrap pt-2 pb-5">
    <div class="container">
        <div class="row gx-55 gx-5">
            <div class="col-lg-8">
                
                <article>
                    <div class="news-img" >
                        <img src="./post_images/<?=$postImage?>" alt="Image" >
                        <a href="section-<?=base64_encode($categoryid)?>" class="news-cat"><?=$categoryName?></a>
                    </div>
                    <ul class="news-metainfo list-style">
                        <li class="author">
                            <p><a href="#"><?=$postAuthor?></a></p>
                        </li>
                        <li><i class="fi fi-rr-calendar-minus"></i><a href="#"><?=$postDate?></a></li>
                        
                    </ul>

                    <div class="news-para">
                        <h1><?=$postTitle?></h1>
                        <p><?=$postDescription?></p>
                    </div>
                    
                </article>

                <div class="post-pagination">

                    <?php 
                        if($getPrevPostDetails!='')
                        {
                    ?>
                            <a class="prev-post" href="details-<?=base64_encode($prevPostId)?>">
                                <span>PREVIOUS</span>
                                <h6><?=$getPrevPostDetails['title']?></h6>
                            </a>

                    <?php
                        }
                    ?>

                    <?php 
                        if($getNextPostDetails!='')
                        {
                    ?>
                            <a class="prev-post" href="details-<?=base64_encode($nextPostId)?>">
                                <span>NEXT</span>
                                <h6><?=$getNextPostDetails['title']?></h6>
                            </a>

                    <?php
                        }
                    ?>

                </div>

                <!-- <h3 class="comment-box-title">3 Comments</h3>
                <div class="comment-item-wrap">
                    <div class="comment-item">
                        <div class="comment-author-img">
                            <img src="assets/img/author/author-thumb-1.webp" alt="Image">
                        </div>
                        <div class="comment-author-wrap">
                            <div class="comment-author-info">
                                <div class="row align-items-start">
                                    <div class="col-md-9 col-sm-12 col-12 order-md-1 order-sm-1 order-1">
                                        <div class="comment-author-name">
                                            <h5>Killian Mider</h5>
                                            <span class="comment-date">Jul 22, 2023 | 7:10 PM</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-12 text-md-end order-md-2 order-sm-3 order-3">
                                        <a href="#cmt-form" class="reply-btn">Reply</a>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-12 order-md-3 order-sm-2 order-2">
                                        <div class="comment-text">
                                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr,
                                                sed diam nonumy eirmod tempor invidunt ut labore et dolore
                                                magna aliquyam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="comment-item reply">
                        <div class="comment-author-img">
                            <img src="assets/img/author/author-thumb-2.webp" alt="Image">
                        </div>
                        <div class="comment-author-wrap">
                            <div class="comment-author-info">
                                <div class="row align-items-start">
                                    <div class="col-md-9 col-sm-12 col-12 order-md-1 order-sm-1 order-1">
                                        <div class="comment-author-name">
                                            <h5>Everly Leah </h5>
                                            <span class="comment-date">Jul 23, 2023 | 7:10 PM</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-12 text-md-end order-md-2 order-sm-3 order-3">
                                        <a href="#cmt-form" class="reply-btn">Reply</a>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-12 order-md-3 order-sm-2 order-2">
                                        <div class="comment-text">
                                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr,
                                                sed diam nonumy eirmod tempor invidunt ut labore et dolore
                                                magna aliquyam erat.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="comment-item">
                        <div class="comment-author-img">
                            <img src="assets/img/author/author-thumb-3.webp" alt="Image">
                        </div>
                        <div class="comment-author-wrap">
                            <div class="comment-author-info">
                                <div class="row align-items-start">
                                    <div class="col-md-9 col-sm-12 col-12 order-md-1 order-sm-1 order-1">
                                        <div class="comment-author-name">
                                            <h5>Michel Ohio</h5>
                                            <span class="comment-date">Jun 14, 2023 | 7:10 PM</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-12 text-md-end order-md-2 order-sm-3 order-3">
                                        <a href="#cmt-form" class="reply-btn">Reply</a>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-12 order-md-3 order-sm-2 order-2">
                                        <div class="comment-text">
                                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr,
                                                sed diam nonumy eirmod tempor invidunt ut labore et dolore
                                                magna aliquyam.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="cmt-form">
                    <div class="mb-30">
                        <h3 class="comment-box-title">Leave A Comment</h3>
                        <p>Your email address will not be published. Required fields are marked.</p>
                    </div>
                    <form action="#" class="comment-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="name" id="name" required placeholder="Name*">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="email" name="email" id="email" required placeholder="Email Address*">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <textarea name="messages" id="messages" cols="30" rows="10"
                                        placeholder="Please Enter Your Comment Here"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check checkbox">
                                    <input class="form-check-input" type="checkbox" id="test_2">
                                    <label class="form-check-label" for="test_2">
                                        Save my info for the next time I commnet.
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <button class="btn-two">Post A Comment<i class="flaticon-right-arrow"></i></button>
                            </div>
                        </div>
                    </form>
                </div> -->

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


<?php include('./includes/footer.php')?>


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

<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/swiper.bundle.min.js"></script>
<script src="assets/js/aos.js"></script>
<script src="assets/js/main.js"></script>

<!-- for default img  -->
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const images = document.getElementsByTagName('img');      
        for (let i = 0; i < images.length; i++) {  
            const img = new Image();
            img.src = images[i].getAttribute("src");

            img.onerror = () => {
            images[i].setAttribute("src","/baxo/default_img.jpg");
            };      
        }

    });
</script>

</body>

<!-- Mirrored from templates.hibootstrap.com/baxo/default/sports-details.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 28 Jun 2023 07:00:55 GMT -->

</html>