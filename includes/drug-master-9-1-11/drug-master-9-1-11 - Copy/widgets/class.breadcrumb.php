<?php
class breadCrumb{
	private $breadCrumbHTML;
	private $page_title, $root_url;
	public function __construct(){
		 $this->breadCrumbHTML = "";
		 $this->page_title = "";
		 $this->root_url = "";
	}
	public function setCompleteBreadCrumb($PATH_INFO="" , $title=""){
		$domain = $_SERVER['DOCUMENT_ROOT'];
		$a=0;
		error_reporting(0);
		ini_set('log_errors', 0);
		$pathArray = explode("/",$PATH_INFO);		// Initialize variable and add link to home page
		$this->breadCrumbHTML[0]['url'] = '/';
		$this->breadCrumbHTML[0]['title'] = "Opiates Home";
		$this->breadCrumbHTML[0]['text'] = 'Home';	// initialize newTrail
		//$this->breadCrumbHTML = '<a href="'.$root_url.'/" title="Opiates Home" rel="nofollow">Home</a> &gt; ';		// initialize newTrail
		$newTrail = $this->root_url."/";		// starting for loop at 1 to remove root
		for($a=1;$a<count($pathArray)-1;$a++){
			// capitalize the first letter of each word in the section name
			$crumbDisplayName = ucwords(str_replace("-", " ",$pathArray[$a]));
			// rebuild the navigation path
			$newTrail .= $pathArray[$a].'/';
			// build the HTML for the breadcrumb trail
			//$this->breadCrumbHTML .= '<a href="'.$newTrail.'" title="'.$crumbDisplayName . '">' .$crumbDisplayName .'</a> &gt; ';
			if (file_exists($domain.$newTrail.'index.html')) {
				$this->breadCrumbHTML[$a]['url'] = $newTrail;
			} else {
				$this->breadCrumbHTML[$a]['url'] = '';
			}
			$this->breadCrumbHTML[$a]['title'] = $crumbDisplayName;
			$this->breadCrumbHTML[$a]['text'] = $crumbDisplayName;
		}
		// Add the current page
		if(end($pathArray)!='index.html'){
			$this->page_title =  $title;
			$this->breadCrumbHTML[$a]['text'] = $this->page_title;
		}
		// print the generated HTML
		//print($breadCrumbHTML);		// return success (not necessary, but maybe the 
		// user wants to test its success?
		//return true;
	}
	public function printBreadCrumb(){
		// print the generated HTML
		print_r($this->breadCrumbHTML);
		//echo $breadCrumbHTML;
		// return success (not necessary, but maybe the 
		// user wants to test its success?
		return true;
	}
	public function getBreadCrumb(){
		return $this->breadCrumbHTML;
	}
	public function setBreadCrumb($customBreadCrumb=""){
		$this->breadCrumbHTML = $customBreadCrumb;
	}
}
?>