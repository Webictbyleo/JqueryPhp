<?php
defined('SAFE')or die();

class jqueryphp_methods_parentsUntil extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($selector=NULL){
			
			$dom = $this->node->__toDomElement();
			
			 $ns = jqm_use($this->node->_parentElement);
			
			$done = true;
			$node = $dom;
				while($done!=false){
						if($node->parentNode){
							$node = $node->parentNode;
								if($node->nodeType !== 1)continue;
								
								if(is_a($selector,'DomElement') AND $node->isSameNode($selector)){$done = false;break;}
									
							$el = $this->createFragment($dom->ownerDocument->saveHtml($node),false);
							$el->_path = $node->getNodepath();
							if(is_a($selector,jqmel) AND $selector->_path===$el->_path){
								$done = false;
										break;
									}
							
							$el->_parentElement = $this->node->_parentElement;
							$el->_parent_path = $this->node->_parent_path;
							$el->_prev_path = $this->node->_prev_path;
							$el->_next_path = $this->node->_next_path;
							$el->setDomID($this->node->_parentElement.$this->node->_token);
							$el->selector = $ns->match_selector($node->tagName.'[data-dom-id="'.key($el->_domId).'"]',$el->_path.'::',false);
								if(!empty($selector)){
							$is = $el->is($selector)->get();
								if($is ===true){
									$done = false;
									break;
								}
								}
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