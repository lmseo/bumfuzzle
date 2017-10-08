<?php
class databaseConnection{
	public function __construct(){

	}
	//Connect to the database
	static function getPDOConnection(){
		static $conn;
		if(isset($conn)){
			return $conn;
		}
		try{
		$conn = new PDO('mysql:host=localhost;dbname=eopiatesmasterdb','eopiatesmasterdb','Anthony845!@#');
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
		}catch(PDOException $e){
			//echo $e->getMessage();
			die("Could not open database");
		}
		return  $conn;
	}
	static function _getConnection() {
		static $hDB;
		if(isset($hDB)){
			return $hDB;
		}
		//error_reporting(E_USER_ERROR); 
		$hDB = mysqli_connect(//'68.178.142.109', 
						'localhost',
						'eopiatesmasterdb', 
						'Anthony845!@#','eopiatesmasterdb');
		if(mysqli_connect_errno($hDB)){
			echo "Failed to connect to database: " . mysqli_connect_error();
			return false;
		}
   		return $hDB;
	}
	
	static function _getConnectionToContact() {
      static $hDB;

      if(isset($hDB)){
         return $hDB;
      }
      $hDB = mysqli_connect('localhost', 
						'opiates', 
                        'steelworks','db_opiates');
	  if(mysqli_connect_errno($hDB)){
		  echo "Failed to connect to database: " . mysqli_connect_error();
		  return false;
	  }
      return $hDB;
	}
}
?>