<?php
defined('SAFE')or die();

class jqueryphp_methods_parents extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($query='*'){
			$path = explode('/',$this->node->_path);
			
			$el = $this->__toDomElement();
			$document = jqm_use($this->node->_parentElement);
			
					
				if(count($path) > 0){
						
					if($query ===NULL || $query =='*'){
						$query = $el->parentNode->tagName;
					}
						$t = count($path);
					
			
			$doc = $document->_DOM;
					
						if($doc->doctype){
					$doc->removeChild($doc->doctype);
						}
						
						$xpath = new DomXpath($doc);
						
						for($i=0; $t > $i;){
							array_pop($path);
							++$i;
							if(empty($path))continue;
							$find = $xpath->query(implode('/',$path));
							if($find->length > 0){
								$el = $this->createFragment($doc->saveHtml($find->item(0)),false);
								$k = key($el->_domId);
								
								$is = $el->is($query);
								
								if($is->get()===true){
									$el->_path = $find->item(0)->getNodepath();
									if($find->item(0)->nextSibling){
										$el->_next_path = $find->item(0)->nextSibling->getNodepath();
									}else{
										$el->_next_path = NULL;
									}
									if($find->item(0)->previousSibling){
										$el->_prev_path = $find->item(0)->previousSibling->getNodepath();
									}else{
										$el->_prev_path = NULL;
									}
									if($find->item(0)->parentNode){
										$el->_parent_path = $find->item(0)->parentNode->getNodepath();
									}else{
										$el->_parent_path = NULL;
									}
									$el->selector = $document->match_selector($query);
									$this->node = $el;
									$this->node->setDomID($el->_parentElement.$el->_token);
									return $this;
									break;
								}
							}
						}
					
				$this->node= new jqueryphp_abstracts_prevObject($this->node->_selector.':parent(*)');
				return $this;
					}
				else{
					return $this->node=new jqueryphp_abstracts_prevObject($this->node->_selector.':parent(*)');
				}
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}

?>