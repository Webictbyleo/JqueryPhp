<?php
defined('SAFE')or die();

class jqueryphp_methods_text extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($str){
				if(isset($str)){
			$this->node->_innerHtml = strip_tags($str);
			$this->node->_innerText = $this->node->_innerHtml;
			$save = $this->node->saveHtml();
				}
			return $this;
		}
		
		public function get(){
			
			return $this->node->_innerText;
		}
		
		
}


?>