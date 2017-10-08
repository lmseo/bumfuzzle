<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/drug-master-9-1-11/class.toHTML.php');
class opiatesToHTML extends toHTML{
	private $listHTML;
	public function __construct(){
		parent::__construct();
	}
	public function __destruct(){
	}
	public function setTextUnorderedList($source, $label='', $container='div', $containerClass='',$listItemClass='rightBox'){
		$this->listHTML = new html($container);
		$recentHTML = new html('ul');
		while ($row = mysql_fetch_assoc($source)){
			if(!($row && count($row))){
			}
			else{
				$recentHTML->inject($this->getAList($row, $listItemClass,$listItemClass));
			}
		}
		if(isset($recentHTML) && !empty($recentHTML)){
			$this->getAlabel($label,'h2', 'list-title', $this->listHTML);
			if(!empty($containerClass)){
				$this->listHTML->set('class',$containerClass);
			}
			$this->listHTML->inject($recentHTML);
		}
	}
	public function getList(){
		return $this->listHTML;
	}
	public function getAlabel($label, $labelType='strong', $labelClass='list-title', $container){
		if(!empty($label)){
			$labelToHTML = new html($labelType);
			$labelToHTML->set('text', $label.' ');
			if(!empty($labelType)){
				$labelToHTML->set('class', $labelClass.' ');
			}
			if(isset($container) && get_class($container)=='html'){
				$container->inject($labelToHTML);
				return $container;
			}
			return $labelToHTML;
		}
	}
	//returns a string <a href="$url" class="$listClass">$row['name']</a> or 
	public function getFlatList($row){
		$recentHTML='';
		if($row['url'] != $_SERVER['PHP_SELF'] && !empty($row['url']) && isset($row['url'])){
			if($row['uri'] == 'index.html'){
				$url = str_replace('index.html','',$row['url']) ; 
			}else{
				$url =$row['url'];
			}
			$recentLinkHTML = new html('a');
			$recentLinkHTML->set('href',$url);
			$recentLinkHTML->set('title',$row['title']);
			$recentLinkHTML->set('text', ucwords($row['name']));
			$recentHTML.=$recentLinkHTML->getHTML();
		}elseif(!empty($row['name']) && isset($row['name'])){
				$recentHTML.= ucwords($row['name']);
		}
		return $recentHTML;
	}
	public function setTextParagraphList($source, $label='', $separator=',', $container='span', $class=''){
		$recentHTML='';
		while ($row = mysql_fetch_assoc($source)){
			if(!($row && count($row))){
			}
			else{
				if(empty($recentHTML)){
					$recentHTML.=$this->getFlatList($row);
				}else{
					$recentHTML.=$separator. ' ' . $this->getFlatList($row);
				}
			}
		}
		if(isset($recentHTML) && !empty($recentHTML)){
			$this->listHTML = $this->getAlabel($label,'strong', $class, new html($container));
			if(!empty($class)){
				$this->listHTML->set('class',$class);
			}
			$recentHTML.='.';
			$this->listHTML->set('text',$recentHTML);
		}
	}
	
