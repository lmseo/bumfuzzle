<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/Connections/class.databaseConnection.php');
class indexSource{
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
	static function _getIndexSource($table, $max=2011 , $min=2011){
	  $qryResults;
	  $addressID =  $_SERVER['PHP_SELF'];
	  switch ($table){
		  case 'opiates':
			  $query = "SELECT * FROM opiates";
			  break;
		  case 'testimonials':
			  $query = "SELECT * FROM Testimonials";
			  break;
		  case 'media':
			  $query = "SELECT * FROM media";
			  break;
		  case 'painkillers':
			  $query = "SELECT * FROM painkillers";
			  break;
		  case 'newsletters':
			  $query = 'SELECT * FROM newsletters WHERE url!=\'/newsletters/index.html\' && active=1 && dateCreated <= \'' .$max . '\' && dateCreated >= \'' . $min . '\' ORDER BY dateCreated DESC';
			  break;
  		  case 'pain':
			  $query = "SELECT * FROM pain";
			  break;
	  }
	  $conn = databaseConnection::_getConnection();
	  $qryResults = mysqli_query($query, $conn);
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