<?php
defined('SAFE')or die();

class jqueryphp_methods_children extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($query=''){
			$dom = $this->node->__toDomElement();
			
			if($dom->childNodes->length > 0){
						if(empty($query))$query = '';
						$nodes = array();
						$ns = jqm_use($this->node->_parentElement);
						$np = 'html';$pos = false;
						if(preg_match('/(\:first|\:last)/',$query,$m)){
							$query = str_replace($m[1],'',$query);
							$pos = substr($m[1],1);
						}
						$selector = $ns->match_selector($query);
						$x = $ns->xPath($dom->ownerDocument);
					$childs = $x->query($dom->getNodePath().'/child::'.trim($selector['xpath'],'/'));
					
					$node = $this->node;
						if($pos){
							if(stripos($pos,'first')===0){
							$iterator = [0];
							}else{
							$iterator = [$childs->length-1];
							}
							
						}else{
					$iterator = range(0,$childs->length-1);
						}
						
				$nodes = array_map(function($i)use($node,$childs){
						$i = $childs->item($i);
						if($i->nodeType !==1)return NULL;
						$ele = $node->exportNode($i);
						
						return $ele;
					},$iterator);
					$nodes = array_filter($nodes);
					if(!empty($nodes)){
						$nodes = array_values($nodes);
					}
					
					$this->node = new jqueryphp_abstracts_nodelist($nodes);
					return $this;
			}else{
				$this->node= new jqueryphp_abstracts_prevObject($this->node->_selector.':children(*)');
				return $this;
			}
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}

?>