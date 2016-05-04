<?php
defined('SAFE')or die();

class jqueryphp_methods_wrap extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($str=nULL){
			if(!is_null($str)){
				$regex = '/<([a-z0-9\-]+)(.*?)>(?:(.*?)(<\/\1>))?/ix';
					if(is_a($str,jqmel)){
						$str = $str->dom()->get()->lastdom;
					}elseif(is_callable($str)){
						$str = call_user_func($str,array());
					}
				$str = preg_replace('/\s+/',' ',$str);
				if(preg_match($regex,$str,$match)){
					$match[2] = rtrim($match[2],'/');
					
				}
				$document = jqm_use($this->node->_parentElement);
					
					$np = $this->node->next()->get();
					$npp = $this->node->prev()->get();
					$par = $this->node->parent();
					$wrap = $str;
					
					if(!is_a($par->get(),jqmel)){
							return;
						}
						
					$rec = $document->_DOM;
					
						if($rec->doctype){
					$rec->removeChild($rec->doctype);
						}
					$xpath = new domxpath($rec);
					$find = $xpath->query($this->node->_path);
					
					
					if($find->length > 0){
						$child = new domDocument;
						$child->loadHtml($wrap);
						if($child->doctype){
						$child->removeChild($child->doctype);
						}
						$chf = $child->getElementsByTagName($match[1]);
						$node = $this->node->__toDomElement();
						
						$frag = $child->importNode($node,true);
						
						$depth = $this->getDeepest($chf->item(0));
						
						$save = $depth->appendChild($frag);
						
						//Import to document
						$frag = $rec->importNode($chf->item(0),true);
						
						
							
						$newsave = $find->item(0)->parentNode->replaceChild($frag,$find->item(0));
						$new_path = explode('/',$frag->getNodePath());
						
						
						
						$p_path = array_filter(explode('/',$save->getNodePath()));
						//$p_path = array_pop($p_path);
							$htm = array_search('html',$p_path);
						if($htm){
							unset($p_path[$htm]);
							unset($p_path[$htm+1]);
							
						}
						
							
							$new_path = array_merge($new_path,$p_path);
							$sh = array_pop($new_path);
								array_pop($new_path);
								
							
						$ele_path = ltrim($newsave->getNodePath(),'/');
						$this->node->_parent_path = implode('/',$new_path);
						$this->node->_path = $this->node->_parent_path.'/'.$sh;
						
						$wrap = $rec->saveHtml($frag->parentNode);
						$wrap = substr($wrap,strpos($wrap,'>')+1);
						if(!empty($par->get()->_localName)){
							$wrap = substr($wrap,0,strripos($wrap,$par->get()->_localName));
							$par->get()->html($wrap);
							
						}
						
					$find = $this->node->getPathById();
						if($find){
							$this->node->_path = $find;
						}
						
						if($this->node->trace){
							
							$key = $this->node->trace->key();
							$this->node->trace->next();
							$n = $this->node->trace->current();
								if($key > 0){
									 $this->node->trace->seek($key-1);
									$p = $this->node->trace->current();
								}
							
							if($p AND is_a($p,jqmel)){
								$find = $p->getPathById();
								if($find){
								$p->_path = $find;
								//var_dump($key,$p);
								}
							}
							if($n AND is_a($n,jqmel)){
								$find = $n->getPathById();
								if($find){
									$n->_path = $find;
									
								}
							}
							unset($p);
							unset($n);
						}
						
					}
					
			}
		}
		
		private function getDeepest(&$node){
					$childT = $node->childNodes->length;
					
						if($childT ==0 ){return $node;}
						
							//if($node->childNodes->item(0)->childNodes->length ==0)return $node;
				while($childT > 0){
					--$childT;
							
						if($node->childNodes->item(0)->childNodes->length >0){
							
							$node = $node->childNodes->item(0)->childNodes->item(0);
							
								
								
								if($node->childNodes->length==1 AND is_a($node->childNodes->item(0),'DOMText')){
									return $node->parentNode;
								}
							return $this->getDeepest($node);
							
							}
							$node = $node->childNodes->item(0);
							return $this->getDeepest($node);
						
					
				}
				
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>