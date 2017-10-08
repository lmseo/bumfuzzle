<?php
require_once('class.contactSource.php');
require_once('class.contactToHTML.php');
class contactPage extends page{
	private $opiatePageSource;
	private $randomRelatedTestimonial, $rightNavBarLinks, $additionalFilesinFolderLinks;
	
	public function __construct(){
		parent::__construct('opiates');
		$this->opiatePageSource = parent::getPageSource();
	}
	public function __destruct(){
	}
	public function printDateModified(){
		echo '<strong>Last Modified:</strong> ' . strip_tags(parent::getDateModified());
	}
	public function printDrugs($id, $class=''){
		$this->drugNames = opiateSource::_getDrugNames();
		if(!($this->drugNames && mysql_num_rows($this->drugNames))){
			return false ;
		}
		else{
			$newToHTML = new contactToHTML();
			$newToHTML->setTextFormList($this->drugNames, $id, $class);
			echo $newToHTML->getList()->getHTML();
			mysql_data_seek($this->drugNames, 0);
		}
		return true;
	}
}
?>