<?php
require 'simple_crawler.classes.php';

$reader = new HtmlReader();

$page = 'http://eopiates.com';
//$page = 'http://www.phpclasses.org';

//read  content from url
$html = $reader->getPageContent($page);

?>