<?php
defined('SAFE')or die();

class jqueryphp_methods_parents extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($query='*',$d=false){
			
			
			$el = $this->__toDomElement();
			$path = explode('/',$el->getNodePath());
			$document = jqm_use($this->node->_parentElement);
			
					
				if(count($path) > 0){
						
					if($query ===NULL || $query =='*'){
						$query = $el->parentNode->tagName;
					}
						
			$doc = $document->_DOM;
					
						if($doc->doctype){
					$doc->removeChild($doc->doctype);
						}
						$selector = $document->match_selector($query,$el->getNodePath().'/ancestor::');
						
						$xpath = $document->xpath($doc);
						$find = $xpath->query($selector['xpath']);
							if($d===true){
						
					}else{
						
					}
						if($find->length){
							$this->node = $this->exportNode($find->item(0),$selector);
							
							return $this->node;
						}
						
							
					
				$this->node= new jqueryphp_abstracts_prevObject($this->node->_selector.':parent(*)');
				return $this;
					}
				else{
					return $this->node=new jqueryphp_abstracts_prevObject($this->node->_selector.':parent(*)');
				}
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}

?>