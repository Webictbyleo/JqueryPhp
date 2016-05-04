<?php
defined('SAFE')or die();

class jqueryphp_methods_children extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($query='*'){
			$dom = $this->node->__toDomElement();
			if($dom->childNodes->length > 0){
						if(empty($query))$query = '*';
						$nodes = array();
						$ns = jqm_use($this->node->_parentElement);
					for($i=0;$dom->childNodes->length > $i;$i++){
						$child = $dom->childNodes->item($i);
						if($child->nodeType !==1)continue;
						$el = $this->createFragment($child->ownerDocument->savehtml($child),false);
						$el->_path = $child->getNodepath();
						$el->setDomID($this->node->_parentElement.$this->node->_token);
						$el->selector = $ns->match_selector($child->tagName.'[data-dom-id="'.key($el->_domId).'"]',$el->_path.'::',false);
							$is = $el->is($query);
									if($is->get() !==true)continue;
									if($child->nextSibling){
										$el->_next_path = $child->nextSibling->getNodepath();
									}else{
										$el->_next_path = NULL;
									}
									if($child->previousSibling){
										$el->_prev_path = $child->previousSibling->getNodepath();
									}else{
										$el->_prev_path = NULL;
									}
									if($child->parentNode){
										$el->_parent_path = $child->parentNode->getNodepath();
									}else{
										$el->_parent_path = NULL;
									}
									$nodes[] = $el;
									unset($el);
					}
					
					$this->node = new jqueryphp_abstracts_nodelist($nodes);
					return $this;
			}else{
				$this->node= new jqueryphp_abstracts_prevObject($this->node->_selector.':children(*)');
				return $this;
			}
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}

?>