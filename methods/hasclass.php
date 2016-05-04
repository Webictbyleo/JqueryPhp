<?php
defined('SAFE')or die();

class jqueryphp_methods_hasclass extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		private $found;
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($classes){
				$classmap = $this->node->_attributes['class'];
				if(is_scalar($classes)){
					$classes = array_filter(explode(' ',$classes));
				}
			
			$find = str_ireplace($classes,'*jqmclass',$classmap,$c);
			
				if($c > 0){
					$this->found = true;
				}else{
					$this->found = false;;
				}
				
		}
		
		public function get(){
			
			return $this->found;
		}
		
		public function __toString(){
			
			return $this->get();
		}
		
		
		
		
}


?>