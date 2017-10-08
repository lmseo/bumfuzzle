<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/Connections/class.databaseConnection.php');
class getFiles  {
	private $conn;
	private $fileContents;
	private $mainContent;
	private $pageType;
	private $h1;
	function __contruct()
	{
		$this->conn = databaseConnection::_getConnection();
	}
	function __destruct()
	{
		$this->conn = databaseConnection::_getConnection();
	}
	public function getUrlData($url=''){
		$result = false;
		//$contents = $this->getUrlContents($url);
		$contents = $contents = @file_get_contents($url);
		//print_r($contents.'<br/>');	
		if (isset($contents) && is_string($contents)){
			$title = null;
			$metaTags = null;			
			preg_match('/<title>([^>]*)<\/title>/si', $contents, $match );	
			if (isset($match) && is_array($match) && count($match) > 0){
				$title = strip_tags($match[1]);
			}
			preg_match_all('/<[\s]*meta[\s]*name="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $contents, $match);
			//print_r( $match);			
			if (isset($match) && is_array($match) && count($match) == 3){
				$originals = $match[0];
				$names = $match[1];
				$values = $match[2];
				
				if (count($originals) == count($names) && count($names) == 	count($values)){
					$metaTags = array();
					
					for ($i=0, $limiti=count($names); $i < $limiti; $i++){
						$metaTags[$names[$i]] = array (
							'metaTag' => htmlentities($originals[$i]),
							'name' => $names[$i],
							'content' => $values[$i]
						);
					}
				}
			}
			
			$result = array (
				'title' => $title,
				'metaTags' => $metaTags
			);
		}		
		return $result;
	}
	public function getUrlContents($url, $maximumRedirections = null, $currentRedirection = 0){
		$result = false;
		$this->fileContents = $contents = @file_get_contents($url);		
		// Check if we need to go somewhere else
		
		if (isset($contents) && is_string($contents)){
			preg_match('/<\s*head\s*>.*<\s*\/\s*head\s*>/si', $contents, $match);
			$header = implode(" ",$match);
			preg_match_all('/<\s*h1\s*[^>]*>.*?<\s*\/\s*h1\s*>/si', $contents, $match2);
			$contents  = preg_replace('/<\s*h1\s*[^>]*>.*?<\s*\/\s*h1\s*>/si', '', $contents);

			if($match2[0][0] == '<h1>Opiates</h1>' && count($match2, COUNT_RECURSIVE)>=3){
				$this->h1 = $match2[0][1];
				$this->h1 = strip_tags($this->h1);
			}else{
				$this->h1 = '';
			}
			//$this->h1 = strip_tags($this->h1);
			preg_match('/<!--\s*InstanceBeginEditable name="body"\s*-->.*?<!--\s*InstanceEndEditable\s*-->/si', $contents, $match);   //<!-- Ins2tanceBeginEditable name="body" -->
			$this->mainContent = implode(" ",$match);
			$this->mainContent = preg_replace('/<!--\s*InstanceBeginEditable name="body"\s*-->/si' , '' ,$this->mainContent);
			$this->mainContent = preg_replace('/<!--\s*InstanceEndEditable\s*-->/si' , '' ,$this->mainContent);
			$this->mainContent = trim($this->mainContent);
			//$this->mainContent = implode(" ", $this->mainContent);
			preg_match_all('/<[\s]*meta[\s]*http-equiv="?REFRESH"?' . '[\s]*content="?[0-9]*;[\s]*URL[\s]*=[\s]*([^>"]*)"?' . '[\s]*[\/]?[\s]*>/si', $header, $match);
			
			if (isset($match) && is_array($match) && count($match) == 2 && count($match[1]) == 1){
				if (!isset($maximumRedirections) || $currentRedirection < $maximumRedirections){
					return getUrlContents($match[1][0], $maximumRedirections, ++$currentRedirection);
				}
				
				$result = false;
			}
			else{
				$result = $header;
			}
			
		}
		
		return $header;
	}

	public function scan_files($path,$afiles) 
	{
		$cleaner = new Links();
		if(is_array($afiles)) 
		{
			foreach($afiles as $cur) 
			{
				//$this->setPageTypeByPath(str_replace('../../', "" , $path) , $cur);
				//$fsize = @filesize("$path/$cur")/1024;
				$upath = $this->encode_path($path);
				$tags = $this->getUrlData('http://' . $_SERVER['HTTP_HOST'] . str_replace('../..', "" , $path). $cur);
				echo 'http://' . $_SERVER['HTTP_HOST'] . str_replace('../..', "" , $path). $cur;
				//$pageHeader = get_headers('http://www.opiates.com' . str_replace('../..', "" , $path). "/$cur");
				echo "          <li><a href=\"".$upath.rawurlencode($cur)."\" class=\"file\" title=\"$cur " . gmdate("Y-m-d\TH:i:s+00:00", filemtime("$path/$cur"));
				//printf("[%.2f Kb]",$fsize);
				// $tags['author'];      
				// tags['keywords'];     
				// $tags['description'];  
				// $tags['geo_position'];
				echo"\">" . ucwords(str_replace( "html", "",$cleaner->clean_anchor($cur))) . "</a> "  . '<br /> ';
				/*print_r( 'H1: ' . $this->h1 . '<br />' ."\n");
				echo 'Folder: ' . str_replace('../../', "" , $path) . '<br />' ."\n" ;
				echo 'Type: ' . $this->pageType . '<br />' ."\n" ;;
				echo 'URL: ' . 'http://www.opiates.com' . str_replace('../..', "" , $path). "/" . rawurlencode($cur)  . '<br />' ."\n" ;
				echo 'URI: ' . rawurlencode($cur) . '<br />' ."\n" ;
				echo 'Last modified: ' . gmdate("Y-m-d\TH:i:s+08:00", filemtime("$path/$cur"));  echo '<br />' . "\n";
				echo 'Page Title: ' . $tags['title']; echo '<br />' . "\n";
				echo 'Page Keywords: ' . $tags['metaTags']['keywords']['value']; echo '<br />' . "\n";
				echo 'Page Description: ' . $tags['metaTags']['description']['value']; echo '<br />' . "\n";
					echo 'Page Content: ' . $this->mainContent; echo '<br />' . "\n";*/
				echo "</li>\n" .'<br />';
				/*if($this->h1 == 'Opiates' || !isset($this->h1))
				{
					if(!empty($tags['title']) or isset($tags['title']) or $tags['title']!='')
					{
						$this->h1 = $tags['title'];
					}
					else
					{
						$this->h1 =ucwords(str_replace( "html", "",$cleaner->clean_anchor($cur)));
					}
				}*/
				$this->h1=str_replace('Detox','Detoxification', $tags['title']);
				$tags['title'] = isset($tags['title'])?$tags['title']:' ';
				$tags['title'] = str_replace('Detoxification','Detox', $tags['title']);
				$tags['title'] = str_replace(' Information','', $tags['title']);
				$this->mainContent = isset($this->mainContent)?$this->mainContent:' ';
				$this->pageType = isset($this->pageType)?$this->pageType : ' ' ;
				$cur = isset($cur)? $cur : ' ' ; 
				$tags['metaTags']['description']['value'] = isset($tags['metaTags']['description']['value']) ? $tags['metaTags']['description']['value']: ' ';
				$tags['metaTags']['keywords']['value'] = isset($tags['metaTags']['keywords']['value'])? $tags['metaTags']['keywords']['value'] : ' ';
				
				/*$qryInsert = sprintf("INSERT INTO opiates (h1) VALUES( '%s')",
				mysql_real_escape_string($this->h1));*/
				echo '<h1>' .$this->h1 . '</h1>';
				
				/*
				echo '<h1>7-</h1>' .$tags['metaTags']['description']['value'] . '<br />';
				echo '<h1>2-</h1>' .$tags['title'] . '<br />';
				echo '<h1>3-</h1>' .$this->mainContent . '<br />';
				echo '<h1>4-</h1>' .$cur . '<br />';
				echo '<h1>5-</h1>' .gmdate("Y-m-d\TH:i:s+08:00", filemtime("$path/$cur")) . '<br />';
				echo '<h1>6-</h1>' .$tags['metaTags']['keywords']['value'] . '<br />';
				
				echo '<h1>8-</h1>' .str_replace('../..', "" , $path) .$cur . '<br />';*/
				
				
				$qryInsert = sprintf("INSERT INTO nih ( h1, title, anchor, content, description, keywords, dateCreated, dateModified, url, uri) VALUES ('%s', '%s','%s', '%s', '%s', '%s', '%s', '%s','%s','%s')",
				mysql_real_escape_string('states'),
				mysql_real_escape_string($this->h1),
				mysql_real_escape_string($tags['title']),
				mysql_real_escape_string($tags['title']),
				mysql_real_escape_string($this->mainContent),
				mysql_real_escape_string($tags['metaTags']['Description']['value']),
				mysql_real_escape_string($tags['metaTags']['Keywords']['value']),
				mysql_real_escape_string(date("Y-m-j H:i:s")),
				mysql_real_escape_string(date("Y-m-j H:i:s", filemtime("$path/$cur"))),
				mysql_real_escape_string(str_replace('../..', "" , $path) .$cur),
				mysql_real_escape_string($cur));
				
				/*$qryInsert = sprintf("UPDATE media SET h1, title, content, pageURI, description, keywords, dateCreated, url SET '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'",
				mysql_real_escape_string($this->h1),
				mysql_real_escape_string($tags['title']),
				mysql_real_escape_string($this->mainContent),
				mysql_real_escape_string($cur),
				mysql_real_escape_string($tags['metaTags']['description']['value']),
				mysql_real_escape_string($tags['metaTags']['keywords']['value']),
				mysql_real_escape_string(gmdate("Y-m-d\TH:i:s+08:00", filemtime("$path/$cur"))),
				mysql_real_escape_string(str_replace('../..', "" , $path) .$cur));*/
				//echo '<h1>9-</h1>' . $qryInsert;

				/*$qryInsert = sprintf("UPDATE opiates SET h1, title, content, type, folder, uri, description, keywords, dateModified, url SET '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s'",
				mysql_real_escape_string($this->h1),
				mysql_real_escape_string($tags['title']),
				mysql_real_escape_string($this->mainContent),
				mysql_real_escape_string($this->pageType),
				mysql_real_escape_string(str_replace('../../', "" , $path)),
				mysql_real_escape_string($cur),
				mysql_real_escape_string($tags['metaTags']['description']['value']),
				mysql_real_escape_string($tags['metaTags']['keywords']['value']),
				mysql_real_escape_string(gmdate("Y-m-d\TH:i:s+08:00", filemtime("$path/$cur"))),
				mysql_real_escape_string(str_replace('../..', "" , $path). "/" . rawurlencode($cur)));*/
		
			// Perform Query
				//getFiles::setStaticDatabaseConnection();
				$result = mysql_query($qryInsert);
			
			// Check result
			// This shows the actual query sent to MySQL, and the error. Useful for debugging.
				if (!$result){
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					//$message .= 'Whole query: ' . $qryInsert. "\n";
					echo $message . '<br />';
					//die($message);
				}else{
					echo 'success' . '<br />';
				}
			}
		}
		
	}
/*function scan($dir=".",$path=".") {
		$directory = new Dir($path,$this->filter);
		if(!$directory) return false;
		
		$adirs = $directory->get_dirs();
		$afiles = $directory->get_files();

		$this->scan_dirs($path,$adirs);
	 	$this->scan_files($path,$afiles);
	}
*/
	public function setSelect(){
		$pageURL = 'http://' .$_SERVER['HTTP_HOST']. $_SERVER['PHP_SELF'];
		$qryContact = "SELECT *  FROM Testimonials  WHERE url='" . $pageURL . "' ORDER BY yearVisit DESC, monthVisit DESC "	;
		
		$this->qryResults = mysql_query($qryContact);
	}
	public function setInsert(){	
		$qryInsert = "INSERT INTO opiates ( title, content, type, drug, uri, url, description, keywords) VALUES ('" . $this->mainPageTitle."', " . ")";
		$this->qryResults = mysql_query($qryInsert);
	}
	public function printFileContents(){
		echo $this->fileContents;
	}
	public function printMyFileContents($pageArray){
		foreach($pageArray as $key=>$value){
			//print_r("$key: $value, ".is_array($value)." <br />\n");
			if(is_array($value)){
				$this->printMyFileContents($value);
				//print_r("$key: $value, ".is_array($value)." <br />\n");
			}else{
				print_r("$key: $value<br />\n");
			}
		}
	}
}
?>

