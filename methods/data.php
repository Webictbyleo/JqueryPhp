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
			$vars = get_object_vars($this->node);
				if(empty($attr)){
					return $vars;
				}
				
				$this->key = $attr;
				
					if(!is_null($attr_value)){
						$this->node->{$this->key} = $attr_value;
							if(!array_key_exists($this->key,$vars)){
						$this->data[$this->key] = $attr_value;
							}
					}
					
					
				return $this->node->{$this->key};
			
		}
		
		public function get(){
			if(isset($this->key)){
				return $this->node->{$this->key};
			}
			return get_object_vars($this->node);
		}
		
		
}


?>