<?php
	ini_set('ignore_repeated_errors' , 1);
	ini_set('log_errors', 0);
	$_SESSION['pageReferer'] .= isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '' . "\n"; 
?>