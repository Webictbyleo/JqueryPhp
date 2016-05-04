<?php
defined('SAFE')or die();

class jqueryphp_methods_html extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($new =Null){
				//If its a document element
			if(!is_null($new)){
					if(is_a($new,jqmel)){
						
					}
				$this->node->_innerHtml = $new;
				$this->node->saveHtml();
			}else{
				return $this->node->_innerHtml;
			}
			
		}
		
		public function get(){
			
			return $this->node->_innerHtml;
		}
		
		
}


?>