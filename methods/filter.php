<?php
defined('SAFE')or die();

class jqueryphp_methods_filter extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(&$ele){
			$this->node  = $ele;
		}
		
		public function run(string $query){
			
			if($this->node instanceOf jqueryphp_abstracts_element and $this->node->is($query)->get()){
				$this->node = new jqueryphp_abstracts_nodelist(array($this->node));
				return $this;
			}else if($this->node instanceOf jqueryphp_abstracts_nodelist==false){
			$this->node = new jqueryphp_abstracts_prevObject($query);
			return $this;
			}
			$t = time();
			$nodes = $this->node->filter($query);
			
			if(!$nodes->length){
			$this->node = new jqueryphp_abstracts_prevObject($query);	
			}else{
			$this->node = $nodes;
			}
			
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>