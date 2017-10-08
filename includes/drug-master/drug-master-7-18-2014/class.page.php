<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/utilities/html/2011/class.html.php');
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/drug-master/drug-master-7-18-2014/widgets/class.breadcrumb.php');
class page{
	private $dbTable;
	private $pageSource, $breadCrumbSource;
	private $head;
	private $body;
	private $H1, $H2, $content, $dateModified, $dateCreated, $folderURL, $folderName, $canonical, $anchor,$pageTemplate,$pageURL;
	private $breadcrumb;
	private $isThereSource;

	public function __construct($table){
		$this->isThereSource=true;
		
		$this->H1 = $this->H2 =  $this->content = $this->dateModified= $this->dateCreated= $this->folderURL = $this->folderName = $this->canonical= $this->pageTemplate = '';
		$this->dbTable = $table;
		$this->pageSource = source::_getPageSource();
		if(!($this->pageSource)){
			$this->isThereSource = false;
			$this->pageSource = source::_get404(); 
			$this->setHead();
			$this->setBody();
			//$this->setPageTemplate();
			$this->setPageTemplateURL();
			//error_reporting(E_ERROR | E_PARSE);
			header("HTTP/1.1 404 Not Found");
			header('Content-Type: text/html',true);
			flush();
			//header("Location: /errordocuments/404page.html",TRUE,303);
		}
		else{
			$this->isThereSource=true;
			$this->setHead();
			$isContent = $this->setBody();
			$this->setPageURL();
			//$this->setPageTemplate();
			$this->setPageTemplateURL();
			if($isContent){
			} 
			else{
				$this->pageSource = source::_get404(); 
				$this->setHead();
				$this->setBody();
				//$this->setPageTemplate();
				$this->setPageTemplateURL();
				header("HTTP/1.1 404 Not Found");
				header('Content-Type: text/html',true);
				flush();
				//header("Location: /errordocuments/404page.html",TRUE,303);
			}
		}
	}
	public function __destruct(){
	}
	public function setPageTemplate(){
		if(!($this->pageSource && mysqli_num_rows($this->pageSource))){
		  return false;
		}
		else{
			if($row = mysqli_fetch_assoc($this->pageSource) && isset($row['templateID'])){
				$this->pageTemplate= $row['templateID'];
			}
			mysqli_data_seek($this->pageSource, 0);
		}
	}
	public function getPageTemplate(){
		if(isset($this->pageTemplate)){
			return $this->pageTemplate;
		}
		return false;
	}
	public function setPageTemplateURL(){
		if(!($this->pageSource && mysqli_num_rows($this->pageSource))){
		  return false;
		}
		else{
			if($row = mysqli_fetch_assoc($this->pageSource)){
				 $this->pageTemplateURL= $row['templateURL'];
				mysqli_data_seek($this->pageSource, 0);
			}
		}
	}
	public function getPageTemplateURL(){
		if(isset($this->pageTemplateURL)){
			return $this->pageTemplateURL;
		}
		return false;
	}
	public function setHead(){
		if(!($this->pageSource && mysqli_num_rows($this->pageSource))){
		  return false;
		}
		else{
			if($row = mysqli_fetch_assoc($this->pageSource)){
				$titleHTML = new html('title');
				if($row['title']!='' && $row['title']!=NULL){
					$titleHTML->set('text', $row['title']);
				}else{
					$titleHTML->set('text', 'No Title');
				}

				$descriptionHTML = new html('meta');
				$descriptionHTML->set('name','description');
				if($row['description']!='' && $row['description']!=NULL){
					$descriptionHTML->set('content', $row['description']);
				}else{
					$descriptionHTML->set('content', 'No Description');
				}
				$keywordsHTML = new html('meta');
				$keywordsHTML->set('name','keywords');
				if($row['keywords']!='' && $row['keywords']!=NULL){
					$keywordsHTML->set('content', $row['keywords']);
				}else{
					$keywordsHTML->set('content', 'No Keywords');
				}
				if(isset($row['canonical']) && $row['canonical']!='' && $row['canonical']!=NULL){
					$canonicalHTML = new html('link');
					$canonicalHTML->set('rel','canonical');
					$canonicalHTML->set('href', $row['canonical']);
					$this->canonical = $canonicalHTML->getHTML();
				}
				$this->head = $titleHTML->getHTML();	
				$this->head .= $descriptionHTML->getHTML();	
				$this->head .= $keywordsHTML->getHTML();
				$this->head .= $this->canonical;
				mysqli_data_seek($this->pageSource, 0);
			}
		}
	}
	public function printCurrentPhone(){
		date_default_timezone_set('America/Los_Angeles');
		$currentTime = date('G.i');
		$currentDay = date('N');
		if($currentDay == 1 or $currentDay <= 5){
			if ($currentTime > 10.4 || $currentTime < 8.30) {
				echo '1-310-927-7155';
			}elseif($currentTime <= 17 || $currentTime >= 8.30) {
				echo '1-888-987-4673';
			}else{
				echo '1-310-927-7155';
			}
		}else{
			echo '1-310-927-7155';
		}
	}
	public function getHead(){
		return $this->head;
	}
	public function printHead(){
		echo $this->head;
	}
	public function setBody(){
		if(!($this->pageSource && mysqli_num_rows($this->pageSource))){
		  return false;
		}
		else{
			if($row = mysqli_fetch_assoc($this->pageSource)){
				if(isset($row['h1']) && $row['h1']!='' && $row['h1']!=NULL){
					$h1HTML = new html('h1');
					$h1HTML->set('class','h1-main');
					$h1HTML->set('text', $row['h1']);
					$this->H1 = $h1HTML->getHTML();
				}
				if(isset($row['h2']) && $row['h2']!='' && $row['h2']!=NULL){
					$h2HTML = new html('h2');
					$h2HTML->set('class','h2-main');
					$h2HTML->set('text', $row['h2']);
					$this->H2 = $h2HTML->getHTML();
				}
				if(isset($row['dateModified']) && $row['dateModified']!='' && $row['dateModified']!=NULL){
					$dateModifiedHTML = new html('h5');
					$dateModifiedHTML->set('class','date-modified');
					$dateModifiedHTML->set('text', date('F d, Y h:i:s A', strtotime($row['dateModified'])));
					$this->dateModified = $dateModifiedHTML->getHTML();
				}
				if(isset($row['dateCreated']) && $row['dateCreated']!='' && $row['dateCreated']!=NULL){
					$dateCreatedHTML = new html('h5');
					$dateCreatedHTML->set('class','date-created');
					$dateCreatedHTML->set('text', date('F d, Y h:i:s A', strtotime($row['dateCreated'])));
					$this->dateCreated = $dateCreatedHTML->getHTML();
				}
				if(isset($row['anchor']) && $row['anchor']!='' && $row['anchor']!=NULL){
					$this->anchor = $row['anchor'];
				}
				if(isset($row['content']) && $row['content']!='' && $row['content']!=NULL){
					$this->content = $row['content'];
				}
				else{
					return false;
				}
				if(isset($row['fName']) && $row['fName']!='' && $row['fName']!=NULL){
					$this->folderName = $row['fName'];
				}
				if(isset($row['fUrl']) && $row['fUrl']!='' && $row['fUrl']!=NULL){
					$this->folderURL = $row['fUrl'];
				}
				mysqli_data_seek($this->pageSource, 0);
				return true;
			}
		}
		return false;
	}
	public function printBreadCrumb(){
		if($this->isThereSource){
			$newbreadcrumb = new breadCrumb();
			$newToHTML= new toHTML();
			$url =$this->getPageURL();
			$title= strip_tags($this->getAnchor());
			$newbreadcrumb->setCompleteBreadCrumb($url, $title);
			$this->breadCrumbSource = $newbreadcrumb->getBreadCrumb();
			//echo $url;
			//print_r($this->breadCrumbSource);
			if(!(count($this->breadCrumbSource))){
				return false;
			}
			else{
				$newToHTML->setBreadCrumbHTML($this->breadCrumbSource);
			}
			$this->breadcrumb = $newToHTML->getBreadCrumbHTML();
			echo $this->breadcrumb;
			return true;
		}
		else{
			return false;
		}
	}
	public function printSubscribeForm(){
		 $newToHTML = new toHTML();
		echo $newToHTML->getAdditionalBox($newToHTML->getSubscribeForm(), 'Get Updates by Email','subscribe-box', 'subscribe-header');
	}
	public function printContactInformation(){
		$newToHTML = new toHTML();
		$newToHTML->setLinkArrayforAdditionalBox('http://www.opiates.com/contact/', 'Contact the Waismann Method', 'Email Us');
		$newToHTML->setLinkArrayforAdditionalBox('', 'Call Us', 'CALL 1 (888) 987-4673');
		echo $newToHTML->getAdditionalBox($newToHTML->getLinkArray(), 'Contact Us','additional-links');
	}
	public function getBody(){
		return $this->body;
	}
	public function printBody(){
		echo $this->body;
	}
	public function getH1(){
		return $this->H1;
	}
	public function printH1(){
		echo $this->H1;
	}
	public function getH2(){
		return $this->H2;
	}
	public function printH2(){
		echo $this->H2;
	}
	public function getContent(){
		return $this->content;
	}
	public function printContent(){
		echo $this->content;
	}
	public function getFolderURL(){
		return $this->folderURL;
	}
	public function printFolderURL(){
		echo $this->folderURL;
	}
	public function getFolderName(){
		return $this->folderName;
	}
	public function printFolderName(){
		echo $this->folderName;
	}
	public function getDateModified(){
		return $this->dateModified;
	}
	public function printDateModified(){
		echo $this->dateModified;
	}
	public function getPageSource(){
		return $this->pageSource;
	}
	public function setPageSource($source){
		if(isset($source) && is_resource($source)){
			$this->pageSource = $source ;
			return true;
		}
		return false;		
	}
	public function printDateCreated(){
		echo $this->dateCreated;
	}
	public function getDateCreated(){
		return $this->dateCreated;
	}
	public function getdbTable(){
		return $this->dbTable;
	}
	public function setdbTable($table){
		if(isset($table)){
			$this->dbTable = $table ;
			return true;
		}
		return false;		 
	}
	public function setPageURL(){
		//print_r($this->pageSource);
		if(!($this->pageSource && mysqli_num_rows($this->pageSource))){
		  return false;
		}
		else{
			if($row = mysqli_fetch_assoc($this->pageSource)){
				if($row['uri']=='index.html'){
					$this->pageURL=$row['url'].'index.html';
				}else{
					$this->pageURL=$row['url'];
				}
			}
			mysqli_data_seek($this->pageSource, 0);
		}
	}
	public function getPageURL(){
		if(isset($this->pageURL)){
			return $this->pageURL;
		}
		return false;
	}
	public function printPageURL(){
		if(isset($this->pageURL)){
			echo $this->pageURL;
		}
		return false;
	}
	public function getIsThereSource(){
		return $this->isThereSource;
	}
	public function setIsThereSource($isSource){
		if(isset($isSource)&& is_bool($isSource)){
			$this->isThereSource = $isSource ;
			return true;
		}
		return false;		 
	}
	public function getCanonical(){
		if(isset($this->canonical)){
			return $this->canonical;
		}
		return false;
	}
	public function setCanonical($a=''){
		$this->canonical = $a;
	}
	public function getAnchor(){
		if(isset($this->anchor)){
			return $this->anchor;
		}
		return false;
	}
	public function setAnchor($a=''){
		$this->anchor = $a;
	}
}
?>