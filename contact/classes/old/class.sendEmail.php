<?php
class sendEmail{
	private $txtBody;

	function __construct(){
		$this->txtBody = '';
		$this->setPredifinedEmailBody();
	}
	public function setPredifinedEmailBody(){
		$remoteIP = $_SERVER['REMOTE_ADDR'];
		$this->txtBody = "IP: {$remoteIP} - for fighting spam \n";
		$this->txtBody .="Form submitted from " . sitename . " on " . today . "\n";
		$this->txtBody .="Name: " . name ." " . lastName . "\n";
		$this->txtBody .="Phone: " . phone1. '-'.phone2.'-'.phone3 . "\n";
		$this->txtBody .="Can leave a message: " . leavemessage. "\n";
		$this->txtBody .="Email Address: " . email . "\n";
		$this->txtBody .="Age of Person: " . ageWho . "\n";
		$this->txtBody .="Drugs and Daily Amount Taken:" . drugs1. ' '.drugAmount1. ' times per day '. drugNumber1 . ". ".otherDrugs."\n";
		$this->txtBody .="Message: " . message . "\n";
		$this->txtBody .="Location: " . city . ', '. region . "\n\n";
	}
	public function sendEmail($email='', $subject='', $addContent='', $flag=false){
		if(!empty($email) && !empty($subject)){
			if(!empty($addContent)){
				if(!$flag){
					$content = $this->txtBody . "\n" .  $addContent;
				}elseif($flag){
					$content = $addContent;
				}
			}
			else{
				$content = $this->txtBody;
			}
			mail($email, $subject, $content, From);
			return true;
		}else{
			return false;
		}
	}
}
?>