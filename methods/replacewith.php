<?php
defined('SAFE')or die();

class jqueryphp_methods_replaceWith extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		private $oldnode;
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($html=NULL){
				
				if(!is_null($html)){
				
					if(is_a($html,jqmel)){
						$html = $html->get()[0];
						if(!$html)return;
					}else if(is_a($html,jqmdoc)){
					$html = $html->__toString();
					}elseif(is_callable($html)){
						if(is_a($html,Closure)){
							$callback = Closure::bind($html,$this->node);
						}
						$html = call_user_func($callback,$this->node->_token);
					}
					$node = $this->__toDomElement();
					if(is_string($html)){
					$newdoc = $node->ownerDocument->createDocumentFragMent();
					$newdoc->appendxml($html);
					}else if(is_a($html,'DOMNode')){
					$html = $node->ownerDocument->importNode($html,true);
					$newdoc = $html;
					}else{
					return;
					}
					$frag = $node->parentNode->insertBefore($newdoc,$node->nextSibling);
					$node->parentNode->removeChild($node);
					$this->node->exportNode($frag,null,true);
				}
			return $this;
		}
		
		
		private function getPathIndex($pathString)
		{
			if(strripos($pathString,']') == strlen($pathString)-1){
$pathString = substr($pathString,strripos($pathString,'['));

if(preg_match('/\[(\d)\]/',$pathString,$match)){
$pathString = (int)$match[1];
	}else{
		$pathString = 0;
	}
					}else{
						$pathString = 0;
					}
					return $pathString;
		}
		public function get(){
			
			return $this->node;
		}
		
		public function __get($name){
				if($name !=='oldnode')return;
				$old = $this->oldnode;
				unset($this->oldnode);
				return $old;
		}
		
		
}


?>