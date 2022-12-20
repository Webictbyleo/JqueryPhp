<?php
defined('SAFE')or die();

class jqueryphp_methods_index extends jqueryphp_abstracts_document{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_document &$ele){
			$this->node  = $ele;
		}
		
		public function run($index){
			if(is_numeric($index)){
				$index = (int)$index;
					if($this->node->offsetExists($index)){
				$this->node->seek($index);
				$this->node->__documentMap =array($this->node->current());
			$this->node->__mapLength = 1;
					}
				
			}
			
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>