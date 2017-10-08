<?php
class sitemapPageSource extends source{
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
	static function _getFacts(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['REQUEST_URI'];
		$query= "select * from opiates o join
			opiates_terms ot on o.opiateID=ot.opiateID
			where ot.termID=(select termID from opiates o JOIN
			opiates_terms ot ON o.opiateID=ot.opiateID
			where o.url='" . $addressID . "' && ot.termID in(select tp.descendant from terms t JOIN 
			termspaths tp ON t.termID = tp.ancestor 
			where t.termID=220)) && ot.opiateID in(select opiateID from opiates_terms where termID in (select tp.descendant FROM 
			termspaths tp Join 
			terms t ON tp.ancestor=t.termID 
			where t.termID=775))";
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
	static function _getGenericTermID(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['REQUEST_URI'];
		$query= "select t.*
			from terms t join 
			termspaths tp on t.termID=tp.descendant
			where  tp.ancestor=226
			and tp.descendant in (SELECT tp.ancestor
			FROM termspaths tp JOIN
			terms t ON t.termID=tp.ancestor 
			where tp.descendant=(SELECT t.termID 
						  FROM terms t JOIN 
						  opiates_terms ot ON t.termID = ot.termID JOIN 
						  opiates o ON  o.opiateID = ot.opiateID
						  WHERE o.url='" . $addressID . "'
						  AND t.termID IN(SELECT tp.descendant
										  FROM terms t JOIN 
										  termspaths tp ON tp.ancestor = t.termID
										  WHERE  t.termID=222))
			&& (tp.length=1 || tp.length=0))
			&& tp.ancestor != tp.descendant
			ORDER BY tp.length ASC
			LIMIT 0,1";
		//222 is the termId for narcotics and 226 is termId for generic drugs
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
	static function _getDrugBrandNames($genericDrug){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$query= "SELECT o.title, o.url, o.uri, t.name,o.anchor,t.termID
			FROM 
			opioid_terms_rankings otr 
			RIGHT OUTER JOIN terms t ON t.termID=otr.termID 
			LEFT OUTER JOIN opiates o ON o.opiateID=t.pageID
			WHERE t.termID IN (
			SELECT t.termID
			FROM
			terms t  
			JOIN termspaths tp ON tp.descendant=t.termID
			WHERE tp.ancestor=".$genericDrug."
			AND tp.descendant IN(SELECT tp.descendant
			FROM terms  t JOIN
			termspaths tp ON tp.descendant=t.termID
			WHERE tp.ancestor=1003)
			AND length >0)
			ORDER BY otr.ranking DESC, t.name ASC";
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
	static function _getCombinations($genericDrug){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$query= "select o.title, t.name, o.url, o.anchor
					FROM opioid_terms_rankings otr 
			RIGHT OUTER JOIN terms t ON t.termID=otr.termID 
			LEFT OUTER JOIN opiates o ON o.opiateID=t.pageID
			WHERE t.termID IN (SELECT t.termID
			from terms t join
			termspaths tp on  tp.descendant=t.termID
			where tp.descendant in (select descendant 
										from termspaths
										where ancestor=".$genericDrug."   
										and ancestor!=descendant)
			and tp.ancestor=817)
			ORDER BY t.name ASC";
			/*817 - Combinatioins*/
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
	static function _getPageTerms(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['REQUEST_URI'];
		$query= "SELECT t.*
			FROM terms t JOIN 
			opiates_terms ot ON ot.termID = t.termID JOIN
			opiates o ON o.opiateID = ot.opiateID
			WHERE o.url='".$addressID."'";
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
	static function _getGenericsList(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$query= "SELECT o.title, o.url, o.uri, t.name,t.name AS anchor,t.termID
			FROM opioid_terms_rankings otr 
			RIGHT OUTER JOIN terms t ON t.termID=otr.termID 
			LEFT OUTER JOIN opiates o ON o.opiateID=t.pageID
			WHERE t.termID IN (
			SELECT t.termID
			FROM `terms` t JOIN
			termspaths tp ON tp.descendant = t.termID
			WHERE tp.ancestor=226
			AND tp.ancestor!=tp.descendant
			AND tp.descendant!=1002
			AND tp.length=1)
			ORDER BY otr.ranking DESC,  t.name ASC";
/*226 - Generic Drugs*/
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
	static function _getTopOpioidsList(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$query= "SELECT o.title, o.url, o.uri, t.name,o.anchor,t.termID, otr.ranking
			FROM opioid_terms_rankings otr 
			RIGHT OUTER JOIN terms t ON t.termID=otr.termID 
			LEFT OUTER JOIN opiates o ON o.opiateID=t.pageID
			WHERE t.termID IN ( SELECT t.termID
			FROM termspaths tp JOIN
			terms t ON t.termID = tp.descendant
			WHERE tp.ancestor=1003)
			ORDER BY otr.ranking DESC, t.name ASC
			LIMIT 0,20";
			/*817 - Combinatioins*/
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
