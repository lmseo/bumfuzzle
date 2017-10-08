<?php

function breadCrumb($PATH_INFO="" , $title="", $lPageType="") {
	error_reporting(0);
	ini_set('log_errors', 0);
	global $page_title, $root_url;

	// Remove these comments if you like, but only distribute 
	// commented versions.
	
	// Replace all instances of _ with a space
	$PATH_INFO = str_replace("_", " ", $PATH_INFO);
	// split up the path at each slash
	$pathArray = explode("/",$PATH_INFO);
	
	// Initialize variable and add link to home page
	if(!isset($root_url)) { $root_url=""; }
	$breadCrumbHTML = '<a href="'.$root_url.'/" title="Opiates Home">Home</a> &gt; ';
	
	// initialize newTrail
	$newTrail = $root_url."/";
	
	// starting for loop at 1 to remove root
	for($a=1;$a<count($pathArray)-1;$a++) {
		// capitalize the first letter of each word in the section name
		$crumbDisplayName = ucwords($pathArray[$a]);
		// rebuild the navigation path
		$newTrail .= $pathArray[$a].'/';
		// build the HTML for the breadcrumb trail
		$breadCrumbHTML .= '<a href="'.$newTrail.'">'.$crumbDisplayName.'</a> &gt; ';
	}
	// Add the current page
	if(!isset($page_title) && $lPageType != "drug") 
	{ 	
		
		$page_title = $title; 
		$breadCrumbHTML .= '<strong>'.$page_title.'</strong>';
	}
	
	
	// print the generated HTML
	print($breadCrumbHTML);
	
	// return success (not necessary, but maybe the 
	// user wants to test its success?
	return true;
}

?>