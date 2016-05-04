<?php
defined('SAFE')or die();
class jqueryphp_methods_clone extends jqueryphp_abstracts_element{
		protected static $node;
		
		public function __construct(jqueryphp_abstracts_element $ele){
			$this->node  = $ele;
		}
		
		public function run(){
				$new = $this->createFragment($this->node->dom()->get()->lastdom,false);
				if(is_a($new,jqmel)){
					$this->node = $new;
					
				}
			
		}
		
		public function get(){
			
			return $this->node;
		}
	}
	
?>