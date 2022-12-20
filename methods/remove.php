<?php
defined('SAFE')or die();

class jqueryphp_methods_remove extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run(){
			
				$dom = $this->node->__toDomElement();	
						if($dom){
				
					if($dom->parentNode){
					$dom->parentNode->removeChild($dom);
					}else{
						//$dom->ownerDocument->removeChild($dom);
					}
			
			$this->node->_attributes = array();
			$this->node->_innerHtml = NULL;
			$this->node->_attrMap = NULL;
			$this->node->_innerText = NULL;
			$this->node->DOMel = NULL;
			$this->node->style = NULL;
			$this->node->_name = NULL;
			$this->node->_localName = NULL;
			$this->node->_length = false;
			$this->node->_content = null;
						
					
							
							
						}
						
					
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>