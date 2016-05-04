<?php
defined('SAFE')or die();

class jqueryphp_methods_not extends jqueryphp_abstracts_document{
	
	protected static $node;
		private $done;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($new = Null){
			$this->done = ($this->node->is($new)->get() !==true);
			
		}
		public function get(){
			
			return $this->done;
		}
		
		public function __toString(){
			return isset($this->done) ? false:false;
		}
}

?>