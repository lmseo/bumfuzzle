<?php 
include_once("abstract.database.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/Connections/class.databaseConnection.php');

class mySQLDatabase extends abstractDatabase{
	private $db, $ht, $un, $pw, $dn;
	
	public function __construct($host=NULL, $username=NULL, $password=NULL, $databaseName=NULL){
		
		if(isset($host) || isset($username) || isset($password) || isset($databaseName)){
			$this->ht=$host;
			$this->un=$username;
			$this->pw=$password;
			$this->dn=$databaseName;
			$this->db = new mysqli($host, $username, $password, $databaseName);
		}else{
			$this->db = databaseConnection::_getConnection();
		}
		if (mysqli_connect_error($this->db)) {
			die('Connection Error ');
		}
	}
	public function __destruct(){
		if($this->db->connect_error){
		}else{
			$this->db->close();
		}
	}
	public function select($query){
		if(mysqli_connect_error($this->db)){
			return false;
		}else{
			return $this->db->query($query);
		}
	}
	public function query($query){
		if(mysqli_connect_error($this->db)){
			return false;
		}else{
			return $this->db->query($query);
		}
	}
	
	public function toArray(mysqli_result $result){
		$arr = array();
		if($result){
			// Cycle through results
			while($row = $result->fetch_assoc()){					
					 array_push($arr, $row);
			}
			// Free result set
			$result->close();
			//prepares $db for next query only if there is a net query
			//if(isset($this->db) && get_class($this->db)=='mysqli'){
			//	$this->db->next_result();
			//}
		}
		return $arr;
		
	}
	
}
/*$conn = new mySQLDatabase();
$results = $conn->select('select * from opiates where folder = "oxycontin"');
$aResults = $conn->toArray($results);
print_r($aResults);*/
?>