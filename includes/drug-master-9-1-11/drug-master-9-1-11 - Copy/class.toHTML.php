<?php
class toHTML{
	private $listHTML, $breadCrumbComplete;
	public function __construct($container='ul'){
		$this->listHTML = new html($container);
	}
	public function __destruct(){
	}
	public function getListHTML(){
		return $this->listHTML;
	}
	public function setListHTML($container){
		$this->listHTML = new html($container);
	}
	public function setBreadCrumbHTML($breadCrumbSource){
		for($a=0;$a<count($breadCrumbSource)-1;$a++){
			$this->breadCrumbComplete .= $this->getBreadCrumbLinks($breadCrumbSource[$a]['url'], $breadCrumbSource[$a]['text'], $breadCrumbSource[$a]['title']);	
		}
		$lastElement =  end($breadCrumbSource);
		if($lastElement['text']!=''){
			$linksContainerHTML = new html('div');
			$linksContainerHTML->set('itemscope','');
			$linksContainerHTML->set('itemtype','http://data-vocabulary.org/Breadcrumb');
			$linksContainerHTML->set('class','breadcrumb-element');
			
			$linkstHTML = new html('span');
			$linkstHTML->set('text', $lastElement['text']);
			$linkstHTML->set('class','breadcrumb-last-element');
			$linkstHTML->set('itemprop','title');
			
			$linksContainerHTML->inject($linkstHTML);
			$this->breadCrumbComplete .= $linksContainerHTML->getHTML();
		}
	}
	public function getBreadCrumbHTML(){
		return $this->breadCrumbComplete;
	}
	public function getBreadCrumbLinks ($url='', $text, $title){
		if($url != '' or !isset($url)){
			$linksContainerHTML = new html('div');
			$linksContainerHTML->set('itemscope','');
			$linksContainerHTML->set('itemtype','http://data-vocabulary.org/Breadcrumb');
			$linksContainerHTML->set('class','breadcrumb-element');


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
			$linksContainerHTML = new html('div');
			$linksContainerHTML->set('itemscope','');
			$linksContainerHTML->set('itemtype','http://data-vocabulary.org/Breadcrumb');
			$linksContainerHTML->set('class','breadcrumb-element');
			
			$linkstHTML = new html('span');
			$linkstHTML->set('text', $text);
			$linkstHTML->set('itemprop','title');
			
			$linksContainerHTML->inject($linkstHTML);
			$linksContainerHTML->set('text',' &gt; ');
			return $linksContainerHTML->getHTML();
		}
	}
	public function getAdditionalBox($content, $title='Additional Information', $class='rightInside', $headerClass='additional-header'){
		$linksHTML = new html('div');
		$linksHTML->set('class',$class );
		$titleHTML = new html('h2');
		$titleHTML->set('class', $headerClass);
		$titleHTML->set('text',  $title);
		$linksHTML->inject($titleHTML);
		$linksHTML->set('text',$content);
		
		return $linksHTML->getHTML();
	}
	public function getRightBox($content, $title='Additional Information', $class='rightContinue',$headerClass='additional-header'){
		$linksHTML = new html('div');
		$linksHTML->set('class',$class );
		$titleHTML = new html('h2');
		$titleHTML->set('class', $headerClass);
		$titleHTML->set('text',  $title);
		$linksHTML->inject($titleHTML);
		$linksHTML->set('text',$content);
		
		return $linksHTML->getHTML();

		/*$boxHTML = new html('div');
		$boxHTML->set('class', 'rightbox');
		
		$boxHeadHTML = new html('div');
		$boxHeadHTML->set('class', 'rightbox-head');*/
		
		/*$titleHTML = new html('h2');
		$titleHTML->set('text', $title);
		
		$boxHTML = new html('div');
		$boxHTML->inject($titleHTML);
		$boxHTML->set('class', 'rightbox-body');
		$boxHTML->set('text', $content);*/
		
		/*$boxBottomHTML = new html('div');
		$boxBottomHTML->set('class', 'rightbox-bottom');
		$emptyHTML = new html('div');
		$boxBottomHTML->inject($emptyHTML);*/
		
		
		/*$boxHeadHTML->inject($titleHTML);
		$boxHTML->inject($boxHeadHTML);
		$boxHTML->inject($boxBodyHTML);
		$boxHTML->inject($boxBottomHTML);*/
	}
	public function setLinkArrayforRightBox($rightNavBarLinks){
		$this->listHTML = new html('ul');
		$this->listHTML->set('class','rightList');
		
		while ($row = mysql_fetch_assoc($rightNavBarLinks)){
				if(!($row && count($row))){
				}
				else{
					//$newToHTML->setLinkArrayforRightBox($row['url'], $row['title'], $row['anchor']);
					$recentHTML = new html('li');
					$recentHTML->set('class','rightBox');
					if($row['url'] != str_replace('index.html','',$_SERVER['PHP_SELF'])){
						$recentLinkHTML = new html('a');
						$recentLinkHTML->set('href',$row['url']);
						$recentLinkHTML->set('title',$row['title']);
						$recentLinkHTML->set('text', ucwords($row['anchor']));
						$recentHTML->inject($recentLinkHTML);
					}else{
						$recentHTML->remove('class');
						$recentHTML->set('class', 'current-page');
						$recentHTML->set('text', ucwords($row['anchor']));
					}
					$this->listHTML->inject($recentHTML);
				}
			}
	}
	public function getLinkArrayforRightBox(){
		return $this->listHTML->getHTML();
	}
	public function setLinkArrayforAdditionalBox($additionalFilesinFolderLinks){
		$this->listHTML = new html('ul');
		$this->listHTML->set('class', 'rightList');
		while ($row = mysql_fetch_assoc($additionalFilesinFolderLinks)){
			if(!($row && count($row))){
			}
			else{				
				$recentHTML = new html('li');
				$recentHTML->set('class','rightBox');
				if($row['url'] != $_SERVER['PHP_SELF'] && !empty($row['url'])){
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
				}else{
					$recentHTML->remove('class');
					$recentHTML->set('class', 'current-page');
					$recentHTML->set('text', ucwords($row['anchor']));
				}
				$this->listHTML->inject($recentHTML);
			}
		}
	}
	public function getLinkArray(){
		return $this->listHTML->getHTML();
	}
	public function getSubscribeForm(){
		$form ='<form action="/contact/subscribe/contactform.php" method="post" name="subscribe" id="subscribe" onsubmit="return checkbae()"><p><input type="hidden" name="sitename" value="Opiates.com" /><input type="hidden" name="contactmethod2" value="1" /><input type="hidden" name="heardfrom " value=" " /><input type="hidden" name="heardabout" value=" " /><input type="hidden" name="city" value=" " /><input type="hidden" name="state" value=" " /><input type="hidden" name="address" value=" " /><input type="hidden" name="zip" value=" " /><input name="redirect" type="hidden" id="redirect" value="sending.php" /><input name="subject" type="hidden" id="subject" value="Information Request from Opiates.com" /></p><div class="subscribe-body"><div class="subscribe-text"><img src="http://www.opiatedetox.org/opiates-com/images/main/internal/additional/check-mark.jpg" width="21" height="20"  alt="Check Mark"/>Weekly newsletter</div><div class="input-wrapper"><div class="email-text">EMAIL:</div><input name="email" type="text" class="form" size="8" style="" /><input name="submit2" type="submit" class="submit" value="Subscribe" title="Get Updates By Email From The Waismann Method" /></div></div></form>';
		return $form;
	}
}
?>