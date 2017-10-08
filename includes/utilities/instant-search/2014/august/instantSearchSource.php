<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/Connections/class.databaseConnection.php');
class instantSearchSource{
	private $conn;
	private $head;
	private $body;
	private $page;
	private $source;

	public function __construct(){
		$this->conn = databaseConnection::_getConnection();
		
	}
	public function __destruct(){
		$conn = databaseConnection::_getConnection();
		mysqli_close($conn);
	}
	public function select($query){
		if(mysqli_connect_error($this->conn)){
			return false;
		}else{
			return $this->conn->query($query);
		}
	}
	static function _getFilesinFolders(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['REQUEST_URI'];
		$query ="select op.url,op.anchor, op.title,op.priority,op.misspelled,op.uri, (SELECT t.name FROM 
			`termspaths` tp join 
			terms t on tp.ancestor=t.termID
			where tp.descendant in ( select ot.termId 
			from opiates o join 
			opiates_terms ot on o.opiateID= ot.opiateId
			where o.url = op.url)&&
			tp.ancestor in (select descendant from termspaths where ancestor =815 && length=1) limit 0,1) as 'pageType'
			 from opiates op join 
			opiates_terms ot on op.opiateID = ot.opiateID join
			terms t on t.termID = ot.termID
			where ot.termID=(select ot.termID 
							 from opiates o join 
							 opiates_terms ot on ot.opiateID=o.opiateID 
							 where o.url='/opiates.html' 
							 && ot.termID in (select termID from
											  terms t join 
											  termspaths tp on tp.descendant = t.termID
											  where tp.ancestor=222))
			&& op.priority !=0 
			&& op.misspelled!=1 ORDER BY op.priority DESC, op.anchor ASC";
		$conn = databaseConnection::_getConnection();
		$qryResults = mysqli_query($conn, $query);
		if(! ($qryResults && mysqli_num_rows($qryResults))){
			unset($qryResults);
			return false;
		}
		else{
		   return $qryResults;
		}
		return false;
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

?>