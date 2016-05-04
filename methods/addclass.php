<?php
defined('SAFE')or die();

class jqueryphp_methods_addClass extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($classes=NULL){
			
				if($classes !=null){
					$attr = $this->node->_attributes;
					
					if(!preg_match('/([\'"])+/',$attr['class'],$m)){
						$m[1] = '"';
					}
					$attr['class'] = trim($attr['class'],$m[1]);
					$classmap = explode(' ',$attr['class']);
					$find = str_ireplace($classes,'*jqmclass',$classmap,$c);
					
					
						if($c==false){
							$classmap[] = $classes;
						}
						
						$attr['class'] = preg_replace('#[\.\'\"\']#','',implode(' ',$classmap));
						$this->node->_attributes = $attr;
						
						$save = $this->node->saveHtml();
						
						
						
				}
			return $this->node;
			
		}
		
		public function get(){
			
			return true;
		}
		
		
}


?>