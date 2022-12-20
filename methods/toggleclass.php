<?php
defined('SAFE')or die();

class jqueryphp_methods_toggleclass extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($classes=NULL){
			
			if($classes){
				if(is_callable($classes)){
						if(is_a($classes,Closure)){
							$callback = Closure::bind($classes,$this->node);
								}
							$classes = call_user_func($callback,$attr['class']);
							if(!is_scalar($classes))return;
					}
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