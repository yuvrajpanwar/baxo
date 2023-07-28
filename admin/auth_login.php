<?PHP
// echo "here";die();
session_start();
require_once('../classes/connect_pdo_emp.php');
require_once('../classes/access_stats_emp.php');
require_once('../classes/utils.php');
$redirectPath_site=path();
//echo $redirectPath_site;die();
//echo $_POST['Login'];die();


if($_POST['Login'] == 'Login')
{
	
	$userName = $_POST['user_name'];
	$userPass = $_POST['password'];
	
	
    $userPass = md5($userPass);
	try
	{
		
		$now = 'NOW()';
		$val="";
		$pdoConnect = new connect_pdo();
		$db = $pdoConnect->connectToDB();
		$prepQuery = $db->prepare("select * from khabarnewindia_adminlogin where user_name=:username and password=:password ");		
		$prepQuery->bindParam(':username', $userName);
		$prepQuery->bindParam(':password', $userPass);
		$prepQuery->execute();
		$affected_rows = $prepQuery->rowCount();
		
		
		$queryRes=$prepQuery->fetch(PDO::FETCH_ASSOC);
		$userName=$queryRes['user_name'];
		$name=$queryRes['name'];
		$userID=$queryRes['id'];
		$empType = $queryRes['user_type'];

		$privilege = 0;
		
		switch($empType) {
		case "emp":
		$privilege = 0;
		break;
		
		case "hr":
		$privilege = 1;
		break;
		
		case "admin":
		$privilege = 2;
		break;
		
		default:
		$privilege = 0;
		}
		
		if($affected_rows>0)
		{
			// echo "here";die();
			$_SESSION['uID'] = $userID ;
			$_SESSION['loginType']=$empType;
			$_SESSION['privilege'] = $privilege;
			$_SESSION['admin_name'] = $name;
			$_SESSION['admin_email'] = $userName;
			$_SESSION['loggedin_time'] = time(); 
           
			if(!isLoginSessionExpired()) {

			   
				header("Location: $redirectPath_site/admin/dashboard.php");
			}
			else{
		
			   header("Location: $redirectPath_site/admin/index.php?route=102");
			   exit;
			
		    }
		}
		else
		{
			header("Location: $redirectPath_site/admin/index.php?route=102");
			exit;
			
		}


	}
	 catch(PDOException $ex) 
	 {
			echo "An Error occured! ".$ex->getMessage();
	 }
}
else 
{
	header("Location: $redirectPath_site/admin/index.php?route=102");
	exit;	
}




	
?>