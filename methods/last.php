<?php
defined('SAFE')or die();

class jqueryphp_methods_last extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(&$ele){
			$this->node  = $ele;
		}
		
		public function run(){
			$this->node->seek($this->node->count() -1);
			$node = $this->node->current();
			$this->node = new jqueryphp_abstracts_nodelist(array($node));
			return $this;
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>