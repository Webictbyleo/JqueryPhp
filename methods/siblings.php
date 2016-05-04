<?php
defined('SAFE')or die();

class jqueryphp_methods_siblings extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($selector=NULL){
			
			$dom = $this->node->__toDomElement();
			
			 $ns = jqm_use($this->node->_parentElement);
			
			$done = true;
			$node = $dom;
			$prev = $next = $node;
				while($done!=false){
						if($prev->previousSibling){
							$prev = $prev->previousSibling;
								if($prev->nodeType == 1){
							$el = $this->createFragment($dom->ownerDocument->saveHtml($prev),false);
							$el->_path = $prev->getNodepath();	
							if(is_a($el,jqmel)){
							$el->_parentElement = $this->node->_parentElement;
							$el->_parent_path = $this->node->_parent_path;
							$el->_prev_path = $this->node->_prev_path;
							$el->_next_path = $this->node->_next_path;
							$el->setDomID($this->node->_parentElement.$this->node->_token);
							$el->selector = $ns->match_selector($prev->tagName.'[data-dom-id="'.key($el->_domId).'"]',$el->_path.'::',false);
								if(!empty($selector)){
							$is = $el->is($selector)->get();
								if($is ===true){
									$nodes[] = $el;
								}
							}else{
								$nodes[] = $el;
							}
							
							}			
								}
						}
						if($next->nextSibling){
							$next = $next->nextSibling;
								if($next->nodeType == 1){
							$el = $this->createFragment($dom->ownerDocument->saveHtml($next),false);
							$el->_path = $next->getNodepath();	
							if(is_a($el,jqmel)){
							$el->_parentElement = $this->node->_parentElement;
							$el->_parent_path = $this->node->_parent_path;
							$el->_prev_path = $this->node->_prev_path;
							$el->_next_path = $this->node->_next_path;
							$el->setDomID($this->node->_parentElement.$this->node->_token);
							$el->selector = $ns->match_selector($next->tagName.'[data-dom-id="'.key($el->_domId).'"]',$el->_path.'::',false);
							if(!empty($selector)){
								
							$is = $el->is($selector)->get();
							
								if($is ===true){
									$nodes[] = $el;
								}
							}else{
								$nodes[] = $el;
							}
							}			
								}
						}
						
						
						if(!$prev->previousSibling AND !$next->nextSibling){
							$done = false;
							break;
						}
				}
				unset($next);
				unset($prev);
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