<?php
date_default_timezone_set('Asia/Kolkata');
	class connect_pdo {

		protected $dbh;
		public $host='';
		public $dbName='';
		public $charSet='';
		public $dbUser='';
		public $dbPass='';


		public function __construct(){

			$this->getRunningServerParam();
			
					try{
					$db = new PDO("mysql:host={$this->host};dbname={$this->dbName};charset={$this->charSet}", "{$this->dbUser}", "{$this->dbPass}",array(PDO::ATTR_EMULATE_PREPARES => false,PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
					$this->dbh = $db;
					}catch(PDOException $ex) {
			
						echo "An Error occured! ".$ex->getMessage();

					}
		}

		public function connectToDB(){

			return $this->dbh;

		}

		public function getRunningServerParam(){


				
				if(preg_match("/.com/i",$_SERVER['SERVER_NAME'])){
					$this->host = 'localhost';
					$this->dbName = 'khabarnewindia_db';
					$this->charSet = 'utf8';
					$this->dbUser = 'root';
					$this->dbPass = '';
				}elseif(preg_match("/localhost/i",$_SERVER['SERVER_NAME'])){
					$this->host = 'localhost';
					$this->dbName = 'khabarnewindia_db';
					$this->charSet = 'utf8';
					$this->dbUser = 'root';
					$this->dbPass = '';
				}else {
					$this->host = 'localhost';
					$this->dbName = 'khabarnewindia_db';
					$this->charSet = 'utf8';
					$this->dbUser = 'root';
					$this->dbPass = '';
				}
				
				return true;
		}
	}
?>