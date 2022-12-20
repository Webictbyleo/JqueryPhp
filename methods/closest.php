<?php
defined('SAFE')or die();

class jqueryphp_methods_closest extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		private $done;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($query=''){
					if(!empty($query) AND $this->node->is($query)->get()){
						return;
					}
				
				$par = $this->node->parents($query)->get();
					if($par->length > 0){
					return $this->node = $par;
					}
				$this->node= new jqueryphp_abstracts_prevObject($this->node->_selector.':closest('.$query.')');
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}

?>