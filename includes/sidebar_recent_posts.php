<div class="sidebar-widget">
<h3 class="sidebar-widget-title">Recent Posts</h3>
<div class="pp-post-wrap">

    <?php
    $count=1;
    if(count($sliderContent)>0)
    {
        foreach($sliderContent as $key=>$value)
        {
            $catImg=$value['post_image'];
            $catTitle=strip_tags($value['title']);
            $catDate=date("d M Y",strtotime($value['created_on']));
            $catAuthor=$value['author'];
            $catId=base64_encode($value['id']);
            
            if($count>0 && $count<=6)
            {
    ?>

                <div class="news-card-one">
                    <div class="news-card-img">
                        <img src="post_images/<?=$catImg?>" alt="Image">
                    </div>
                    <div class="news-card-info">
                        <h3><a href="details-<?=$catId?>"><?=$catTitle?></a></h3>
                        <ul class="news-metainfo list-style">
                            <li><i class="fi fi-rr-calendar-minus"></i><a href="news-by-date.html"><?=$catDate?></a></li>
                        </ul>
                    </div>
                </div>
    
    <?php
            }
            $count++;
        }
    }
    ?>
            
</div>
</div>