<?php
session_start();  
require_once('../classes/utils.php');
require_once('../classes/connect_pdo_emp.php');
require_once('../classes/access_stats_emp.php');
$privilege = '0';
include("resizecode.php");
$nav = new access_stats($privilege);
set_timezone();
$pdoConnect = new connect_pdo();
$db = $pdoConnect->connectToDB();
$cuurent_datetime=date("Y-m-d H:i:s");
  try
	{
		//print_r($_POST); die();
		$file_string= $_POST['mid'];
        $destinpath="../images/".$file_string;
        
        //echo $destinpath;die();
      
        if($destinpath)
        {
            if(file_exists($destinpath))
            {
                unlink($destinpath);
            }
        }
      
       
		
		

	}
	 catch(PDOException $ex) 
	 {
			echo "An Error occured! Please contact Administrator.";
	 }

?>