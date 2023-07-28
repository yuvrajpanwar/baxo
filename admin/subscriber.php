<?php
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
		


		
	}
	 catch(PDOException $ex) 
	 {
			echo "An Error occured! Please contact Administrator.";
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
                                <div class="col-sm-8"><h2>Subscribers</h2></div>
                            </div>
                        </div>
                        <table id="example" class="table table-striped table-bordered" style="width:100%">
						<thead>
                                                <tr>
                                                    <th>Email</th><th>Date</th></tr>
                        </thead>

                                            <tbody>
											<?php
												$sel_record=$db->query("select * from khabarnewindia_subscribe_details order by id desc");

                                            
												$num_record=$sel_record->rowCount();
												if($num_record)
												{
													while($fetch_record=$sel_record->fetch(PDO::FETCH_ASSOC))
													{
														$t_id=$fetch_record['id'];
														$encrypt_id=base64_encode($t_id);
														$user_email=$fetch_record['email'];
														$date_time=$fetch_record['created'];
														
														echo"<tr>
														<td>$user_email</td>
                                                        <td>$date_time</td>
														
														</tr>";
													}	
												}
												else
												{
													echo"<tr><td>No Record found!</td><td></td><td></td><td></td></tr>";
												}
											?>
                                       
                                            </tbody>
											<tr>
                                            <tr>
                                                    <th>Email</th><th>Date</th></tr>
											</tr>
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
    })
</script>

</body>

</html>