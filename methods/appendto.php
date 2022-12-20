<?php
defined('SAFE')or die();

class jqueryphp_methods_appendTo extends jqueryphp_abstracts_element{
	
		
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
					$x = new DomXpath($this->__toDomElement()->ownerDocument);
					$find = $x->query($s['xpath']);
					
						if($find->length ==0)return;
						$el = $this->node->exportNode($find->item(0));
						
				}
			if(is_a($el,jqmel)){
					$html = $this->node->dom()->get()->lastdom;
					$el->append($html);
					
					$this->node->remove();
					$dom = $el->__toDomElement();
						if($dom->lastChild){
					$this->node = $this->node->exportNode($dom->lastChild);
						}
				
					
				}
				return $this;
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>