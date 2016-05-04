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
				$new = $this->createFragment($html);
				
			if(is_a($new,jqmel)){
				
					
					$this->oldnode = clone($this->node);
					
					$document = jqm_use($this->node->_parentElement);
					
					$np = $this->node->next()->get();
					$npp = $this->node->prev()->get();
					
					$this->node->_selector = $new->_selector;
					$this->node->_token = $new->_token;
					$this->node->_nodeLevel = $new->_nodeLevel;
					
					$this->node->selector = $new->selector;
					$this->node->_name= $new->_name;
					$this->node->_content= $new->_content;
					$this->node->_attrMap= $new->_attrMap;
					$this->node->_innerHtml= $new->_innerHtml;
					$this->node->_innerText= $new->_innerText;
					
					$this->node->_localName= $new->_localName;
					$this->node->_attributes = $new->_attributes;
					
					$save = $this->node->saveHtml();
					$k = key($this->node->_domId);
					$this->node->_domId[$k] = end($new->_domId);
					
					$paths = explode('/',$this->node->_path);
					$sh = array_pop($paths);
					$paths[] = $new->_name;
					
					$this->node->_path = $save;
					//$save = $this->node->saveHtml();
					
					$par = $this->node->parent();
					
						if(is_a($par,jqmel)){
							
							$this->node->_parent_path = $par->get()->_path;
							
								if(is_a($npar,jqmel)){
									$npar->node = $par->get();
								}
						}
						
					//Reconcle paths
						$rec = $document->_DOM;
						if($rec->doctype){
						$rec->removeChild($rec->doctype);
						}
						$xpath = new DomXpath($rec);
						$find = $xpath->query($save);
							if($find->length > 0){
								
								$wrap = $rec->saveHtml($find->item(0)->parentNode);
						$wrap = substr($wrap,strpos($wrap,'>')+1);
						if(!empty($par->get()->_localName)){
							$wrap = substr($wrap,0,strripos($wrap,$par->get()->_localName));
							
							$par->get()->html($wrap);
							$par->get()->saveHtml();
							
						}
								$this->node->_path = $find->item(0)->getNodePath();
								
								if(is_a($np,jqmel)){
									if($find->item(0)->nextSibling){
						$this->node->_next_path = $find->item(0)->nextSibling->getNodePath();
									}else{
						$this->node->_next_path = NULL;
							}
							
						$np->_path = $this->node->_next_path;
						$np->_prev_path = $this->node->_path;
						$npd = $np->__toDomElement();
							if($npd->nextSibling){
								$np->_next_path = $npd->nextSibling->getNodePath();
							}else{
								$np->_next_path = NULL;
							}
							unset($npd);
					}
					if($find->item(0)->previousSibling AND is_a($npp,jqmel)){
						
						$this->node->_prev_path = $find->item(0)->previousSibling->getNodePath();
						
					}else{
						$this->node->_prev_path = NULL;
					}
					$npp->_path = $this->node->_prev_path;
						$npp->_next_path = $this->node->_path;
						$npd = $npp->__toDomElement();
							if($npd->previousSibling){
								$npp->_prev_path = $npd->previousSibling->getNodePath();
							}else{
								$npp->_prev_path = NULL;
							}
							unset($npd);
							}
					
							
							
							
							
							
					unset($new);
			}
				}
			
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