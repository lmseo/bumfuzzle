<?php
session_start();
$include_root = $_SERVER['DOCUMENT_ROOT'];
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/drug-master/drug-master-7-18-2014/class.source.php');
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/drug-master/drug-master-7-18-2014/class.toHTML.php');
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/drug-master/drug-master-7-18-2014/class.page.php');
$newPage = new page('opiates');
$newPageTemplate = $newPage->getPageTemplate();
if(isset($newPageTemplate)){
	require_once($include_root . $newPage->getPageTemplateURL() );
}else{
	require_once($include_root . $newPage->getPageTemplateURL() );
}
?>