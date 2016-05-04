<?php
defined('SAFE')or die();

class jqueryphp_methods_removeAttr extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($key=NULL){
			
			$attr = $this->node->_attributes;
			
			unset($attr[$key]);
				$this->node->_attributes = $attr;
				
				$save = $this->node->saveHtml();
			
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>