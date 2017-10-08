<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/drug-master-4-28-11/class.source.php');
class opiateSource extends source{
	private $conn;
	private $head;
	private $body;
	private $page;
	private $source;

	public function __construct(){
	}
	public function __destruct(){
		$conn = databaseConnection::_getConnection();
		mysql_connect($conn);
	}
	static function _getFilesinFolders(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['PHP_SELF'];
		$query= "SELECT title, url, anchor FROM opiates WHERE folder = (SELECT folder FROM opiates WHERE url='" . $addressID . "' LIMIT 0,1) ORDER BY priority ASC, anchor ASC";
		$conn = databaseConnection::_getConnection();
		$qryResults = mysql_query($query, $conn);
		if(! ($qryResults && mysql_num_rows($qryResults))){
			unset($qryResults);
			return false;
		}
		else{
		   return $qryResults;
		}
		return false;
	}
	static function _getFiles(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['PHP_SELF']; 
		if(basename($addressID) == 'index.html')
			$addressID = str_replace('index.html', '' ,$addressID); 
		$query= "SELECT * FROM `pain` where folderID=(select folderID from pain where url='".  mysql_real_escape_string($addressID) . "' limit 0,1) order by anchor asc";
		$conn = databaseConnection::_getConnection();
		$qryResults = mysql_query($query, $conn);
		if(! ($qryResults && mysql_num_rows($qryResults))){
			unset($qryResults);
			return false;
		}
		else{
		   return $qryResults;
		}
		return false;
	}
	static function _getRandomRelatedTestimonialFomDB()
	{
		static $localQryResults;
		if(isset($localQryResults)){
			return $localQryResults;
		}
		$addressID =  $_SERVER['PHP_SELF']; 
		$sql = "SELECT * FROM Testimonials WHERE drug_1 = (SELECT folder FROM opiates WHERE url='" . $addressID . "' LIMIT 0,1)ORDER BY RAND() LIMIT 0,2";
		databaseConnection::_getConnection();
		$localQryResults = mysql_query($sql);
		if(! ($localQryResults && mysql_num_rows($localQryResults)))
		{
			return false;
		}
		return $localQryResults;
	}
	static function _getRightNavBarLinks()
	{
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['PHP_SELF']; 
		$sql = "SELECT replace(url,'index.html','') url, title, folder, priority, anchor FROM opiates WHERE type = (SELECT type FROM opiates WHERE url='" . $addressID . "' LIMIT 0,1) && priority!=0 ORDER BY anchor ASC" ;
		databaseConnection::_getConnection();
		$qryResults = mysql_query($sql);
		if(! ($qryResults && mysql_num_rows($qryResults)))
		{
			return false;
		}
		return $qryResults;
	}
}
?>
