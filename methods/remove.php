<?php
defined('SAFE')or die();

class jqueryphp_methods_remove extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run(){
			
			$document = jqm_use($this->node->_parentElement);
			
			$doc = $document->_DOM;
						if($doc->doctype){
					$doc->removeChild($doc->doctype);
						}
			
			
			
				$pt = $this->node->getPathByID();
				
						if($pt){
				$path = new DomXpath($doc);
						$get = $path->query($pt);
						
							if($get->length > 0){
								
								$this->node->_attributes = array();
			$this->node->_innerHtml = NULL;
			$this->node->_name = NULL;
			$this->node->_localName = NULL;
			$this->node->_length = false;
						
						$save = $get->item(0)->parentNode->removeChild($get->item(0));
						
					$document->offsetUnset($this->node->_token);
							
							}
						}else{
							$document->offsetUnset($this->node->_token);
							$this->node->_length = false;
						}
						
					
		}
		
		public function get(){
			
			return false;
		}
		
		
}


?>