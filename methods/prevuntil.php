<?php
defined('SAFE')or die();

class jqueryphp_methods_prevUntil extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($selector=NULL){
			
			$dom = $this->node->__toDomElement();
			
			 $ns = jqm_use($this->node->_parentElement);
			
			$done = true;
			$node = $this->node;
			$x = $ns->Xpath($dom->ownerDocument);
				$find = $x->query($dom->getNodePath().'/preceding-sibling::node()');
				
					if($find->length > 0){
						$iterator = range(0,$find->length-1);
				$nodes = array_map(function($i)use($find,$node,$selector,$dom){
					if(isset($dom->indexStop))return NULL;
						$item = $find->item(($find->length-1)-$i);
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