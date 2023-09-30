<?php

function update_count($db,$newsCount,$id)
{
    $sql = "UPDATE khabarnewindia_post_view_records SET counts=:count WHERE id=:id";
    $stmt= $db->prepare($sql);
    $stmt->execute([':count'=>$newsCount,':id'=>$id]);
}

function get_news_count($db,$id)
{
    $selectQuery=$db->prepare("select * from khabarnewindia_post_view_records where post_id=:postId");
    $selectQuery->execute(['postId'=>$id]);
    $resultArray=$selectQuery->fetch(\PDO::FETCH_ASSOC);
    return $resultArray;
}


function get_counter($db)
{
    $selectQuery=$db->prepare("select visits from khabarnewindia_counter");
    $selectQuery->execute();
    // print_r($selectQuery);
    // die();
    $resultArray=$selectQuery->fetch(\PDO::FETCH_ASSOC);
    return $resultArray;
}

function update_counter($db,$count,$id)
{
    $sql = "UPDATE khabarnewindia_counter SET visits = :visits WHERE id = :id";
    $stmt= $db->prepare($sql);
    $stmt->execute([':visits'=>$count,':id'=>$id]);
}

function breaking_news_list($db)
{
    $selectQuery=$db->query("select title,created from khabarnewindia_breaking_news order by id desc limit 10");
    $selectQuery->execute();
    $resultArray=$selectQuery->fetchall(\PDO::FETCH_ASSOC);
    return $resultArray;
}

function category_listing($db)
{
    $selectQuery=$db->query("select id,name from khabarnewindia_category where status=1 order by id asc");
    $selectQuery->execute();
    $resultArray=$selectQuery->fetchall(\PDO::FETCH_ASSOC);
    return $resultArray;
}

function category_of_news($db,$post_id)
{
    $selectQuery=$db->prepare("select * from khabarnewindia_post_category where post_id=:id");
    $selectQuery->execute(['id'=>$post_id]);
    $resultArray=$selectQuery->fetch(\PDO::FETCH_ASSOC);
    return $resultArray['category_id'];
}

function slider_content($db)
{
    $sel_slider_post=$db->query("select khabarnewindia_post_records.id,khabarnewindia_post_records.title,khabarnewindia_post_records.description,khabarnewindia_post_records.slug_title,khabarnewindia_post_records.author,khabarnewindia_post_records.post_image,khabarnewindia_post_records.created_on, GROUP_CONCAT(khabarnewindia_post_category.category_id SEPARATOR ', ') as category_data from khabarnewindia_post_records,khabarnewindia_post_category where khabarnewindia_post_records.id=khabarnewindia_post_category.post_id and khabarnewindia_post_records.news_type='Text News' and khabarnewindia_post_records.status=1 and khabarnewindia_post_records.is_enabled='Y' and khabarnewindia_post_records.is_deleted='N' GROUP BY khabarnewindia_post_category.post_id  order by khabarnewindia_post_records.id desc limit 20");
    $row_sliderpost = $sel_slider_post->rowCount();
    $slider_post_data_arry=$sel_slider_post->fetchAll(\PDO::FETCH_ASSOC);
    return $slider_post_data_arry;
}

function video_post_content($db,$offset)
{
    $video_post=$db->query("select khabarnewindia_post_records.id,khabarnewindia_post_records.video_link,khabarnewindia_post_records.title,khabarnewindia_post_records.slug_title,khabarnewindia_post_records.author,khabarnewindia_post_records.post_image,khabarnewindia_post_records.created_on, GROUP_CONCAT(khabarnewindia_post_category.category_id SEPARATOR ', ') as category_data from khabarnewindia_post_records,khabarnewindia_post_category where khabarnewindia_post_records.id=khabarnewindia_post_category.post_id and khabarnewindia_post_records.news_type='Video News' and khabarnewindia_post_records.status=1 and khabarnewindia_post_records.is_enabled='Y' and khabarnewindia_post_records.is_deleted='N' GROUP BY khabarnewindia_post_category.post_id  order by khabarnewindia_post_records.id desc limit $offset,10");
    $row_videoPost = $video_post->rowCount();
    $video_post_data_arry=$video_post->fetchAll(\PDO::FETCH_ASSOC);
    return $video_post_data_arry;
}
function get_popular_post($db)
{
    $popular_post=$db->query("select khabarnewindia_post_records.*,khabarnewindia_post_view_records.id as post_view_records_id ,khabarnewindia_post_view_records.counts from khabarnewindia_post_records,khabarnewindia_post_view_records where khabarnewindia_post_records.id=khabarnewindia_post_view_records.post_id and khabarnewindia_post_records.status=1 and khabarnewindia_post_records.news_type='Text News' and khabarnewindia_post_records.is_enabled='Y' and khabarnewindia_post_records.is_deleted='N'  and khabarnewindia_post_records.created_on <= NOW() order by id desc limit 10");
    $row_popular=$popular_post->rowCount();
    $row_popular_array=$popular_post->fetchAll(\PDO::FETCH_ASSOC);
    return $row_popular_array;
}

