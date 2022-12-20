<?php
defined('SAFE')or die();

class jqueryphp_methods_insertBefore extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($el=NULL){
			if($el instanceOf DomElement){
					$el = $this->node->ExportNode($el);
				}elseif(is_scalar($el)){
					$j = jqm_use($this->node->_parentElement);
					$el = ($j($el));
					if($el->length ==0)return;
					$el = $el->first()->get();
				}
					
			if(is_a($el,jqmel)){
					$el->before($this->__toDomElement());
				}
				return $this;
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>