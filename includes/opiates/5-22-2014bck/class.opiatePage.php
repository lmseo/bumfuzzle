<?php
require_once('class.opiateSource.php');
require_once('class.opiatesToHTML.php');
//define('WP_USE_THEMES', false);
//require($_SERVER['DOCUMENT_ROOT'].'/blog/wp-blog-header.php');
class opiatePage extends page{
	private $opiatePageSource,  $genericDrugSource, $parentDrugClass;
	private $randomRelatedTestimonial, $rightNavBarLinks, $additionalFilesinFolderLinks, $facts, $waismannLinks;
	
	public function __construct(){
		parent::__construct('opiates');
		$this->opiatePageSource = parent::getPageSource();
	}
	public function __destruct(){
	}
	public function isIndex(){
		static $isIndexTerm;
		if(isset($isIndexTerm)){
			return $isIndexTerm;
		}
		$this->parentDrugClass = opiateSource::_getPageTerms();
		if(!($this->parentDrugClass && mysql_num_rows($this->parentDrugClass))){
		}
		else{
		  while ($row = mysql_fetch_assoc($this->parentDrugClass)){
			if(!($row && count($row))){
			}
			else{
				if(isset($row['termID']) and $row['termID']==778){
					mysql_data_seek($this->parentDrugClass, 0);
					$isIndexTerm = true;
					return $isIndexTerm;
				}
			}
		  }
		}
		return false;
	}
	public function getGenericDrug(){
		static $term;
		if(isset($term)){
			return $term;
		}
		$this->genericDrugSource = opiateSource::_getGenericDrug();
		if(!($this->genericDrugSource && mysql_num_rows($this->genericDrugSource))){
		}
		else{
		  while ($row = mysql_fetch_assoc($this->genericDrugSource)){
			if(!($row && count($row))){
			}
			else{
				if(isset($row['name'])){
					$term= $row['name'];
				}
			}
		  }
		  mysql_data_seek($this->genericDrugSource, 0);
		  return $term;
		}
		return false;
	}
	public function getGenericDrugTermID(){
		static $term;
		if(isset($term)){
			return $term;
		}
		$this->genericDrugSource = opiateSource::_getGenericTermID();
		if(!($this->genericDrugSource && mysql_num_rows($this->genericDrugSource))){
		}
		else{
		  while ($row = mysql_fetch_assoc($this->genericDrugSource)){
			if(!($row && count($row))){
			}
			else{
				if(isset($row['termID'])){
					$term= $row['termID'];
				}
			}
		  }
		  mysql_data_seek($this->genericDrugSource, 0);
		  return $term;
		}
		return false;
	}
	public function printGenericDrug($label=''){
		$this->genericDrugSource = opiateSource::_getGenericDrug();
		if(!($this->genericDrugSource && mysql_num_rows($this->genericDrugSource))){
		}
		else{
		  $newToHTML = new opiatesToHTML();
		  $newToHTML->setTextParagraphList($this->genericDrugSource, $label);
		  echo $newToHTML->getList()->getHTML();
		  mysql_data_seek($this->genericDrugSource, 0);
		}
	}
	public function isBrandDrug(){
		$this->parentDrugClass = opiateSource::_getDrugBrandNames();
		if(!($this->parentDrugClass && mysql_num_rows($this->parentDrugClass))){
		}
		else{
			$newToHTML = new opiatesToHTML();
			$newToHTML->setTextParagraphList($this->parentDrugClass);
			echo $newToHTML->getList()->getHTML();
			mysql_data_seek($this->parentDrugClass, 0);
		}
		return true;
	}
	public function printParentDrugClass($label=''){
		$this->parentDrugClass = opiateSource::_getParentDrugClass();
		if(!($this->parentDrugClass && mysql_num_rows($this->parentDrugClass))){
		}
		else{
			$newToHTML = new opiatesToHTML();
			$newToHTML->setTextParagraphListDrugClass($this->parentDrugClass, $label, ' > ','div','drug-class' );
			echo $newToHTML->getList()->getHTML();
			mysql_data_seek($this->parentDrugClass, 0);
		}
	}
	public function printDrugBrandNames($label=''){
		$this->parentDrugClass = opiateSource::_getDrugBrandNames($this->getGenericDrugTermID());
		if(!($this->parentDrugClass && mysql_num_rows($this->parentDrugClass))){
		}
		else{
			$newToHTML = new opiatesToHTML();
			if($this->getGenericDrug()){
				$newToHTML->setTextUnorderedList($this->parentDrugClass,$label,'div','brand-names rightContinue',strtolower($this->getGenericDrug()).'-brand-name');
			}else{
				$newToHTML->setTextUnorderedList($this->parentDrugClass,$label,'div','rightContinue','opiate-brand-drug');
			}
			$output= $newToHTML->getList()->getHTML();
			if(!empty($output)){
				echo $output;
				$this->printDividider();
			}else{
				mysql_data_seek($this->parentDrugClass, 0);
				return false;
			}
			mysql_data_seek($this->parentDrugClass, 0);
		}
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
			$newToHTML->getLinkArrayforRightBox($this->rightNavBarLinks);
			echo $newToHTML->getRightBox($newToHTML->getLinkArrayforRightBox(),'Related Information');
			mysql_data_seek($this->rightNavBarLinks, 0);
			return false ;
		}
		else{
			$newToHTML = new opiatesToHTML();
			$newToHTML->setLinkArrayforRightBox($this->rightNavBarLinks);
			echo $newToHTML->getRightBox($newToHTML->getLinkArrayforRightBox(),'Related Information');
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
			/*while ($row = mysql_fetch_assoc($this->additionalFilesinFolderLinks)){
				echo '<pre>'.$row['url'] . ' ' . $row['pageType'].'</pre>';
			}mysql_data_seek($this->additionalFilesinFolderLinks, 0);*/
			$newToHTML = new opiatesToHTML();
			$newToHTML->setLinksInFolderList($this->additionalFilesinFolderLinks);
			$output= $newToHTML->getList()->getHTML();
			//print_r($newToHTML);
			if(!empty($output)){
				echo $output;
				$this->print2LayerDividider();
			}else{
				mysql_data_seek($this->additionalFilesinFolderLinks, 0);
				return false;
			}
			mysql_data_seek($this->additionalFilesinFolderLinks, 0);
		}
		return true;
	}
	public function printCombinations($label=''){
		$this->combinationsLinks = opiateSource::_getCombinations($this->getGenericDrugTermID());
		if(!($this->combinationsLinks && mysql_num_rows($this->combinationsLinks))){
			return false ;
		}
		else{			
			$newToHTML = new opiatesToHTML();
			if($this->getGenericDrug()){
				$newToHTML->setTextUnorderedList($this->combinationsLinks,$label,'div','combinations rightContinue',strtolower($this->getGenericDrug()).'-combination');
				
			}else{
				$newToHTML->setTextUnorderedList($this->combinationsLinks,$label,'div','combinations rightContinue','opiate-combination');
			}
			$output= $newToHTML->getList()->getHTML();
			if(!empty($output)){
				echo $output;
				$this->printDividider();
			}else{
				mysql_data_seek($this->combinationsLinks, 0);
				return false;
			}
			mysql_data_seek($this->combinationsLinks, 0);
		}
		return true;
	}
	public function printFacts(){
		 $this->facts = opiateSource::_getFacts();
		if(!( $this->facts && mysql_num_rows( $this->facts))){
			return false ;
		}
		else{
			$newToHTML = new opiatesToHTML();
			$newToHTML->setLinkArrayforAdditionalBox( $this->facts);
			echo '<h2>'.parent::getFolderName().'Facts</h2>';
			echo $newToHTML->getLinkArrayforRightBox();
			mysql_data_seek( $this->facts, 0);
		}
		return true;
	}
	public function printGenericsList(){
		 $this->genericsList = opiateSource::_getGenericsList();
		if(!( $this->genericsList && mysql_num_rows( $this->genericsList))){
			return false ;
		}
		else{
			$newToHTML = new opiatesToHTML();
			$newToHTML->setTextUnorderedList($this->genericsList,'Generic Opioids','div','generic-list rightContinue','opioid-generic-drug');
			$output =$newToHTML->getList()->getHTML();
			if(!empty($output)){
				echo $output;
			}else{
				mysql_data_seek($this->genericsList, 0);
				return false;
			}
			mysql_data_seek($this->genericsList, 0);
		}
		return true;
	}
	public function printTopOpioids(){
		 $this->topOpioidsList = opiateSource::_getTopOpioidsList();
		if(!( $this->topOpioidsList && mysql_num_rows( $this->topOpioidsList))){
			return false ;
		}
		else{
			$newToHTML = new opiatesToHTML();
			$newToHTML->setTextUnorderedList($this->topOpioidsList,'Top 20 Opioid Drugs (Brand Names)','div','rightContinue','opioid-top-20-drugs');
			$output= $newToHTML->getList()->getHTML();
			if(!empty($output)){
				echo $output;
				$this->printDividider();
			}else{
				mysql_data_seek($this->topOpioidsList, 0);
				return false;
			}
			mysql_data_seek($this->topOpioidsList, 0);
		}
		return true;
	}
	public function printDateModified(){
		echo '<strong>Last Modified:</strong> ' . strip_tags(parent::getDateModified());
	}
	public function printWaismannFiles(){
		$this->waismannLinks = opiateSource::_getWaismannFiles();
		if(!($this->waismannLinks && mysql_num_rows($this->waismannLinks))){
			return false ;
		}
		else{
			$newToHTML = new toHTML();
			$newToHTML->setLinkArrayforAdditionalBox($this->waismannLinks);
			echo '<h2>Our Treatment Center</h2>';
			$output= $newToHTML->getLinkArray();;
			if(!empty($output)){
				echo $output;
				$this->print2LayerDividider();
			}else{
				mysql_data_seek($this->waismannLinks, 0);
				return false;
			} 
			mysql_data_seek($this->waismannLinks, 0);
		}
		return true;
	}
	public function printDividider($cssClass='additional-divider'){
		if(!empty($cssClass)){
			echo '<div class="'.$cssClass.'"></div>';
		}
		else{
			return false; 
		}
		return true;
	}
	public function print2LayerDividider($outerClass='wrapper-additional-divider', $innerClass='additional-divider'){
		if(!empty($outerClass) && !empty($innerClass)){
			echo '<div class="'.$outerClass.'"><div class="'.$innerClass.'"></div></div>';
		}
		else{
			return false; 
		}
		return true;
	}
/*	public function printRecentBlogPosts(){
		query_posts('showposts=5');	
		$myBuffer='<h2>Recent Blog Posts</h2><ul class="recent-blog-post-list">';
		while (have_posts()): the_post();
			$myTitle = the_title("", "", false);
			$myBuffer .= '<li class="recent-blog-post-list-element"><a href="'. get_permalink().'">'.$myTitle.'</a></li>';
		endwhile;
		$myBuffer.='</ul>';
		echo $myBuffer;
	}*/
}
?>