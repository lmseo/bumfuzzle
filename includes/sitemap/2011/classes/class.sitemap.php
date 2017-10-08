<?php
require_once("class.filter.php");
require_once("class.sitemapSource.php");
require_once("class.sitemapView.php");

class sitemap {
	private $d;
	private $currentFolder;
	private $siteMapArray;
	private $out;
	private $empty_dirs;		// display empty dirs?
 	private $filter;
	
	public function sitemap($filter=null) {
		$this->currentFolder = '';
		$this->out='';
		$this->show_empty_dirs(false);
		if(null==$filter) $this->set_filter(new filter());
	}
	/**
	 * if set to true maphp will display empty directories.
	 * if we set it to false empty directories will not be
	 * displayed on the list.
	 */	
	 public function show_empty_dirs($bool) {
		$this->empty_dirs=$bool;
	}

	/**
	 * set a filter for the current list
	 */
	public function set_filter($filter) {
		$this->filter=$filter;
	}
	public function setSource($path=".", $dateFlag=false) {
		if($dateFlag==false){
			$this->d = new sitemapSource($path,$this->filter);	
			return true;
		}elseif($dateFlag==true){
			$this->d = new sitemapSource($path,$this->filter, $dateFlag);
			return true;
		}
		return false;			
		//print_r ($this->d->getTree());
	}
	public function printSitemapToHTML($d){
		if(isset($d)){
			$sitemapPrint = new sitemapView($d);
			$sitemapPrint->setHTML();
			$sitemapPrint->printSitemap();
		}
		return false;
	}
	public function getSource(){
		if(isset($this->d) ){
			return $this->d->orderTree();
		}
		return false;
	}
	public function printSitemapToXML($d){
		if(isset($d)){
			$sitemapPrint = new sitemapView($d);
			$sitemapPrint->setXML();
			$sitemapPrint->printSitemap();
			return true;
		}
		return false;
	}
}
?>
