<?php 
require_once('instantSearchSource.php');
class MatchType{
	const BEGINS_WITH = 0;
	const ENDS_WITH   = 1;
	const CONTAINS    = 2;
}
class InstantSearchController{
	
	private $query, $matchType;
	
	public function __construct(){
		$this->setQuery();
		$this->setMatchType();
	}
	public function __destruct(){
	}
	public function setQuery(){
		$this->query = isset($_POST['query'])?$_POST['query'] : '';
	}
	public function getQuery(){
		if(isset($this->query)){
			return $this->query;
		}else{
			return false;
		}
	}
	public function setMatchType(){
		$this->matchType = isset($_POST['match_type'])?$_POST['match_type'] : MatchType::CONTAINS;
	}
	public function getMatchType(){
		if(isset($this->matchType)){
			return $this->matchType;
		}else{
			return false;
		}
	}
	public function proccessRequest($query, $matchType){
		$db = new instantSearchSource();
		$like = "'%{$query}%'";
		switch($matchType){
			case MatchType::BEGINS_WITH:
				$like =  "'{$query}%'";
			break;
			case MatchType::ENDS_WITH:
				$like =  "'%{$query}'";
			break;
		}
		$selectQuery = "SELECT title, url, anchor FROM opiates WHERE title LIKE {$like} ORDER BY title ASC";
		$results = $db->select($selectQuery);
		header("Content-type: application/json");
		//echo json_encode(array("numbers"=>mysqli_num_rows($results)));
		echo json_encode(array("numbers"=>mysqli_num_rows($results), "links"=>$db->toArray($results)));
	}
}
$newInstantSC = new InstantSearchController();
$newInstantSC->proccessRequest($newInstantSC->getQuery(), $newInstantSC->getMatchType());
?>