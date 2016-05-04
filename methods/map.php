<?php
defined('SAFE')or die();
class jqueryphp_methods_map extends jqueryphp_abstracts_element{
		protected static $node;
		
		public function __construct(&$ele){
			$this->node  = $ele;
		}
		
		public function run($callback){
				
			$this->node = $this->node->children()->get()->each($callback);
				if($this->node->length > 0){
			$this->node = $this->node->toArray();
				}
		}
		
		public function get(){
			
			return $this->node;
		}
	}
	
?>