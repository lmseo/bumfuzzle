<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/Connections/class.databaseConnection.php');
class source{
	private $conn;

	public function __construct(){
	}
	public function __destruct(){
		$conn = databaseConnection::_getConnection();
		mysql_connect($conn);
	}
	static function _getConn(){
		return $this->conn;
	}
	static function _getPageSource(){
	  static $qryResults;
      if(isset($qryResults)){
         return $qryResults;
      }
	  $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
	  $addressID = $uri_parts[0];
			  $query = "SELECT O.*, concat(pt.templateBaseURL,pt.templateURI) as templateURL
FROM opiates o 
JOIN opiate_page_templates opt ON o.opiateID=opt.opiateID 
JOIN page_templates pt ON pt.templateID = opt.templateID
where o.url='". $addressID ."'";
	  $conn = databaseConnection::_getConnection();
	  if(isset($query)){
		  $qryResults = mysql_query($query, $conn);
		  if(! ($qryResults && mysql_num_rows($qryResults))){
			  unset($qryResults);
			  return false;
		  }
		  else{
			 return $qryResults;
		  }
	  }
	  return false;
	}
	static function _get404(){
	  static $qryResults;
      if(isset($qryResults)){
         return $qryResults;
      }
	  $addressID =  '/errordocuments/404page.html';
	  $query = "SELECT *, concat(pt.templateBaseURL,pt.templateURI) as templateURL
FROM opiates o JOIN 
opiate_page_templates opt ON o.opiateID=opt.opiateID JOIN
page_templates pt ON pt.templateID = opt.templateID
where o.url='". $addressID ."'";
	  $conn = databaseConnection::_getConnection();
	  if(isset($query)){
		  $qryResults = mysql_query($query, $conn);
		  if(! ($qryResults && mysql_num_rows($qryResults))){
			  unset($qryResults);
			  return false;
		  }
		  else{
			 return $qryResults;
		  }
	  }
	  return false;
	}
}
?>