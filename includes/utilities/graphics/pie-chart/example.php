<?php 
include('class.pie.php'); 
$dataArr = array(2001=>10, 2002=>30, 2003=>50, 2004=>10); 
$width=600; 
$height=480; 
$pie = new simplepie($width, $height, $dataArr); 
$pie->render(); 
?>