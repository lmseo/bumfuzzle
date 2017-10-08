<?php
require_once("filter.php");
require_once("dir.php");
include("links.php");

class maphp {
	var $empty_dirs;		// display empty dirs?
 	var $filter;
	var $strReplace;
	
	function maphp($filter=null) {
		$this->strReplace = array('.','..');
		$this->show_empty_dirs(true);
		if(null==$filter) $this->set_filter(new filter());
	}

	/**
	 * if set to true maphp will display empty directories.
	 * if we set it to false empty directories will not be
	 * displayed on the list.
	 */

	function show_empty_dirs($bool) {
		$this->empty_dirs=$bool;
	}

	/**
	 * set a filter for the current list
	 */

	function set_filter($filter) {
		$this->filter=$filter;
	}

	/**
	 * Returns the path string in which non-alphanumeric characters except -_. 
	 * have been replaced with a percent (%) sign followed by two hex digits.
	 */
	 
	function encode_path($path) {
		$tmp = explode("/",$path);
		for($i=0;$i<count($tmp);$i++) {
			$tmp[$i]=rawurlencode($tmp[$i]);
		}
		return implode("/",$tmp);
	}

	///////////////////////////////////////
	// 		HTML output functions		//
	//////////////////////////////////////

	/**
	 * html output for file names. we link the name to the full 
	 * file path so we can browse to it.
	 */

	function scan_files($path,$afiles) 
	{
		$cleaner = new Links();
		if(is_array($afiles)) {
			foreach($afiles as $cur) {
				//$fsize = @filesize("$path/$cur")/1024;
				$upath = $this->encode_path($path);
				echo "	<url>
            <loc>http://" . $_SERVER['HTTP_HOST'] .  str_replace($this->strReplace,"",$upath) . "/".rawurlencode($cur). "</loc>
            <priority>0.6</priority>
            <lastmod>".gmdate("Y-m-d\TH:i:s+00:00", filemtime("$path/$cur")) . "</lastmod>
            <changefreq>daily</changefreq>
	</url>" . "\n";
				//echo "          <li><a href=\"".$upath."/".rawurlencode($cur)."\" class=\"file\" title=\"$cur " . date ("F d Y H:i:s.", filemtime("$path/$cur"));
				//printf("[%.2f Kb]",$fsize);
				//echo"\">" . ucwords(str_replace( "html", "",$cleaner->clean_anchor($cur))) . "</a></li>\n";
			}
		}
	}

	/**
	 * scan all directories on current path and
	 * output html code.
	 */

	function scan_dirs($path,$adirs) 
	{
		$cleaner = new Links();
		if(is_array($adirs)) 
		{
			foreach($adirs as $cur) 
			{
				
				/*
				 * display empty directories only if
				 * $this->empty_dirs is true.
				 */ 
				
				$d = new Dir("$path/$cur",$this->filter);
				
				if($d->is_empty() && !$this->empty_dirs) continue;
				$items = count($d->get_dirs()) + count($d->get_files());
				$upath = $this->encode_path($path);
				
				echo "   <url>
      <loc>http://" . $_SERVER['HTTP_HOST'] .  str_replace($this->strReplace,"",$upath) . "/".rawurlencode($cur). "/</loc>
      <priority>0.9</priority>
      <lastmod>".gmdate("Y-m-d\TH:i:s+00:00", filemtime("$path/$cur")) . "</lastmod>
      <changefreq>daily</changefreq>
   </url>" . "\n";
				//echo "      <li>". "\n";
				//echo "		  <a href=\"".$upath."/".rawurlencode($cur)."/\" class=\"folder\" title=\"$items items - " . date ("F d Y H:i:s.", filemtime("$path/$cur")) . "\">" . ucwords ($cleaner->clean_dir($cur)) . "</a>". "\n";
				//echo "        <ul class=\"submenu\">" . "\n";

				$this->scan("$cur","$path/$cur");

				//echo "        </ul>" . "\n";
				//echo "      </li>" ."\n";				
			}
		}
	}
	/**
	 * scan the files and directories in the current path.
	 * it calls the scan_dirs and scan_files functions.
	 */
	function scan($dir=".",$path=".") {
		$directory = new Dir($path,$this->filter);
		if(!$directory) return false;
		
		$adirs = $directory->get_dirs();
		$afiles = $directory->get_files();

		$this->scan_dirs($path,$adirs);
	 	$this->scan_files($path,$afiles);
	}

	/**
	 * setup the html list and start scan.
	 */
	
	function run($path=".") {
		//echo "  <div id=\"mainMenu\">" . "\n";
		//echo "    <ul id=\"menuList\">" . "\n";
		//echo "<li class=\"menu\">";
		
		/** 
		 *	output server name
		 *	echo "<a href=\"#\" class=\"name\">";
		 *	echo $_SERVER['SERVER_NAME']; 
		 *	echo "	</a>";
		*/

		//echo "      <ul class=\"menu\">" . "\n";
	
		if (is_dir($path)) {
			$d = new Dir($path,$this->filter);
			if($d && !$d->is_empty()) 
				$this->scan($path,$path);
			else
				echo "This directory is empty!";
		}
		else {
			echo "<b class=\"error\">Path does not exist!</b>";
		}
		
		//echo "  </div>" . "\n";
	}
}
?>
