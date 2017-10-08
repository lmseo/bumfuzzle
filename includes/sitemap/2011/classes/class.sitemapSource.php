<?php
require_once("class.links.php");
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/Connections/class.databaseConnection.php');

class sitemapSource {
	private $delim ; 
	private $tree;
	private $dirs;
	private $files;
	private $flagDate, $dateModifiedArray;
	function __construct($wd, $filter, $flagD=false){
		$this->flagDate = $flagD;
		$this->delim = strstr(PHP_OS, "WIN") ? "/" : "/";
		if($flagD)
			$this->setDateModified();
		$this->setTree($wd, $filter);
	}
	static function _getDateModifiedSource(){
		static $qryResults;
		if(isset($qryResults)){
		   return $qryResults;
		}
		$addressID =  $_SERVER['PHP_SELF'];
		$query = "SELECT url, dateModified FROM `opiates` order by url";
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
	public function setTree($path,$filter) {
		$aReplace = array('../','./');
		$cleaner = new Links();
		if ($dir = @opendir($path)){
			$fTitle=$dTitle= '';
			while (($element = readdir($dir)) !== false) { 
				if (is_dir($path.$this->delim.$element) && $element != "." && $element != ".." && !$filter->in_dir_filter($element)) {
					$dTitle = trim(ucwords(str_replace( "html", "",$cleaner->clean_anchor($element))));
					//echo $dTitle . "\n";
					$array[$dTitle]['name'] = $dTitle; 
					$array[$dTitle]['type'] = 'folder';
					//$array[$j]['url'] = $path.$this->delim.$element;
					$array[$dTitle]['files']= $this->setTree($path.$this->delim.$element,$filter);
					//print_r( $array[$dTitle]['files']); 
					if(isset($array[$dTitle]['files']['Index']['url'])){
						$array[$dTitle]['url'] = str_replace($aReplace,'/', $path.$this->delim.$element.$this->delim);
						$array[$dTitle]['dateModified'] = $array[$dTitle]['files']['Index']['dateModified'];
						unset($array[$dTitle]['files']['Index']);
						if(count($array[$dTitle]['files'])==0){
							unset($array[$dTitle]['files']);
						}
					}
					//echo $element . "\n";
				} elseif ($element != "." && $element != ".." && is_file($path.$this->delim.$element) && !$filter->in_file_filter($element) ) {
					//echo $element . ' '. $dTitle . "<br />\n";
						$fTitle = trim(ucwords(str_replace( "html", "",$cleaner->clean_anchor($element)))) ; 
						$array[$fTitle]['name'] = $fTitle ;
						$array[$fTitle]['url'] =  str_replace($aReplace,'/', $path.$this->delim.$element); 
						$array[$fTitle]['type'] = 'file';
						if($this->flagDate){
							$date= $this->addDateModifiedToSource($array[$fTitle]['url']);
							
							//echo $date . "\n";
							if(!$date){
							}else{
								//echo $date;
								$array[$fTitle]['dateModified'] = $date;
								//echo $array[$fTitle]['dateModified'] . ' '.  $array[$fTitle]['url'] ."\n";
							}
						}
				}
			} 
			closedir($dir); 
			
		} 
		if(isset($array)){
			$this->tree=$array;
			//print_r($array);
			return $array;
		}
		return false; 
	}
	public function orderTree(){
		if(is_array($this->tree)) 
			ksort($this->tree);
		return $this->tree;
	}
	public function getTree(){
		if(is_array($this->tree)) 
			return $this->tree;
		return false;
	}
	public function setDateModified(){
		$dateModified = sitemapSource::_getDateModifiedSource();
		$i=0;
		$i = sprintf('%04s', $i);
		while($row = mysql_fetch_assoc($dateModified)){
			$i = sprintf('%04s', $i);
			$this->dateModifiedArray[ $i .' ' .$row['dateModified'] ]= $row['url'];
			$i++;
		}
		//print_r ($this->dateModifiedArray);
	}
	public function addDateModifiedToSource($urlString){
		$key = array_search($urlString, $this->dateModifiedArray); 
		$key = substr($key, 5);
		//echo "\n " . substr($key, 5) . " | $urlString \n ";
		if(!$key){
		  
		}else{
			unset($this->dateModifiedArray[$i]);
			return $key;
		}
		return false;
	}
}
?>
