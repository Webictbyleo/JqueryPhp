<?php
defined('SAFE')or die();

class jqueryphp_methods_after extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($str=NULL){
			if($str==NULL)return $this;
			$dom  = $this->node->dom()->get();
			
			$this->node->_lastDom = $dom->lastdom.$str;
			
			$rec = new DomDocument();
			$rec->loadHtml($str);
			if($rec->doctype){
				$rec->removeChild($rec->doctype);
			}
			
			$document = jqm_use($this->node->_parentElement);
					
				$dom = $document->_DOM;
						
						if($dom->doctype){
						$dom->removeChild($dom->doctype);
						}
						$body = $rec->childNodes->item(0)->firstChild;
						
						$frag = $dom->importNode($body,true);
						$xpath = new DomXpath($dom);
						
						$find = $this->node->getPathByID($dom);
						
						$find = $xpath->query($find);
						if($find->length > 0){
							
							
							$save = $find->item(0)->parentNode->insertBefore($frag->firstChild,$find->item(0)->nextSibling);
							$this->node->_path = $save->previousSibling->getNodePath();
							$document->_DOM = $dom;
							
							
						}
			return $this;
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>