	public function getAList($row, $listItemClass='rightBox', $noLinkListItemClass='no-link'){
		$recentHTML = new html('li');
		$recentHTML->set('class',$listItemClass);
		if($row['url'] != $_SERVER['PHP_SELF'] && !empty($row['url']) && isset($row['url'])){
			if(basename($row['url']) == 'index.html'){
				$url = str_replace('index.html','',$row['url']) ; 
			}else{
				$url =$row['url'];
			}
			$recentLinkHTML = new html('a');
			$recentLinkHTML->set('href',$url);
			$recentLinkHTML->set('title',$row['title']);
			$recentLinkHTML->set('text', ucwords($row['anchor']));
			$recentHTML->inject($recentLinkHTML);
		}elseif($row['url'] == $_SERVER['PHP_SELF'] && !empty($row['url']) && isset($row['url'])){
			$recentHTML->remove('class');
			$recentHTML->set('class', 'current-page');
			$recentHTML->set('text', ucwords($row['anchor']));
		}elseif(isset($row['anchor']) && !empty($row['anchor'])){
			$recentHTML->remove('class');
			$recentHTML->set('class', $noLinkListItemClass);
			$recentHTML->set('text', ucwords($row['anchor']));
		}elseif(isset($row['name']) && !empty($row['name'])){
			$recentHTML->set('text',ucwords($row['name']));
		}
		return $recentHTML;
	}
	public function setLinksInFolderList($additionalFilesinFolderLinks){
		$this->listHTML = new html('div');
		$this->listHTML->set('class', 'rightList');
		$pageType = array();
		$typeLists =array();
		$counter =0;
		while ($row = mysql_fetch_assoc($additionalFilesinFolderLinks)){
			if(!($row && count($row))){
			}
			else{
				if($row['pageType']==NULL){
					if(!isset($typeLists['other'])){
						$typeLists['other'] = new html('ul');				
					}
					$typeLists['other']->inject($this->getAList($row));
				}elseif($row['pageType']=='Combinations'){
				}else{
					$arrayLocation = array_search($row['pageType'], $pageType);
					if(FALSE===$arrayLocation){
						$pageType[]= $row['pageType'];
						$typeLists[$row['pageType']] = new html('ul');
						$typeLists[$row['pageType']]->inject($this->getAList($row));
					}else{
						$typeLists[$row['pageType']]->inject($this->getAList($row));
					}
				}
			}
		}
		ksort($typeLists	);
		//print_r($typeLists);
		foreach($typeLists as $key=> $value){
			$titleHTML = new html('h2');
			$titleHTML->set('text', $key);
			//$titleHTML->add($value);
			$this->listHTML->inject($titleHTML);
			$this->listHTML->inject($value);
		}
		//print_r($typeLists);
	}
	public function setLinksInFolderInList($additionalFilesinFolderLinks){
		$this->listHTML = new html('ul');
		$this->listHTML->set('id', 'accordion');
		$pageType = array();
		$typeLists =array();
		$counter =0;
		while ($row = mysql_fetch_assoc($additionalFilesinFolderLinks)){
			if(!($row && count($row))){
			}
			else{
				if($row['pageType']==NULL){
					if(!isset($typeLists['other'])){
						$typeLists['other'] = new html('ul');
						$typeLists['other']->set('id', 'other');
					}
					$typeLists['other']->inject($this->getAList($row));
				}elseif($row['pageType']=='Combinations'){
				}else{
					$arrayLocation = array_search($row['pageType'], $pageType);
					if(FALSE===$arrayLocation){
						$pageType[]= $row['pageType'];
						$typeLists[$row['pageType']] = new html('ul');
						$typeLists[$row['pageType']]->set('id', $row['pageType']);
						$typeLists[$row['pageType']]->inject($this->getAList($row));
					}else{
						$typeLists[$row['pageType']]->inject($this->getAList($row));
					}
				}
			}
		}
		ksort($typeLists);
		//print_r($typeLists);
		foreach($typeLists as $key=> $value){
			$titleHTML = new html('a');
			$titleHTML->set('text', $key);
			$titleHTML->set('href', '#'.$key);			
			$titleHTML->set('class', 'heading');
			//$titleHTML->add($value);
			$listHTMLElement = new html('li');
			$listHTMLElement->inject($titleHTML);
			$listHTMLElement->inject($value);
			$this->listHTML->inject($listHTMLElement);
		}
	}
	public function setHTMLCombinationLinks($additionalFilesinFolderLinks, $title=''){
		$this->listHTML = new html('div');
		$this->listHTML->set('class', 'rightContinue');
		$pageType = array();
		$typeLists =array();
		$counter =0;
				
		while ($row = mysql_fetch_assoc($additionalFilesinFolderLinks)){
			if(!($row && count($row))){
			}
			else{
				if($row['pageType']==NULL){
				}elseif($row['pageType']=='Combinations'){ 
					if(!isset($typeLists['Combinations'])){
						$typeLists['Combinations'] = new html('ul');
						$typeLists['Combinations']->set('class','rightList');
					}
					$typeLists['Combinations']->inject($this->getAList($row));
				}else{
				}
			}
		}
		
		ksort($typeLists);
		foreach($typeLists as $key=> $value){
			$titleHTML = new html('h2');
			
			if(!empty($title)){
				
				$titleHTML->set('text', $title);
			}else{
				$titleHTML->set('text', $key);
			}
			//$titleHTML->add($value);
			$this->listHTML->inject($titleHTML);
			$this->listHTML->inject($value);
		}
		//print_r($typeLists);
	}
}
?>