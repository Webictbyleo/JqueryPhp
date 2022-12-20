<?php
	defined('SAFE')or die();
	
	class jqueryphp_methods_append extends jqueryphp_abstracts_element{
		
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($new=NULL){
			if($new==NULL)return $this;
			if(is_a($new,jqmel)){
				$new = $new->get()[0];
				if(!$new)return;
				}else if(is_a($new,jqmdoc)){
				$new = $html->__toString();
			}else if(is_callable($new)){
				if(is_a($new,'Closure')){
					$new = Closure::bind($new,$this->node);
				}
				$new = call_user_func($new,$this->node->_token);
				if(!is_scalar($new))return;
			}
			$d = $this->__toDomElement();
			if(is_string($new)){
				$in = $d->ownerDocument->createDocumentFragMent();
				$in->appendxml($new);
				}else if(is_a($new,'DOMNode')){
				$in = $d->ownerDocument->importNode($new,true);
			}
			$d->appendChild($in);
			
			$this->node->exportNode($d,null,true);
			
			return $this;
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
	}
	
	
?>