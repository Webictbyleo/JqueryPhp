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
					$ch = $parent->__toDomElement()->childNodes;
					
					if($ch->length > 0){
						
						$n = $this->node->__toDomElement();$pp = $parent->DOMel->parentNode;
						foreach($ch as $item){
							$chd[] = $item;
							
							
							$item->parentNode->removeChild($item);
							if(!$pp){
								$item->ownerDocument->appendChild($item);
							}else{
								
								$pp->insertBefore($item);
							}
						}
						
						$parent->remove();
						
						
						
						
					}
				
					
					
				}
			
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>