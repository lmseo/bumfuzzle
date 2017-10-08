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
		//$hDB = mysql_connect('eopiatesmasterdb.db.11054938.hostedresource.com', 'eopiatesmasterdb', 'Anthony845!@#');
		$hDB = mysql_connect(//'68.178.142.109', 
						'localhost',
						'eopiatesmasterdb', 
						'Anthony845!@#') or die("Failure connecting to the database!");
		mysql_select_db('eopiatesmasterdb',$hDB)  or die ("Could not open database");
   		return $hDB;
	}
	
	static function _getConnectionToContact() {
      static $hDB;

      if(isset($hDB)){
         return $hDB;
      }
      $hDB = mysql_connect('localhost', 
						'opiates', 
                        'steelworks')
         or die("Failure connecting to the database!");
	  mysql_select_db('db_opiates',$hDB)  or die ("Could not open database");
      return $hDB;
	}
}
?>