<?php
defined('SAFE')or die();

class jqueryphp_methods_on extends jqueryphp_abstracts_Window{
	
		
		protected static $node;
		
		public  function __construct(&$ele){
			$this->node  = $ele;
		}
		
		public function run($event,$selector=NULL,$data,$callback,$once=false){
				
			if($event==NULL)return $this;
				$callable = (is_callable($callback) || function_exists($callback));
				if(!$callback)return $this;
				if(!is_a($this->node,jqmel))return $this;
				$ns = $this->node->data('_parentElement')->get();
					if(empty($ns))return $this;
					$document = jqm_use($ns);
					
					
			if(!isset($document->Window) AND !is_a($document->Window,jqmwin))return false;
				
				if(!isset($this->node->events)){
						$this->node->data('events',new stdclass);
					}
					
					if(!isset($this->node->events->{$event})){
					$this->node->events->{$event} = array();
				}
				/* if(!isset($this->node->trace)){
					$this->node->events[$event] = true;
				} */
			array_unshift($this->node->events->{$event},array($callback,$data,$selector,$once));
			
				
			return $this;
			
		}
		
		public function get(){
			
			return $this;
		}
		
		
}


?>