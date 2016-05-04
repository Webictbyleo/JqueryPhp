<?php
defined('SAFE')or die();

class jqueryphp_methods_before extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($str=NULL){
			if($str==NULL)return $this;
			$document = jqm_use($this->node->_parentElement);
					
				$dom = $document->_DOM;
						if($dom->doctype){
						$dom->removeChild($dom->doctype);
						}
							$find = $this->node->getPathById($dom);
							if(!$find)$find = $this->node->_path;
						$xpath = new DomXpath($dom);
						$find = $xpath->query($find);
						if($find->length > 0){
							$child = new DomDocument;
							$child->loadHtml($str);
							if($child->doctype){
						$child->removeChild($child->doctype);
							}
							$child->normalize();
							$frag = $dom->importNode($child->firstChild->firstChild->firstChild,true);
							
							$save = $find->item(0)->parentNode->insertBefore($frag,$find->item(0));
							$this->node->_path = $save->nextSibling->getNodePath();
							$document->_DOM = $dom;
						}
			return $this;
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>