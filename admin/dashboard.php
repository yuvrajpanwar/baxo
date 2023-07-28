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

      header("Location: $redirectPath_site/admin/index.php?route=102");
  }
  // echo"here";die();
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

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>


  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">

  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon">
  <!-- Custom styles -->
  <link rel="stylesheet" href="./css/style.min.css">

  

</head>

<body>
  <div class="layer"></div>
<!-- ! Body -->
<a class="skip-link sr-only" href="#skip-target">Skip to content</a>
<div class="page-flex">

  <!-- ! Sidebar -->
  <?php include('./includes/sidebar.php');?>

  <div class="main-wrapper">

    <!-- ! Main nav -->
    <?php include('./includes/main_nav.php'); ?>

    <!-- ! Main -->
    <main class="main users chart-page" id="skip-target">
      <div class="container ">
        <h2 class="main-title">Dashboard</h2>
        <div class="row stat-cards">

        <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item" >
              <div class="stat-cards-icon primary">
                <i data-feather="folder" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info" style="margin-left:20px;">
                <p class="stat-cards-info__num"><?=$total_category_all?></p>
                <h4>Categories<h4>              
              </div>
            
                
                <ul class="top-cat-list" style="width:100%">
                  <hr>
                  <li>
                    <a href="##">
                      <div class="top-cat-list__title" style="font-size:16px">
                        Total <span><?=$total_category_all?></span>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="##">
                      <div class="top-cat-list__title" style="font-size:16px">
                        Active <span><?=$total_category_active?></span>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="##">
                      <div class="top-cat-list__title" style="font-size:16px">
                        Deactive <span><?=$total_category_deactive?></span>
                      </div>
                    </a>
                  </li>
                  <hr>
                  <li style="display:flex;  justify-content:center;">
                      <a href="<?=$redirectPath_site?>/admin/category_list.php"><button style="margin:10px;background-color:green;color:white;padding: 5px;">Manage</button></a>
                  </li>
                </ul>
              </article>
          </div>

          <div class="col-md-6 col-xl-3">
            <article class="stat-cards-item" >
              <div class="stat-cards-icon primary">
                <i data-feather="file" aria-hidden="true"></i>
              </div>
              <div class="stat-cards-info" style="margin-left:20px;">
                <p class="stat-cards-info__num"><?=$total_post_all?></p>
                <h4>Posts<h4>              
              </div>
            
                
                <ul class="top-cat-list" style="width:100%">
                  <hr>
                  <li>
                    <a href="##">
                      <div class="top-cat-list__title" style="font-size:16px">
                        Total <span><?=$total_post_all?></span>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="##">
                      <div class="top-cat-list__title" style="font-size:16px">
                        Active <span><?=$total_post_active?></span>
                      </div>
                    </a>
                  </li>
                  <li>
                    <a href="##">
                      <div class="top-cat-list__title" style="font-size:16px">
                        Deactive <span><?=$total_post_deactive?></span>
                      </div>
                    </a>
                  </li>
                  <hr>
                  <li style="display:flex;  justify-content:center;">
                      <a href="./post_list.php"><button style="margin:10px;background-color:green;color:white;padding: 5px;">Manage</button></a>
                  </li>
                </ul>
              </article>
          </div>

        </div>       
      </div>
    </main>

    <!-- ! Footer -->
    <?php include('./includes/footer.php'); ?>

  </div>

</div>

<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>



<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
</body>

</html>