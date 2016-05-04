<?php
defined('SAFE')or die();

class jqueryphp_methods_length extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(&$ele){
			$this->node  = $ele;
		}
		
		public function run(){
			
				if($this->node instanceOf jqueryphp_abstracts_document){
					$this->_length = $this->node->count();
				}elseif(is_a($this->node,jqmel)){
					$this->_length = $this->node->_length;
				}elseif(is_a($this->node,'jqueryphp_abstracts_nodelist')){
					$this->_length = $this->node->count();
				}else{
						$this->_length = 0;
				}
			
		}
		
		public function get(){
			
			return $this->_length;
		}
		
		
}


?>