<?php
defined('SAFE')or die();

class jqueryphp_methods_attr extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		protected $key;
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($attr=NULL,$value=NULL){
			if(empty($attr)){
					return $this->node->_attributes;
				}
				$this->key = $attr;
			$attri = $this->node->_attributes;
			
			$attr_value = func_get_arg(1);
						
							if(is_array($attr)){
								
									$attr_value = array_values($attr);
									
										$keys = array_keys($attr);
										
								$attr = @array_combine($keys,$attr_value);
								$attri = array_merge($attri,$attr);
								
							}elseif(is_scalar($attr) AND isset($value) AND !empty($attr)){
								
						$attri[$this->key] = func_get_arg(1);
						
							}
						
						if($attri !== $this->node->_attributes){
								$this->node->_attributes = $attri;
								$dom = $this->node->__toDomElement();
								foreach($attri as $k=>$v){
									$dom->setAttribute($k,$v);
								}
								//$this->node->saveHtml();
								
							}
						
					
					return $this;
		}
		
		public function get(){
			
			if(isset($this->key) AND is_scalar($this->key)){
				return $this->node->_attributes[$this->key];
			}
			return $this->node;
		}
		
		
}


?>