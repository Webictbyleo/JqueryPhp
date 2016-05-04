<?php
defined('SAFE')or die();

class jqueryphp_methods_removeClass extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($classes){
			$class = $this->node->_attributes['class'];
			if(is_scalar($classes)){
					$classes = array_filter(explode(' ',$classes));
				}
				$class = str_ireplace($classes,'',$class);
				$attr = $this->node->_attributes;
				$attr['class'] = $class;
				$this->node->_attributes = $attr;
				$save = $this->node->saveHtml();
			
		}
		
		public function get(){
			
			return $this->node->_content;
		}
		
		
}


?>