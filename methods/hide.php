<?php
defined('SAFE')or die();
class jqueryphp_methods_hide extends jqueryphp_abstracts_element{
		protected static $node;
		public function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run(){
			$this->node->css('display','none');
			$this->node->css('opacity','0');
			$this->savehtml();
		}
		
		public function get(){
			
			return $this->node;
		}
	}
	
?>