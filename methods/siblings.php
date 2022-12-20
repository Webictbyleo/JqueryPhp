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
			$isxml = $this->isxml();
			$np = 'HTML';
			if($isxml)$np = 'XML';
				$next = $this->node->nextAll()->get();
				$prev = $this->node->prevall()->get();
				$nodes = array();
				if($prev->length){
					$nodes = $prev->toArray();
				}
					if($next->length){
						$nodes = array_merge($nodes,$next->toArray());
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