<?php
defined('SAFE')or die();

class jqueryphp_methods_width extends jqueryphp_abstracts_Window{
	
		
		protected static $node;
		
		public  function __construct(&$ele){
			$this->node  = $ele;
		}
		
		public function run($size=NULL){
				
			if(!is_null($size)){
				 $this->node->attr('width',$size);
					if(is_numeric($size)){
						
						 $this->node->css('width',$size.'px');
					}else{
						 $this->node->css('width',$size);
					}
			}
			
		}
		
		public function get(){
			$width = $this->node->attr('width')->get();
				$css = $this->node->css()->get();
				if(array_key_exists('width',$css)){
					$width = $css['width'];
				}
				$width = preg_replace('/[^0-9]/','',$width);
					if(is_numeric($width)){
			return (int)$width;
					}
					return NULL;
		}
		
		
}


?>