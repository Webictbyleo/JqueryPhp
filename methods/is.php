<?php
defined('SAFE')or die();

class jqueryphp_methods_is extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		private $done;
		private $matched;
		private $query_arg;
		public  function __construct(&$ele){
			$this->node  = $ele;
		}
		
		public function run($new =Null){
				if(is_a($new,jqmel)){
					return $this->done= ($new === $this->node);
				}elseif(is_callable($new)){
					if(is_a($new,Closure)){
							$new = Closure::bind($new,$this->node);
								}
					return $this->done = (call_user_func($new) ==true);
				}else if(is_object($new) and $new InstanceOf DomNode){
				return $this->done = $this->__toDomElement()->isSameNode($new);
				}
				
				
				$attr = $this->node->data('_attributes')->get();
				$path = $this->node->data('_path')->get();
				$ns = $this->node->data('_parentElement')->get();
				$tag = $this->node->data('_name')->get();
				$done = false;
				$d = jqm_use($ns);
				
				$def = $this->__toDomElement();
				
				$document = jqm_use($this->node->_parentElement);
				$query = $document->find($new);
				
				$query = ($query->filter(function($e)use($def){
					
					return ($def->isSameNode($e[0]));
				}));
				$this->done = $query->length > 0;
						
			return $this->done;
			
		}
		
		public function get(){
			
			return $this->done;
		}
		
		public function __toString(){
			$this->negate();
			
			return isset($this->done) ? false:false;
		}
		
		
		private function Negate(){
			
		}
}


?>