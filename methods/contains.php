<?php
defined('SAFE')or die();

class jqueryphp_methods_contains extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		private $done;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run(jqueryphp_methods_dom $ele){
			$frag = $this->createFragment($ele->lastdom,false);
			
				$this->node->refreshDom();
				
					$frag->_path = $ele->path;
					$is = $frag->parents($this->node->_name)->get();
					
					if(is_a($is,jqmel)){
						$this->done = ($is->_path === $this->node->_path);
					}else{
						$this->done = false;
					}
			
			
		}
		
		public function get(){
			
			return isset($this->done) ? $this->done : false;
		}
		
		
}

?>