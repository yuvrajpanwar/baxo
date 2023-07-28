<?php
	date_default_timezone_set('Asia/Kolkata');
	session_start();  
	require_once('../classes/utils.php');
	require_once('../classes/connect_pdo_emp.php');
	require_once('../classes/access_stats_emp.php');
	$privilege = '0';
	$nav = new access_stats($privilege);
	set_timezone();
	$pdoConnect = new connect_pdo();
	$db = $pdoConnect->connectToDB();
	$redirectPath_site=path();
	if(isLoginSessionExpired()) {

		header("Location: $redirectPath_site/news-admin/index.php?route=102");
	}
	try
		{
			
			$adminid = $_SESSION['uID'];
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
			

			// Delete records....................................
			if(isset($_GET['act']) && base64_decode($_GET['act']) == 'del')
			{
				//echo"here";die();
				$encode_tid=$_GET['tid'];
				$tid=base64_decode($encode_tid);
				// echo $tid;die();
				$pdoConnect = new connect_pdo();
				$db = $pdoConnect->connectToDB();
				$sel_record=$db->query("select * from khabarnewindia_post_records where id='$tid'");
				$num_record=$sel_record->rowCount();
				// echo $num_record;die();
				if(!$num_record)
				{
					header("location:post_list.php");die();
				}
				else
				{
					$fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC);
					$post_image=$fetch_record['post_image'];
					$image_path="../post_images/".$post_image;
					if(file_exists($image_path))
					{
						unlink($image_path);
					}
					
					$Delete_query = $db->prepare("update khabarnewindia_post_records set is_enabled=:enable,is_deleted=:deleted where id= :id");
					$params = array("enable"=>'N',"deleted"=>'Y',"id" => $tid);
					$data = $Delete_query->execute($params);
					
					$del_category=$db->prepare("update khabarnewindia_post_category set is_enabled=:enable,is_deleted=:deleted where id= :id");
					$params_del_category = array("enable"=>'N',"deleted"=>'Y',"id" => $tid);
					$data_del_category = $del_category->execute($params_del_category);
					
					$Delete_comments = $db->prepare("delete from khabarnewindia_post_comment where post_id= :id");
					$params_comments = array("id" => $tid);
					$data_comments = $Delete_comments->execute($params_comments);
					header("location:post_list.php");die();
				}
			}
			
			// status update..........................
			if(isset($_GET['act']) && base64_decode($_GET['act']) == 'status')
			{
				$encode_tid=$_GET['tid'];
				$tid=base64_decode($encode_tid);
				
				$pdoConnect = new connect_pdo();
				$db = $pdoConnect->connectToDB();
				$sel_record=$db->query("select * from khabarnewindia_post_records where id='$tid'");
				$num_record=$sel_record->rowCount();
				// echo $num_record;die();
				if(!$num_record)
				{
					header("location:post_list.php");die();
				}
				else
				{
					
					$fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC);
					$status=$fetch_record['status'];
					if($status==1)
					{
						$update_status=0;
					}
					else
					{
						$update_status=1;
					}	
					$update_query = $db->prepare("update khabarnewindia_post_records SET status= :st where id= :id");
					$params = array("st" => $update_status,"id" => $tid);
					$data = $update_query->execute($params);
					header("location:post_list.php");die();
				}
			}
			
		}
		catch(PDOException $ex) 
		{
				// echo "An Error occured! Please contact Administrator.".$ex;
		}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Categories</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon">
    <!-- Custom styles -->
    <link rel="stylesheet" href="./css/style.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

            <div class="container">
                <div class="table-responsive">
                    <div class="table-wrapper">
                        <div class="table-title">
                            <div class="row">
                                <div class="col-sm-8"><h2>Posts</h2></div>
                            </div>
                        </div>
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
											<thead>
                                                <tr>
                                                    <th>Title</th><th>Category Name</th><th>Type</th><th style='width: 90px;'>Date</th><th>Status</th><th> View</th><th style='width: 170px;'>Action</th></tr>
													
													<!--<th>Unverified/Total</th>-->
                                            </thead>

                                			<tbody>
												<?php
													$sel_record=$db->query("select * from khabarnewindia_post_records where is_enabled='Y' and is_deleted='N'  ORDER BY id desc");
													$num_record=$sel_record->rowCount();
													if($num_record)
													{
														while($fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC))
														{
															$t_id=$fetch_record['id'];
															$encrypt_id=base64_encode($t_id);
															$title=$fetch_record['title'];
															$news_type=$fetch_record['news_type'];
															$author=$fetch_record['author'];
															$created_on=$fetch_record['created_on'];
															$mod_formate=date("d-M-Y",strtotime($created_on));
															
															$cat_count=1;
															$category_content="";
															$sel_category=$db->query("select khabarnewindia_post_category.*, khabarnewindia_category.name from khabarnewindia_post_category,khabarnewindia_category where khabarnewindia_post_category.category_id=khabarnewindia_category.id and khabarnewindia_post_category.post_id='$t_id'");
															$num_category=$sel_category->rowCount();
															while($fetch_category=$sel_category->fetch(PDO::FETCH_ASSOC))
															{
																$category_name=$fetch_category['name'];
																$category_content.=$category_name;
																if($cat_count<$num_category)
																{
																	$category_content.=", ";
																}
																$cat_count++;
															}
															
															$status=$fetch_record['status'];													
															if($status==1)
															{
																$st_content="Deactive";
																$status_dispaly="Active";
															}
															else
															{
																$st_content="Active";
																$status_dispaly="Deactive";
															}	
															$dt_text=base64_encode("del");
															$ed_text=base64_encode("edit");
															$st_text=base64_encode("status");
															
															
															
															echo"<tr>
															<td>$title</td>
															<td>$category_content</td>
															<td>$news_type</td>
															<td>Published On $mod_formate</td>
															<td>$status_dispaly</td>
															
															<td><a href='post_details.php?tid=$encrypt_id' title='View Post'><i class='fa fa-eye' aria-hidden='true'></i></a></td>
															<td><a href='add_post.php?tid=$encrypt_id&act=$ed_text' title='Edit Post'><i class='fa fa-pencil' aria-hidden='true''></i></a> | <a href='post_list.php?tid=$encrypt_id&act=$st_text'>$st_content</a> | <a class='delete_link' href='post_list.php?tid=$encrypt_id&act=$dt_text' title='Delete Post'><i class='fa fa-trash' aria-hidden='true'></i></a></td>
															</tr>";
														}	
													}
													else
													{
														echo"<tr><td>No Record found!</td><td></td><td></td><td></td></tr>";
													}
												?>
                                            </tbody>
											
											<tfoot>
													<tr>
                                                    <th>Title</th><th>Category Name</th><th>Type</th><th style='width: 90px;'>Date</th><th>Status</th><th> View</th><th style='width: 170px;'>Action</th></tr>
													
                            				</tfoot>
                        </table>
                        

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


<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap4.min.js"></script>

<!-- load data table  -->
<script>
    $(document).ready(function(){
        new DataTable('#example');

        var inputText = document.querySelector("input[type='search']");
        inputText.classList.remove("form-control", "form-control-sm");
    });
</script>

</body>

</html>