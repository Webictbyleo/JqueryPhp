<?php
defined('SAFE')or die();

class jqueryphp_methods_has extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		private $done;
		
		public  function __construct(&$ele){
			$this->node  = $ele;
		}
		
		public function run($ele){
			$document = jqm_use($this->node->_parentElement);
				
				if(is_scalar($ele) AND !is_numeric($ele)){
					$query = $document->match_selector($ele);
					
				}elseif(is_a($ele,jqmel)){
					$ele = $ele->_name;
					$query = $document->match_selector($ele);	
				}else{
					$this->node = new jqueryphp_abstracts_prevObject;
					return ;
				}
				if($query){
					$this->node = $this->node->find($query['selectors'])->get();
				}
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}

?>