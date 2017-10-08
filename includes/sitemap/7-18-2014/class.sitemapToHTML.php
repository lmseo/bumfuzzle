<?php
class sitemapToHTML extends toHTML{
	private $listHTML;
	public function __construct(){
		parent::__construct();
	}
	public function __destruct(){
	}
	public function setTextUnorderedList($source, $label='', $container='div', $containerClass='',$listItemClass='rightBox'){
		$this->listHTML = new html($container);
		$recentHTML = new html('ul');
		while ($row = mysqli_fetch_assoc($source)){
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
		if($row['url'] != $_SERVER['REQUEST_URI'] && !empty($row['url']) && isset($row['url'])){
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
		while ($row = mysqli_fetch_assoc($source)){
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
		if($row['url'] != $_SERVER['REQUEST_URI'] && !empty($row['url']) && isset($row['url'])){
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
		}elseif($row['url'] == $_SERVER['REQUEST_URI'] && !empty($row['url']) && isset($row['url'])){
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
		while ($row = mysqli_fetch_assoc($additionalFilesinFolderLinks)){
			//echo '<pre>'.$row['url'] . ' ' . $row['pageType'].'</pre>';
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
		ksort($typeLists);
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
		while ($row = mysqli_fetch_assoc($additionalFilesinFolderLinks)){
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
				
		while ($row = mysqli_fetch_assoc($additionalFilesinFolderLinks)){
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
	public function getAlabelDrugClass($label, $labelType='strong', $labelClass='list-title', $container){
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
	public function getFlatListDrugClass($row){
		$recentHTML='';
		//echo '<pre>';print_r($_SERVER); echo '</pre>';
		if($row['url'] != $_SERVER['REQUEST_URI'] && !empty($row['url']) && isset($row['url'])){
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
	public function setTextParagraphListDrugClass($source, $label='', $separator=',', $container='span', $class=''){
		$recentHTML='';
		while ($row = mysqli_fetch_assoc($source)){
			if(!($row && count($row))){
			}
			else{
				if(empty($recentHTML)){
					$recentHTML.=$this->getFlatListDrugClass($row);
				}else{
					$recentHTML.=$separator. ' ' . $this->getFlatListDrugClass($row);
				}
			}
		}
		if(isset($recentHTML) && !empty($recentHTML)){
			$this->listHTML = $this->getAlabelDrugClass($label,'strong', $class, new html($container));
			if(!empty($class)){
				$this->listHTML->set('class',$class);
			}
			$recentHTML.='.';
			$this->listHTML->set('text',$recentHTML);
		}
	}
	public function getAlabelGenericDrug($label, $labelType='strong', $labelClass='list-title'){
		
		if(!empty($label)){
			$labelToHTML = new html($labelType);
			$labelToHTML->set('text', $label.' ');
			if(!empty($labelType)){
				$labelToHTML->set('class', $labelClass.' ');
			}
			/*if(isset($container) && get_class($container)=='html'){
				$container->inject($labelToHTML);
				return $container;
			}*/
			//print_r($labelToHTML);
			return $labelToHTML;
		}
		/*if($isList){
			$recentHTML= new html('li');
			$recentHTML->set('class', 'generic-list-item');
			$recentHTML->inject($labelToHTML);
			return $recentHTML;
		}else{
			return $labelToHTML;
		}*/
		return false;
	}
	//returns a string <a href="$url" class="$listClass">$row['name']</a> or 
	public function getListGenericDrug($row ,$isList=false,$label, $labelType='strong', $labelClass='list-title'){
		
		if($row['url'] != $_SERVER['REQUEST_URI'] && !empty($row['url']) && isset($row['url'])){
			if($row['uri'] == 'index.html'){
				$url = str_replace('index.html','',$row['url']) ; 
			}else{
				$url =$row['url'];
			}
			$recentContainerHTML = new html('a');
			$recentContainerHTML->set('href',$url);
			$recentContainerHTML->set('class', 'generic-name');
			$recentContainerHTML->set('itemprop', 'activeIngredient');
			$recentContainerHTML->set('title',$row['title']);
			$recentContainerHTML->set('text', ucwords($row['name']));
			//$recentHTML.=$recentLinkHTML->getHTML();
		}elseif(!empty($row['name']) && isset($row['name'])){
				$recentContainerHTML = new html('span');
				$recentContainerHTML->set('class', 'generic-name');
				$recentContainerHTML->set('itemprop', 'activeIngredient');
				$recentContainerHTML->set('text', ucwords($row['name']));
				//$recentHTML.=$recentSpanHTML->getHTML();
		}
		if($isList){
			$recentHTML= new html('li');
			$recentHTML->set('class', 'generic-list-item');
			$label=$this->getAlabelGenericDrug($label,'span', 'generic-label');
			if(!$label){
			}else{
				$recentHTML->inject($label);
			}
			$recentHTML->inject($recentContainerHTML);
		}else{
			return $recentContainerHTML;
		}
		return $recentHTML;
	}
	public function setTextParagraphListGenericDrug($source, $label='', $separator=',', $container='span', $class=''){
		$isList=false;
		if($container=='ul' || $container=='ol'){
			$isList=true;
		}else{
			$isList=false;
		}
		if( isset($container) && !empty($container)){
			$this->listHTML = new html($container);
		}else{
			$this->listHTML = new html('span');
		}
		if(isset($this->listHTML) ){
			//$this->listHTML->inject($this->getAlabelGenericDrug($label,'span', 'generic-label', new html($container),$isList));
			if(!empty($class)){
				$this->listHTML->set('class',$class);
			}
			//$this->listHTML->inject($recentHTML);
		}
		if ($row = mysqli_fetch_assoc($source)){
			if(!($row && count($row))){
			}
			else{
				$this->listHTML->inject($this->getListGenericDrug($row,$isList,$label,'span', 'generic-label'));
				
			}
		}

	}
}
?>