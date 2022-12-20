<?php
defined('SAFE')or die();

class jqueryphp_methods_not extends jqueryphp_abstracts_element{
	
	protected static $node;
		private $done;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($new = Null){
			
			$t = time();
			$nodes = array();
			if($this->node instanceOf jqueryphp_abstracts_nodelist){
			$this->node = $this->node->not($new);	
			return $this;
			}else if($this->node Instanceof jqueryphp_abstracts_element and $this->node->is($new)==false){
				$nodes = array($this->node);
			}
			if(empty($nodes)){
			$this->node = new jqueryphp_abstracts_prevObject($new);	
			}else{
			$this->node = new jqueryphp_abstracts_nodelist($nodes);
			}
			
		}
		public function get(){
			
			return $this->node;
		}
		
		public function __toString(){
			return isset($this->node->length) ? false:true;
		}
}

?>