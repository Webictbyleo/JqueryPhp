<?php
defined('SAFE')or die();

class jqueryphp_methods_prev extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($query=NULL){
			
			$dom = $this->__toDomElement();
						if($dom->previousSibling){
							$doc = jqm_use($this->node->_parentElement);
							
							$dom = $dom->previousSibling;
							//Get the search param
							if($dom->nodeType !==1){
								
									$dom = $dom->previousSibling;
								}
							
								if(!is_null($query) and !empty($query)){
									
									
									$x = $doc->Xpath($doc->_DOM);
									$selector = $doc->match_selector($query,$this->__toDomElement()->getNodePath().'/preceding-sibling::');
									$find = $x->query($selector['xpath']);
									
										if($find->length){
											$dom = $find->item(0);
										}else{
											$dom = NULL;
										}
								}

								if(!$dom){
									return $this->node =  new jqueryphp_abstracts_prevObject();
								}
							$path = $dom->getNodePath();	
							
								
							$dom = $this->node->exportNode($dom);
							
							if(is_a($dom,jqmel)){
				
				return $this->node = $dom;
							}else{
								//notfound
								return $this->node =  new jqueryphp_abstracts_prevObject();
							}
							
						}else{
							//notfound
							return $this->node = new jqueryphp_abstracts_prevObject($this->node->_selector.':prev');
						}
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>