<?php
class rapidSource extends source{
	private $conn;
	private $head;
	private $body;
	private $page;
	private $source;

	public function __construct(){
	}
	public function __destruct(){
		$conn = databaseConnection::_getConnection();
		mysqli_close($conn);
	}
	static function _getFilesinFolders(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$query= "SELECT title, url, anchor FROM opiates WHERE folder='rapid detox' ORDER BY priority ASC, anchor ASC";
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
	static function _getRightNavBarLinks(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$query = "SELECT replace(url,'index.html','') url, title, folder, priority, anchor FROM opiates WHERE type = 'detox' && priority !=0 && misspelled!=1 ORDER BY anchor ASC" ;
		$conn = databaseConnection::_getConnection();
		$qryResults = mysqli_query($conn, $query);
		if(! ($qryResults && mysqli_num_rows($qryResults))){
			return false;
		}
		return $qryResults;
	}
	static function _getDetoxNavBarLinks(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$query = "SELECT replace(url,'index.html','') url, title, folder, priority, anchor FROM opiates WHERE type = 'detox' && priority !=0 && misspelled!=1 ORDER BY anchor ASC" ;
		$conn = databaseConnection::_getConnection();
		$qryResults = mysqli_query($conn, $query);
		if(! ($qryResults && mysqli_num_rows($qryResults))){
			return false;
		}
		return $qryResults;
	}
	static function _getWaismannFiles(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$query= "SELECT title, url, anchor FROM opiates WHERE folder='rapid detox' ORDER BY priority ASC, anchor ASC";
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
}
?>
