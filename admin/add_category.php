<?php
	session_start();  
	require_once('../classes/utils.php');
	require_once('../classes/connect_pdo_emp.php');
	require_once('../classes/access_stats_emp.php');
	date_default_timezone_set('Asia/Kolkata');
	$privilege = '0';
	$nav = new access_stats($privilege);
	set_timezone();
	$pdoConnect = new connect_pdo();
	$db = $pdoConnect->connectToDB();
	$redirectPath_site=path();
	if(isLoginSessionExpired()) {

		header("Location: $redirectPath_site/news-admin/index.php?route=102");
	}
	$title="";
  try
	{
		
		$adminid = $_SESSION['uID'];
		$todayNow = date('Y-m-d H:i:s');
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


			$name=$_POST['title'];
			if($name=="")
			{
				//$validate_message="<p style='color:red;'>Please Provide Category Name</p>";
				$validate_message="
									 Please Provide Category Name.
								";

			}
			else
			{
				$insert_query = $db->prepare("insert into khabarnewindia_category (name,status,created) values (:title,:st,:date)");
				
				$params = array("title" => $name,"st" => 1,"date" => $todayNow);
				$data = $insert_query->execute($params);
				$validate_message="
										Category Add Sucessfully.
									";
				
				//$encode_msg=base64_encode("done");
				//header("location:add_question.php?msg=$encode_msg");die();
				
			}
		}
		if(isset($_GET['act']) && base64_decode($_GET['act'])== 'edit')
		{
			
			$encode_tid=$_GET['tid'];
			$tid=base64_decode($encode_tid);
			$sel_record=$db->query("select * from khabarnewindia_category where id='$tid'");
			$num_record=$sel_record->rowCount();
			// echo $num_record;die();
			if(!$num_record)
			{
				header("location:category_list.php");die();
			}
			else
			{
				
				$fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC);
				$title=$fetch_record['name'];
			}	
		}
		if(isset($_GET['act']) && base64_decode($_GET['act']) == 'update')
		{
			
			$encode_tid=$_GET['tid'];
			$tid=base64_decode($encode_tid);
			// echo $tid;die();
			$pdoConnect = new connect_pdo();
			$db = $pdoConnect->connectToDB();
			$sel_record=$db->query("select * from khabarnewindia_category where id='$tid'");
			$num_record=$sel_record->rowCount();
			// echo $num_record;die();
			if(!$num_record)
			{
				header("location:category_list.php");die();
			}
			else
			{
				$fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC);
				$validate_message="";
				$name=$_POST['title'];
				if($name=="")
				{
					$validate_message="<p style='color:red;'>Please Provide Category Name</p>";
				}
				else
				{

					$update_query = $db->prepare("update khabarnewindia_category SET name = :title where id = :rid");
					$params = array("title" => $name,"rid" => $tid);
					$data = $update_query->execute($params);
					header("location:category_list.php");die();
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
  <title>Add Category</title>

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
	 	<div class="container-fluid m-4 p-4"><h2><h2><?php if($title!=""){echo"Update Category";}else echo"Add Category";?></h2></h2></div>
		 <div class="clearfix"></div>
						<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
							<section class="card text-center" style="max-width:350px">						

									<?php 
									if(isset($validate_message))
										echo isset($validate_message)?$validate_message:'';
									?>
								
									<?php
									if(isset($_GET['act']) && base64_decode($_GET['act'])== 'edit')
									{
										$ed_text=base64_encode("update");
										?>
									<form  method="POST" action="add_category.php?tid=<?=$encode_tid?>&act=<?=$ed_text?>" name="category_form" id="category_form" class="card-body">
									<?php } else { ?>
									<form  method="POST" action="add_category.php" name="category_form" id="category_form" class="card-body">
									<?php } ?>
									
										<div class="">
											<div class="form-group">
												<label class="form-label" for="field-1">Category Name</label>
												<span class="desc"></span>
												<div class="">
													<input type="text" value="<?=$title?>" class="" name="title" id="title">
												</div>
											</div>
										</div>

										<div class="" >
											<div >
													<?php
													if(isset($_GET['act']) && base64_decode($_GET['act'])== 'edit')
													{
													?>
													<button type="submit" name="update" class="btn btn-primary" style="margin-top: 30px;" onclick="show_alert()">Update</button>
													<?php } else { ?>
													<button type="submit" name="submit" class="btn btn-primary" style="margin-top: 30px;" onclick="show_alert()">Save</button>
													<?php }?>
											</div>
										</div>
									</form>
								
							
							</section>
						</div>
                        

                    </div>
                </div>        
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