<?php
defined('SAFE')or die();

class jqueryphp_methods_next extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($query=NULL){
			
			$dom = $this->__toDomElement();
			
						if($dom->nextSibling){
							$doc = jqm_use($this->node->_parentElement);
							
								
							$dom = $dom->nextSibling;
							
								if($dom->nodeType !==1){
									$dom = $dom->nextSibling;
								}
								
								if(!is_null($query) and !empty($query)){
									$x = $doc->xPath($doc->_DOM);
									$selector = $doc->match_selector($query,$this->__toDomElement()->getNodePath().'/following-sibling::');
									$find = $x->query($selector['xpath']);
									
										if($find->length){
											$dom = $find->item(0);
										}else{
											$dom = NULL;
										}
								}
								if(!$dom){
									return $this->node =  new jqueryphp_abstracts_prevObject($selector['selectors']);
								}
							
							$dom = $this->exportNode($dom);
							
							if(is_a($dom,jqmel)){
					
				return $this->node = $dom;
							}else{
								//notfound
								return $this->node = new jqueryphp_abstracts_prevObject($selector['selectors']);
							}
							
						}else{
							//notfound
							return $this->node = new jqueryphp_abstracts_prevObject($this->node->_selector.':next');
						}
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>