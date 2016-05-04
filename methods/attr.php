<?php
defined('SAFE')or die();

class jqueryphp_methods_attr extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		protected $key;
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($attr=NULL,$value){
			if(empty($attr)){
					return $this->node->_attributes;
				}
				$this->key = $attr;
			$attri = $this->node->_attributes;
			$attr_value = func_get_arg(1);
			
			
			
						
							if(is_array($attr)){
								
									$attr_value = array_values($attr);
									
									/* $attr_value =  preg_replace('#[^\w\-\/\.]#','.',implode('|',$attr_value));
									
										if($attr_value){
											$attr_value =explode('.',$attr_value);
										} */
										
										$keys = array_keys($attr);
										
								$attr = @array_combine($keys,$attr_value);
								$attri = array_merge($attri,$attr);
								
							}elseif(is_scalar($attr) AND isset($value) AND !empty($attr)){
								
						$attri[$this->key] = preg_replace('#[^\w\-\/\.]#','',func_get_arg(1));
							}
						$this->node->_attributes = $attri;
						$this->node->saveHtml();
						
					
					return $this;
		}
		
		public function get(){
			
			if(isset($this->key)){
				return $this->node->_attributes[$this->key];
			}
			return $this->node->_attributes;
		}
		
		
}


?>