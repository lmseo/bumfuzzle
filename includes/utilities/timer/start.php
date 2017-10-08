<?php 

//start the time @ your login page 
    session_start(); 
    $start=time(); 
    $_SESSION['time_start']=$start; 
    /*get the login info & set to session */ 
?>