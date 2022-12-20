<?php
defined('SAFE')or die();

class jqueryphp_methods_nextUntil extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($selector){
			
			$dom = $this->node->__toDomElement();
			
			 $ns = jqm_use($this->node->_parentElement);
			$sc = $ns->match_selector($selector);
			$node = $dom;
			
			$x = $ns->xpath($dom->ownerDocument);
			
				$find = $x->query($dom->getNodePath().'/following-sibling::node()');
				
				if($find->length){
						$iterator = range(0,$find->length-1);
					$node = $this->node;
				$nodes = array_map(function($i)use($find,$node,$selector,$dom){
					if(isset($dom->indexStop))return NULL;
						$item = $find->item($i);
						$ele = $node->exportNode($item);
							if($ele->is($selector)->get()){
								$dom->indexStop = $i;
								return NULL;
							}
						return $ele;
					},$iterator);
				if(is_array($nodes)){
					
					$nodes = array_values(array_filter($nodes));
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