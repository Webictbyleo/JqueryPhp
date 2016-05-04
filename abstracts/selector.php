<?php
defined('SAFE')or die();
	class jqueryphp_abstracts_selector{
		
		private $node;
		
		public function __construct(array $searchString){
			$this->node = $searchString;
		}
		
		
		
		public function parent(){
			
		}
		
		public function hasAttr(){
			
		}
		
		public function attrEquals(){
			
		}
		
		public function __get($name){
			
			return isset($this->node[$name]) ? $this->node[$name]: false;
		}
		
	}

?>