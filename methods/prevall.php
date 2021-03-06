<?php
defined('SAFE')or die();

class jqueryphp_methods_prevAll extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run(){
			
			$dom = $this->node->__toDomElement();
			
			 $ns = jqm_use($this->node->_parentElement);
			
			$done = true;
			$node = $dom;
				while($done!=false){
						if($node->previousSibling){
							$node = $node->previousSibling;
								if($node->nodeType !== 1)continue;
							$el = $this->createFragment($dom->ownerDocument->saveHtml($node),false);
							$el->_path = $node->getNodepath();
							$el->_parentElement = $this->node->_parentElement;
							$el->_parent_path = $this->node->_parent_path;
							$el->_prev_path = $this->node->_prev_path;
							$el->_next_path = $this->node->_next_path;
							$el->setDomID($this->node->_parentElement.$this->node->_token);
							$el->selector = $ns->match_selector($node->tagName.'[data-dom-id="'.key($el->_domId).'"]',$el->_path.'::',false);
							$nodes[] = $el;
							
						}else{
							$done = false;
							break;
						}
				}
					if(!isset($nodes) || empty($nodes)){
						return $this->node = new jqueryphp_abstracts_prevObject;
					}
					$this->node = new jqueryphp_abstracts_nodelist($nodes);
				return $this;
				
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>