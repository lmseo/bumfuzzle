<?php
session_start();
require_once("classes/class.contactform.php"); 
 $newForm = new contactForm();
 $newForm->sendEmailToAdmin();
 $newForm->displayVisitorEntry();
?>