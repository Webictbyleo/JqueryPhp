<?php
defined('SAFE')or die();

class jqueryphp_methods_contents extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($query='*'){
			$dom = $this->node->__toDomElement();
			
					
			if($dom->childNodes->length > 0){
						
						$nodes = array();
						
					$iterator = range(0,$dom->childNodes->length-1);
					$nodes = array_map(function($i)use($dom){
						return $dom->childNodes->item($i);
					},$iterator);
					$this->node = new jqueryphp_abstracts_nodelist($nodes);
					return $this;
			}else{
				$this->node= new jqueryphp_abstracts_prevObject($this->node->_selector.':contents(*)');
				return $this;
			}
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}

?>