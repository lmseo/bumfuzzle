<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/drug-master-9-1-11/class.source.php');
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
		mysql_connect($conn);
	}
	static function _getFilesinFolders(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['PHP_SELF'];
		$query= "SELECT title, url, anchor FROM opiates WHERE folder='rapid detox' ORDER BY priority ASC, anchor ASC";
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
		$sql = "SELECT * FROM testimonials WHERE url!='/success/index.html' and url!='/success/index-2009-2008.html' and url!='/success/index-2007-1999.html' ORDER BY RAND(), priority ASC, yearVisit DESC, monthVisit DESC LIMIT 0,2";
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
		$sql = "SELECT replace(url,'index.html','') url, title, folder, priority, anchor FROM opiates WHERE type = 'detox' && priority !=0 && misspelled!=1 ORDER BY anchor ASC" ;
		databaseConnection::_getConnection();
		$qryResults = mysql_query($sql);
		if(! ($qryResults && mysql_num_rows($qryResults)))
		{
			return false;
		}
		return $qryResults;
	}
	static function _getDetoxNavBarLinks()
	{
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['PHP_SELF']; 
		$sql = "SELECT replace(url,'index.html','') url, title, folder, priority, anchor FROM opiates WHERE type = 'detox' && priority !=0 && misspelled!=1 ORDER BY anchor ASC" ;
		databaseConnection::_getConnection();
		$qryResults = mysql_query($sql);
		if(! ($qryResults && mysql_num_rows($qryResults)))
		{
			return false;
		}
		return $qryResults;
	}
	static function _getWaismannFiles(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['PHP_SELF'];
		$query= "SELECT title, url, anchor FROM opiates WHERE folder='rapid detox' ORDER BY priority ASC, anchor ASC";
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
}
?>
