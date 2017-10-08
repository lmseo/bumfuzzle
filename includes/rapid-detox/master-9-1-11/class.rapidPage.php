<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/drug-master-9-1-11/class.page.php');
require_once('class.rapidSource.php');
require_once('class.rapidToHTML.php');
class opiatePage extends page{
	private $opiatePageSource;
	private $randomRelatedTestimonial, $rightNavBarLinks, $additionalFilesinFolderLinks;
	
	public function __construct($table){
		parent::__construct($table);
		$this->opiatePageSource = parent::getPageSource();
	}
	public function __destruct(){
	}
	public function printRandomRelatedTestimonial(){
		$this->randomRelatedTestimonial = rapidSource::_getRandomRelatedTestimonialFomDB();
		if(!($this->randomRelatedTestimonial && mysql_num_rows($this->randomRelatedTestimonial))){
			return false ;
		}
		else{
			$listHTML = new html('ul');
			while ($row = mysql_fetch_assoc($this->randomRelatedTestimonial)){
				if(!($row && count($row))){
				}
				else{
					$recentLinkHTML = new html('a');
					$recentLinkHTML->set('href',$row['url']);
					$recentLinkHTML->set('title',$row['title']);
					$recentLinkHTML->set('text', ucwords($row['anchor']));
					$contentHTML = new html('div');
					$contentHTML->set('class','little-testimonial-body');
					$contentHTML->set('text', substr(strip_tags($row['content']), 0, 400).'...');
					$yearHTML = new html('strong');
					$yearHTML->set('class','little-testimonial-footer');
					$yearHTML->set('text', $row['yearVisit'].' '.$row['drug_1']. ' Patient');
					$recentHTML = new html('li');
					$listHTML->set('class','menu');
					$recentHTML->inject($recentLinkHTML);
					$recentHTML->inject($contentHTML);
					$recentHTML->inject($yearHTML);
					$listHTML->inject($recentHTML);
				}
			}
			$newToHTML = new toHTML();
			echo $newToHTML->getAdditionalBox($listHTML->getHTML(), 'Success Stories');
			mysql_data_seek($this->randomRelatedTestimonial, 0);
		}
		return true;
	}
	public function printRightNavBarLinks(){
		$this->rightNavBarLinks = rapidSource::_getRightNavBarLinks();
		if(!($this->rightNavBarLinks && mysql_num_rows($this->rightNavBarLinks))){
			$this->rightNavBarLinks = rapidSource::_getDetoxNavBarLinks();
			$newToHTML = new toHTML();
			$newToHTML->getLinkArrayforRightBox($this->rightNavBarLinks);
			echo $newToHTML->getRightBox($newToHTML->getLinkArrayforRightBox(),'<a href="/opiates.html">Opiates</a>');
			mysql_data_seek($this->rightNavBarLinks, 0);
			return false ;
		}
		else{
			$newToHTML = new opiatesToHTML();
			$newToHTML->setLinkArrayforRightBox($this->rightNavBarLinks);
			echo $newToHTML->getRightBox($newToHTML->getLinkArrayforRightBox(),'<a href="/opiates.html">Opiates</a>');
			mysql_data_seek($this->rightNavBarLinks, 0);
		}
		return true;
	}
	public function printRelatedFolders(){
		$this->filesSource = rapidSource::_getFolders();
		if(!($this->filesSource && mysql_num_rows($this->filesSource))){
			return false ;
		}
		else{
			$listHTML = new html('ul');
			while ($row = mysql_fetch_assoc($this->filesSource)){
				if(!($row && count($row))){
				}
				else{
				}
			}
			echo $this->getRightBox($listHTML->getHTML(),'opiate');
			mysql_data_seek($this->filesSource, 0);
		}
		return true;
	}
	public function printAdditionalFilesinFolderLinks(){
		$this->additionalFilesinFolderLinks = rapidSource::_getFilesinFolders();
		if(!($this->additionalFilesinFolderLinks && mysql_num_rows($this->additionalFilesinFolderLinks))){
			return false ;
		}
		else{
			$newToHTML = new opiatesToHTML();
			$newToHTML->setLinkArrayforAdditionalBox($this->additionalFilesinFolderLinks);
			echo '<h2>OUR TREATMENT CENTER</h2>';
			echo $newToHTML->getLinkArrayforRightBox();
			mysql_data_seek($this->additionalFilesinFolderLinks, 0);
		}
		return true;
	}
	public function printDateModified(){
		echo '<strong>Last Modified:</strong> ' . strip_tags(parent::getDateModified());
	}
	public function printWaismannFiles(){
		$this->additionalFilesinFolderLinks = rapidSource::_getWaismannFiles();
		if(!($this->additionalFilesinFolderLinks && mysql_num_rows($this->additionalFilesinFolderLinks))){
			return false ;
		}
		else{
			$newToHTML = new toHTML();
			$newToHTML->setLinkArrayforAdditionalBox($this->additionalFilesinFolderLinks);
			echo $newToHTML->getAdditionalBox($newToHTML->getLinkArray(), 'OUR TREATMENT CENTER');
			mysql_data_seek($this->additionalFilesinFolderLinks, 0);
		}
		return true;
	}
}
?>