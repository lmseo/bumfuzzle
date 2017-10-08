<?php 
/* creates an html element, like in js */ 
class html{ 
	/* vars */ 
	private $type;
	private $attributes;
	private $self_closers;
	private $items;
	private $html;
	private $nested;
	/* constructor */ 
	public function __construct($type, $text='' ,$self_closers = array('input','img','hr','br','meta','link')){
		$this->attributes = array();
		$this->type = strtolower($type);
		$this->self_closers = $self_closers;
		$this->nested = 0;
		if($text!=''){
			foreach($self_closers as $value){
				if($value!=$type){
					$this->set('text',$text);
				}
			}
		}
	} 
	public function __destruct(){
	}
	/* get */ 
	public function get($attribute){ 
		return $this->attributes[$attribute];
	} 
	/* set&mdasharray or key,value */ 
	public function set($attribute,$value = ''){ 
		if(!is_array($attribute) && isset($value)){ 
		  if(isset($this->attributes[$attribute])){
			if($attribute=='class'){
				$this->attributes[$attribute].= ' ' . $value;
		  	}else{
		  		$this->attributes[$attribute].= $value;
			}
		  }else{
		  	$this->attributes[$attribute]= $value;
		  }
		}
		elseif(isset($value)){
		  $this->attributes = array_merge($this->attributes,$attribute);
		}
	}
	/* remove an attribute */ 
	public function remove($att){
		if(isset($this->attributes[$att])){
		  unset($this->attributes[$att]);
		}
	}
	/* clear */ 
	public function clear(){
		$this->attributes = array();
	}
	/* inject */
	public function inject($object){
		if(@get_class($object) == __class__){
			if(!isset($this->attributes['text'])){
				$this->attributes['text'] ='';
				$this->attributes['text'].= $object->rdd();
			}
			else
				$this->attributes['text'].= $object->rdd();
		}
	}
	/* build */ 
	private function rdd(){
		$build = '<'.$this->type;
		//add attributes
		if(count($this->attributes)){
			foreach($this->attributes as $key=>$value){
			  if($key != 'text') { $build.= ' '.$key.'="'.$value.'"'; }
			} 
		}
		//closing
		if(!in_array($this->type,$this->self_closers)){
			if(!isset($this->attributes['text']))
				$build.= '></'.$this->type.'>';
			else
				$build.= '>'.$this->attributes['text'].'</'.$this->type.'>';
		}
		else{
		  $build.= ' />';
		}
		//return it 
		return $build;
	}
	public function build(){//start
		$this->html = $this->rdd();
		if(isset($this->items) and count($this->items)>0){
			foreach($this->items as $key=>&$value){
				if($value['item']->isNested()){
					$this->html .=$value['item']->build();
				}
				else{
					$value['text'] = $value['item']->rdd();
					if($value['pos']=='a'){
						$this->html .= $value['text'];
					}
					if($value['pos']=='b'){
						$this->html = $value['text'] . $this->html;
					}
				}
			}
		}
		else{
		}
		return $this->html;
	}
	public function add(&$object, $position='a'){
		if(@get_class($object) == __class__){
		  $this->items[] = array('item'=>$object, 'pos'=>$position);
		  $this->nested = 1;
		}
	}
	/* spit it out */ 
	public function output(){
		echo $this->build();
	}
	public function isNested(){
		if(isset($this->items) and count($this->items)>0){
			
			return $this->nested =1;
		}
		else{
			return $this->nested =0;
		}
	}
	public function getItems(){
		return $items;
	}
	public function getHTML(){
		if($this->html !='' and isset($this->html)){
			return $this->html;
		}
		else{
			return $this->build();
		}
	}
}
?>