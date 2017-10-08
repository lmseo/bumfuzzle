<?php 

	$host= $_SERVER['DOCUMENT_ROOT'];
	require_once($host . "/includes/sitemap/2011/classes/class.sitemap.php");
	require_once($host . "/includes/sitemap/2011/classes/customFilter.php");
	
	$explorer = new sitemap();
 	$explorer->set_filter($filter);	
	$explorer->setSource(".", true);
	$explorer->printSitemapToXML($explorer->getSource());
?>