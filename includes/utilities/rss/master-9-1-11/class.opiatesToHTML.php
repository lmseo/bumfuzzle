<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/drug-master-9-1-11/class.toHTML.php');
class opiatesToHTML extends toHTML{
	private $listHTML;
	public function __construct(){
		parent::__construct();
	}
	public function __destruct(){
	}
	public function setTextUnorderedList($additionalFilesinFolderLinks){
		$this->listHTML = new html('ul');
		$this->listHTML->set('class', 'rightList');
		while ($row = mysql_fetch_assoc($additionalFilesinFolderLinks)){
			if(!($row && count($row))){
			}
			else{				
				$recentHTML = new html('li');
				$recentHTML->set('class','rightBox');
				if(isset($row['url'])){
					if($row['url'] != $_SERVER['PHP_SELF'] && !empty($row['url'])){
						if(basename($row['url']) == 'index.html'){
							$url = str_replace('index.html','',$row['url']) ; 
						}
						$recentLinkHTML = new html('a');
						$recentLinkHTML->set('href',$row['url']);
						$recentLinkHTML->set('title',$row['title']);
						$recentLinkHTML->set('text', ucwords($row['name']));
						$recentHTML->inject($recentLinkHTML);
					}else{
						$recentHTML->remove('class');
						$recentHTML->set('class', 'current-page');
						$recentHTML->set('text', ucwords($row['name']));
					}
				}else{
					$recentHTML->set('text', ucwords($row['name']));
				}
				$this->listHTML->inject($recentHTML);
			}
		}
	}
	public function getList(){
		return $this->listHTML;
	}
	public function setTextParagraphList($source, $label='', $separator=','){
		$this->listHTML = new html('span');
		if(!empty($label)){
			$labelToHTML = new html('strong');
			$labelToHTML->set('text', $label.' ');
			$this->listHTML->inject($labelToHTML);
		}
		$counter=0;
		$recentHTML='';
		while ($row = mysql_fetch_assoc($source)){
			if(!($row && count($row))){
			}
			else{
				if(isset($row['url'])){
					if($row['url'] != $_SERVER['PHP_SELF'] && !empty($row['url'])){
						if(basename($row['url']) == 'index.html'){
							$url = str_replace('index.html','',$row['url']) ; 
						}
						$recentLinkHTML = new html('a');
						$recentLinkHTML->set('href',$row['url']);
						$recentLinkHTML->set('title',$row['title']);
						$recentLinkHTML->set('text', ucwords($row['name']));
						$recentHTML.=$recentLinkHTML;
					}else{
					}
				}else{
					if($counter == 0){
						$recentHTML.= ucwords($row['name']);
					}else{
						$recentHTML.= $separator . ' '. ucwords($row['name']);
					}
				}
				
				$counter++;
			}
			
		}
		if(isset($recentHTML) && !empty($recentHTML)){
			$recentHTML.='.';
			$this->listHTML->set('text',$recentHTML);
		}
	}
}
?>