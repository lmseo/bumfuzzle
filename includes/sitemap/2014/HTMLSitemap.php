<?php 
	$host= $_SERVER['DOCUMENT_ROOT'];
	require_once($host . "/includes/sitemap/2014/classes/class.sitemap.php");
	require_once($host . "/includes/sitemap/2014/classes/customFilter.php");
	
	//require_once($host . '/includes/utilities/instant-search/2014/august/InstantSearchController.php');
	
	$explorer = new sitemap();
 	$explorer->set_filter($filter);	
	$explorer->setHTMLSource();
	$explorer->printSitemapToHTMLFromDB($explorer->getSource());
?>