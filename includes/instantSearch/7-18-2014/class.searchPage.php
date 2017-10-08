<?php
require_once('class.searchSource.php');
require_once('class.searchToHTML.php');
class searchPage extends page{
	private $searchPageSource,  $genericDrugSource, $parentDrugClass;
	private $randomRelatedTestimonial, $rightNavBarLinks, $additionalFilesinFolderLinks, $facts, $waismannLinks,$H1, $genericDrugTermID, $genericDrugName;
	
	public function __construct(){
		parent::__construct('searchs');
		$this->searchPageSource = parent::getPageSource();
		$this->setH1();
		$this->setGenericDrugTermID();
	}
	public function __destruct(){
	}
	public function isIndex(){
		static $isIndexTerm;
		if(isset($isIndexTerm)){
			return $isIndexTerm;
		}
		$this->parentDrugClass = searchSource::_getPageTerms();
		if(!($this->parentDrugClass && mysqli_num_rows($this->parentDrugClass))){
		}
		else{
		  while ($row = mysqli_fetch_assoc($this->parentDrugClass)){
			if(!($row && count($row))){
			}
			else{
				if(isset($row['termID']) and $row['termID']==778){
					mysqli_data_seek($this->parentDrugClass, 0);
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
		$this->genericDrugSource = searchSource::_getGenericDrug();
		if(!($this->genericDrugSource && mysqli_num_rows($this->genericDrugSource))){
		}
		else{
		  while ($row = mysqli_fetch_assoc($this->genericDrugSource)){
			if(!($row && count($row))){
			}
			else{
				if(isset($row['name'])){
					$term= $row['name'];
				}
			}
		  }
		  mysqli_data_seek($this->genericDrugSource, 0);
		  return $term;
		}
		return false;
	}
	public function setGenericDrugTermID(){
		static $term;
		if(isset($term)){
			return $term;
		}
		$this->genericDrugSource = searchSource::_getGenericTermID();
		if(!($this->genericDrugSource && mysqli_num_rows($this->genericDrugSource))){
		}
		else{
		  while ($row = mysqli_fetch_assoc($this->genericDrugSource)){
			if(!($row && count($row))){
			}
			else{
				if(isset($row['termID'])){
					$this->genericDrugTermID= $row['termID'];
				}
				if(isset($row['name'])){
					$this->genericDrugName= $row['name'];
				}
				
			}
		  }
		  mysqli_data_seek($this->genericDrugSource, 0);
		  return true;
		}
		return false;
	}
	public function getGenericDrugTermID(){
		if(isset($this->genericDrugTermID)){
			return $this->genericDrugTermID;
		}else{
			return false;
		}
	}
	public function getGenericDrugName(){
		if(isset($this->genericDrugName)){
			return $this->genericDrugName;
		}else{
			return false;
		}
	}
	public function printGenericDrug($label=''){
		$this->genericDrugSource = searchSource::_getGenericDrug();
		if(!($this->genericDrugSource && mysqli_num_rows($this->genericDrugSource))){
		}
		else{
		  $newToHTML = new searchsToHTML();
		  if(mysqli_num_rows($this->genericDrugSource)==1){
		  }elseif(mysqli_num_rows($this->genericDrugSource)>1){
			  mysqli_data_seek($this->genericDrugSource, 1);
		  }
		  $newToHTML->setTextParagraphListGenericDrug($this->genericDrugSource, $label,',','ul','generic-list');
		  echo $newToHTML->getList()->getHTML();
		  mysqli_data_seek($this->genericDrugSource, 0);
		}
	}
	public function isBrandDrug(){
		$this->parentDrugClass = searchSource::_getDrugBrandNames();
		if(!($this->parentDrugClass && mysqli_num_rows($this->parentDrugClass))){
		}
		else{
			$newToHTML = new searchsToHTML();
			$newToHTML->setTextParagraphList($this->parentDrugClass);
			echo $newToHTML->getList()->getHTML();
			mysqli_data_seek($this->parentDrugClass, 0);
		}
		return true;
	}
	public function printParentDrugClass($label=''){
		$this->parentDrugClass = searchSource::_getParentDrugClass();
		if(!($this->parentDrugClass && mysqli_num_rows($this->parentDrugClass))){
		}
		else{
			$newToHTML = new searchsToHTML();
			$newToHTML->setTextParagraphListDrugClass($this->parentDrugClass, $label, ' > ','div','drug-class' );
			echo $newToHTML->getList()->getHTML();
			mysqli_data_seek($this->parentDrugClass, 0);
		}
	}
	public function printOpiateList($label=''){
		$this->opiateList = searchSource::getOpiateList();
		if(!($this->opiateList && mysqli_num_rows($this->opiateList))){
		}
		else{
			$arrayOpiateList= searchSource::opiateListToArray($this->opiateList);
		}
	}
	public function printDrugBrandNames($label=''){
		$this->parentDrugClass = searchSource::_getDrugBrandNames($this->getGenericDrugTermID());
		if(!($this->parentDrugClass && mysqli_num_rows($this->parentDrugClass))){
		}
		else{
			$newToHTML = new searchsToHTML();
			if($this->getGenericDrug()){
				$newToHTML->setTextUnorderedList($this->parentDrugClass,$this->getGenericDrugName().' Brand Names:','div','brand-names rightContinue',strtolower($this->getGenericDrug()).'-brand-name');
			}else{
				$newToHTML->setTextUnorderedList($this->parentDrugClass,$this->getGenericDrugName().' Brand Names:','div','rightContinue','search-brand-drug');
			}
			$output= $newToHTML->getList()->getHTML();
			if(!empty($output)){
				echo $output;
				$this->printDividider();
			}else{
				mysqli_data_seek($this->parentDrugClass, 0);
				return false;
			}
			mysqli_data_seek($this->parentDrugClass, 0);
		}
	}
	public function printRightNavBarLinks(){
		$this->rightNavBarLinks = searchSource::_getRightNavBarLinks();
		if(!($this->rightNavBarLinks && mysqli_num_rows($this->rightNavBarLinks))){
			$this->rightNavBarLinks = searchSource::_getDetoxNavBarLinks();
			$newToHTML = new toHTML();
			$newToHTML->getLinkArrayforRightBox($this->rightNavBarLinks);
			echo $newToHTML->getRightBox($newToHTML->getLinkArrayforRightBox(),'Related Information');
			mysqli_data_seek($this->rightNavBarLinks, 0);
			return false ;
		}
		else{
			$newToHTML = new searchsToHTML();
			$newToHTML->setLinkArrayforRightBox($this->rightNavBarLinks);
			echo $newToHTML->getRightBox($newToHTML->getLinkArrayforRightBox(),'Related Information');
			mysqli_data_seek($this->rightNavBarLinks, 0);
		}
		return true;
	}
	public function printRelatedFolders(){
		$this->filesSource = searchSource::_getFolders();
		if(!($this->filesSource && mysqli_num_rows($this->filesSource))){
			return false ;
		}
		else{
			$listHTML = new html('ul');
			while ($row = mysqli_fetch_assoc($this->filesSource)){
				if(!($row && count($row))){
				}
				else{
				}
			}
			echo $this->getRightBox($listHTML->getHTML(),'search');
			mysqli_data_seek($this->filesSource, 0);
		}
		return true;
	}
	public function printAdditionalFilesinFolderLinks(){
		$this->additionalFilesinFolderLinks = searchSource::_getFilesinFolders();
		if(!($this->additionalFilesinFolderLinks && mysqli_num_rows($this->additionalFilesinFolderLinks))){
			return false ;
		}
		else{
			/*while ($row = mysqli_fetch_assoc($this->additionalFilesinFolderLinks)){
				echo '<pre>'.$row['url'] . ' ' . $row['pageType'].'</pre>';
			}mysqli_data_seek($this->additionalFilesinFolderLinks, 0);*/
			$newToHTML = new searchsToHTML();
			$newToHTML->setLinksInFolderList($this->additionalFilesinFolderLinks);
			$output= $newToHTML->getList()->getHTML();
			//print_r($newToHTML);
			if(!empty($output)){
				echo $output;
				$this->print2LayerDividider();
			}else{
				mysqli_data_seek($this->additionalFilesinFolderLinks, 0);
				return false;
			}
			mysqli_data_seek($this->additionalFilesinFolderLinks, 0);
		}
		return true;
	}
	public function printCombinations($label=''){
		$this->combinationsLinks = searchSource::_getCombinations($this->getGenericDrugTermID());
		if(!($this->combinationsLinks && mysqli_num_rows($this->combinationsLinks))){
			return false ;
		}
		else{			
			$newToHTML = new searchsToHTML();
			if($this->getGenericDrug()){
				$newToHTML->setTextUnorderedList($this->combinationsLinks,$this->getGenericDrugName().' Combinations:','div','combinations rightContinue',strtolower($this->getGenericDrug()).'-combination');
				
			}else{
				$newToHTML->setTextUnorderedList($this->combinationsLinks,$this->getGenericDrugName().' Combinations:','div','combinations rightContinue','search-combination');
			}
			$output= $newToHTML->getList()->getHTML();
			if(!empty($output)){
				echo $output;
				$this->printDividider();
			}else{
				mysqli_data_seek($this->combinationsLinks, 0);
				return false;
			}
			mysqli_data_seek($this->combinationsLinks, 0);
		}
		return true;
	}
	public function printFacts(){
		 $this->facts = searchSource::_getFacts();
		if(!( $this->facts && mysqli_num_rows( $this->facts))){
			return false ;
		}
		else{
			$newToHTML = new searchsToHTML();
			$newToHTML->setLinkArrayforAdditionalBox( $this->facts);
			echo '<h2>'.parent::getFolderName().'Facts</h2>';
			echo $newToHTML->getLinkArrayforRightBox();
			mysqli_data_seek( $this->facts, 0);
		}
		return true;
	}
	public function printGenericsList(){
		 $this->genericsList = searchSource::_getGenericsList();
		if(!( $this->genericsList && mysqli_num_rows( $this->genericsList))){
			return false ;
		}
		else{
			$newToHTML = new searchsToHTML();
			$newToHTML->setTextUnorderedList($this->genericsList,'Generic Opioids','div','generic-list rightContinue','opioid-generic-drug');
			$output =$newToHTML->getList()->getHTML();
			if(!empty($output)){
				echo $output;
			}else{
				mysqli_data_seek($this->genericsList, 0);
				return false;
			}
			mysqli_data_seek($this->genericsList, 0);
		}
		return true;
	}
	public function printTopOpioids(){
		 $this->topOpioidsList = searchSource::_getTopOpioidsList();
		if(!( $this->topOpioidsList && mysqli_num_rows( $this->topOpioidsList))){
			return false ;
		}
		else{
			$newToHTML = new searchsToHTML();
			$newToHTML->setTextUnorderedList($this->topOpioidsList,'Top 20 Opioid Drugs (Brand Names)','div','rightContinue','opioid-top-20-drugs');
			$output= $newToHTML->getList()->getHTML();
			if(!empty($output)){
				echo $output;
				$this->printDividider();
			}else{
				mysqli_data_seek($this->topOpioidsList, 0);
				return false;
			}
			mysqli_data_seek($this->topOpioidsList, 0);
		}
		return true;
	}
	public function printDateModified(){
		echo '<strong>Last Modified:</strong> ' . strip_tags(parent::getDateModified());
	}
	public function printWaismannFiles(){
		$this->waismannLinks = searchSource::_getWaismannFiles();
		if(!($this->waismannLinks && mysqli_num_rows($this->waismannLinks))){
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
				mysqli_data_seek($this->waismannLinks, 0);
				return false;
			} 
			mysqli_data_seek($this->waismannLinks, 0);
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
	public function setH1(){
		if(!($this->searchPageSource && mysqli_num_rows($this->searchPageSource))){
		  return false;
		}
		else{
			if($row = mysqli_fetch_assoc($this->searchPageSource)){
				//print_r($row);
				if(isset($row['h1']) && $row['h1']!='' && $row['h1']!=NULL){
					$h1HTML = new html('h1');
					$h1HTML->set('itemprop','name');
					$h1HTML->set('class','h1-main');
					$h1HTML->set('text', $row['h1']);
					$this->H1 = $h1HTML->getHTML();
				}
			}
		}
		mysqli_data_seek($this->searchPageSource, 0);
	}
	public function getH1(){
		return $this->H1;
	}
	public function printH1(){
		echo $this->H1;
	}
}
?>