function post_content($db,$tid,$offset,$limit)
{

    $condition="khabarnewindia_post_category.category_id='$tid'";
    
    if($tid==26){

        $condition='';
        $multiCondition = '';
         
        for($i=26;$i<97;$i++)
        {
            if($i==96)
                $multiCondition.=$i;
            else
                $multiCondition .=$i.', ';
        }
        $condition .="khabarnewindia_post_category.category_id in ($multiCondition)";
    }

    $sel_slider_post=$db->query("select TO_BASE64(khabarnewindia_post_records.id) as enc_id,khabarnewindia_post_category.post_id, khabarnewindia_post_records.* from khabarnewindia_post_category,khabarnewindia_post_records where khabarnewindia_post_category.post_id=khabarnewindia_post_records.id and $condition and khabarnewindia_post_records.status=1 and khabarnewindia_post_records.news_type='Text News' and khabarnewindia_post_records.is_enabled='Y' and khabarnewindia_post_records.is_deleted='N' order by khabarnewindia_post_records.id desc limit $offset, $limit");
    $row_sliderpost = $sel_slider_post->rowCount();
    $slider_post_data_arry=$sel_slider_post->fetchAll(\PDO::FETCH_ASSOC);
    return $slider_post_data_arry;
}

function get_post_details($db,$tid)
{
    $selectQuery=$db->prepare("select * from khabarnewindia_post_records where is_enabled=:enable and is_deleted=:deleted and id=:id");
    $selectQuery->execute(['enable'=>'Y','deleted'=>'N','id'=>$tid]);
    $resultArray=$selectQuery->fetch(\PDO::FETCH_ASSOC);
    return $resultArray;

}

function categoryTypeList($postCatType,$categoryList)
{
    $postCatTypeVal=explode(',',$postCatType);
    $topCatNewsName="";
    if(sizeof($postCatTypeVal)>0)
    {
        $matchCount=1;
        for($i=0;$i<sizeof($postCatTypeVal);$i++)
        {
            
            if($matchCount>4)
            {
                break;
            }
            $postCatId=$postCatTypeVal[$i];

            foreach($categoryList as $key=>$value)
            {
                $categoryId=$value['id'];
                $categoryName=$value['name'];
                if($categoryId==$postCatId)
                {
                    $topCatNewsName.=$categoryName." , ";
                    $matchCount++;
                }
                
            }
        }
    }
    $topCatNewsName=rtrim($topCatNewsName,', ');
    return $topCatNewsName;
}

function different_categories_data($contentValues)
{
    if(count($contentValues)>0)
    {
        $leftContent="<div class=\"col-lg-5 t-pb-30 pb-lg-0\">
        <div class=\"row\">";
        $rightContent="<div class=\"col-lg-7\">
        <div class=\"row\">";
        $count=1;
        $content="";
        foreach($contentValues as $key=>$value)
        {
            $img=$value['post_image'];
            $title=strip_tags($value['title']);
            $title=format_description($title,$numberOfWords=14);
            $date=date("d M Y",strtotime($value['created_on']));
            
            $author=$value['author'];
            $id=base64_encode($value['id']);
            if($count>0 && $count<3)
            {
                
                $leftContent.="<div class=\"col-12 t-pb-30\">
                <div class=\"post post--in\">
                    <img
                        src=\"./post_images/$img\"
                        alt=\"kotha\"
                        class=\"img-fluid w-100\"
                   />
                    <a
                        href=\"single-post.php?tid=$id\"
                        class=\"post__overlay t-link\"
                    ></a>
                    <div
                        class=\"post--in-content\"
                    >
                        <ul
                            class=\"list d-flex align-items-center\"
                        >
                    
                            <li>
                                <a
                                    href=\"single-post.php?tid=$id\"
                                    class=\"t-link t-link--light ex-sm-text\"
                                >
                                    <span
                                        class=\"las la-calendar-alt sm-text\"
                                    ></span>
                                    $date
                                </a>
                            </li>
                        </ul>
                        <h6
                            class=\"post__title mb-0 t-mt-10\"
                        >
                            <a
                                href=\"single-post.php?tid=$id\"
                                class=\"t-link t-link--light\"
                            >
                                $title...
                            </a>
                        </h6>
                    </div>
                </div>
            </div>";
            }
            if($count==3)
            {
                $leftContent.="</div></div>";
            }
            if($count>2 && $count<6)
            {
                $rightContent.="<div class=\"col-12 t-pb-30\">
                <div class=\"post post--right\">
                    <div
                        class=\"post--right-img t-flex-100 t-mr-16\"
                    >
                        <img
                            src=\"./post_images/$img\"
                            alt=\"kotha\"
                            class=\"img-fluid w-100\"
                        />
                    </div>
                    <div
                        class=\"post--right-content t-flex-100\"
                    >
                       
                        <h6
                            class=\"post__title post__title-xmin t-mt-10 t-mb-10\"
                        >
                            <a
                                href=\"single-post.php?tid=$id\"
                                class=\"t-link t-link--secondary\"
                            >
                                $title...
                            </a>
                        </h6>
                        <ul
                            class=\"list d-none d-md-flex d-lg-none d-xl-flex align-items-center\"
                        >
                            <li>
                                <a
                                    href=\"single-post.php?tid=$id\"
                                    class=\"t-link t-link--secondary ex-sm-text text-capitalize\"
                                >
                                    <span
                                        class=\"sm-text\"
                                    >By </span>
                                    $author
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>";
            }
            if($count==5)
            {
                $rightContent.="</div></div>";
            }
            $count++;
        }
        $content.=$leftContent;
        $content.=$rightContent;
    }
    return $content;
}

?>