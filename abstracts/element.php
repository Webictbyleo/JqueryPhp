<?php
defined('SAFE')or die();
	 class jqueryphp_abstracts_element{
		
		protected  static $_selector,
		$_content,
		$_attributes,
		$_baseUrl,
		$_childElementCount,
		$_childNodes,
		$_children,
		$_classNames,
		$_boxHeight,
		$_boxWidth,
		$_boxLeft,
		$_boxTop,
		$_defaultValue,
		$_token,
		$_innerHtml,
		$_innerText,
		$_localName,
		$_name,
		$_namespaceClass,
		$_ownerClass,
		$_parentElement,
		$_childElement,
		$_translate,
		$_lang,
		$_nodeLevel,
		$_events,
		$_lastDom,
		$_next_path,		
		$_prev_path,
		$_parent_path,
		$_path,
		$DOMel;
		public $_length;
		public $isxml;
		protected $_domId;
		
		public function __set($attr,$val){
				if($attr ==='_domId')return false;
			$this->{$attr} = $val;
			return true;
		}
		
		public function setDomID($id){
			if(get_class($this) !==jqmel)return false;
			if(!isset($this->_domId)){
					if(array_key_exists('data-dom-id',$this->_attributes)){
						
					$this->_domId = array($this->_attributes['data-dom-id']=>md5($id.'_'.microtime(true)));	
					}else{
						$this->_domId = array(md5($id.'_'.microtime(true))=>NULL);
					}
				$d=	jqm_use($this->_parentElement);
				$k = key($this->_domId);
				//$this->attr('id',$k);
				$this->_attributes['data-dom-id'] = $k;
					
				//$this->saveHTML(true);
				//var_dump($this->DOMel);
					
					
					$this->isxml = $d->isxml;
					if(!is_null($this->_domId[$k])){
				$this->_attributes['data-dom-id'] =  $this->_domId[$k];
					}
					$this->DOMel->setAttribute('data-dom-id',$k);
				
			}
			
		}
		
		public function setDom(DomNode &$node){
			$this->DOMel = $node;
		}
		
		public function __call($method,$arg){
			
			$class = 'jqueryphp_methods_'.strtolower($method);
				if(!class_exists($class)){
					
					return $this;
				}
				//Support chaining;
				if(isset($this->node) AND is_a($this,jqmel)){
					$node = $this->node;
				}else{
					$node = $this;
				}
				//Refresh
				if(is_a($node,jqmnull))return $this;
				
			$call = new $class($node);
			$parse = call_user_func_array(array($call,'run'),$arg);
			
			return $call;
		}
		
		protected function run($args){
			return $this;
		}
		
		protected function get(){
			return ;
		}
		
		public function getInst(){
			
			
			return ;
		}
		
		public function __toString(){
			
			if(method_exists($this,'get')){
				
				return $this->get();
			}
			return '';
		}
		
		protected function __toDomElement(&$doc=NULL){
			$node = $this->getNode();
			if(!is_a($node,jqmel)){
				throw new Exception("Conversion not allowed within context(".get_called_class().")");
			}
			
			return $node->DOMel;
			$document = jqm_use($node->_parentElement);
			
			
			
			
			$doc = $document->_DOM;
					
						if($doc->doctype){
					$doc->removeChild($doc->doctype);
						}
					//$doc->preserveWhiteSpace = false;
					
					$path = new DomXpath($doc);
					$qs = $node->_name.'[@data-dom-id = "'.key($node->_domId).'"]';
						$get = $path->query('descendant-or-self::'.$qs);
						
						
						
						if($get->length > 0 ){
						
					return $get->item(0);
						}elseif(is_a($node->DOMel,'DomNode')){
							return $node->DOMel;
						}
						throw New Exception('Invalid Dom Node');
						return false;
		}
		public function __toArray(){
			if(get_class($this) !== __CLASS__)throw new Exception("Conversion not allowed within context(".get_called_class().")");
			$array = array();
			$array[] = $this->_content;
			$array[] = $this->_name;
			$array[] = http_build_query($this->_attributes);
			$array[] = $this->_innerHtml;
			$array[] = $this->_localName;
			$array[] = $this->selector->pattern;
			$array[] = $this->_path;
			
			return ($array);
		}
		
		protected function exportNode(DomNode &$node,&$selector=NULL,$mergeself=false){
			$nodens = $this->getNode();
			$document = jqm_use($nodens->_parentElement);
			$item = $node;
			
							
			if(!is_array($selector)){
				$selector = array(
								'pattern'=>'/<('.$node->tagName.')\b(.*?)>(?:(.*?)(<\/\1>))?/xsi',
								'selectors'=>$node->tagName,
								'tag'=>$node->tagName,
								'xpath'=>'descendant-or-self::'.$node->tagName
								);;
			}
			
					if($document->isxml){
							$s = $document->_DOM->saveXML($item);
						}else{
					$s = $document->_DOM->saveHTML($item);
						}
						
						//$s = preg_replace('/\s+/',' ',$s);
						preg_match($selector['pattern'], $s, $match);
						
						if(!$document->isxml){
							
						if($item->childNodes->length > 1){
							$se = preg_match('/<([a-z0-9\-]*)\b(.*?)>/xsi',$s,$r);
							if($se){
							$wrap = substr($s,strlen($r[0]));
						
						$match[3] = substr($wrap,0,strripos($wrap,'</'.$match[1].'>'));	
							}
						
						
							}else{
								
							if($item->childNodes->length ==0){
								$match[3] = NULL;
							}else{
								$match[3] = $document->_DOM->saveHtml($item->childNodes->item(0));
								}
							}
							
						}
						
					
					if(empty($match))return NULL;
					if($item->nodeType !==1)return NULL;
					$all[] = $s;
					$all[] = $node->tagName;
					$all[] = $match[2];
					$map = (object)array('_path'=>NULL,'_prev_path'=>NULL,'_next_path'=>NULL,'_parent_path'=>NULL);
					if($item->nextSibling){
						$map->_next_path = $item->nextSibling->getNodePath();
					}
					if($item->previousSibling){
						$map->_prev_path = $item->previousSibling->getNodePath();
					}
					if($item->parentNode){
						$map->_parent_path = $item->parentNode->getNodePath();
					}
					$map->_path = $item->getNodePath();
					$all[3] = $match[3];
					$all[4] = $match[4];
					
					$m = array($all[0],$all[1],$all[2],$all[3],$all[4]);
					if(!$document->isxml){
					$m[2] = str_replace("\n",'',$m[2]);
					}
					$repair = preg_replace('/=([\'"])\s/','=$1',$m[2]);
					
					if(preg_match_all('#([a-z0-9\-_]{1,}) =? (?:(?:[\'"])(.*?)[\'"])?#ix', $repair, $test)){
							
							if(empty($test[1])){
								$attr = array();
							}else{
								$attr = @array_combine($test[1],$test[2]);
								
							}
						}
						
					$ele = $document->toElement($m);
					$ele->_selector = $nodens->_selector.' '.$selector['selectors'];
				$ele->_nodeLevel = $selector['pattern'];
				$ele->_length = 1;
				$ele->length = 1;
				$ele->_localName = $all[4];
				$ele->_parentElement = $nodens->_parentElement;
				$ele->_token = $document->count()+1;
				$ele->_path = $map->_path;
				$ele->_prev_path = $map->_prev_path;
				$ele->_next_path = $map->_next_path;
				$ele->_parent_path = $map->_parent_path;
				$ele->_attributes = $attr;
				$ele->isxml = $nodens->isxml;
				$ele->selector = new jqueryphp_abstracts_selector($selector);
				$ele->setDom($node);
				$ele->setDomID($ele->_token);
				
				return $ele;
		}
		
	protected function findRelatedDom(array $relation){
		
		if(empty($relation)){
			
			return false;
		}
	
		$doc = jqm_use($this->node->_parentElement);
				
				
				if(!is_a($doc,jqmdoc)){
					
					return false;}
					
				$keys = array_keys($relation);
				$sg = func_get_arg(1);
				$fd = $doc->export();
				$k = array_keys($fd);
				$find = array_filter($fd,function($e)use($relation){
						if(!is_a($e,jqmEl))return false;
						$data = $e->data()->get();
					$find = array_intersect_assoc($relation,$data);
					return (!empty($find));
					});
				if(!empty($find))return current($find);
				return false;
	}
		
	protected function createFragment($content,$mapId = true){
			if(!empty($content) AND is_scalar($content)){
				$node = $this->getNode();
				$doc = jqm_use($node->_parentElement);
				
				$np = 'html';
							if($this->isxml())$np = 'xml';
				if(is_a($doc,jqmdoc)){
						$dom = new domDocument;
						$dom->{'load'.$np}(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
						
						if($dom->doctype){
				$dom->removeChild($dom->doctype);
					}
						if($dom->childNodes->length > 1){
							$content = '<div>'.$content.'</div>';
						}
						
				$content = preg_replace('/\s+/',' ',$content);
				$regex = '/<([a-z0-9\-]*)\b(.*?)>(?:(.*?)(<\/\1>))?/xsi';
				preg_match($regex,$content,$m);
				
				$selector = $doc->match_selector($m[1]);
				preg_match($selector['pattern'],$content,$m);
				}else{
					return new jqueryphp_abstracts_prevObject($content);
				}
					
				if(is_array($m) AND count($m) >= 2){
					$m[0] = $content;
					
					$se = preg_match('/<([a-z0-9\-]*)\b(.*?)>/xsi',$content,$r);
					
					
					if($se==true AND !empty($r)){
						
						$wrap = substr($content,strlen($r[0]));
						$wrap = substr($wrap,0,strripos($wrap,'</'.$m[1].'>'));
						$m[3] = $wrap;
						unset($wrap);
					}
					$repair = preg_replace('/=([\'"])\s/','=$1',$m[2]);
					if(preg_match_all('#([\w\-_]{2,}) =* (?:(?:[\'"])(.*?)[\'"])?#xi', $repair, $test)){
							
							if(empty($test[1])){
								$attr = array();
							}else{
								$attr = @array_combine($test[1],$test[2]);
								
							}
						}
						
				$ele = $doc->toElement($m);
				$ele->_selector = '* '.$selector['selectors'];
				$ele->_nodeLevel = $selector['pattern'];
				$ele->_length = 1;
				$ele->_localName = $m[4];
				$ele->_parentElement = $node->_parentElement;
				$ele->_token = $doc->count()+1;
				$ele->_attributes = $attr;
				$ele->isxml = $this->isxml();
				if($se){
				$domel= $dom->getElementsByTagName($r[1]);
				
				$ele->setDom($domel->item(0));
				}
					if($mapId===true){
						
				$ele->setDomID($node->_parentElement.$ele->_token);
			
					}
				
				return $ele;
							}else{
								
								return new jqueryphp_abstracts_prevObject($content);
							}
			}
		}
		
		protected function getNode(){
			
			if(get_parent_class($this) === __CLASS__){
				
					$node = $this->node;
				
			}elseif(get_class($this)===jqmel){
				
				$node = $this;
				}
				return isset($node) ? $node : false;
		
		
		}
		public  function escape($input) {

  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );

    $output = preg_replace($search, '', $input);
	
    return  $output;
	
  }
		public function get_selector(){
			$node = $this->getNode();
			if(is_a($node,jqmel)){
				$query = '';
				$attr = $node->_attributes;
				$dom = $node->__toDomElement();
					if(!empty($node->_name))$query .=$node->_name;
					if(!is_null($attr['id'])){$query .='#'.$attr['id'];unset($attr['id']);}
					if(!empty($node->_innerHtml)){
						$text = preg_replace('#[\s\W]#','',$this->escape($node->_innerHtml));
						
						$query .=':contains("'.$text.'")';
						
					}else{
						$query .=':empty';
					}
					
					if(!is_null($attr['class'])){
						//$query .='[class][class="'.trim($attr['class']).'"]';
						}
					
					
					
					$attr = array_filter($attr);
					
					
					foreach($attr as $key => $value){
						$query .= '['.$key.']';
						$value = trim($value);
						
							if(strlen($value) > 0){
								$vs = explode(' ',$value);
								$vk = range(0,count($vs)-1);
								$query .= '['.$key.'^="'.$vs[0].'"]';
								$query .= '['.$key.'$="'.end($vs).'"]';
								$query .= '['.$key.'="'.$value.'"]';
								
							}
					}
					if(strip_tags($node->_innerHtml) !== $node->_innerHtml){
							$query .= ':parent';
						}
					if($dom->parentNode){
					$query .= ':parent('.$dom->parentNode->tagName.')';
					}
					
					$doc = jqm_use($node->_parentElement);
				
				$s = $doc->match_selector($query);
				
					$node->selector = new jqueryphp_abstracts_selector($s);
					
					return true;
					
					
			}
		}
		
		protected function refresh(){
			$node = $this->getNode();
				if(is_a($node,jqmel)){
					$k = key($node->_domId);
					
					if(array_key_exists('data-dom-id',$node->_attributes) AND $node->_attributes['data-dom-id'] !== $k){
						$node->_domId = array($k=>$node->_attributes['data-dom-id']);
					}
						$attr = $node->_attributes;
						$attr['data-dom-id'] = $node->_domId[$k];
						$node->_attributes = $attr;
						
						
					
				}
		}
		
		
		public function savehtml($refresh=true){
			
			if(extension_loaded('xml') AND class_exists('DomXpath')){
				if(get_parent_class($this) === __CLASS__){
				$node = $this->node;
			}elseif(get_parent_class($this)===false){
				$node = $this;
				}else{
					return false;
				}
				
					if(!is_a($node,jqmel))return false;
					if($node->_length ===false)return false;
				
				$docm = jqm_use($node->_parentElement);
				//$docm->__documentRaw = preg_replace('/\s+/',' ',$docm->__documentRaw);
				$doc = $docm->_DOM;
			
					if($doc->doctype){
				$doc->removeChild($doc->doctype);
					}	$k = key($node->_domId);
					if($refresh ==true){
						
						$this->refresh();
						
						$node->_attributes['data-dom-id'] = $k;
						
					}else{
						
							if($node->_domId[$k]===NULL){
							$attr = $node->_attributes;
							unset($attr['data-dom-id']);
							$node->_attributes = $attr;
							
							}else{
						$node->_attributes['data-dom-id'] = $node->_domId[$k];
							}
						
					}
					
					
				$newdoc = new domDocument;
				$dom = $node->dom()->get();
				$np = 'html';
						
			if($this->isxml() ===false){
				
				$newdoc->{'load'.$np}(mb_convert_encoding($dom->lastdom, 'HTML-ENTITIES', 'UTF-8'));
				$newdoc->preserveWhiteSpace = true;
			$newdoc->substituteEntities = true;
			$newdoc->formatOutput = true;
			$newdoc->encoding = 'utf-8';
			}else{
				$np = 'XML';
				$newdoc->{'load'.$np}($dom->lastdom);
				
			}
			
					if($newdoc->doctype){
				$newdoc->removeChild($newdoc->doctype);
					}
				
				$newdoc_get = $newdoc->getElementsByTagName($node->_name);
				
				if(is_a($node->DOMel,'DoMNode') AND $newdoc_get->length > 0){
					$item= $node->DOMel;
					
					$frag = $doc->importNode($newdoc_get->item(0),true);
							
							if($item->parentNode){	
						
					$item->parentNode->replaceChild($frag,$item);
					
						
							}
							
							if($this->isXML()==false){
						$node->DOMel = $frag;
						
							}else{
							$node->DOMel = $frag;	
							}
							
						
					
			$node->_attributes['data-dom-id'] = $node->_domId[$k];
			
				
			return $frag->getNodepath();
				}else{
					
				throw new Exception('Cannot assign node ID');
				}
				
				
				
			}
		}
		public function isxml(){
			$node =  $this->getNode();
			if(!is_a($node,jqmel))return;
			return jqm_use($node->_parentElement)->isxml;
		}
		public function Doc_isHtml(){
			$node =  $this->getNode();
				if(!is_a($node,jqmel))return;
			$docm = jqm_use($node->_parentElement);
			
			return (strip_tags($docm->__documentRaw,'<html>') !==$docm->__documentRaw);
		}
		
		protected function getPathByID(&$doc=NULL){
			if(!is_a($this,jqmel))return false;
						if(!is_a($doc,'DomDocument')){
					
					$document = jqm_use($this->_parentElement);
					$doc = $document->_DOM;
					
						}
						$x = new DomXpath($doc);
						$qs = $this->_name.'[@data-dom-id = "'.key($this->_domId).'"]';
					$find = $x->query('descendant-or-self::'.$qs);
					
						if($find->length > 0){
							$find = $find->item(0);
							if($find AND is_a($find,'DomElement')){
								return $find->getNodepath();
							}
						}
						return false;
		}
		
		public function refreshDom(){
			if(get_class() !==__CLASS__)return false;
				
					$document = jqm_use($this->_parentElement);
					$doc = $document->_DOM;
					
						$x = new DomXpath($doc);
						$qs = $this->_name.'[@data-dom-id = "'.key($this->_domId).'"]';
					$find = $x->query('descendant-or-self::'.$qs);
					
						if($find->length > 0){
							$find = $find->item(0);
						}
						
					if($find AND is_a($find,'DomElement')){
							if(!$document->isxml){
						$this->replaceWith($doc->saveHTML($find));
							}else{
								
								$this->replaceWith($doc->savexml($find));
							}
							
						$this->get_selector();
						return true;
					}else{
						
						$dom = $this->__toDomElement();
						
							if(is_a($dom,'DomElement')){
								
								if(!$document->isxml){
									
								$this->replaceWith($doc->saveHTML($dom));
								}else{
									
									$this->replaceWith($doc->savexml($dom));
									
								}
								
								$this->get_selector();
								return true;
							}
						return false;
					}
					return false;
		}
		
		public function __invoke(){
			
				if(is_a($this,jqmlist)){
					$node = $this->current();
					
				}elseif(is_a($this,jqmdoc)){
					$node = $this->first()->current();
				}else{
			$node = $this->getNode();
				}
				
			if(!is_a($node,jqmel))return new jqueryphp_abstracts_prevObject;
			$args = func_get_arg(0);
			if($args ===false)$args = '*';
			
				$find = $node->find($args)->get();
				
				return $find;
		}
		
		public function __clone(){
			$node= $this->getNode();
			if(!is_a($node,jqmel))return;
			$node->_domId = NULL;
			$node->_path = NULL;
		}
		
		public function toString(){
			if($this instanceof jqueryphp_abstracts_nodelist){
				$d = $this->first()->current()->__toDomElement();
			}else{
			$d = $this->__toDomElement();
			}
			
			if(is_a($d,'DoMNode')){
				$ns = 'html';
				if($this->isxml())$ns = 'xml';
				
				$n = $d->ownerDocument->{'save'.$ns}($d);
				$n = preg_replace('/\s+data-dom-id\=(?:(?:[\'"])+[a-z0-9]+[\'"])/x','',$n);
				return $n;
			}
			return NULL;
		}
	}

?>