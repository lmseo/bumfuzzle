<?php
class Links
{
	var $uRL;
	var $directory ;
	var $anchorText;
	function clean_url($text) 
	{ 
		$text = strtolower($text); 
		$code_entities_match = array(' ', '-', '--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','.','/','*','+','~','`','='); 
		//$code_entities_replace = array('-','-','','','','','','','','','','','','','','','','','','','','','','','',''); 
		$text = str_replace($code_entities_match, "-", $text); 
		return $text; 
	} 
	
	function clean_anchor($anchor) 
	{ 
		$anchor = strtolower($anchor); 
		$code_entities_match = array('', '-', '--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','.','/','*','+','~','`','='); 
		//$code_entities_replace = array('-','-','','','','','','','','','','','','','','','','','','','','','','','',''); 
		$anchor = str_replace($code_entities_match, " ", $anchor); 
		return $anchor; 
	} 
	function clean_dir($text) 
	{ 
		$text = strtolower($text); 
		$code_entities_match = array(' ', '-', '--','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','.','/','*','+','~','`','='); 
		//$code_entities_replace = array('-','-','','','','','','','','','','','','','','','','','','','','','','','',''); 
		$text = str_replace($code_entities_match, " ", $text); 
		return $text; 
	} 
	
}

?>
