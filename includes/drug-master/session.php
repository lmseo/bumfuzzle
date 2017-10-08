<?php
	if(!isset($_SESSION['pageReferer']))
		$_SESSION['pageReferer'] = '';
	if(isset($_SERVER['HTTP_REFERER']))
		$_SESSION['pageReferer'] .= $_SERVER['HTTP_REFERER'] . "\n";
?>