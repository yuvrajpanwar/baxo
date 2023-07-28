<?php
	session_start();  
	require_once('../classes/utils.php');
	require_once('../classes/connect_pdo_emp.php');
	require_once('../classes/access_stats_emp.php');
	date_default_timezone_set('Asia/Kolkata');
	include("resizecode.php");
	$privilege = '0';
	$nav = new access_stats($privilege);
	set_timezone();
	$pdoConnect = new connect_pdo();
	$db = $pdoConnect->connectToDB();
	
	$tag_name="";
	$tag_description="";
	$tag_slug="";
	$redirectPath_site=path();
	if(isLoginSessionExpired()) {

		header("Location: $redirectPath_site/news-admin/index.php?route=102");
	}
  try
	{
		
		$adminid = $_SESSION['uID'];
		$todayNow = date('Y-m-d H:i:s');
		$todayDate = date('Y-m-d');
		$adminemail = $_SESSION['admin_email'];
		$adminname = $_SESSION['admin_name'];
		$now = 'NOW()';
		$val="";
		$empID = $_SESSION['uID'];
		$prepQuery = $db->query("select * from khabarnewindia_adminlogin where id='$adminid' and user_name='$adminemail' and name='$adminname' limit 1");
	    $complete_rows = $prepQuery->rowCount();
		
		if($complete_rows<=0)
	    {
			header("Location: index.php");die();
		
		}
		if(isset($_POST['submit']) == 'Save')
		{
			//echo "here";die();
			$name=$_POST['title'];
			$slug=$_POST['slug'];
			$description=$_POST['description'];

			
			if($name=="")
			{
				$validate_message="
									
									 Please Provide Tag Name.
								";
			}
			else
			{	
				
				$insert_query = $db->prepare("insert into khabarnewindia_tags_details (tag_name,tag_slug,tag_description,status,created) values (:title,:sl,:des,:st,:date)");
				
				$params = array("title" => $name,"sl" => $slug,"des" => $description,"st" => 'active',"date" => $todayNow);
				$data = $insert_query->execute($params);
				
				
				$validate_message="
										
										Tag Added Sucessfully.
																";
				
			}
		}
		if(isset($_GET['act']) && base64_decode($_GET['act'])== 'edit')
		{
			//echo"here";die();
			$encode_tid=$_GET['tid'];
			$tid=base64_decode($encode_tid);
			$sel_record=$db->query("select * from khabarnewindia_tags_details where id='$tid' limit 1");
			$num_record=$sel_record->rowCount();
			// echo $num_record;die();
			if(!$num_record)
			{
				header("location:tag_list.php");die();
			}
			else
			{
				
				$fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC);
				
				$tag_name=$fetch_record['tag_name'];
				$tag_description=$fetch_record['tag_description'];
				$tag_slug=$fetch_record['tag_slug'];
			}
		}

		if(isset($_GET['act']) && base64_decode($_GET['act']) == 'update')
		{
			
			$encode_tid=$_GET['tid'];
			$tid=base64_decode($encode_tid);
			// echo $tid;die();
			$pdoConnect = new connect_pdo();
			$db = $pdoConnect->connectToDB();
			$sel_record=$db->query("select * from khabarnewindia_tags_details where id='$tid'");
			$num_record=$sel_record->rowCount();
			// echo $num_record;die();
			if(!$num_record)
			{
				header("location:tag_list.php");die();
			}
			else
			{
				$name=$_POST['title'];
				$slug=$_POST['slug'];
				$description=$_POST['description'];

				
				if($name=="")
				{
					$validate_message=" Please Provide Tag Name.
									";
				}
				else
				{

					$update_query = $db->prepare("update khabarnewindia_tags_details SET tag_name = :name, tag_slug = :sl, tag_description = :des where id = :rid");
					$params = array("name" => $name,"sl" => $slug,"des" => $description,"rid" => $tid);
					$data = $update_query->execute($params);
					header("location:tag_list.php");die();
				}	
				
			}
		}
		
	}
	 catch(PDOException $ex) 
	 {
			echo "An Error occured! Please contact Administrator.";
	 }
	 // echo"here";die();
		
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add tag</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon">
    <!-- Custom styles -->
    <link rel="stylesheet" href="./css/style.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<style>
		.error
		{
			color:red !important;
		}
		</style>
		<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script>



	function show_alert()
	{
		console.log('here');
		$("#alert").css("{opacity: 1;}");
	}
			
					
</script>

</head>

<body>
  <div class="layer"></div>
