<?php
require_once("./classes/connect_pdo_emp.php");
require_once("./classes/utils.php");
$redirectPath_site=path();
$pdoConnect=new connect_pdo();
$db=$pdoConnect->connectToDB();
require_once("./models/common_db.php");
//$breakingNews=breaking_news_list($db);
$categoryList=category_listing($db);

$sliderContent=slider_content($db);
$popularContent=get_popular_post($db);
$offset=0;
$videoPostContent=video_post_content($db,$offset);

?>

    <!-- common header  -->
    <?php include ('./includes/header.php'); ?>
    <!-- common header end  -->

    <div class="container-fluid">
        <div class="trending-news-box">
            <div class="row gx-5">
                <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4">
                    <h4>Breaking News </h4>
                    <div class="trending-prev"><i class="flaticon-left-arrow"></i></div>
                    <div class="trending-next"><i class="flaticon-right-arrow"></i></div>
                </div>
                <div class="col-xxl-10 col-xl-9 col-lg-9 col-md-8">
                    <div class="trending-news-slider swiper">
                        <div class="swiper-wrapper">
                            
                            <?php
                                
                                foreach($popularContent as $key => $value)
                                {
                                    $catImg=$value['post_image'];
                                    $catTitle=strip_tags($value['title']);
                                    $catDate=date("d M Y",strtotime($value['created_on']));
                                    $catAuthor=$value['author'];
                                    $catId=base64_encode($value['id']);
                                    $count=1;

                                    if($count<5)
                                    echo"
                                        <div class='swiper-slide news-card-one'>
                                            <a href='details-$catId'><div class='news-card-img'>
                                                <img src='./post_images/$catImg' alt='Image'>
                                                </div></a>
                                            <div class='news-card-info'>
                                                <h3><a href='details-$catId'>".format_description($catTitle, 15)."</a></h3>
                                                <ul class='news-metainfo list-style'>
                                                    <li><i class='fi fi-rr-clock-three'></i>$catDate</li>
                                                </ul>
                                            </div>
                                        </div>
                                    ";
                                    $count++;
                                }
                            ?>
                                                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container-fluid pb-75">
        <div class="news-col-wrap">

            <div class="news-col-one">
                <?php 
                $postContent=post_content($db,$categoryList[5]['id'],$offset=0,$limit=8); 
                echo '
                <a href="details-'.  base64_encode($postContent['0']['id'])  . '">
                    <div class="news-card-two">
                        <div class="news-card-img">
                            <img  src="./post_images/'.$postContent[0]['post_image'].'" alt="Image">
                            <a href="section-' . base64_encode($categoryList[5]['id']) . '" class="news-cat">' .$categoryList[5]['name']. '</a>
                        </div>
                        <div class="news-card-info">
                            <h3><a href="details-'.  base64_encode($postContent['0']['id'])  . '">'.format_description($postContent[0]['title'], 15). '</a></h3>
                            <ul class="news-metainfo list-style">
                                <li><i class="fi fi-rr-calendar-minus"></i><a href="#">'.$postContent[0]['created_on'].'</a></li>
                            </ul>
                        </div>
                    </div>
                </a>
                ';
                ?>

                <?php
                $postContent=post_content($db,$categoryList[0]['id'],$offset=0,$limit=3);
                $count=1;

                if(count($postContent)>0)
                {
                foreach($postContent as $key=>$value)
                {
                    $catImg=$value['post_image'];
                    $catTitle=format_description(strip_tags($value['title']),$numberOfWords=15);
                    $catDate=date("d M Y",strtotime($value['created_on']));
                    $catAuthor=$value['author'];
                    $catId=base64_encode($value['id']);
                    $catDesc=format_description(strip_tags($value['description']),$numberOfWords=15);
                
                    if($count<=1)
                    {
                    ?>

                        
                            <div class="news-card-three">
                               
                                    <div class="news-card-img">
                                        <a href="details-<?=$catId?>">
                                            <img src="./post_images/<?=$catImg?>" alt="Image">
                                        </a>
                                    </div>
                                    <div class="news-card-info">
                                        <a href="section-<?=base64_encode($categoryList['0']['id'])?>" class="news-cat"><?=$categoryList['0']['name']?></a>
                                        <h3><a href="details-<?=$catId?>"><?=$catTitle?></a>
                                        </h3>
                                        <ul class="news-metainfo list-style">
                                            <li><i class="fi fi-rr-calendar-minus"></i><a href="#"><?=$catDate?></a></li>
                                        </ul>
                                    </div> 
                                
                            </div> 
                    

                        <?php
                        }
                    }
                } 
                ?>  
                        
            </div>

            <div class="news-col-two">
            
                <div class="news-card-eight">
                
                    <?php $postContent=post_content($db,$categoryList[5]['id'],$offset=0,$limit=8);?>
                    
                        <img src="./post_images/<?=$postContent['2']['post_image']?>" alt="Image">
                    
                    <div class="news-card-info">
                        <h3 style="font-size: 19px;"><a href="details-<?=base64_encode($postContent['2']['id'])?>"><?=format_description($postContent['2']['title'], $numberOfWords=20)?></a></h3>
                        <ul class="news-metainfo list-style">
                            <li><i class="fi fi-rr-calendar-minus"></i><a href=""><?=$postContent['2']['created_on']?></a></li>
                        </ul>
                    </div>
                
                </div>

                <div class="news-card-five">
                    <?php $postContent=post_content($db,$categoryList[0]['id'],$offset=0,$limit=8);
                    $catDesc=format_description(strip_tags($postContent[3]['description']),$numberOfWords=20);?>
                    <div class="news-card-img">
                        <a href="details-<?=base64_encode($postContent[3]['id'])?>"><img src="post_images/<?=$postContent[3]['post_image']?>" alt="Image" class='small-img-cards-2col'></a>
                        <a href="section-<?=base64_encode($categoryList['0']['id'])?>" class="news-cat"><?=$categoryList[0]['name']?></a>
                    </div>
                    <div class="news-card-info">
                        <h3><a href="details-<?=base64_encode($postContent[3]['id'])?>"><?=format_description($postContent[3]['title'], $numberOfWords)?></a></h3>
                        <p><?=$catDesc?>....</p>
                        <ul class="news-metainfo list-style">
                            <li><i class="fi fi-rr-calendar-minus"></i><a href="#"><?=$postContent[3]['created_on']?></a></li>
                            
                        </ul>
                    </div>
                </div>

                <div class="news-card-five">
                    <?php $postContent=post_content($db,$categoryList[14]['id'],$offset=0,$limit=8);
                    $catDesc=format_description(strip_tags($postContent[3]['description']),$numberOfWords=21);?>
                    <div class="news-card-img">
                        <a href="details-<?=base64_encode($postContent[3]['id'])?>"><img src="post_images/<?=$postContent[3]['post_image']?>" alt="Image" class='small-img-cards-2col'></a>
                        <a href="section-<?=base64_encode($categoryList['14']['id'])?>" class="news-cat"><?=$categoryList[14]['name']?></a>
                    </div>
                    <div class="news-card-info">
                        <h3><a href="details-<?=base64_encode($postContent[3]['id'])?>"><?=format_description($postContent[3]['title'], $numberOfWords=15)?></a></h3>
                        <p><?=$catDesc?>....</p>
                        <ul class="news-metainfo list-style">
                            <li><i class="fi fi-rr-calendar-minus"></i><a href="#"><?=$postContent[3]['created_on']?></a></li>
                            
                        </ul>
                    </div>
                </div>

            </div>

            <div class="news-col-three">

                <?php 
                $postContent=post_content($db,$categoryList[5]['id'],$offset=0,$limit=8); 
                echo '
                <a href="details-'.base64_encode($postContent['1']['id']).'">
                    <div class="news-card-two">
                    <div class="news-card-img">
                        <img src="./post_images/'.$postContent[1]['post_image'].'" alt="Image">
                        <a href="section-'.base64_encode($categoryList[5]['id']).'" class="news-cat">' .$categoryList[5]['name']. '</a>
                    </div>
                    <div class="news-card-info">
                        <h3><a href="details-'.base64_encode($postContent['1']['id']).'">'.format_description($postContent[1]['title'], $numberOfWords=15).'</a></h3>
                        <ul class="news-metainfo list-style">
                            <li><i class="fi fi-rr-calendar-minus"></i><a href="#">'.$postContent[1]['created_on'].'</a></li>
                        </ul>
                    </div>
                    </div>
                </a>
                ';
                ?>

                <?php
                $postContent=post_content($db,$categoryList[14]['id'],$offset=0,$limit=3);
                foreach($postContent as $key=>$value)
                {
                    $catImg=$value['post_image'];
                    $catTitle=strip_tags($value['title']);
                    $catDate=date("d M Y",strtotime($value['created_on']));
                    $catAuthor=$value['author'];
                    $catId=base64_encode($value['id']);
                    $catDesc=format_description(strip_tags($value['description']),$numberOfWords=20);
                
                    if($count<=1)
                    {
                    ?>
                    <div class="news-card-three">
                        <div class="news-card-img" >
                            <a href="details-<?=$catId?>">
                            <img src="./post_images/<?=$catImg?>" alt="Image" class="small-img-cards-3col">
                            </a>
                        </div>
                        <div class="news-card-info">
                            <a href="section-<?=base64_encode($categoryList['14']['id'])?>" class="news-cat"><?=$categoryList[14]['name']?></a>
                            <h3><a href="details-<?=$catId?>"><?= format_description($catTitle,12) ?></a></h3>
                            <ul class="news-metainfo list-style">
                                <li><i class="fi fi-rr-calendar-minus"></i><a href="#"><?=$catDate?></a></li>
                                
                            </ul>
                        </div>
                    </div>
                <?php
                    }
                }
                ?>
                

            </div>

        </div>
    </div>


    <div class="bg_gray editor-news pb-70">
        <div class="container-fluid">
            <div class="row gx-5">
                <div class="col-xl-6">
                    <div class="editor-box">
                        <div class="row align-items-end mb-40">
                            <!-- <div class="col-xl-6 col-md-6">
                                <h2 class="section-title">Editor's Pick<img class="section-title-img"
                                        src="assets/img/section-img.webp" alt="Image"></h2>
                            </div> -->
                            <div class="col-xl-12 col-md-12">
                                <ul class="nav nav-tabs news-tablist-two row" role="tablist">
                                    <li class="nav-item col d-flex justify-content-center px-0">
                                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab_1"
                                            type="button" role="tab"><span class="text-center">उत्तराखण्ड</span></button>
                                    </li>
                                    <li class="nav-item col d-flex justify-content-center px-0">
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab_2"
                                            type="button" role="tab"><span class="text-center">देश</span></button>
                                    </li>
                                    <li class="nav-item col d-flex justify-content-center px-0">
                                        <button class="nav-link " data-bs-toggle="tab" data-bs-target="#tab_3"
                                            type="button" role="tab"><span class="text-center">विदेश</span></button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="tab-content editor-news-content">
                            
                            <div class="tab-pane fade show active" id="tab_1" role="tabpanel">
                                <div class="row">
                                    
                                <?php
                                    $postContent=post_content($db,$categoryList[0]['id'],$offset=0,$limit=4);
                                    $count=1;

                                    if(count($postContent)>0)
                                    {
                                    foreach($postContent as $key=>$value)
                                    {
                                        $catImg=$value['post_image'];
                                        $catTitle=format_description(strip_tags($value['title']), $numberOfWords=15);
                                        $catDate=date("d M Y",strtotime($value['created_on']));
                                        $catAuthor=$value['author'];
                                        $catId=base64_encode($value['id']);
                                        $catDesc=format_description(strip_tags($value['description']),$numberOfWords=20);
                                    
                                        if($count<=1)
                                        {
                                        ?>
                                            <div class="col-md-6">
                                            <div class="news-card-six">
                                                <div class="news-card-img">
                                                    <a href="details-<?=$catId?>">
                                                    <img src="./post_images/<?=$catImg?>" alt="Image">
                                                    </a>
                                                    <a href="section-<?=base64_encode($categoryList[0]['id'])?>" class="news-cat">उत्तराखण्ड</a>
                                                </div>
                                                <div class="news-card-info">
                                                    <div class="news-author">
                                                        <h5>By <a href="#"><?=$catAuthor?></a></h5>
                                                    </div>
                                                    <h3><a href="details-<?=$catId?>"><?=$catTitle?></a></h3>
                                                    <ul class="news-metainfo list-style">
                                                        <li><i class="fi fi-rr-calendar-minus"></i><a
                                                                href="#"><?=$catDate?></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            </div>
                                        <?php
                                        }
                                    }
                                    }
                                ?>

                                </div>
                            </div>

                            <div class="tab-pane fade" id="tab_2" role="tabpanel">
                                <div class="row">

                                <?php
                                    $postContent=post_content($db,$categoryList[16]['id'],$offset=0,$limit=4);
                                    $count=1;

                                    if(count($postContent)>0)
                                    {
                                    foreach($postContent as $key=>$value)
                                    {
                                        $catImg=$value['post_image'];
                                        $catTitle=format_description(strip_tags($value['title']), $numberOfWords=15);
                                        $catDate=date("d M Y",strtotime($value['created_on']));
                                        $catAuthor=$value['author'];
                                        $catId=base64_encode($value['id']);
                                        $catDesc=format_description(strip_tags($value['description']),$numberOfWords=20);
                                    
                                        if($count<=1)
                                        {
                                        ?>
                                            <div class="col-md-6">
                                            <div class="news-card-six">
                                                <div class="news-card-img">
                                                    <a href="details-<?=$catId?>">
                                                        <img src="./post_images/<?=$catImg?>" alt="Image">
                                                    </a>
                                                    <a href="section-<?=base64_encode($categoryList[16]['id'])?>" class="news-cat">देश</a>
                                                </div>
                                                <div class="news-card-info">
                                                    <div class="news-author">
                                                        <h5>By <a href="#"><?=$catAuthor?></a></h5>
                                                    </div>
                                                    <h3><a href="details-<?=$catId?>"><?=$catTitle?></a></h3>
                                                    <ul class="news-metainfo list-style">
                                                        <li><i class="fi fi-rr-calendar-minus"></i><a
                                                                href="#"><?=$catDate?></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            </div>
                                        <?php
                                        }
                                    }
                                    }
                                ?> 

                                </div>
                            </div>
                            
                            <div class="tab-pane fade" id="tab_3" role="tabpanel">
                                <div class="row">

                                <?php
                                    $postContent=post_content($db,$categoryList[102]['id'],$offset=0,$limit=4);
                                    $count=1;

                                    if(count($postContent)>0)
                                    {
                                    foreach($postContent as $key=>$value)
                                    {
                                        $catImg=$value['post_image'];
                                        $catTitle=format_description(strip_tags($value['title']), $numberOfWords=15);
                                        $catDate=date("d M Y",strtotime($value['created_on']));
                                        $catAuthor=$value['author'];
                                        $catId=base64_encode($value['id']);
                                        $catDesc=format_description(strip_tags($value['description']),$numberOfWords=20);
                                    
                                        if($count<=1)
                                        {
                                        ?>
                                            <div class="col-md-6">
                                            <div class="news-card-six">
                                                <div class="news-card-img">
                                                    <a href="details-<?=$catId?>">
                                                        <img src="./post_images/<?=$catImg?>" alt="Image">
                                                    </a>
                                                    <a href="section-<?=base64_encode($categoryList[102]['id'])?>" class="news-cat">विदेश</a>
                                                </div>
                                                <div class="news-card-info">
                                                    <div class="news-author">
                                                        <h5>By <a href="#"><?=$catAuthor?></a></h5>
                                                    </div>
                                                    <h3><a href="details-<?=$catId?>"><?=$catTitle?></a></h3>
                                                    <ul class="news-metainfo list-style">
                                                        <li><i class="fi fi-rr-calendar-minus"></i><a
                                                                href="#"><?=$catDate?></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            </div>
                                        <?php
                                        }
                                    }
                                    }
                                ?> 

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="pp-news-box">
                        <ul class="nav nav-tabs news-tablist-two" role="tablist">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab_10"
                                    type="button" role="tab">Popular News</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab_11" type="button"
                                    role="tab">Recent News</button>
                            </li>
                            
                        </ul>
                        <div class="tab-content news-tab-content">

                            <div class="tab-pane fade show active" id="tab_10" role="tabpanel">
                             
                                <?php
                                    $count=1;
                                    foreach($popularContent as $key => $value)
                                    {
                                        $catImg=$value['post_image'];
                                        $catTitle=format_description(strip_tags($value['title']), $numberOfWords=15);
                                        $catDate=date("d M Y",strtotime($value['created_on']));
                                        $catAuthor=$value['author'];
                                        $catId=base64_encode($value['id']);
                                        
                                        if($count<5)
                                        {
                                        ?>
                                            <div class="news-card-seven">
                                                <div class="news-card-img">
                                                    <a href="details-<?=$catId?>">
                                                        <img src="./post_images/<?=$catImg?>" alt="Image">
                                                    </a>
                                                </div>
                                                <div class="news-card-info">
                                                    <!-- <a href="details-<?=$catId?>" class="news-cat">Lifestyle</a> -->
                                                    <h3><a href="details-<?=$catId?>"><?=$catTitle?></a></h3>
                                                    <ul class="news-metainfo list-style">
                                                        <li><i class="fi fi-rr-calendar-minus"></i><a href="#"><?=$catDate?></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        $count++;
                                    }
                                ?>
                                                              
                            </div>

                            <div class="tab-pane fade" id="tab_11" role="tabpanel">

                                <?php
                                    $count=1;
                                    foreach($sliderContent as $key => $value)
                                    {
                                        $catImg=$value['post_image'];
                                        $catTitle=format_description(strip_tags($value['title']), $numberOfWords=15);
                                        $catDate=date("d M Y",strtotime($value['created_on']));
                                        $catAuthor=$value['author'];
                                        $catId=base64_encode($value['id']);
                                        
                                        if($count<5)
                                        {
                                        ?>
                                            <div class="news-card-seven">
                                                <div class="news-card-img">
                                                    <a href="details-<?=$catId?>">
                                                        <img src="./post_images/<?=$catImg?>" alt="Image">
                                                    </a>
                                                </div>
                                                <div class="news-card-info">
                                                    <!-- <a href="business.html" class="news-cat">Lifestyle</a> -->
                                                    <h3><a href="details-<?=$catId?>"><?=$catTitle?></a></h3>
                                                    <ul class="news-metainfo list-style">
                                                        <li><i class="fi fi-rr-calendar-minus"></i><a href="#"><?=$catDate?></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        $count++;
                                        }
                                ?>
                                
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="bg_gray popular-news pt-0 pb-100">
        <div class="container-fluid">
            <div class="row align-items-end mb-40">
                <div class="col-md-7">
                    <h2 class="section-title">Most Popular<img class="section-title-img"
                            src="assets/img/section-img.webp" alt="Image"></h2>
                </div>                
            </div>
            <div class="row gx-55">

                <div class="col-xl-6">
                    <div class="row">

                        <div class="col-12">
                            <div class="news-card-eleven">
                                <div class="news-card-img">
                                    <a href="details-<?=base64_encode($popularContent[0]['id'])?>">
                                        <img src="./post_images/<?=$popularContent[0]['post_image']?>" alt="Image">
                                    </a>        
                                </div>
                                <div class="news-card-info">
                                    <div class="news-author">
                                        
                                        <h5>By <a href="#"><?=$popularContent[0]['author']?></a></h5>
                                    </div>
                                    <h3><a href="details-<?=base64_encode($popularContent[0]['id'])?>"><?=format_description($popularContent[0]['title'], $numberOfWords=15)?></a></h3>
                                    <ul class="news-metainfo list-style">
                                        <li><i class="fi fi-rr-calendar-minus"></i><a href="#"><?=$popularContent[0]['created_on']?></a></li>
                                    </ul>
                                </div>
                                <?=format_description($popularContent[0]['description'], $numberOfWords=55)?>  
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="row">
                        
                        <?php
                            for($i=3;$i<7;$i++)
                            {
                            ?>

                                <div class="col-md-6">
                                    <div class="news-card-six">
                                        <div class="news-card-img">
                                            <a href="details-<?=base64_encode($popularContent[$i]['id'])?>">
                                                <img src="./post_images/<?=$popularContent[$i]['post_image']?>" alt="Image">                                          
                                            </a>
                                        </div>
                                        <div class="news-card-info">
                                            <div class="news-author">                                          
                                                <h5>By <a href="#"><?=$popularContent[$i]['author']?></a></h5>
                                            </div>
                                            <h3><a href="details-<?=base64_encode($popularContent[$i]['id'])?>"><?=format_description($popularContent[$i]['title'], $numberOfWords=15)?></a></h3>
                                            <ul class="news-metainfo list-style">
                                                <li><i class="fi fi-rr-calendar-minus"></i><a href="#"><?=$popularContent[$i]['created_on']?></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div> 

                            <?php
                            }
                        ?>
                           
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="video-news-wrap pt-5 pb-75">
        <div class="container-fluid">

            <div class="row mb-50 align-items-center">
                <div class="col-md-7">
                    <h2 class="section-title text-white">Video News<img class="section-title-img"
                            src="assets/img/section-img.webp" alt="Image"></h2>
                </div>
                <div class="col-md-5 text-md-end">
                    <a href="video-news.php" class="link-one">View All Video News<i
                            class="flaticon-right-arrow"></i></a>
                </div>
            </div>

            <div class="featured-video-box">
                <div class="row ">

                    <div class="col-xl-6">

                        <div class="news-card-four">
                            <img src="./post_images/<?=$videoPostContent[0]['post_image']?>" alt="Image">

                            <?php
                            $videoLink=$videoPostContent[0]['video_link'];							                                    
							$pattern = "/(?:www\.|)(?:youtube\.com|m\.youtube\.com|youtu\.|youtube-nocookie\.com)/i";
                            if(preg_match($pattern, $videoLink)) 
                                {
                                    preg_match('/(?:http|https)*?:\/\/(?:www\.|)(?:youtube\.com|m\.youtube\.com|youtu\.|youtube-nocookie\.com).*(?:v=|v%3D|v\/|(?:a|p)\/(?:a|u)\/\d.*\/|watch\?|vi(?:=|\/)|\/embed\/|oembed\?|be\/|e\/)([^&?%#\/\n]*)/', $videoLink, $matches, PREG_OFFSET_CAPTURE);
                                    $vidcode = $matches[1][0];
                                }
							?>
                            
                            <a class="play-now" href="#quickview-modal" onclick='change_link("<?=$vidcode?>");' data-bs-toggle="modal">
                                <i class="flaticon-play-button"></i>
                                <span class="ripple"></span>
                            </a>
                            <div class="news-card-info">
                                <h3><a href="#quickview-modal" data-bs-toggle="modal" onclick='change_link("<?=$vidcode?>");' ><?=$videoPostContent[0]['title']?></a></h3>
                                <ul class="news-metainfo list-style">
                                    <li><i class="fi fi-rr-calendar-minus"></i><a href="#"><?=$videoPostContent[0]['created_on']?></a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="news-card-four">
                            <img src="./post_images/<?=$videoPostContent[1]['post_image']?>" alt="Image">

                            <?php
                            $videoLink=$videoPostContent[1]['video_link'];							                                    
							$pattern = "/(?:www\.|)(?:youtube\.com|m\.youtube\.com|youtu\.|youtube-nocookie\.com)/i";
                            if(preg_match($pattern, $videoLink)) 
                                {
                                    preg_match('/(?:http|https)*?:\/\/(?:www\.|)(?:youtube\.com|m\.youtube\.com|youtu\.|youtube-nocookie\.com).*(?:v=|v%3D|v\/|(?:a|p)\/(?:a|u)\/\d.*\/|watch\?|vi(?:=|\/)|\/embed\/|oembed\?|be\/|e\/)([^&?%#\/\n]*)/', $videoLink, $matches, PREG_OFFSET_CAPTURE);
                                    $vidcode = $matches[1][0];
                                }
							?>
                            
                            <a class="play-now" href="#quickview-modal" onclick='change_link("<?=$vidcode?>");' data-bs-toggle="modal">
                                <i class="flaticon-play-button"></i>
                                <span class="ripple"></span>
                            </a>
                            <div class="news-card-info">
                                <h3><a href="#quickview-modal" data-bs-toggle="modal" onclick='change_link("<?=$vidcode?>");' ><?=$videoPostContent[1]['title']?></a></h3>
                                <ul class="news-metainfo list-style">
                                    <li><i class="fi fi-rr-calendar-minus"></i><a href="#"><?=$videoPostContent[1]['created_on']?></a></li>
                                </ul>
                            </div>
                        </div>

                    </div>

                    <div class="col-xl-6">
                        

                            <?php
                                for($i=2;$i<4;$i++)
                                {
                                $videoLink=$videoPostContent[$i]['video_link'];							                                    
                                $pattern = "/(?:www\.|)(?:youtube\.com|m\.youtube\.com|youtu\.|youtube-nocookie\.com)/i";
                                if(preg_match($pattern, $videoLink)) 
                                    {
                                        preg_match('/(?:http|https)*?:\/\/(?:www\.|)(?:youtube\.com|m\.youtube\.com|youtu\.|youtube-nocookie\.com).*(?:v=|v%3D|v\/|(?:a|p)\/(?:a|u)\/\d.*\/|watch\?|vi(?:=|\/)|\/embed\/|oembed\?|be\/|e\/)([^&?%#\/\n]*)/', $videoLink, $matches, PREG_OFFSET_CAPTURE);
                                        $vidcode = $matches[1][0];
                                    }
                                    
                                ?>
                                    
                                        <div class="news-card-four">
                                            <img src="post_images/<?=$videoPostContent[$i]['post_image']?>" alt="Image">
                                            <a class="play-now" href="#quickview-modal" onclick='change_link("<?=$vidcode?>");' data-bs-toggle="modal">
                                                <i class="flaticon-play-button"></i>
                                                <span class="ripple"></span>
                                            </a>
                                            <div class="news-card-info">
                                                <h3><a href="#quickview-modal" onclick='change_link("<?=$vidcode?>");' data-bs-toggle="modal"><?=$videoPostContent[$i]['title']?></a></h3>
                                                <ul class="news-metainfo list-style">
                                                    <li><i class="fi fi-rr-calendar-minus"></i><a href="#"><?=$videoPostContent[$i]['created_on']?></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    
                                <?php
                                }
                            
                            ?>

                        
                    </div>

                </div>
            </div>

            <div class="video-slider-wrap">
                <div class="video-slider swiper">
                    <div class="swiper-wrapper">

                        <?php
                            for($i=4;$i<9;$i++)
                            {
                            $videoLink=$videoPostContent[$i]['video_link'];							                                    
                            $pattern = "/(?:www\.|)(?:youtube\.com|m\.youtube\.com|youtu\.|youtube-nocookie\.com)/i";
                            if(preg_match($pattern, $videoLink)) 
                                {
                                    preg_match('/(?:http|https)*?:\/\/(?:www\.|)(?:youtube\.com|m\.youtube\.com|youtu\.|youtube-nocookie\.com).*(?:v=|v%3D|v\/|(?:a|p)\/(?:a|u)\/\d.*\/|watch\?|vi(?:=|\/)|\/embed\/|oembed\?|be\/|e\/)([^&?%#\/\n]*)/', $videoLink, $matches, PREG_OFFSET_CAPTURE);
                                    $vidcode = $matches[1][0];
                                }
                            ?>   
                                <div class="swiper-slide">
                                    <div class="news-card-nine">
                                            <img src="post_images/<?=$videoPostContent[$i]['post_image']?>" alt="Image">
                                            <a class="play-now" href="#quickview-modal" onclick='change_link("<?=$vidcode?>");' data-bs-toggle="modal">
                                                <i class="flaticon-play-button"></i>
                                                <span class="ripple"></span>
                                            </a>
                                            <div class="news-card-info">
                                                <h3><a href="#quickview-modal" onclick='change_link("<?=$vidcode?>");' data-bs-toggle="modal"><?=$videoPostContent[$i]['title']?></a></h3>
                                                <ul class="news-metainfo list-style">
                                                    <li><i class="fi fi-rr-calendar-minus"></i><a href="#"><?=$videoPostContent[$i]['created_on']?></a></li>
                                                </ul>
                                            </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        
                        

                    </div>
                </div>
                <div class="video-prev"><i class="flaticon-left-arrow"></i></div>
                <div class="video-next"><i class="flaticon-right-arrow"></i></div>
            </div>

        </div>
    </div>

    <div class="latest-news pb-100 my-4">
        <div class="container-fluid">
            <div class="content-wrapper">
                
            <div class="col-12 align-items-end mb-40">
                        <div class="col-lg-12">
                            <h2 class="section-title">Latest News<img class="section-title-img"
                                    src="assets/img/section-img.webp" alt="Image"></h2>
                        </div>                       
                    </div>

                <div class="left-content">

                    

                    <div class="row gx-5">

                        <div class="col-xl-7">
                            <div class="scrollscreen">

                                <?php
                                    for($i=0;$i<8;$i++)
                                    {
                                    ?>
                                        <div class="news-card-five">
                                            <div class="news-card-img">
                                                <a href="details-<?=base64_encode($sliderContent[$i]['id'])?>">
                                                    <img src="post_images/<?=$sliderContent[$i]['post_image']?>" alt="Image">
                                                </a>
                                            </div>
                                            <div class="news-card-info">
                                                <h3><a href="details-<?=base64_encode($sliderContent[$i]['id'])?>"><?=format_description($sliderContent[$i]['title'], $numberOfWords=15)?></a></h3>
                                                <!-- <p><?=format_description($sliderContent[$i]['description'],20)?></p> -->
                                                <ul class="news-metainfo list-style">
                                                    <li><i class="fi fi-rr-calendar-minus"></i><a href="#"><?=$sliderContent[$i]['created_on']?></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                ?>
                                                         
                            </div>
                        </div>

                        <div class="col-xl-5">

                            <div class="news-card-two">
                                <div class="news-card-img">
                                    <a href="details-<?= base64_encode( $sliderContent[8]['id'])?>">
                                        <img src="./post_images/<?=$sliderContent[8]['post_image']?>" alt="Image"> 
                                    </a>                                   
                                </div>

                                <div class="news-card-info">
                                    <h3><a href="details-<?= base64_encode( $sliderContent[8]['id'])?>"><?=format_description($sliderContent[8]['title'], $numberOfWords)?></a></h3>
                                    <ul class="news-metainfo list-style">
                                        <li><i class="fi fi-rr-calendar-minus"></i><a href="#"><?=$sliderContent[8]['created_on']?></a></li>
                                    </ul>
                                </div>

                            </div>

                            <div class="news-card-three">
                                <div class="news-card-img">
                                    <a href="details-<?= base64_encode( $sliderContent[9]['id'])?>">
                                        <img src="./post_images/<?=$sliderContent[9]['post_image']?>" alt="Image"> 
                                    </a>                                   
                                </div>
                                <div class="news-card-info">
                                    <h3><a href="details-<?= base64_encode( $sliderContent[9]['id'])?>"><?=format_description($sliderContent[9]['title'], $numberOfWords)?></a></h3>
                                    <ul class="news-metainfo list-style">
                                        <li><i class="fi fi-rr-calendar-minus"></i><a href="#"><?=$sliderContent[9]['created_on']?></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="news-card-three">
                                <div class="news-card-img">
                                    <a href="details-<?= base64_encode( $sliderContent[10]['id'])?>">
                                        <img src="./post_images/<?=$sliderContent[10]['post_image']?>" alt="Image">
                                    </a>                                    
                                </div>
                                <div class="news-card-info">
                                    <h3><a href="details-<?= base64_encode( $sliderContent[10]['id'])?>"><?=format_description($sliderContent[10]['title'], $numberOfWords)?></a></h3>
                                    <ul class="news-metainfo list-style">
                                        <li><i class="fi fi-rr-calendar-minus"></i><a href="#"><?=$sliderContent[10]['created_on']?></a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="sidebar">

                    <?php
                        include('./includes/sidebar_categories.php');
                    ?>

                    <!-- <div class="sidebar-widget">
                        <h3 class="sidebar-widget-title">खेल</h3>
                        <div class="featured-widget">
                            <div class="featured-slider swiper">
                                <div class="swiper-wrapper">

                                    <?php
                                    $postContent=post_content($db,19,0,10);
                                    
                                    for($i=0;$i<4;$i++)
                                    {
                                    ?>

                                        <div class="swiper-slide">
                                            <div class="news-card-one">
                                                <div class="news-card-img">
                                                    <img src="./post_images/<?=$postContent[$i]['post_image']?>" alt="Image">
                                                </div>
                                                <div class="news-card-info">
                                                    <h3><a href="details-<?= base64_encode($postContent[$i]['id'])?>"><?=format_description($postContent[$i]['title'], 15)?></a></h3>
                                                    <ul class="news-metainfo list-style">
                                                        <li><i class="fi fi-rr-calendar-minus"></i><a
                                                                href="#"><?=$postContent[$i]['created_on']?></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                    }
                                    ?> 
                                                                       

                                </div>
                                <div class="featured-prev"><i class="flaticon-left-arrow"></i></div>
                                <div class="featured-next"><i class="flaticon-right-arrow"></i></div>
                            </div>
                        </div>
                    </div> -->

                </div>

            </div>
        </div>
    </div>

    <!-- <div class="container-fluid pb-50">
        <div class="instagram-slider swiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <a class="instagram-slide" href="https://www.instagram.com/" target="_blank">
                        <img src="assets/img/instagram/insta-1.webp" alt="Image">
                        <span>@Baxo on Instagram<i class="flaticon-right-arrow"></i></span>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a class="instagram-slide" href="https://www.instagram.com/" target="_blank">
                        <img src="assets/img/instagram/insta-2.webp" alt="Image">
                        <span>@Baxo on Instagram<i class="flaticon-right-arrow"></i></span>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a class="instagram-slide" href="https://www.instagram.com/" target="_blank">
                        <img src="assets/img/instagram/insta-3.webp" alt="Image">
                        <span>@Baxo on Instagram<i class="flaticon-right-arrow"></i></span>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a class="instagram-slide" href="https://www.instagram.com/" target="_blank">
                        <img src="assets/img/instagram/insta-4.webp" alt="Image">
                        <span>@Baxo on Instagram<i class="flaticon-right-arrow"></i></span>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a class="instagram-slide" href="https://www.instagram.com/" target="_blank">
                        <img src="assets/img/instagram/insta-5.webp" alt="Image">
                        <span>@Baxo on Instagram<i class="flaticon-right-arrow"></i></span>
                    </a>
                </div>
                <div class="swiper-slide">
                    <a class="instagram-slide" href="https://www.instagram.com/" target="_blank">
                        <img src="assets/img/instagram/insta-6.webp" alt="Image">
                        <span>@Baxo on Instagram<i class="flaticon-right-arrow-1"></i></span>
                    </a>
                </div>
            </div>
        </div>
    </div> -->

    

    <?php include('./includes/footer.php');?>

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
                        <iframe id = "video-popup-iframe" width="885" height="498" src="https://www.youtube.com/embed/3FjT7etqxt8"
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

<!-- for changing link in popup iframe  -->
<script>
    function change_link(vidcode)
    {
        console.log('here');
        document.getElementById("video-popup-iframe").setAttribute("src","https://www.youtube.com/embed/".concat(vidcode) ); 
    }
</script>



<!-- for default img  -->
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const images = document.getElementsByTagName('img');      
        for (let i = 0; i < images.length; i++) {  
            const img = new Image();
            img.src = images[i].getAttribute("src");

            img.onerror = () => {
            images[i].setAttribute("src","/baxo/default_img.jpg");
            // images[i].setAttribute("src","/default_img.jpg");

            };      
        }

    });
</script>

</body>

<!-- Mirrored from templates.hibootstrap.com/baxo/default/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 28 Jun 2023 07:00:43 GMT -->

</html>