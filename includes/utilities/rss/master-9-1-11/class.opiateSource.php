<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/drug-master-9-1-11/class.source.php');
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
	static function _getRandomRelatedTestimonialFomDB()
	{
		static $localQryResults;
		if(isset($localQryResults)){
			return $localQryResults;
		}
		$addressID =  $_SERVER['PHP_SELF']; 
		$sql = "SELECT * FROM testimonials WHERE drug_1 = (SELECT folder FROM opiates WHERE url='" . $addressID . "' LIMIT 0,1) and url!='/success/index.html' and url!='/success/index-2009-2008.html' and url!='/success/index-2007-1999.html' ORDER BY RAND() LIMIT 0,2";
		databaseConnection::_getConnection();
		$localQryResults = mysql_query($sql);
		if(! ($localQryResults && mysql_num_rows($localQryResults)))
		{
			$sql = "SELECT * FROM testimonials WHERE and url!='/success/index.html' and url!='/success/index-2009-2008.html' and url!='/success/index-2007-1999.html' ORDER BY RAND() LIMIT 0,2";
			databaseConnection::_getConnection();
			$localQryResults = mysql_query($sql);
			if(! ($localQryResults && mysql_num_rows($localQryResults)))
			{
				return false;
			}
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
		$sql = "SELECT replace(url,'index.html','') url, title, folder, priority, anchor FROM opiates WHERE type = (SELECT type FROM opiates WHERE url='" . $addressID . "' LIMIT 0,1) && priority !=0 && misspelled!=1 ORDER BY anchor ASC" ;
		$conn = databaseConnection::_getConnection();
		$qryResults = mysql_query($sql, $conn);
		if(! ($qryResults && mysql_num_rows($qryResults)))
		{
			$sql = "SELECT replace(url,'index.html','') url, title, folder, priority, anchor FROM opiates WHERE type = 'detox' && priority !=0 && misspelled!=1 ORDER BY anchor ASC" ;
			databaseConnection::_getConnection();
			$qryResults = mysql_query($sql);
			if(! ($qryResults && mysql_num_rows($qryResults)))
			{
				return false;
			}
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
		$query= "SELECT title, url, anchor FROM rapid_detox ORDER BY priority ASC, anchor ASC";
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
	
	static function _getGenericDrug(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['PHP_SELF'];
		$query= "SELECT * 
FROM terms 
WHERE termID =(
select tp.ancestor 
from terms t join 
termspaths tp 
on t.termID=tp.descendant 
where tp.ancestor in(
SELECT tp.descendant FROM `terms` t JOIN termspaths tp ON t.termID=tp.ancestor where t.termID=226) and t.termID=(SELECT termID 
FROM terms t NATURAL JOIN opiates_terms ot 
NATURAL JOIN opiates o
WHERE url='".$addressID."'
AND t.termID IN(SELECT tp.descendant
FROM terms t JOIN termspaths tp ON tp.ancestor = t.termID
WHERE  t.termID=222)))";
		//222 is the termId for narcotics and 226 is termId for generic drugs
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
	static function _getParentDrugClass(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['PHP_SELF'];
		$query= "SELECT *
FROM terms t JOIN  termspaths tp ON tp.ancestor= t.termID
WHERE 
TP.ancestor != 226 AND tp.descendant =(SELECT t.termID 
FROM terms t 
NATURAL JOIN opiates_terms ot 
NATURAL JOIN opiates o
WHERE o.url='".$addressID."'
AND t.termID in(
SELECT tp.descendant
FROM terms t 
JOIN termspaths tp 
ON tp.ancestor = t.termID
WHERE  t.termID=222))
ORDER BY length ASC";
//226 IS gENERIC dRUGS
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
	static function _getDrugBrandNames(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['PHP_SELF'];
		$query= "SELECT * FROM 
terms t JOIN termspaths tp ON tp.descendant= t.termID
WHERE tp.ancestor != tp.descendant AND tp.ancestor= (
SELECT termID 
FROM terms 
WHERE termID =(
select tp.ancestor 
from terms t join 
termspaths tp 
on t.termID=tp.descendant 
where tp.ancestor in(
SELECT tp.descendant FROM `terms` t JOIN termspaths tp ON t.termID=tp.ancestor where t.termID=226) and t.termID=(SELECT termID 
FROM terms t NATURAL JOIN opiates_terms ot 
NATURAL JOIN opiates o
WHERE url='".$addressID."'
AND t.termID IN(SELECT tp.descendant
FROM terms t JOIN termspaths tp ON tp.ancestor = t.termID
WHERE  t.termID=222))))
LIMIT 0,20";
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
	static function _getPageTerms(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['PHP_SELF'];
		$query= "SELECT t.*
FROM terms t NATURAL JOIN opiates_terms ot 
NATURAL JOIN opiates o
WHERE url='".$addressID."'";
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
	static function _getMisspellings(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['PHP_SELF'];
		$query= "SELECT replace(url,'index.html','') url, title, folder, priority, anchor FROM opiates  WHERE misspelled=1 && priority !=0 && type='index' ORDER BY anchor ASC";
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
