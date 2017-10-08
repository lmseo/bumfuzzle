<?php
class breadCrumb{
	private $breadCrumbHTML;
	private $page_title, $root_url;
	public function __construct(){
		 $this->breadCrumbHTML = array();
		 $this->page_title = "";
		 $this->root_url = "";
	}
	public function url_exists($url) {
		if(! @ file_get_contents($url)){
		  return false;
		}
		return true;		
	}
	public function setCompleteBreadCrumb($PATH_INFO="" , $title=""){
		$domain = 'http://'.$_SERVER['HTTP_HOST'];
		$a=0;
		//error_reporting(0);
		//ini_set('log_errors', 0);
		$pathArray = explode("/",$PATH_INFO);		// Initialize variable and add link to home page
		$this->breadCrumbHTML[0]['url'] = '/';
		$this->breadCrumbHTML[0]['title'] = "Opiates Home";
		$this->breadCrumbHTML[0]['text'] = 'Home';	// initialize newTrail
		//$this->breadCrumbHTML = '<a href="'.$root_url.'/" title="Opiates Home" rel="nofollow">Home</a> &gt; ';		// initialize newTrail
		$newTrail = $this->root_url;		// starting for loop at 1 to remove root
		//print_r($pathArray);
		for($a=1;$a<count($pathArray)-1;$a++){
			// capitalize the first letter of each word in the section name
			$crumbDisplayName = ucwords(str_replace("-", " ",$pathArray[$a]));
			// rebuild the navigation path
			if($a==1){
				$newTrail .= '/'.$pathArray[$a].'/';
			}elseif($a>1){
				$newTrail .= $pathArray[$a].'/';
			}
			
			// build the HTML for the breadcrumb trail
			//$this->breadCrumbHTML .= '<a href="'.$newTrail.'" title="'.$crumbDisplayName . '">' .$crumbDisplayName .'</a> &gt; ';
			//echo $domain.$newTrail.'index.html ' . $this->url_exists($domain.$newTrail.'index.html');
			if ($this->url_exists($domain.$newTrail.'index.html')) {
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
		//echo '<pre>';print_r($this->breadCrumbHTML);echo '</pre>';		// return success (not necessary, but maybe the 
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