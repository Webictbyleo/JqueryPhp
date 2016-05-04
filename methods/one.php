<?php
defined('SAFE')or die();

class jqueryphp_methods_one extends jqueryphp_abstracts_Window{
	
		
		protected static $node;
		
		public  function __construct(&$ele){
			$this->node  = $ele;
		}
		
		public function run($event,$selector=NULL,$data,$callback){
				
			if($event==NULL)return $this;
				$callable = (is_callable($callback) || function_exists($callback));
				if(!$callback)return $this;
				if(!is_a($this->node,jqmel))return $this;
					$this->node->on($event,$selector,$data,$callback,true);
				
			
				
			return $this;
			
		}
		
		public function get(){
			
			return $this;
		}
		
		
}


?>