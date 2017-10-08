<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<body>
<?php 
    
    include('class.smallGoogleTranslator.php'); 
	require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/drug-master-04-10-10/class.databaseConnection.php');
	$conn = databaseConnection::_getConnection();
    $query = "SELECT * FROM opiates WHERE url='/opiates/index.html'";
	$qryResults = mysql_query($query, $conn);
			if(! ($qryResults && mysql_num_rows($qryResults))) 
			{
				  $txtToTranslate = "Opiate abuse has become a national epidemic and threatens to continue taking lives and eroding society if something isn’t done. Some states are taking steps now to help stem the problem. The U.S. Department of Health and Human Services reports that mortality rates due to unintentional drug overdoses has reached historic levels, especially among those taking or abusing prescription painkillers. The Centers for Disease Control and Prevention shows a 160 percent increase in prescription painkiller-related deaths in the U.S. between 1999 and  .";
			}
			else{
				while ($row = mysql_fetch_assoc($qryResults)) 
				{
					  $txtToTranslate = strip_tags($row['content']);
				}
			}
    /* The Header Definition For HTML, To Be Used In <head> of the HTML Document */ 
    $utfCharSet = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'; 
     
    /* The Primary Text To Be Translated */ 
  
     
    $translateFromLanguage = 'English'; 
    $translateToLanguage   = 'German';     
     
    echo "<b>Original</b>: $txtToTranslate<br /><br />"; 
    echo "<i>Translated from $translateFromLanguage to $translateToLanguage:</i><br /><br />"; 
     
    $result = new SmallGoogleTranslator($txtToTranslate, $translateFromLanguage, $translateToLanguage); 
    if (!$result){ 
        echo "Translation failed."; 
    }else{ 
        echo "<b>Translation</b>: $result"; 
    } 
     
    echo "<br/><br/>"; 
     
    $translateFromLanguage = 'English'; 
    $translateToLanguage   = 'Spanish';     
     
    echo "<b>Original</b>: $txtToTranslate<br /><br />"; 
    echo "<i>Translated from $translateFromLanguage to $translateToLanguage:</i><br /><br />"; 
     
    $result = new SmallGoogleTranslator($txtToTranslate, $translateFromLanguage, $translateToLanguage); 
    if (!$result){ 
        echo "Translation failed."; 
    }else{ 
        echo "<b>Translation</b>: $result"; 
    } 
     
     
     
?>
</body>
</html>