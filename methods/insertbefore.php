<?php
defined('SAFE')or die();

class jqueryphp_methods_insertBefore extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($el=NULL){
			
			if(is_a($el,jqmel)){
					
					
					$el->before($this->node->dom()->get()->lastdom);
						
					$this->node->remove();
					
					
					$i = $el->savehtml();
				}
				return $this;
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>