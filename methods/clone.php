<?php
defined('SAFE')or die();
class jqueryphp_methods_clone extends jqueryphp_abstracts_element{
		protected static $node;
		
		public function __construct(jqueryphp_abstracts_element $ele){
			$this->node  = $ele;
		}
		
		public function run($deep=true){
			$el = ($this->node->__toDomElement());
			$this->node = clone($this->node);
			
			$new = ($el->cloneNode($deep));
			$this->node->setDom($new);
			return $this->node;
		}
		
		public function get(){
			
			return $this->node;
		}
	}
	
?>