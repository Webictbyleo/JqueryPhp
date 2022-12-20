<?php
defined('SAFE')or die();

class jqueryphp_methods_height extends jqueryphp_abstracts_Window{
	
		
		protected static $node;
		
		public  function __construct(&$ele){
			$this->node  = $ele;
		}
		
		public function run($size=NULL){
				
			if(!is_null($size)){
				if(is_callable($size)){
						if(is_a($size,Closure)){
							$callback = Closure::bind($size,$this->node);
								}
							$size = call_user_func($callback,$this->get());
							if(!is_scalar($size))return;
					}
				 $this->node->attr('height',$size);
					if(is_numeric($size)){
						
						 $this->node->css('height',$size.'px');
					}else{
						 $this->node->css('height',$size);
					}
			}
			
		}
		
		public function get(){
			$height = $this->node->attr('height')->get();
			$css = $this->node->css()->get();
				if(array_key_exists('height',$css)){
					$height = $css['height'];
				}
			$height = preg_replace('/[^0-9]/','',$height);
			if(is_numeric($height)){
				return (int)$height;
			}
			return NULL;
		}
		
		
}


?>