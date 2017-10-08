<?php
class indexToHTML{
	private $mainColumn;
		private $columnGroupHTML;
	private $leftColumn, $rightColumn;
	
	public function __construct(){
		$this->mainColumn = new html('div');
	}
	public function __destruct(){
	}
	public function _setMainColumnHTML(){
		$this->mainColumn->set('class',"bColumn column");
		$dividerHTML = new html('div');
		$dividerHTML->set('class',"doubleRuleDivider");
		$this->mainColumn->inject($dividerHTML);
	}
	public function columnGroupHTML($position=0, $articleArray){
		$columnGroupHTML = new html('div');
		if($position==0){
			$columnGroupHTML->set('class','columnGroup');
		}
		elseif($position==1){
			$columnGroupHTML->set('class','columnGroup first');
		}
		elseif($position==2){
			$columnGroupHTML->set('class','columnGroup last');
		}
		$storyHTML = new html('div');
		$storyHTML->set('class','story');
		$h5HTML = new html('h5');
		$aHTML = new html('a');
		$aHTML->set('href', $articleArray['url']);
		$aHTML->set('text',$articleArray['title']);
		$h6HTML = new html('div');
		$h6HTML->set('class','byline');
		$h6HTML->set('text', 'By ' . $articleArray['author']);
		$timeHTML = new html('span');
		$timeHTML->set('class','timestamp');
		$timeHTML->set('text', ' ' . date('F d, Y h:i:s A', strtotime($articleArray['dateCreated'])));
		$excerptHTML = new html('p');
		$excerptHTML->set('class','excerpt');
		$excerptHTML->set('text',$articleArray['excerpt']);
		$h5HTML->inject($aHTML);
		$h6HTML->inject($timeHTML);
		$storyHTML->inject($h5HTML);
		$storyHTML->inject($h6HTML);
		$storyHTML->inject($excerptHTML);
		$columnGroupHTML->inject($storyHTML);
		$this->mainColumn->inject($columnGroupHTML);
	}
	public function _getMainColumnHTML(){
		return $this->mainColumn->getHTML();
	}
}
?>