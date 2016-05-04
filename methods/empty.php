<?php
defined('SAFE')or die();

class jqueryphp_methods_empty extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run(){
			$this->node->_innerHtml = NULL;
			$this->node->_innerText = NULL;
			$this->node->saveHtml();
			return $this;
		}
		
		public function get(){
			
			return true;
		}
		
		
}


?>