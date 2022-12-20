<?php
defined('SAFE')or die();

class jqueryphp_methods_hasAttr extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		private $done;
		public  function __construct(&$ele){
			$this->node  = $ele;
		}
		
		public function run($name){
				
				$def = $this->__toDomElement();
				
				$this->done = $def->hasAttribute($name);
						
			return $this->done;
			
		}
		
		public function get(){
			
			return $this->done;
		}
		
}


?>