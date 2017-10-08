<?php
$include_root = $_SERVER['DOCUMENT_ROOT']."/";
require_once( $include_root . 'includes/sitemap/maphp.php');

class getFiles extends maphp  {
	var $dbhost;
	var $dbname;
	var $dbuser;
	var $dbpass;
	var $fileContents;
	var $mainContent;
	var $pageType;
	var $h1;
	var $pageTypeArray = array('abuse', 'addiction','detox', 'overdose', 'rehab', 'side-effects', 'treatment', 'withdrawals','warnings','get-off', 'index');
	var $opiateSubSectionArray  = array('actiq' , 'buprenorphine' , 'codeine' , 'darvocet' , 'demerol' , 'dilaudid' , 'duragesic' , 'fentanyl' , 'fentora' , 'heroin' , 'hydrocodone' , 'kadian', 'laam' , 'lorcet' , 'lortab' , 'methadone' , 'morphine' , 'ms contin' , 'norco' , 'opana' , 'opiates', 'opioids', 'oxycodone' , 'oxycontin' , 'oxymorphone', 'percocet' , 'percodan' , 'roxycodone', 'roxycontin', 'stadol' , 'suboxone' , 'subutex' , 'tramadol' , 'tussionex' , 'ultram' , 'vicodin' , 'vicoprofen' , 'xodol' , 'zydone');
	function getFiles()
	{
		$this->dbhost = "localhost";
		$this->dbname = "testimonials";
		$this->dbuser = "luis1420";
		$this->dbpass = "m74337433";
		$this->pageType = '';
		getFiles::setDatabaseConnection();
	}
	function setDatabaseConnection()
	{
		
		$conn = mysql_connect($this->dbhost,$this->dbuser,$this->dbpass);
		
		if (!$conn) die ("Could not connect MySQL");
			$mysql_select_db = mysql_select_db($this->dbname,$conn) or die ("Could not open database");
			//print($mysql_select_db);
	}
	static function setStaticDatabaseConnection()
	{
		$dbhost = "localhost";
		$dbname = "testimonials";
		$dbuser = "luis1420";
		$dbpass = "m74337433";
		$conn = mysql_connect($dbhost,$dbuser,$dbpass);
		
		if (!$conn) die ("Could not connect MySQL");
			$mysql_select_db = mysql_select_db($dbname,$conn) or die ("Could not open database");
			//print($mysql_select_db);
	}
	function setPageTypeByPath($folder, $uri)
	{
		foreach($this->opiateSubSectionArray as $value1)
		{
			if ($value1 == $folder)
			{
				
				foreach($this->pageTypeArray as $value2)
				{
					
					$pos = strpos(  $uri, $value2);
					//echo  "ok3";
					if($pos !== false)
					{
						$this->pageType = $value2;
						return true;
					}
				}
			}
		}
		return false;
	}
	function getUrlData($url='')
	{
		$result = false;
		
		$contents = $this->getUrlContents($url);
		if (isset($contents) && is_string($contents))
		{
			$title = null;
			$metaTags = null;
			
			preg_match('/<title>([^>]*)<\/title>/si', $contents, $match );
	
			if (isset($match) && is_array($match) && count($match) > 0)
			{
				$title = strip_tags($match[1]);
			}
			
			preg_match_all('/<[\s]*meta[\s]*name="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $contents, $match);
			//print_r( $match);
			
			if (isset($match) && is_array($match) && count($match) == 3)
			{
				$originals = $match[0];
				$names = $match[1];
				$values = $match[2];
				
				if (count($originals) == count($names) && count($names) == 	count($values))
				{
					$metaTags = array();
					
					for ($i=0, $limiti=count($names); $i < $limiti; $i++)
					{
						$metaTags[$names[$i]] = array (
							'html' => htmlentities($originals[$i]),
							'value' => $values[$i]
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
	
	function getUrlContents($url, $maximumRedirections = null, $currentRedirection = 0)
	{
		$result = false;
		
		$this->fileContents = $contents = @file_get_contents($url);		
		// Check if we need to go somewhere else
		
		if (isset($contents) && is_string($contents))
		{
			preg_match('/<\s*head\s*>.*<\s*\/\s*head\s*>/si', $contents, $match);
			$header = implode(" ",$match);
			preg_match_all('/<\s*h1\s*[^>]*>.*?<\s*\/\s*h1\s*>/si', $contents, $match2);
			$contents  = preg_replace('/<\s*h1\s*[^>]*>.*?<\s*\/\s*h1\s*>/si', '', $contents);

			if($match2[0][0] == '<h1>Opiates</h1>' && count($match2, COUNT_RECURSIVE)>=3)
			{
				$this->h1 = $match2[0][1];
				$this->h1 = strip_tags($this->h1);
			}
			else
			{
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
			
			if (isset($match) && is_array($match) && count($match) == 2 && count($match[1]) == 1)
			{
				if (!isset($maximumRedirections) || $currentRedirection < $maximumRedirections)
				{
					return getUrlContents($match[1][0], $maximumRedirections, ++$currentRedirection);
				}
				
				$result = false;
			}
			else
			{
				$result = $header;
			}
			
		}
		
		return $header;
	}

	function scan_files($path,$afiles) 
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
				
				
				$qryInsert = sprintf("INSERT INTO opiates (folder, h1, title, anchor, content, description, keywords, dateCreated, dateModified, url, uri) VALUES ( '%s','%s', '%s','%s', '%s', '%s', '%s', '%s', '%s','%s','%s')",
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
				if (!$result)
				{
					$message  = 'Invalid query: ' . mysql_error() . "\n";
					//$message .= 'Whole query: ' . $qryInsert. "\n";
					echo $message . '<br />';
					//die($message);
				}
				else
				{
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
	function setSelect()
	{
		$pageURL = 'http://' .$_SERVER['HTTP_HOST']. $_SERVER['PHP_SELF'];
		$qryContact = "SELECT *  FROM Testimonials  WHERE url='" . $pageURL . "' ORDER BY yearVisit DESC, monthVisit DESC "	;
		
		$this->qryResults = mysql_query($qryContact);
	}
	function setInsert()
	{	
		$qryInsert = "INSERT INTO opiates ( title, content, type, drug, uri, url, description, keywords) VALUES ('" . $this->mainPageTitle."', " . ")";
		$this->qryResults = mysql_query($qryInsert);
	}
	function printFileContents()
	{
		echo $this->fileContents;
	}
}
	$explorer = new getFiles();
	$cwd = basename(getcwd());
	$filter=new filter();
	//$filter->add_dir_reg("/^\..*$/");
	$filter->add_extension("inc");
	$filter->add_extension("ram");
	$filter->add_extension("LCK");
	$filter->add_extension("txt");
	$filter->add_extension("xml");
	$filter->add_extension("js");
	$filter->add_extension("css");
	$filter->add_extension("jpg");
	$filter->add_extension("png");
	$filter->add_extension("php");
	$filter->add_extension("swf");
	$filter->add_extension("db");
	$filter->add_extension("gif");
	$filter->add_extension("ico");
	$filter->add_file("test.html");
	$filter->add_file_reg("/^\..*$/");
	$filter->add_file_reg("/^.*~$/");
	$filter->add_dir_reg("/pdf/");	
	$filter->add_dir("_mmServerScripts");
	$filter->add_dir("_notes");
	$filter->add_extension("pdf");
	/*

	//$filter->add_dir("private");
	
	$filter->add_dir("adserver");
	$filter->add_dir("contact");
	$filter->add_dir("California");
	$filter->add_dir("NewsAbstractsTextFiles");
	$filter->add_dir("ShockwaveLogos");
	$filter->add_dir("Templates");
	$filter->add_dir("classes");
	$filter->add_dir("cms");
	$filter->add_dir("css");
	$filter->add_dir("files");
	$filter->add_dir("flash");
	$filter->add_dir("functions");
	$filter->add_dir("images");
	$filter->add_dir("img");
	$filter->add_dir("includes");
	$filter->add_dir("monthly-reports");
	$filter->add_dir("picture_library");
	$filter->add_dir("plesk-stat");
	$filter->add_dir("search");
	$filter->add_dir("sendpage");
	$filter->add_dir("styles");
	$filter->add_dir("swap");
	$filter->add_dir("test");
	$filter->add_dir("testimonials");
	$filter->add_dir("blog");
	$filter->add_dir("captcha");
	//$filter->add_dir("errordocuments");
	$filter->add_dir("java");
	$filter->add_dir("test");
	$filter->add_dir("ajax");
	$filter->add_dir("about");
	$filter->add_dir("abuse");
	$filter->add_dir("addiction");
	$filter->add_dir("alprazolam");
	$filter->add_dir("ambien");
	$filter->add_dir("ativan");
	$filter->add_dir("benzodiazepine");
	$filter->add_dir("drug-addiction");
	$filter->add_dir("drug-detox");
	$filter->add_dir("drug-rehab");
	$filter->add_dir("drugs");
	$filter->add_dir("glossary");
	$filter->add_dir("klonopin");
	$filter->add_dir("legal");
	$filter->add_dir("media");
	//$filter->add_dir("opiates");
		$filter->add_dir("opioids");
	$filter->add_dir("prescription-painkillers");
	$filter->add_dir("rapid-detox");
	$filter->add_dir("reference");
	$filter->add_dir("rehab");
	$filter->add_dir("reports");
	$filter->add_dir("side-effects");
	$filter->add_dir("sitemap");
	$filter->add_dir("stadol-addiction");
	$filter->add_dir("success");
	$filter->add_dir("treatment");	
	$filter->add_dir("ultram-addiction");
	$filter->add_dir("valium");
	$filter->add_dir("withdrawal");
	$filter->add_dir("xanax");
	$filter->add_dir("zydone-addiction");
	$filter->add_dir("Connections");
	$filter->add_dir("index");
	$filter->add_dir("newsletters");
	

	$filter->add_dir('actiq');
	$filter->add_dir('buprenorphine');
	$filter->add_dir('codeine');
	$filter->add_dir('darvocet');
	$filter->add_dir('demerol');
	$filter->add_dir('dilaudid');
	$filter->add_dir('duragesic');
	$filter->add_dir('fentanyl');
	$filter->add_dir('fentora');
	$filter->add_dir('heroin');
	$filter->add_dir('hydrocodone');
	$filter->add_dir('kadian');
	$filter->add_dir('laam');
	$filter->add_dir('lorcet');
	$filter->add_dir('lortab');
	$filter->add_dir('methadone');
	$filter->add_dir('morphine');
	$filter->add_dir('mscontin');
	$filter->add_dir('norco');
	$filter->add_dir('opana');
	$filter->add_dir('oxycodone');
	$filter->add_dir('oxycontin');
	$filter->add_dir('oxymorphone');
	$filter->add_dir('percocet');
	$filter->add_dir('percodan');
	$filter->add_dir('roxycodone');
	$filter->add_dir('roxycontin');
	$filter->add_dir('stadol');
	$filter->add_dir('suboxone');
	$filter->add_dir('subutex');
	$filter->add_dir('tramadol');
	$filter->add_dir('tussionex');
	$filter->add_dir('ultram');
	$filter->add_dir('vicodin');
	$filter->add_dir('vicoprofen');
	$filter->add_dir('xodol');
	$filter->add_dir('zydone');
	$filter->add_dir('campaigns');
	$filter->add_dir('errordocuments');
	$filter->add_dir('homepage-backup');	
	

	
	$filter->add_file("favicon.ico");
	$filter->add_file("prescription-painkiller-addiction.html");
	$filter->add_file("resources.html");
	$filter->add_file("opiate-addiction.html");
	$filter->add_file("opiate-withdrawal.html");
	$filter->add_file("opiate-detox-comparisons.html");
	$filter->add_file("opiate-antagonist.html");
	$filter->add_file("opiate-agonist.html");
	$filter->add_file("waisman-institute.html");
	$filter->add_file("waissmann-institute.html");
	$filter->add_file("weisman-institute.html");
	$filter->add_file("suboxonesurvey.html");
	$filter->add_file("luis");
	$filter->add_file("luis-map-2.html");
	$filter->add_file("contact.html");

	$filter->add_file("contactform.php");
	$filter->add_file("email.html");
	$filter->add_file("media-sending.html");
	$filter->add_file("media.html");
	$filter->add_file("phone.html");
	$filter->add_file("postal.html");
	$filter->add_file("sending.html");
	$filter->add_file("sent.html");
	$filter->add_file("support.html");
	$filter->add_file("tech-sending.html");
	$filter->add_file("robots.txt");
	$filter->add_file("Brochure 03.pdf");
	$filter->add_file("Intake_Form.doc");
	$filter->add_file("_vti_inf.html");
	$filter->add_file("at_domains_index.html");
	$filter->add_file("beta.htm");
	$filter->add_file("bup_survey.gif");
	$filter->add_file("clifford-bernstein-old.html");
	$filter->add_file("inc.config.php");
	$filter->add_file("nolongerworkingthere_david-crausman.html");
	$filter->add_file("orig_index.html");
	$filter->add_file("phprint.php");
	$filter->add_file("search-test.php");
	$filter->add_file("sitemap.xml");
	$filter->add_file("smbmeta.xml");
	$filter->add_file("staff-old.html");
	$filter->add_file("survey-popup.html");
	$filter->add_file("tracking.js");
	$filter->add_file("yahoo_authkey_8949f37bead68d83.txt");*/

 	$explorer->set_filter($filter);	
	$explorer->run("../../states/");
?>

