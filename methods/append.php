<?php
defined('SAFE')or die();

class jqueryphp_methods_append extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($str=NULL){
			if($str==NULL)return $this;
			$inner = $this->node->_innerHtml;
			$inner .= $str;
			$this->node->_innerHtml = $inner;
			$i = $this->node->savehtml();
			
			return $this;
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>