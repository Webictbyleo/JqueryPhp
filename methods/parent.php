<?php
defined('SAFE')or die();

class jqueryphp_methods_parent extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
			
		}
		
		public function run(){
			$path = $this->node->_path;
			
			$el = $this->__toDomElement();
			$doc = jqm_use($this->node->_parentElement);
							
				
				if($el->parentNode){
			$content = $el->ownerDocument->saveHtml($el->parentNode);
			$node = $this->createFragment($content,false);
				if(is_a($node,jqmel)){
					$node->_path = $el->parentNode->getNodePath();
					$node->setDomID($this->node->_parentElement.$this->node->_token);
					
				
				
				$this->node = $node;
				
				return $this;
					}
				}else{
					return new jqueryphp_abstracts_prevObject($this->node->_selector.':parent(*)');
				}
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}

?>