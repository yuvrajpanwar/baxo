<?php 
  require_once('../classes/utils.php');
  set_timezone();
  
        $sectionOfTime = getDaySection();
		$route = (isset($_REQUEST['route']))?$_REQUEST['route']:'';
		$msg = '';

		switch($route) {

		case "102":
		$msg = 'Invalid userName / Password. Please Try again.';
		break;

		case "103":
		$msg = 'You are successfully logout.';
		break;

		default:
		$msg='';
		
		}     
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In</title>
  <!-- Favicon -->
  <link rel="shortcut icon" href="./img/svg/logo.svg" type="image/x-icon">
  <!-- Custom styles -->
  <link rel="stylesheet" href="./css/style.min.css">
</head>

<body>

<!-- <div class="layer">
</div>  -->
<main class="page-center" >
  <article class="sign-up">       
    <div style="display:flex;justify-content:center;margin-bottom: 50px;">
      <a href="/" class="logo-wrapper" title="Home">
        <img class="logo-dark" src="../assets/img/logo.webp" alt="logo" >
      </a>
    </div>
    <div style="padding-top:10px;color:red; text-align: center; width:100%;margin:0;margin-bottom:10px"><?=$msg?></div>
    <form class="sign-up-form form" name="login_form" id="login_form" action="auth_login.php" method="post">
      <label class="form-label-wrapper">
        <p class="form-label">Username</p>
        <input class="form-input" type="text" placeholder="Enter your Username" name="user_name" id="user_name" required>
      </label>
      <label class="form-label-wrapper">
        <p class="form-label">Password</p>
        <input class="form-input" type="password" placeholder="Enter your password" name="password" id="password" required>
      </label>
      <button class="form-btn primary-default-btn transparent-btn" value="Login" name="Login" id="Login">Sign in</button>
    </form>

  </article>
</main>
<!-- Chart library -->
<script src="./plugins/chart.min.js"></script>
<!-- Icons library -->
<script src="plugins/feather.min.js"></script>
<!-- Custom scripts -->
<script src="js/script.js"></script>
</body>

</html>