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
		//echo $adminid;die();
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
		if(isset($_POST['submit']) == 'Submit')
		{
			// echo"here";die();
			$validate_message="";
			$new_password=$_POST['new_pass'];
			$new_pass_len=strlen($new_password);
			//$coniform_password=$_POST['confirm_pass'];
			//$coniform_pass_len=strlen($coniform_password);
			$old_pass=$_POST['ol_pass'];
			if($old_pass=="")
			{
				$validate_message="Please Provide Old Password";
			}
			else if($new_password=="")
			{
				$validate_message="Please provide New Password";
			}
			else if($new_pass_len<4 || $new_pass_len>15) {echo"first";die();$validate_message="Password length must be greater than 4 and less than 15 characters";}
			else
			{
                 $old_pass = md5($old_pass);
                
				$selectQuery = $db->query("select * from khabarnewindia_adminlogin where id='$adminid' and user_name='$adminemail' and name='$adminname'and password='$old_pass'");
				$num_rows = $selectQuery->rowCount();
				if($num_rows)
				{
                    $new_password = md5($new_password);
                    
					//echo $new_password;die();
					$update_query = $db->prepare("update khabarnewindia_adminlogin SET password = :pass where id = :admin_id");
					$params = array("pass" => $new_password,"admin_id" => $adminid);
					$data = $update_query->execute($params);
					$encode_msg=base64_encode("done");
					header("location:chnage_password.php?msg=$encode_msg");die();
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
<html class=" ">
<head>

        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <meta charset="utf-8" />
        <title>Khabar New India - सोच ईमानदार, खबर दमदार </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />    <!-- Favicon -->
        

        <!-- CORE CSS FRAMEWORK - START -->
        <link href="assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
        <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
        <link href="assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css"/>
        <!-- CORE CSS FRAMEWORK - END -->

        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <link href="assets/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" media="screen"/>        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE CSS TEMPLATE - START -->
        <link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css"/>
        
        <style>
		.error
		{
			color:red !important;
		}
		</style>

        <!-- CORE CSS TEMPLATE - END -->
		 <script src="i-js/jquery-2.2.3.min.js"></script>
        <script src="i-js/jquery.validate.min.js"></script>
       
       <script>
        (function($,W,D)
        {
        var JQUERY4U = {};

        JQUERY4U.UTIL =
        {
            setupFormValidation: function()
            {
                //form validation rules
                $("#change_password").validate({
                    rules: {
                                ol_pass:
                                {
                                    required: true,
                                },
                                new_pass:
                                {
                                    required: true,
                                    minlength: 4,
                                    maxlength: 16,
                                }
                    },
                    messages: 
                    {
                        ol_pass:
                        {
                            required:"Please provide Old Password",

                        },
                        new_pass:
                        {
                            required:"Please provide New Password",
                            minlength:"Password length must be greater than 3 and less than 16 characters",
                            maxlength:"Password length must be greater than 3 and less than 16 characters",
                        }
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });


            }
        }

        //when the dom has loaded setup form validation rules
        $(D).ready(function($) {
            JQUERY4U.UTIL.setupFormValidation();
        });

        })(jQuery, window, document);

        $(function(){
        // alert("hello");
        $("#ol_pass").change(function() {
            var password = $("#ol_pass").val();
            var data='pass=' + password;
            $.ajax({
                    url: 'old-password-handler.php',
                    type: 'POST',
                    data: data,
                    cache: false,
                    async:false,
                    success: function(html)
                    {
                        // alert(html);
                        if(html=="no")
                        {
                            alert("Old Password not matched Please try again");
                            $("#ol_pass").val("");
                            return false;
                        }
                    }
                });
        });


        });
        </script>
    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body class=" ">
        <!-- START TOPBAR -->
        <div class='page-topbar '>
            <div class='logo-area'>

            </div>
			<?php $page_name="setting"; require_once("include/top_bar.php"); ?>

        </div>
        <!-- END TOPBAR -->
        <!-- START CONTAINER -->
        <div class="page-container row-fluid">

            <!-- SIDEBAR - START -->
			<?php require_once("include/sidebar.php"); ?>
            <!--  SIDEBAR - END -->
            <!-- START CONTENT -->
            <section id="main-content" class=" ">
                <section class="wrapper main-wrapper" style=''>
					
                    <?php
					if(isset($validate_message))
					echo$validate_message;
						?>

					<?php if( isset($_GET['msg']) && base64_decode($_GET['msg'])=="done"){ ?>
							<h3 class="redmsg">Update Password Successfully!</h3>
					<?php } ?>

                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 page_title_block'>
                        <div class="page-title">

                            <div class="pull-left">
                                <h1 class="title">Change Password</h1>                            </div>

                            <div class="pull-right hidden-xs">
                                <ol class="breadcrumb">
                                    <li>
                                        <a href="dashboard.php"><i class="fa fa-home"></i>Home</a>
                                    </li>
                                    <!--<li>
                                        <a href="form-elements.html">Forms</a>
                                    </li>-->
                                    <li class="active">
                                        <strong>Change Password</strong>
                                    </li>
                                </ol>
                            </div>

                        </div>
                    </div>




                    <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                        <section class="box ">
                            <header class="panel_header">
                            </header>
                            <div class="content-body">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">


                                        <form class="form-inline" name="change_password" id="change_password" method="POST" >
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputEmail3">Old Password</label>
                                                <input type="password" style="width: 100%;" class="form-control" id="ol_pass" name="ol_pass" placeholder="Old Password">
                                            </div>
                                            <div class="form-group">
                                                <label class="sr-only" for="exampleInputPassword3">New Password</label>
                                                <input type="password" style="width: 100%;" class="form-control" id="new_pass" name="new_pass" placeholder="New Password">
                                            </div>
                                            
                                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                        </form>

                                    </div>
                                </div>

                            </div>
                        </section></div>


                </section>
            </section>
            <!-- END CONTENT -->



            <div class="chatapi-windows ">


            </div>    </div>
        <!-- END CONTAINER -->
        <!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->


        <!-- CORE JS FRAMEWORK - START --> 
        <script src="assets/js/jquery-1.11.2.min.js" type="text/javascript"></script> 
        <script src="assets/js/jquery.easing.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/pace/pace.min.js" type="text/javascript"></script>  
        <script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js" type="text/javascript"></script> 
        <script src="assets/plugins/viewport/viewportchecker.js" type="text/javascript"></script>  
        <!-- CORE JS FRAMEWORK - END --> 


        <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START --> 
        <script src="assets/plugins/autosize/autosize.min.js" type="text/javascript"></script><script src="assets/plugins/icheck/icheck.min.js" type="text/javascript"></script><!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END --> 


        <!-- CORE TEMPLATE JS - START --> 
        <script src="assets/js/scripts.js" type="text/javascript"></script> 
        <!-- END CORE TEMPLATE JS - END --> 

        <!-- Sidebar Graph - START --> 
        <script src="assets/plugins/sparkline-chart/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="assets/js/chart-sparkline.js" type="text/javascript"></script>
        <!-- Sidebar Graph - END --> 

        
    </body>
</html>