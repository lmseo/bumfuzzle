<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/Connections/class.databaseConnection.php');
class source{
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
	static function _getConn(){
		return $this->conn;
	}
	static function _getPageSource($table){
	  static $qryResults;
      if(isset($qryResults)){
         return $qryResults;
      }
	  $addressID =  $_SERVER['PHP_SELF'];
	  switch ($table){
		  case 'opiates':
			  $query = "SELECT * FROM opiates  WHERE url='". $addressID ."'";
			  break;
			case 'rapid_detox':
			  $query = "SELECT * FROM opiates  WHERE url='". $addressID ."'";
			  break;
		  case 'testimonials':
			  $query = "SELECT * FROM testimonials  WHERE url='". $addressID ."'";
			  break;
		  case 'media':
			  $query = "SELECT * FROM media  WHERE url='". $addressID ."'";
			  break;
		  case 'painkillers':
			  $query = "SELECT * FROM painkillers  WHERE url='". $addressID ."'";
			  break;
		  case 'newsletters':
			  $query = "SELECT * FROM  newsletters  WHERE url='" . $addressID ."'";
			  break;
  		  case 'pain':
			  $query = "SELECT p.*, f.* FROM `pain` p ,folders f where p.folderId=f.id && CONCAT(f.url,p.uri)='" . $addressID ."'";
			  break;
		  case 'about':
			  $query = "SELECT * FROM about  WHERE url='". $addressID ."'";
			  break;
	  }
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
	  $query = "SELECT * FROM opiates  WHERE url='". $addressID ."'";
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
	static function _getNewslettersSource($table){
	  static $qryResults;
      if(isset($qryResults)){
         return $qryResults;
      }
	  $addressID =  $_SERVER['PHP_SELF'];
	  switch ($table){
		  case 'opiates':
			  $query = "SELECT * FROM opiates  WHERE url='". $addressID ."'";
			  break;
		  case 'testimonials':
			  $query = "SELECT * FROM Testimonials  WHERE url='http://www.opiates.com". $addressID ."'";
			  break;
		  case 'media':
			  $query = "SELECT * FROM media  WHERE url='". $addressID ."'";
			  break;
		  case 'painkillers':
			  $query = "SELECT * FROM painkillers  WHERE url='". $addressID ."'";
			  break;
		  case 'newsletters':
			  $query = "SELECT * FROM  newsletters  WHERE url='" . $addressID ."'";
			  break;
  		  case 'pain':
			  $query = "SELECT * FROM pain  WHERE url='". $addressID ."'";
			  break;
	  }
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