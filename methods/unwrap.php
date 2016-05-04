<?php
defined('SAFE')or die();

class jqueryphp_methods_unwrap extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run(){
				if(empty($this->node->_localName))return $this;
			$parent= $this->node->parent()->get();
			
				if(is_a($parent,jqmel)){
					$path = $parent->_path;
					$str = $parent->_innerHtml;
					$document = jqm_use($this->node->_parentElement);
					
				$dom = $document->_DOM;
						if($dom->doctype){
						$dom->removeChild($dom->doctype);
						}
						$xpath = new DomXpath($dom);
						$find = $xpath->query($path);
							if($find->length > 0){
								$tp = new domdocument;
								$tp->loadHtml($str);
								if($tp->doctype){
									$tp->removeChild($tp->doctype);
								}
								$frag = $dom->importNode($tp->firstChild->firstChild,true);
								$find->item(0)->parentNode->replaceChild($frag,$find->item(0));
								
								
								
					$find = $this->node->getPathByID();
						if($find){
							$this->node->_path = $find;
						}else{
							$pts = explode('/',$this->node->_path);
								$ep = array_pop($pts);
								$pts = explode('/',$frag->getNodepath());
								array_pop($pts);
								$pts[] = $ep;
								$this->node->_path= implode('/',$pts);
						}
							}
					
					
				}
			
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>