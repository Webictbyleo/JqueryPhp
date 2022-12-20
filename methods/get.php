<?php
defined('SAFE')or die();

class jqueryphp_methods_get extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run(){
			
			return $this->node->DOMel;
			
		}
		
		public function get(){
			
			return $this->node->DOMel;
		}
		
		
}


?>