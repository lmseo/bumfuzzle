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
	private $pageSource;
	
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
	public function setHTMLSource() {
		$this->pageSource = sitemapSource::dbSourceHTML();
		if(!($this->pageSource && mysqli_num_rows($this->pageSource))){
		  return false;
		}
		else{
			return true;
		}
		return false;
	}
	public function setSource() {
		$this->pageSource = sitemapSource::dbSource();
		if(!($this->pageSource && mysqli_num_rows($this->pageSource))){
		  return false;
		}
		else{
			//$this->printSitemapToXMLDB($this->pageSource);
			/*while($row = mysql_fetch_assoc($this->pageSource)){
				if(!$this->filter->in_file_filter($row['url']) && !$this->filter->in_dir_filter($row['url'])){
					//echo $row['url'] . "\n";
					echo $row['url']. " in file: ".!$this->filter->in_file_filter($row['url']). " in directory: " .!$this->filter->in_dir_filter($row['url'])."\n";
				}
			}*/
			//echo preg_match('/^\/errordocuments\//','/errordocuments/404page.html',$matches, PREG_OFFSET_CAPTURE) ;
			//print_r($matches);
			/*$subject = "abcdef";
			$pattern = '/def/';
			preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE);
			print_r($matches);
			$aReplace = array('../','./');
			$cleaner = new Links();
			if ($dir = @opendir('.')){
				while (($element = readdir($dir)) !== false) { 
					echo $element . "\n ";
				}
			}*/
			//print_r($this->filter);
			//mysql_data_seek($this->pageSource, 0);
			return true;
		}
		
		/*if($dateFlag==false){
			$this->d = new sitemapSource($path,$this->filter);	
			return true;
		}elseif($dateFlag==true){
			$this->d = new sitemapSource($path,$this->filter, $dateFlag);
			return true;
		}*/
		return false;			
		//print_r ($this->d->getTree());
	}
	public function printSitemapToHTML($d){
		if(isset($d)){
			$sitemapPrint = new sitemapView($d);
			$sitemapPrint->setHTMLDB();
			$sitemapPrint->printSitemap();
		}
		return false;
	}
	public function printSitemapToHTMLFromDB($d){
		if(isset($d)){
			$sitemapPrint = new sitemapView($d);
			$sitemapPrint->setHTMLDB();
			$sitemapPrint->printSitemap();
		}
		return false;
	}
	public function getSource(){
		if(isset($this->pageSource) ){
			return $this->pageSource;
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
	public function printSitemapToXMLDB($d){
		if(isset($d)){
			$sitemapPrint = new sitemapView($d);
			$sitemapPrint->setXMLDB();
			$sitemapPrint->printSitemap();
			return true;
		}
		return false;
	}
}
?>
