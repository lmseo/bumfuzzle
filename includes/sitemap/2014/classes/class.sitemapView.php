<?php
class sitemapView{
	private $sitemapArray, $out, $dateModiefSource;
	public function sitemapView($dbSource){
		$this->out='';
		$this->sitemapSourceDB =$dbSource;
	}
	public function setHTML(){
		$this->out = "<div id=\"mainMenu\">" ;
		$this->out .= "<ul id=\"menuList\">" ;
		foreach( $this->sitemapArray as $key=> $value){
			if (is_array($this->sitemapArray)) {
					$this->out .='<li class="menu">';
					$type =$this->sitemapArray[$key]['type'];
					if(isset($this->sitemapArray[$key]['url'])){
						$this->out .='<a href="'. $this->encode_path($this->sitemapArray[$key]['url']);
						if(isset($type)){						
							$this->out .='" class="'. $type ;	
						}
						$this->out .= '" >' .$this->sitemapArray[$key]['name'] . "</a>" ;
					}else{
						if(isset($type))
							$this->out .= '<span class="' . $type. '">';
							$this->out .= $this->sitemapArray[$key]['name']. '</span>';	
					}
					if(is_array($this->sitemapArray[$key]['files'])){
							$this->out .= $this->setHTMLSubMenus($this->sitemapArray[$key]['files']);
					}else{
							//echo is_array($this->sitemapArray[$key]['files']) . ' ' . $this->sitemapArray[$key]['name'] . "\n";
					}
			}else{
				//$this->out .= "This directory is empty!";
			}			
			$this->out .= "</li>";
		}
		$this->out .= "</ul>";
		$this->out .= "</div>";
	}
	public function setHTMLDB(){
		$this->out = "<div id=\"mainMenu\">" ;
		$this->out .= "<ul id=\"menuList\">" ;
		while($row = mysqli_fetch_assoc( $this->sitemapSourceDB)){
			$this->out .='<li class="menu">';
			$type =$row['uri'];
			if(isset($row['url'])){
				$this->out .='<a href="'. $this->encode_path($row['url']);
				if(isset($type) && $type=='index.html'){						
					$this->out .='" class="folder' ;	
				}elseif($type!='index.html'){
					$this->out .='" class="file' ;	
				}
				$this->out .= '" >' .$row['anchor'] . "</a>" ;
					
				if($row['uri']!='index.html'){
						//$this->out .= $this->setHTMLSubMenus($this->sitemapArray[$key]['files']);
				}else{
						//echo is_array($this->sitemapArray[$key]['files']) . ' ' . $this->sitemapArray[$key]['name'] . "\n";
							
					}
			}else{
				if(isset($type)){
						$this->out .= '<span class="' . $type. '">';
						$this->out .= $this->sitemapArray[$key]['name']. '</span>';
				}
			}			
			$this->out .= "</li>";
		}
		$this->out .= "</ul>";
		$this->out .= "</div>";
	}
	public function setHTMLSubMenus(array $a){
		$this->out .="<ul class=\"submenu\">";
		foreach( $a as $key=> $value){
			if(isset($a[$key]['type']))	
				$type = $a[$key]['type'];
			if(isset($a[$key]['url'])){
				$this->out .= '<li>';
				$this->out .='<a href="' . $this->encode_path($a[$key]['url']) . '" ';
				
				if(isset($type))						
					$this->out .='class="'. $type ;				
				$this->out .= '" >' . $a[$key]['name'] . '</a>';
			}else{
				$this->out .= '<li class="'. $type .'">';
				$this->out .= $a[$key]['name'];
			}
			if(is_array($a[$key]['files'])){
				$this->out .= $this->setHTMLSubMenus($a[$key]['files']);
			}
		}
		$this->out .= '</li></ul>';
	}

	public function setXMLDB(){
		$this->out = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"><url><loc>http://www.eopiates.com/</loc><priority>1.0</priority><lastmod>'.gmdate("Y-m-d\TH:i:s+00:00", filemtime(".")) . '</lastmod><changefreq>daily</changefreq></url>';
		while($row = mysqli_fetch_assoc( $this->sitemapSourceDB)){
			if(isset($row['url'])){
				$this->out .= " <url><loc>" ."http://" . $_SERVER['HTTP_HOST'] .$this->encode_path($row['url']) ."</loc>";
				if(isset($row['dateModified'])){
					$this->out .= '<lastmod>'.gmdate("Y-m-d\TH:i:s+00:00", strtotime ($row['dateModified'])).'</lastmod>';
				}
				$this->out .= /*"<priority>0.7</priority>*/"</url>";
			}else{
			}
		}
		$this->out .= "</urlset>";
	}
	public function printSitemap(){
		echo $this->out;
	}
	public function encode_path($path) {
		$tmp = explode('/',$path);
		for($i=0;$i<count($tmp);$i++) {
			$tmp[$i]=rawurlencode($tmp[$i]);
		}
		return implode("/",$tmp);
	}
	public function setDatemodified($s){
		if(isset($s)){
			$this->dateModiefSource = $s;
		}
		$this->dateModiefSorce = false;
	}
}
?>