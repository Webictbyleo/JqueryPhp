<?php
	defined('SAFE')or die();
	
	class jqueryphp_methods_html extends jqueryphp_abstracts_element{
		
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($new =Null){
			//If its a document element
			if(!is_null($new)){
				if(is_a($new,jqmel)){
					$new = $new->get()[0];
					if(!$new)return;
				}else if(is_a($new,jqmdoc)){
				$new = $html->__toString();
				}				
				$d = $this->__toDomElement();
				$d->nodeValue = '';
				if(is_string($new)){
				$in = $d->ownerDocument->createDocumentFragMent();
				$in->appendxml($new);
				}else if(is_a($new,'DOMNode')){
				$in = $d->ownerDocument->importNode($new,true);
				}
				$d->appendChild($in);
				$this->node->exportNode($d,null,true);
				
				}else{
				$dom = ($this->node->__toDomElement());
				$inner = '';
				for($i=0;$dom->childNodes->length > $i;$i++){
					if($this->node->isxml()){
						$inner .=$dom->childNodes[$i]->ownerDocument->saveXml($dom->childNodes[$i]);	
						}else{
						$inner .=$dom->childNodes[$i]->ownerDocument->saveHtml($dom->childNodes[$i]);
					}
				}
				
				$this->node->_innerHtml = $inner;
				unset($inner);
				return $inner;
			}
			
		}
		
		public function get(){
			
			return $this->node->_innerHtml;
		}
		
		
	}
	
	
?>