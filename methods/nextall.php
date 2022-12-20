<?php
defined('SAFE')or die();

class jqueryphp_methods_nextAll extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run(){
			
			$dom = $this->node->__toDomElement();
			
			 $ns = jqm_use($this->node->_parentElement);
			 
			$xpath = $ns->xpath($dom->ownerDocument);
			$find = $xpath->query($dom->getNodePath().'/following-sibling::*');
				if($find->length > 0){
					$iterator = range(0,$find->length-1);
					$node = $this->node;
				$nodes = array_map(function($i)use($find,$node){
						$item = $find->item($i);
						$ele = $node->exportNode($item);
						return $ele;
					},$iterator);
					
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