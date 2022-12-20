<?php
defined('SAFE')or die();

class jqueryphp_methods_removeClass extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($classes=NULL){
			$class = $this->node->_attributes['class'];
			$attr = $this->node->_attributes;
				if(is_null($classes)){
					$attr['class'] = '';
					$this->__toDomElement()->setAttribute('class',$attr['class']);
				$this->node->_attributes = $attr;
					return $this;
				}
				if(is_callable($classes)){
						if(is_a($classes,Closure)){
							$callback = Closure::bind($classes,$this->node);
								}
							$classes = call_user_func($callback,$attr['class']);
							if(!is_scalar($classes))return;
					}
			if(is_scalar($classes)){
					$classes = array_filter(explode(' ',$classes));
				}
				
				rsort($classes);
				$class = str_ireplace($classes,'',$class);
				$attr['class'] = trim($class);
				$this->node->_attributes = $attr;
				$this->__toDomElement()->setAttribute('class',$attr['class']);
				//$save = $this->node->saveHtml();
			
		}
		
		public function get(){
			
			return $this->node->_content;
		}
		
		
}


?>