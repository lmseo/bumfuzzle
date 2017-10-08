<?php
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/drug-master-10-13-10/class.page.php');
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/drug-master-10-13-10/widgets/class.breadcrumb.php');
require_once( $_SERVER['DOCUMENT_ROOT'] . '/includes/utilities/html/class.html.php');

require_once( 'class.indexSource.php');
require_once( 'class.indexToHTML.php');

class indexNewsletterPage extends page{
	private $dbTable;
	private $pageSource;
	private $indexSource,
			$isIndexSourceSet;
	private $indexMainContent;
		private $isIndexContentSet;

	public function __construct($table, $max=2011 , $min=2011){
		parent::__construct($table);
		$this->newsletterPageSource = parent::getPageSource();
		$this->dbTable = $table;
		if(!($this->indexSource = indexNewsletterSource::_getIndexSource($this->dbTable, $max, $min))){
			$this->isIndexSourceSet = false;
			echo 'Content Missing';
		}
		else{
			$this->isIndexSourceSet = true;
			$this->indexMainContent = new indexNewsletterToHTML();
			$this->isIndexContentSet = $this->_setIndexContent();
		}
	}
	public function __destruct(){
	}
	public function _setIndexSource($table, $max=2011 , $min=2011){
		print_r($this->indexMainContent);
		unset($this->indexSource);
		unset($this->indexMainContent);
		
		if(!($this->indexSource = indexNewsletterSource::_getIndexSource($table, $max, $min))){
			$this->isIndexSourceSet = false;
			echo 'Content Missing';
		}
		else{
			$this->isIndexSourceSet = true;
			$this->indexMainContent = new indexNewsletterToHTML();
			$this->isIndexContentSet = $this->_setIndexContent();
		}
	}
	public function _setIndexContent(){	
		if(!($this->indexSource && mysql_num_rows($this->indexSource))){
		  return false;
		}
		else{
			$this->indexMainContent->_setMainColumnHTML();
			$i=0;
			while($row = mysql_fetch_assoc($this->indexSource)){
				if($i !=  mysql_num_rows($this->indexSource) && $i !=  0 ) {
					$this->indexMainContent->columnGroupHTML(0 , $row);
				}
				else if($i ==  0){
					$this->indexMainContent->columnGroupHTML(1 , $row);
				}
				else if($i ==  mysql_num_rows($this->indexSource)-1) {
					$this->indexMainContent->columnGroupHTML(2 , $row);
				}
				  $i++;
			}
			mysql_data_seek($this->indexSource, 0);
		}
		return true;
	}
	public function printIndexContent(){
		if($this->isIndexSourceSet && $this->isIndexContentSet)
			echo $this->indexMainContent->_getMainColumnHTML();
		unset($this->indexMainContent);
	}
}
?>