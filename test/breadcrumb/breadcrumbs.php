 <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
  <a href="http://www.example.com/dresses" itemprop="url">
    <span itemprop="title">Dresses</span>
  </a> ›
</div>  
<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
  <a href="http://www.example.com/dresses/real" itemprop="url">
    <span itemprop="title">Real Dresses</span>
  </a> ›
</div>  
<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
  <a href="http://www.example.com/clothes/dresses/real/green" itemprop="url">
    <span itemprop="title">Real Green Dresses</span>
  </a>
</div>
	
   <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
		 <a href="http://www.example.com/dresses" itemprop="url">
		<span itemprop="title">Dresses</span>
		 </a> ›
	</div>  
<?php
	public function _getBreadCrumbHTML ($url='', $text, $title){
		if($url != ''){
			$linksContainerHTML = new html('div');
			$linksContainerHTML->set('itemtype','http://data-vocabulary.org/Breadcrumb');
			$linksContainerHTML->set('itemscope','');

			$linkstHTML = new html('a');
			$linkstHTML->set('href',$url);
			$linkstHTML->set('title',$title);
			$linkstHTML->set('itemprop','url');

			$linkTitleHTML = new html('span');
			$linkTitleHTML->set('text', $text);
			$linkTitleHTML->set('itemprop','title');
			
			$linkstHTML->inject($linkTitleHTML);
			$linksContainerHTML->inject($linkstHTML);
			$linksContainerHTML->set('text',' &gt; ');

			return $linksContainerHTML->getHTML();
		}else{
			$linkstHTML = new html('span');
			$linkstHTML->set('text', $text);
			return $linkstHTML->getHTML() . ' &gt; ';
		}
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
		if($this->isThereSource){
			$newbreadcrumb = new breadCrumb();
			$newToHTML= new toHTML();
			$url =$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
			$title= strip_tags($this->getAnchor());
			$newbreadcrumb->setCompleteBreadCrumb($url, $title);
			$this->breadCrumbSource = $newbreadcrumb->getBreadCrumb();
			if(!(count($this->breadCrumbSource))){
				return false;
			}
			else{
				$breadCrumbComplete='';
				for($a=0;$a<count($this->breadCrumbSource)-1;$a++){
					$breadCrumbComplete .= $newToHTML->_getBreadCrumbHTML ($this->breadCrumbSource[$a]['url'], $this->breadCrumbSource[$a]['text'], $this->breadCrumbSource[$a]['title']);	
				}
				$lastElement =  end($this->breadCrumbSource);
				if($lastElement['text']!=''){
						$breadCrumbComplete .= ' <strong>'. $lastElement['text'].'</strong>';
				}
			}
			$this->breadcrumb = $breadCrumbComplete;
			echo $breadCrumbComplete;
			return true;
		}
		else{
			return false;
		}
	}
?>