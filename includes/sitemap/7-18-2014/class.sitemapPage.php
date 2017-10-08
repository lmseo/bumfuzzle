<?php
require_once('class.sitemapPageSource.php');
require_once('class.sitemapToHTML.php');
class sitemapPage extends page{
	private $sitemapPageSource,  $genericDrugSource, $parentDrugClass;
	private $rightNavBarLinks, $additionalFilesinFolderLinks, $facts, $waismannLinks,$H1, $genericDrugTermID, $genericDrugName;
	
	public function __construct(){
		parent::__construct('opiates');
		$this->sitemapPageSource = parent::getPageSource();
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
		$this->parentDrugClass = sitemapPageSource::_getPageTerms();
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
		$this->genericDrugSource = sitemapPageSource::_getGenericDrug();
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
		$this->genericDrugSource = sitemapPageSource::_getGenericTermID();
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
		$this->genericDrugSource = sitemapPageSource::_getGenericDrug();
		if(!($this->genericDrugSource && mysqli_num_rows($this->genericDrugSource))){
		}
		else{
		  $newToHTML = new sitemapToHTML();
		  if(mysqli_num_rows($this->genericDrugSource)==1){
		  }elseif(mysqli_num_rows($this->genericDrugSource)>1){
			  mysqli_data_seek($this->genericDrugSource, 1);
		  }
		  $newToHTML->setTextParagraphListGenericDrug($this->genericDrugSource, $label,',','ul','generic-list');
		  echo $newToHTML->getList()->getHTML();
		  mysqli_data_seek($this->genericDrugSource, 0);
		}
	}
	public function printDateModified(){
		echo '<strong>Last Modified:</strong> ' . strip_tags(parent::getDateModified());
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
	public function setH1(){
		if(!($this->sitemapPageSource && mysqli_num_rows($this->sitemapPageSource))){
		  return false;
		}
		else{
			if($row = mysqli_fetch_assoc($this->sitemapPageSource)){
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
		mysqli_data_seek($this->sitemapPageSource, 0);
	}
	public function getH1(){
		return $this->H1;
	}
	public function printH1(){
		echo $this->H1;
	}
}
?>