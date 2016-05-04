<?php
defined('SAFE')or die();

class jqueryphp_methods_toggleclass extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($classes=NULL){
			
			if($classes){
				
					if($this->node->hasClass($classes)->get() ===true){
						$this->node->removeClass($classes);
					}else{
						$this->node->addClass($classes);
					}
			}
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}

?>