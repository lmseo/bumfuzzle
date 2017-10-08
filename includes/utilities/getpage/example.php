<?php 
require_once('class.getFiles.php');
$newPAgeCrawled = new getFiles();
$pageArray= $newPAgeCrawled->getUrlData('http://dailymed.nlm.nih.gov/dailymed/drugInfo.cfm?id=82203');
$newPAgeCrawled->printMyFileContents($pageArray);