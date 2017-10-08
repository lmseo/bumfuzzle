<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/drug-master-4-28-11/class.page.php');
require_once('class.opiateSource.php');
require_once('class.opiatesToHTML.php');
class opiatePage extends page{
	private $opiatePageSource;
	private $randomRelatedTestimonial, $rightNavBarLinks, $additionalFilesinFolderLinks;
	
	public function __construct(){
		parent::__construct('opiates');
		$this->opiatePageSource = parent::getPageSource();
	}
	public function __destruct(){
	}
	public function printRandomRelatedTestimonial(){
		$this->randomRelatedTestimonial = opiateSource::_getRandomRelatedTestimonialFomDB();
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
		$this->rightNavBarLinks = opiateSource::_getRightNavBarLinks();
		if(!($this->rightNavBarLinks && mysql_num_rows($this->rightNavBarLinks))){
			$this->rightNavBarLinks = opiateSource::_getDetoxNavBarLinks();
			$newToHTML = new toHTML();
			while ($row = mysql_fetch_assoc($this->rightNavBarLinks)){
				if(!($row && count($row))){
				}
				else{
					$newToHTML->setLinkArrayforRightBox($row['url'], $row['title'], $row['anchor']);
				}
			}
			echo $newToHTML->getRightBox($newToHTML->getLinkArrayforRightBox(),'<a href="/opiates/">Opioids &amp; Opiates</a>');
			mysql_data_seek($this->rightNavBarLinks, 0);
			return false ;
		}
		else{
			$newToHTML = new toHTML();
			while ($row = mysql_fetch_assoc($this->rightNavBarLinks)){
				if(!($row && count($row))){
				}
				else{
					$newToHTML->setLinkArrayforRightBox($row['url'], $row['title'], $row['anchor']);
				}
			}
			echo $newToHTML->getRightBox($newToHTML->getLinkArrayforRightBox(),'<a href="/opiates/">Opioids &amp; Opiates</a>');
			mysql_data_seek($this->rightNavBarLinks, 0);
		}
		return true;
	}
	public function printRelatedFolders(){
		$this->filesSource = opiateSource::_getFolders();
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
		$this->additionalFilesinFolderLinks = opiateSource::_getFilesinFolders();
		if(!($this->additionalFilesinFolderLinks && mysql_num_rows($this->additionalFilesinFolderLinks))){
			return false ;
		}
		else{
			$newToHTML = new toHTML();
			while ($row = mysql_fetch_assoc($this->additionalFilesinFolderLinks)){
				if(!($row && count($row))){
				}
				else{
					$newToHTML->setLinkArrayforAdditionalBox($row['url'], $row['title'], $row['anchor']);
				}
			}
			echo $newToHTML->getAdditionalBox($newToHTML->getLinkArray());
			mysql_data_seek($this->additionalFilesinFolderLinks, 0);
		}
		return true;
	}
	public function printDateModified(){
		echo '<strong>Last Modified:</strong> ' . strip_tags(parent::getDateModified());
	}
	public function printWaismannFiles(){
		$this->additionalFilesinFolderLinks = opiateSource::_getWaismannFiles();
		if(!($this->additionalFilesinFolderLinks && mysql_num_rows($this->additionalFilesinFolderLinks))){
			return false ;
		}
		else{
			$newToHTML = new toHTML();
			while ($row = mysql_fetch_assoc($this->additionalFilesinFolderLinks)){
				if(!($row && count($row))){
				}
				else{
					$newToHTML->setLinkArrayforAdditionalBox($row['url'], $row['title'], $row['anchor']);
				}
			}
			echo $newToHTML->getAdditionalBox($newToHTML->getLinkArray(), 'Waismann Method');
			mysql_data_seek($this->additionalFilesinFolderLinks, 0);
		}
		return true;
	}
}
?>