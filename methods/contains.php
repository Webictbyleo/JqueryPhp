<?php
defined('SAFE')or die();

class jqueryphp_methods_contains extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		private $done;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($ele){
			
					
					if(is_a($ele,jqmel)){
						$document = jqm_use($this->node->_parentElement);
						$x = $document->Xpath($this->__toDomElement()->ownerDocument);
						
						$find = $x->query($ele->_path.'/ancestor::'.$this->node->_name.'[@data-dom-id = "'.key($this->node->_domId).'"][1]');
						if(!$find->length){
							$this->done = false;
						}else{
							$this->done = true;
						}
					}else{
						$this->done = false;
					}
			
			
		}
		
		public function get(){
			
			return isset($this->done) ? $this->done : false;
		}
		
		
}

?>