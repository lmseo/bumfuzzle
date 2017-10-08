<?php
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
				 where o.url='" . $addressID . "' 
				 && ot.termID in (select termID from
								  terms t join 
								  termspaths tp on tp.descendant = t.termID
								  where tp.ancestor=221))
&& op.priority !=0 
&& op.misspelled!=1 ORDER BY op.priority DESC, op.anchor ASC";
		//$query= "SELECT title, url, anchor FROM opiates WHERE folder = (SELECT folder FROM opiates WHERE url='" . $addressID . "' LIMIT 0,1) ORDER BY priority ASC, anchor ASC";
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
		$addressID =  $_SERVER['REQUEST_URI']; 
		$sql = "SELECT * FROM testimonials WHERE drug_1 = (SELECT folder FROM opiates WHERE url='" . $addressID . "' LIMIT 0,1) ORDER BY RAND() LIMIT 0,2";
		databaseConnection::_getConnection();
		$localQryResults = mysql_query($sql);
		if(! ($localQryResults && mysql_num_rows($localQryResults)))
		{
			$sql = "SELECT * FROM testimonials ORDER BY RAND() LIMIT 0,2";
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
		$addressID =  $_SERVER['REQUEST_URI']; 
		$sql = "SELECT replace(url,'index.html','') url, title, folder, priority, anchor FROM opiates WHERE type = (SELECT type FROM opiates WHERE url='" . $addressID . "' LIMIT 0,1) && type !='combinations' &&  priority !=0 && misspelled!=1 ORDER BY anchor ASC" ;
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
		/*SELECT *
FROM opiates o join 
opiates_terms ot on o.opiateID=ot.opiateID JOIN
`termspaths` tp ON ot.termID=tp.descendant join 
terms t on tp.ancestor=t.termID 
where tp.descendant in ( select ot.termId 
                         from opiates o join 
                         opiates_terms ot on o.opiateID= ot.opiateId
                         where o.url = '/opiate-home-detox.html')
&& tp.ancestor in (select descendant 
                   from termspaths 
                   where ancestor =815 && length=1)
limit 0,90*/
	}
	static function _getDetoxNavBarLinks()
	{
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['REQUEST_URI']; 
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
		$addressID =  $_SERVER['REQUEST_URI'];
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
	static function _getGenericDrug(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['REQUEST_URI'];
		/*$query = "SELECT o.title, o.url, o.uri, t.name AS name, tp.length,t.termID
FROM termspaths tp 
JOIN terms t ON tp.ancestor = t.termID
LEFT JOIN opiates o on  t.pageID = o.opiateID
where tp.descendant=(SELECT t.termID 
FROM terms t JOIN
opiates o ON  o.opiateID = t.pageID
WHERE o.url='".$addressID."') 
AND tp.ancestor in 
(SELECT tp.descendant
FROM terms t 
JOIN termspaths tp 
ON tp.ancestor = t.termID
WHERE  t.termID=222)
AND tp.ancestor in 
(SELECT tp.descendant
FROM terms t 
JOIN termspaths tp 
ON tp.ancestor = t.termID
WHERE  t.termID=226)
ORDER BY tp.length ASC";*/
		$query="SELECT title, o.url, uri, t.name, t.termID
FROM terms t
LEFT OUTER JOIN opiates o ON o.opiateID=t.pageID
WHERE t.termID = ( 
SELECT t.termID
FROM terms t
JOIN termspaths tp ON t.termID = tp.descendant
WHERE tp.ancestor =226
AND tp.descendant
IN (SELECT tp.ancestor
FROM termspaths tp
JOIN terms t ON t.termID = tp.ancestor
WHERE tp.descendant = ( 
SELECT t.termID
FROM terms t
JOIN opiates_terms ot ON t.termID = ot.termID
JOIN opiates o ON o.opiateID = ot.opiateID
WHERE o.url =  '".$addressID."'
AND t.termID
IN (SELECT tp.descendant
FROM terms t
JOIN termspaths tp ON tp.ancestor = t.termID
WHERE t.termID =222
) ) && ( tp.length =1 || tp.length =0 ) ) && tp.ancestor != tp.descendant
ORDER BY tp.length ASC 
LIMIT 0 , 1
)";
		/*$query= "select * 
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
LIMIT 0,1";*/
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
	static function _getGenericTermID(){
		static $qryResults;
		if(isset($qryResults)){
			return $qryResults;
		}
		$addressID =  $_SERVER['REQUEST_URI'];
		/*226 is Generic drug*/
		$query="SELECT t.termID, t.name
FROM terms t JOIN
termspaths tp ON t.termID = tp.ancestor
where tp.descendant = (select ttp.termID 
from opiates o  NATURAL JOIN
opiates_terms ot JOIN 
(select t.* 
FROM terms t JOIN 
termspaths tp ON tp.descendant = t.termID
WHERE tp.ancestor=226) ttp ON ot.termID = ttp.termID
WHERE o.url='" . $addressID . "') &&
t.termID IN (select t.termID 
FROM terms t JOIN 
termspaths tp ON tp.descendant = t.termID
WHERE tp.ancestor=226)
ORDER BY tp.length ASC
LIMIT 0,1";
		/*$query= "select t.*
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
LIMIT 0,1";*/
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
		$addressID =  $_SERVER['REQUEST_URI'];
		/*$query="SELECT o.title, o.url, o.uri, t.name AS name, tp.length,t.termID
FROM termspaths tp 
JOIN terms t ON tp.ancestor = t.termID
LEFT JOIN opiates o on  t.pageID = o.opiateID
where tp.descendant=(SELECT t.termID 
FROM terms t JOIN
opiates o ON  o.opiateID = t.pageID
WHERE o.url='" . $addressID . "') 
AND tp.ancestor in 
(SELECT tp.descendant
FROM terms t 
JOIN termspaths tp 
ON tp.ancestor = t.termID
WHERE  t.termID=222)
ORDER BY length ASC";*/
		$query="SELECT o.title, o.url, o.uri, o.anchor AS name, tp.length
FROM opiates o 
JOIN terms t ON t.pageID = o.opiateID
JOIN  termspaths tp ON tp.ancestor= t.termID
WHERE tp.descendant =(SELECT t.termID 
FROM terms t JOIN 
opiates_terms ot ON ot.termID = t.termID JOIN
opiates o ON  o.opiateID = ot.opiateID
WHERE o.url='" . $addressID . "'
AND t.termID in(
SELECT tp.descendant
FROM terms t 
JOIN termspaths tp 
ON tp.ancestor = t.termID
WHERE  t.termID=222))
AND tp.ancestor in (SELECT tp.descendant
FROM terms t 
JOIN termspaths tp 
ON tp.ancestor = t.termID
WHERE  t.termID=222)
ORDER BY length ASC";
		/*$query= "SELECT *
FROM terms t JOIN  termspaths tp ON tp.ancestor= t.termID
WHERE tp.descendant =(SELECT t.termID 
FROM terms t JOIN 
opiates_terms ot ON ot.termID = t.termID JOIN
opiates o ON  o.opiateID = ot.opiateID
WHERE o.url='" . $addressID . "'
AND t.termID in(
SELECT tp.descendant
FROM terms t 
JOIN termspaths tp 
ON tp.ancestor = t.termID
WHERE  t.termID=222))
AND tp.ancestor in (SELECT tp.descendant
FROM terms t 
JOIN termspaths tp 
ON tp.ancestor = t.termID
WHERE  t.termID=222)
ORDER BY length ASC";*/
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
/*drug brand names select * from opiates o join
opiates_terms ot on o.opiateID=ot.opiateID
where 
ot.termID=778
&& ot.opiateID in(
                 select opiateID 
                 from opiates_terms 
                 where termID in (
                                 SELECT tp.descendant FROM 
terms t
JOIN termspaths tp ON tp.descendant= t.termID
WHERE tp.ancestor != tp.descendant 
AND tp.ancestor= (
                  SELECT termID 
                  FROM terms 
                  WHERE termID =(
                                select tp.ancestor 
                                from terms t join 
                                termspaths tp 
                                on t.termID=tp.descendant 
                                where tp.ancestor in(
                                                    SELECT tp.descendant 
                                                    FROM `terms` t 
                                                    JOIN termspaths tp ON t.termID=tp.ancestor 
                                                    where t.termID=226) 
                                and t.termID=(
                                              SELECT termID 
                                              FROM terms t NATURAL 
                                              JOIN opiates_terms ot 
                                              NATURAL JOIN opiates o
                                              WHERE url='/oxycodone.html'
                                              AND t.termID IN(
                                                             SELECT tp.descendant
                                                             FROM terms t 
                                                             JOIN termspaths tp ON tp.ancestor = t.termID
                                                             WHERE  t.termID=222)))) ))*/
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
		$addressID =  $_SERVER['REQUEST_URI'];
		$query= "SELECT t.*
FROM terms t JOIN 
opiates_terms ot ON ot.termID = t.termID JOIN
opiates o ON o.opiateID = ot.opiateID
WHERE o.url='".$addressID."'";
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
