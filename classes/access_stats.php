<?php

	class access_stats {

		public $userAccess;
		public $moveInvalid;
			public function __construct($access){
				$this->userAccess = (isset($access))? $access : '1';
				$this->moveInvalid = $this->checkSession();
				if(!$this->moveInvalid) $this->navigateNonValidUser();
				
			}

			public function checkSession(){
					if(isset($_SESSION['loginType']) && isset($_SESSION['uID'])){
						return $this->checkPrivileges();
					}
				return false;
			}
			
			public function checkPrivileges(){
				if($_SESSION['privilege'] > $this->userAccess) return true;

			}

			public function navigateNonValidUser(){

						if(preg_match("/.com/i",$_SERVER['SERVER_NAME'])){
								$redirectPath = "./admin";
						}else{
								$redirectPath = "./admin";
						}

					header("Location: $redirectPath/index.php?route=102");
					exit;

			}
	}
?>