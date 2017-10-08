<?php
class contactToHTML extends toHTML{
	private $listHTML;
	public function __construct(){
		parent::__construct();
	}
	public function __destruct(){
	}
	
	/*<select  id="drugs">
<option value=""></option>
</select>*/
	public function setTextFormList($additionalFilesinFolderLinks, $id='', $class=''){
		$this->listHTML = new html('select');
		$this->listHTML->set('id',$id);
		$this->listHTML->set('name',$id);
		$optionHTML = new html('option');
		$optionHTML->set('text','');
		$optionHTML->set('value','');
		$optionHTML->set('text','');
		$this->listHTML->inject($optionHTML);
		while ($row = mysql_fetch_assoc($additionalFilesinFolderLinks)){
			if(!($row && count($row))){
			}
			else{				
				if(isset($row['name']) && isset($row['value'])){
					$recentHTML = new html('option');
					$recentHTML->set('text',$row['name']);
					$recentHTML->set('value',$row['value']);
					$this->listHTML->inject($recentHTML);
				}else{
					unset($this->listHTML);
				}
			}
		}
	}
	public function getList(){
		return $this->listHTML;
	}
}
?>