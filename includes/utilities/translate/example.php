<?php 
     
    include('class.smallGoogleTranslator.php'); 
     
     
    /* The Header Definition For HTML, To Be Used In <head> of the HTML Document */ 
    $utfCharSet = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'; 
     
    /* The Primary Text To Be Translated */ 
    $txtToTranslate = "Opiate abuse has become a national epidemic and threatens to continue taking lives and eroding society if something isn’t done. Some states are taking steps now to help stem the problem. The U.S. Department of Health and Human Services reports that mortality rates due to unintentional drug overdoses has reached historic levels, especially among those taking or abusing prescription painkillers. The Centers for Disease Control and Prevention shows a 160 percent increase in prescription painkiller-related deaths in the U.S. between 1999 and 2004.";
     
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