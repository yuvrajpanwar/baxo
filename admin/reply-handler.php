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
$cuurent_datetime=date("Y-m-d H:i:s");
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
		$key=$_POST['key'];
		$row_id=base64_decode($key);
		$reply_text=$_POST['text'];
		if($key)
		{
			//echo"here";die();
			$checkQuery = $db->query("select * from khabarnewindia_post_comment where id='$row_id'");
			$check_rows = $prepQuery->rowCount();
			if($check_rows)
			{
				$update_query = $db->prepare("update khabarnewindia_post_comment SET reply = :rpy, modified = :current_time where id = :id");
				$params = array("rpy" => $reply_text,"current_time" => $cuurent_datetime,"id" => $row_id);
				$data = $update_query->execute($params);
				echo"yes";die();
			}
			else
			{
				echo"no";die();
			}
			
			
		}
		else
		{
			//echo"hello";die();
			echo"no";die();
		}

	}
	 catch(PDOException $ex) 
	 {
			echo "An Error occured! Please contact Administrator.";
	 }

?>