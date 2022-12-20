<?php
defined('SAFE')or die();

class jqueryphp_methods_position extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_document &$ele){
			$this->node  = $ele;
		}
		
		public function run(){
			return $this;
			
		}
		
		public function get(){
			
			return $this->node->key();
		}
		
		
}


?>