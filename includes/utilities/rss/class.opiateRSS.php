<?php
$include_root = $_SERVER['DOCUMENT_ROOT']."/";
require_once( $include_root . 'includes/rss/class.rss.php');

	class OpiateRSS extends RSS
	{
			public function GetFeed()
			{ 
				return $this->getDetails("rss_channels", 'rss_items', 'opiates'); 
			}
	}
?>