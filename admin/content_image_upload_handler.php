<?php

session_start();  
require_once('../classes/utils.php');
$redirectPath_site=path();
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
		
		//print_r($_POST);die();
		$orgfilename = $_FILES["content_img"]["name"];
		
		if($orgfilename)
		{
			function adms_regid()
			{
				$genid="";
				for($i=0; $i<6; $i++)
				{
					$d=rand(1,30)%2; 
					$d=$d ? chr(rand(65,90)) : chr(rand(48,57));
					$genid=$genid.$d;
				}
				
				return $genid;
			}
					
			$row_id=adms_regid();
			$maxsize    = 2097152;		
			$valid_formats = array("jpg","jpeg","JPG","JPEG","png", "PNG");
			$tmp_filename = $_FILES["content_img"]["tmp_name"];
			$temp=pathinfo($orgfilename);
			if(!empty($orgfilename))
			{
				$get_file_extension = strtolower($temp['extension']);
				if(in_array($get_file_extension, $valid_formats))
				{
					$file_info = getimagesize($_FILES['content_img']['tmp_name']);
					if(empty($file_info)) // No Image?
					{
						echo"invalid";die();
					}
					else
					{
						if($_FILES['content_img']['size'] >= $maxsize)
						{
							echo"size";die();
						}
						else
						{
							$destinpath = "../images/$orgfilename";
							//echo $destinpath;
							$url = '../images/'.$row_id.".".$get_file_extension;
							$image_name='images/'.$row_id.".".$get_file_extension;
							move_uploaded_file($tmp_filename,$url);
							// echo $result;die();
							/*$modwidth = 580;
							$image=new resizecode();
							$image->load($destinpath);
							$image->resizeTowidth($modwidth);*/
							//$image->resizeToHeight($modheight);
							
							//$image->save($url);
							
							if(file_exists($destinpath))
							{
								unlink($destinpath);
							}
							
							$digits = 3;
							$id_sel=rand(pow(10, $digits-1), pow(10, $digits)-1);
							$file_name_string=$row_id.".".$get_file_extension;
							
							//echo$image_name;die();
							$result="<div class='col-lg-2' id='block-$row_id'><a href='#' id='$file_name_string' class='media_del' onclick='delete_media_file(this.id);' ><i class='fa fa-times' aria-hidden='true' style='font-size: 20px;'></i></a><img src='$redirectPath_site/$image_name' class='$id_sel' style='width:95px; height:60px; margin-bottom:5px;'><input type='hidden' value='$redirectPath_site/$image_name' id='$id_sel' ></br><a href='#' onclick='copy($id_sel);' class='btn' style='margin-bottom:5px;'>Copy Link</a></div>";
							//$result="<img src='$redirectPath_site/$image_name' class='$id_sel' style='width:100px; height:50px;'><p id='$id_sel' style='display:none;'>$redirectPath_site/$image_name</p></br><button onclick='copy($id_sel);'>Copy Link</button>";
							
							echo$result;
							
							die();
						}							

					}
					
					
				}
				else
				{
					echo"invalid";die();
					
				}
			}
			else
			{
				echo"invalid";die();
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