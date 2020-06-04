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
					if(is_a($html,'DOMNode')){
						$np = 'HTML';if($this->node->isXml())$np = 'XML';
						$html = $html->ownerDocument->{'save'.$np}($html);
						if(!is_scalar($html))return;
					}elseif(is_a($html,jqmel)){
						$html = $html->toString();
						if(!is_scalar($html))return;
					}elseif(is_callable($html)){
						if(is_a($html,Closure)){
							$callback = Closure::bind($html,$this->node);
								}
							$html = call_user_func($callback,$this->node->_token);
							
							if(!is_scalar($html))return;
					}
					
					$html = preg_replace('/\s+/',' ',$html);
					$regex = '/<([a-z0-9\-]+)(.*?)>(?:(.*?)(<\/\1>))?/xsi';
				if(preg_match($regex,$html,$match)){
					$match[2] = rtrim($match[2],'/');
				}
				
					if(empty($match[1]))return;
					$np = 'html';
					$dc=new domdocument;
					$dc->preserveWhiteSpace = false;
					if($this->node->isxml())$np = 'xml';
					$dc->{'load'.$np}($html);
					$x = new DomXpath($dc);
					$new = $x->query('/html/body/'.$match[1])->item(0);
					//$new = $new->firstChild;
					
					$frag = $this->__toDomElement()->ownerDocument->importNode($new,true);
					$this->__toDomElement()->parentNode->replaceChild($frag,$this->__toDomElement());
					
					
					$node = $this->node->exportNode($frag);
					
					$this->node->_attributes = $node->_attributes;
					$this->node->_name = $node->_name;
					$this->node->_attrMap = $node->_attrMap;
					$this->node->_nodeLevel = $node->_nodeLevel;
					$this->node->_innerHtml = $node->_innerHtml;
					$this->node->_innerText = $node->_innerText;
					$this->node->_childElement = $node->_childElement;
					$this->node->_selector = $node->_selector;
					$this->node->_localName = $node->_localName;
					$this->node->_path = $node->_path;
					$this->node->selector = $node->selector;
					$this->node->DOMel = $node->DOMel;
					$this->node->_content = $node->_content;
					
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