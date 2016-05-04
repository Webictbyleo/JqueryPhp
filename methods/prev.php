<?php
defined('SAFE')or die();

class jqueryphp_methods_prev extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run(){
			
			$dom = $this->__toDomElement();
						if($dom->previousSibling){
							$doc = jqm_use($this->node->_parentElement);
							
							$dom = $dom->previousSibling;
							//Get the search param
							if($dom->nodeType !==1){
									$dom = $dom->previousSibling;
								}
							$selector = $doc->match_selector($dom->tagName);
							
								if(!$dom){
									return $this->node =  new jqueryphp_abstracts_prevObject($selector['selectors']);
								}
							$path = $dom->getNodePath();
								
							//Find this ele in the Dom Node
							$node = $this->findRelatedDom(array('_path'=>$path));
								
							$str = $dom->ownerDocument->savehtml($dom);
							
							if(is_a($node,jqmel)){
								
								
									$this->node = $node;
									unset($node);
									return;
								}
							$dom = $this->createFragment($str,false);
							
							if(is_a($dom,jqmel)){
					
				$dom->_path = $path;
				$dom->selector = new jqueryphp_abstracts_selector($selector);
				$dom->setDomID($dom->_parentElement.$dom->_token);
				return $this->node = $dom;
							}else{
								//notfound
								return $this->node =  new jqueryphp_abstracts_prevObject($selector['selectors']);
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