<!-- ! Body -->
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>
<div class="page-flex">

		<?php
	  	  date_default_timezone_set('Asia/Kolkata');
			$current_date = date("Y-m-d");
			$start=$current_date." 00:00:00";
			$end=$current_date." 23:59:59";
													
			$sel_total_category=$db->query("select COUNT(*) from khabarnewindia_category where status=1");
			$fetch_total_category=$sel_total_category->fetch(PDO::FETCH_ASSOC);
			$total_category_active=$fetch_total_category['COUNT(*)'];
			
			$sel_total_post=$db->query("select COUNT(*) from khabarnewindia_post_records where status=1");
			$fetch_total_post=$sel_total_post->fetch(PDO::FETCH_ASSOC);
			$total_post_active=$fetch_total_post['COUNT(*)'];
													
			$sel_total_category_all=$db->query("select COUNT(*) from khabarnewindia_category");
			$fetch_total_category_all=$sel_total_category_all->fetch(PDO::FETCH_ASSOC);
			$total_category_all=$fetch_total_category_all['COUNT(*)'];
			
			$sel_total_category_deactive=$db->query("select COUNT(*) from khabarnewindia_category where status=0");
			$fetch_total_category_deactive=$sel_total_category_deactive->fetch(PDO::FETCH_ASSOC);
			$total_category_deactive=$fetch_total_category_deactive['COUNT(*)'];
			
			$sel_total_post_all=$db->query("select COUNT(*) from khabarnewindia_post_records");
			$fetch_total_post_all=$sel_total_post_all->fetch(PDO::FETCH_ASSOC);
			$total_post_all=$fetch_total_post_all['COUNT(*)'];
			
			$sel_total_post_deactive=$db->query("select COUNT(*) from khabarnewindia_post_records where status=0");
			$fetch_total_post_deactive=$sel_total_post_deactive->fetch(PDO::FETCH_ASSOC);
			$total_post_deactive=$fetch_total_post_deactive['COUNT(*)'];
		  
			$sel_tag = $db->query("select * from khabarnewindia_tags_details where status='active'");
			  $total_tags = $sel_tag->rowCount();
	  	?>
  <!-- ! Sidebar -->
  <?php include('./includes/sidebar.php');?>

  <div class="main-wrapper">

    <!-- ! Main nav -->
    <?php include('./includes/main_nav.php'); ?>

    <!-- ! Main -->
    <main class="" id="skip-target">
        <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 '>
            <div class="container-fluid m-4 p-4"><h2><?php if($tag_name!=""){echo"Update Tag";}else echo"Add tag";?></h2></div>
            <div class="clearfix"></div>
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <section class="box ">
                    
                    <div class="content-body">
                        <div class="row">
							<div class="col-12">
                            <?php 
                                if(isset($validate_message))
                                echo $validate_message;
                            ?>
							</div>
                                <?php
                                    if(isset($_GET['act']) && base64_decode($_GET['act'])== 'edit')
                                    {
                                    $ed_text=base64_encode("update");
                                ?>
                                    <form action ="add_tag.php?tid=<?=$encode_tid?>&act=<?=$ed_text?>" method="post" name="tag_form" id="tag_form" enctype="multipart/form-data">
                                <?php } else { ?>
                                    <form action ="add_tag.php" method="post" name="tag_form" id="tag_form" enctype="multipart/form-data">
                                <?php } ?>
                        
                            <div class="col-lg-4 col-md-8 col-sm-9 col-xs-12">

                            <div class="form-group">
                                <label class="form-label" for="field-1">Tag Name</label>
                                <span class="desc"></span>
                                <div class="">
                                    <input type="text" value="<?=$tag_name?>" class="" id="title" name="title">
                                </div>
                            </div>

                                </div>
                                <div class="col-lg-4 col-md-8 col-sm-9 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label" for="field-1">Tag Slug</label>
                                    <span class="desc"></span>
                                    <div class="controls">
                                        <input type="text" value="<?=$tag_slug?>" class="" id="slug" name="slug">
                                    </div>
                                </div>

                            </div>
                                <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12">
                                <div class="form-group">
                                    <label class="form-label" for="field-6">Description</label>
                                    <span class="desc"></span>
                                    <div class="controls">
                                        <textarea class=""  id="description" name="description"><?=$tag_description?></textarea>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-8 col-md-8 col-sm-9 col-xs-12 padding-bottom-30">
                                <div class="text-left">
                                    <?php
                                    if(isset($_GET['act']) && base64_decode($_GET['act'])== 'edit')
                                    {
                                    ?>
                                    <button type="submit" name="update" class="btn btn-primary">Update</button>
                                    <?php } else { ?>
                                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                                    <?php }?>
                                </div>
                            </div>
                            </form>
                        </div>														
                    </div>
                </section>
			</div>
        </div>                   
    </main>

    <!-- ! Footer -->
    <div class="container-fluid my-4 py-4">
    <!-- <?php include('./includes/footer.php'); ?> -->
    </div>
  </div>

</div>



<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
<!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 







</body>

</html>