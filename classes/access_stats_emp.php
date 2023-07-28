<?php

	class access_stats {

		public $userAccess;
		public $moveInvalid;
			public function __construct($access){
				$this->userAccess = (isset($access))? $access : '0';
				$this->moveInvalid = $this->checkSession();

				if(!$this->moveInvalid) $this->navigateNonValidUser();
				//if(!$this->isSessionActive()) $this->navigateNonValidUser();
				
			}

			public function checkSession(){
					if(isset($_SESSION['loginType']) && isset($_SESSION['uID'])){
						return $this->checkPrivileges();
					}
				return false;
			}
			
			public function checkPrivileges(){
				if($_SESSION['privilege'] >= $this->userAccess) 
				{
					return true;
				}
				else {
					return false;
				}
			}

			public function navigateNonValidUser(){

						if(preg_match("/.com/i",$_SERVER['SERVER_NAME'])){
								$redirectPath = ".";
						}else{
								$redirectPath = ".";
						}
				// echo"here";die();
					header("Location: $redirectPath/index.php?route=102#Login-Screen");
					exit;

			}
			
			public function isSessionActive() {
				if(isset($_SESSION['lastActivity']) && (time() - $_SESSION['lastActivity'] > 1800)) {					
					session_unset();
					session_destroy();
					return false;
				}else {	
					$_SESSION['lastActivity'] = time();	
					return true;
				}
			
			}
	}
?>