<?php
defined('SAFE')or die();

class jqueryphp_methods_prependTo extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($el=NULL){
			
			
			if($el instanceOf DomElement){
					$el = $this->node->ExportNode($el);
				}elseif(is_scalar($el) AND strip_tags($el) != $el){
					
					$j = jqm_use($this->node->_parentElement);
					$el = $j($el)->current();
					
				}elseif(is_scalar($el)){
					$j = jqm_use($this->node->_parentElement);
					$s = $j->match_selector($el);
					$x = $j->xpath($this->__toDomElement()->ownerDocument);
					$find = $x->query($s['xpath']);
					
						if($find->length ==0)return;
						$el = $this->node->exportNode($find->item(0));
						
				}
				if(is_a($el,jqmel)){
					
					
					$el->prepend($this->node->dom()->get()->lastdom);
					
						$this->node->remove();
						$dom = $el->__toDomElement();
						if($dom->firstChild){
					$this->node = $this->node->exportNode($dom->firstChild);
						}
						
					
					
				}
			return $this;
			
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>