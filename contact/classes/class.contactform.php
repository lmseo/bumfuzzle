<?php
require_once("class.fieldProccesing.php"); 
require_once("class.sendEmail.php");
require_once("class.emailToDB.php");
class contactForm{

	private $webPageReferer;
	private $thisPageReferer;
	private $Post;

	function __construct()
	{
		define('today', date("m-d-Y"));
		define('dateAdd', date("Y-m-d h:m:s"));
		
		$this->webPageReferer = $_SESSION['pageReferer'];
		$this->thisPageReferer = $_SERVER['HTTP_REFERER'];
		$this->Post=new UnicPost($_POST); 
		define('From', "From: \"" . ucwords($_POST['name']) .' ' . ucwords($_POST['lastName']) . "\" <" . $_POST['email'] . ">");
		$this->Post->setEmpty();
		if($this->Post->CheckEmpty()){ 
			$this->Post->DefineName();
			
			/*echo name1."<br>"; 
			echo lastName."<br>"; 
			echo email."<br>";*/
		}else{ 
			echo 'Please fill out the Email field';     
		} 
	}
	public function _setFormFields(){
		
	}
	public function _getFormFields(){		
	}
	public function sendEmailToAdmin($subject="Technical Info for Admin"){
		$mySendEmail = new sendEmail();
		$TxtBody2 = "-------------------------------------------"."\n\n";
		foreach ($_SERVER as $key => $value){
			$TxtBody2 .= $key . ': ' . $value."\n";
		}
		foreach ($_POST as $key => $value){
			$TxtBody2 .= $key . ': ' . $value."\n";
		}
		$TxtBody2 .= "Referer: " . "\n" . $this->webPageReferer . "\n" . $this->thisPageReferer."\n";
		$mySendEmail->sendEmail("luis@eopiates.com", $subject, $TxtBody2); 
	}
	public function sendEmailToSales(){ 
		$CustEmail = "luis@eopiates.com"; 
		$mySendEmail = new sendEmail(); 
		$mySendEmail->sendEmail($CustEmail, subject);
	}
	public function insertFieldsToDB(){
	}
	public function get_request_headers(&$text){
		foreach($_SERVER as $key => $value){
		  //$headers[str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))))] = $value;
		  if($key != 'REQUEST_TIME'){
			  $text .= str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower($key)))) . ' - ' . $value . "\n";
		  }else{
			$text .= str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower($key)))) . ' - ' . date(DATE_RFC822, $value) . "\n";
		  }      
		}
	}
	public function displayVisitorEntry(){
		if(defined('lastName') or defined('name')){
			echo '<p>Name:</p> <input disabled="disabled" type="text" value="'.name. ' '. lastName.'" />';
		}
		if(defined('email')){
			echo '<p>Email: </p><input disabled="disabled" type="text" value="'. email.'" />';
		}
		if(defined('phone1') && defined('phone2') && defined('phone3')){
			echo '<p>Phone Number:</p> <input disabled="disabled" type="text" value="('. phone1.') '.phone2.'-'.phone3.'" />';
		}	
		if(defined('drugs1')){
			echo '<p>Drug: </p><input disabled="disabled" type="text" value="'. drugs1.'" />';
		}
		if(defined('otherDrugs')){
			echo '<p>Other drugs: </p><input disabled="disabled" type="text" value="'. otherDrugs.'" />';
		}
		if(defined('message')&& message!=''){
			echo '<p>Message: </p><textarea disabled="disabled" type="text" rows="4" >'. message.'</textarea>';
		}
		if(defined('emailupdates') && emailupdates!=''){ 
			echo '<p>Newsletter and updates: </p><input disabled="disabled" type="text" value="'. emailupdates.'" />';   
		} 
	}
	public function sendEmailToVisitor(){
		$emailContent = 'eOpiates
		----------------------------------------------------------------------
		Dear Subscriber,'."\n\n";
		/*if(emailupdates=='Yes, you may send updates'){ 
			$emailContent.="
		
		Thank you for signing up for a eOpiates.com newsletter and updates.";
		}*/
		$emailContent .= '

		Thank you, we have received your email. 
		To ensure that you receive our emails, please add info@eopiates.com to your contact list. 
		If you do not see our first email response within a few hours, please check your Bulk, Junk or Spam email folder. 
		If you do not receive our response after 24 hours, please call us at 1-310-927-7155'."\n\n";
		
		
		$emailContent.= '
		MEMBER AGREEMENT
		Use of our site is governed by our Member Agreement. 
		Please read the Member Agreement.
		http://www.eopiates.com/legal/
		
		PRIVACY
		We will never share your e-mail address without your explicit permission. 
		Please read our Privacy Policy.
		http://www.eopiates.com/privacy/
		
		Sincerely,
		eOpiates.com';
		$mySendEmail = new sendEmail();
		$fromEmail ='From: Clarity <luis@eopiates.com>';
		$subjectEmail ="eOpiates.com: Confirming Your E-Mail Address"; 
		$mySendEmail->sendEmail(email, $subjectEmail,$emailContent, true, $fromEmail); 
	}
}
?>

