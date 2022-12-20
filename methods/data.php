<?php
defined('SAFE')or die();

class jqueryphp_methods_data extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		protected $key;
		public $data;
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($attr=NULL,$attr_value=NULL){
			
				if(empty($attr)){
					return get_object_vars($this->node);
				}
				
				$this->key = $attr;
				if($this->key=='_style' and is_array($attr_value)){
					if(isset($this->node->_style) and $this->node->_style InstanceOf jqueryphp_abstracts_cssStyle){
					$this->node->_style->setArray($attr_value);	
					}else{
						$this->node->_style = new jqueryphp_abstracts_cssStyle($attr_value);
					}
					return $this->node;
				}else if(in_array($this->key,['style','_style'])){
					$this->key = '_style';
					if(!$this->node->_style InstanceOf jqueryphp_abstracts_cssStyle){
					$this->node->_style = new jqueryphp_abstracts_cssStyle($this->node->_attributes['style']);
					}
				}
					if(!is_null($attr_value)){
						$this->node->{$this->key} = $attr_value;
							if(!property_exists($this->node,$this->key)){
						$this->data[$this->key] = $attr_value;
							}
					}
					
					
				return $this->node->{$this->key};
			
		}
		
		public function get(){
				
				//Implement data-value standard
				if(array_key_exists('data-'.$this->key,$this->node->_attributes)){
					return $this->node->_attributes['data-'.$this->key];
				}
			if(isset($this->key)){
				return $this->node->{$this->key};
			}
			return get_object_vars($this->node);
		}
		
		
}


?>