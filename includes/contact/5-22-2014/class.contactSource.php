<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/drug-master/drug-master-7-18-2014/class.source.php');
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
	static function _getDrugNames(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['PHP_SELF'];
		$query= "SELECT DrugName as name, DrugName as value FROM `druginfo`";
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
