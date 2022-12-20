<?php
defined('SAFE')or die();

class jqueryphp_methods_removeAttr extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($key=NULL){
			if(is_null($key))return $this;
			$attr = $this->node->_attributes;
				if(is_string($key)){
					$key = preg_replace('/\s+/',' ',$key);
					$key = array_filter(explode(' ',$key));
					$key = array_fill_keys($key,NULL);
					$attr = array_diff_key($attr,$key);
				}else{
					$key = array_fill_keys($key,NULL);
					$attr = array_diff_key($attr,$key);
				}
				
				$dom = $this->node->__toDomElement();
				$key = array_intersect_key($this->node->_attributes,$key);
				
				foreach($key as $k=>$v){
					$dom->removeAttribute($k);
				}
				
				$this->node->_attributes = $attr;
				//$save = $this->node->saveHtml();
			
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>