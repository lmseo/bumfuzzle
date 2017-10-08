<?php
class UnicPost{
private $post=array(); 
private  $Empty=''; 

function __construct($p){ 
    $this->post=$p; 
    } 
public function CheckEmpty(){ 
    $i=0; 
    if($this->Empty != ''){ 
        $DivisionArray=explode(";", $this->Empty); 
        foreach($DivisionArray as $key){ 
        if(empty($_POST[$key])){ 
            $i++; 
            } 
        } 
        if($i>0){ 
            return false;     
            }else{ 
            return true; 
            } 
        }else{ 
        return true;     
        } 
    } 
public function DefineName(){ 
    foreach($this->post as $key=>$value){ 
        define($key, $value); 
        } 
    }
public function setEmpty($empty=''){
	$this->Empty =$empty;
}
}
?>