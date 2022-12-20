<?php
defined('SAFE')or die();

class jqueryphp_methods_slice extends jqueryphp_abstracts_document{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_document &$ele){
			$this->node  = $ele;
		}
		
		public function run($start=NULL,$end=NULL){
				if(is_numeric($start)){
			$map = $this->node->__documentMap;
			$map = array_slice($map,$start,$end);
			$this->node->__documentMap = $map;
			$this->node->__mapLength = count($map);
				}
			return $this->node;
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>