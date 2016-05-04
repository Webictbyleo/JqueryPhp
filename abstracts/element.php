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
		$_path;
		public $_length;
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
					$this->_domId = array(md5($id.'_'.microtime(true))=>$this->_attributes['data-dom-id']);	
					}else{
						$this->_domId = array(md5($id.'_'.microtime(true))=>NULL);
					}
				$k = key($this->_domId);
				//$this->attr('id',$k);
				$this->_attributes['data-dom-id'] = $k;
				
				$this->saveHTML(true);
				
					if(!is_null($this->_domId[$k])){
				$this->_attributes['data-dom-id'] =  $this->_domId[$k];
					}
				
			}
			
		}
		
		public function __call($method,$arg){
			
			$class = 'jqueryphp_methods_'.$method;
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
			
			if(get_parent_class($this) === __CLASS__){
				$node = $this->node;
			}elseif(get_parent_class($this)===false){
				$node = $this;
			}else{
				throw new Exception("Conversion not allowed within context(".get_called_class().")");
			}
			
			$document = jqm_use($node->_parentElement);
			
			
			
			
			$doc = $document->_DOM;
					
						if($doc->doctype){
					$doc->removeChild($doc->doctype);
						}
					$doc->preserveWhiteSpace = false;
					
					$path = new DomXpath($doc);
						$get = $path->query($node->_path);
						
						if($get->length > 0 ){
				
					return $get->item(0);
						}
						
						return false;
		}
		protected function __toArray(){
			if(get_parent_class($this) !== __CLASS__)throw new Exception("Conversion not allowed within context(".get_called_class().")");
			$array = array();
			$array[] = $this->node->_content;
			$array[] = $this->node->_name;
			$array[] = http_build_query($this->node->_attributes);
			$array[] = $this->node->_innerHtml;
			$array[] = $this->node->_localName;
			$array[] = $this->node->selector->pattern;
			$array[] = $this->node->_path;
			return ($array);
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
				$k = array_keys($doc->export());
				
				for($i=0;$doc->count() > $i;$i++){
					$doc->seek($k[$i]);
					$data = $doc->current()->data()->get();
					
					$find = array_intersect_assoc($relation,$data);
					
					if(empty($find))continue;
						
					
					return $doc->current();
					break;
				}
				return false;
	}
		
	protected function createFragment($content,$mapId = true){
			if(!empty($content) AND is_scalar($content)){
				$node = $this->getNode();
				$doc = jqm_use($node->_parentElement);
				
				
				if(is_a($doc,jqmdoc)){
						$dom = new domDocument;
						$dom->loadHTML($content);
						if($dom->doctype){
				$dom->removeChild($dom->doctype);
					}
						if($dom->childNodes->length > 1){
							$content = '<div>'.$content.'</div>';
						}
						unset($dom);
				$content = preg_replace('/\s+/',' ',$content);
				$regex = '/<([a-z0-9\-]*)\b(.*?)>(?:(.*?)(<\/\1>))?/ix';
				preg_match($regex,$content,$m);
				
				$selector = $doc->match_selector($m[1]);
				preg_match($selector['pattern'],$content,$m);
				}else{
					return new jqueryphp_abstracts_prevObject($content);
				}
					
				if(is_array($m) AND count($m) >= 2){
					$m[0] = $content;
					
					$se = preg_match('/<([a-z0-9\-]*)\b(.*?)>/ix',$content,$r);
					
					
					if($se==true AND !empty($r)){
						
						$wrap = substr($content,strlen($r[0]));
						
						$wrap = substr($wrap,0,strripos($wrap,'</'.$m[1].'>'));
						$m[3] = $wrap;
						unset($wrap);
					}
					$repair = preg_replace('/=([\'"])\s/','=$1',$m[2]);
					if(preg_match_all('#([\w\-_]{2,}) =* (?:(?:[\'"])(.*?)[\'"])?#ix', $repair, $test)){
							
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
			}elseif(get_parent_class($this)===false){
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
					$k = key($this->_domId);
					
					if(array_key_exists('data-dom-id',$node->_attributes) AND $node->_attributes['data-dom-id'] !== $k){
						$this->_domId = array($k=>$node->_attributes['data-dom-id']);
					}
						$attr = $node->_attributes;
						$attr['data-dom-id'] = $this->_domId[$k];
						$node->_attributes = $attr;
						
						
					
				}
		}
		
		
		public function saveHtml($refresh=true){
			
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
					}	$k = key($this->_domId);
					if($refresh ==true){
						
						$this->refresh();
						
						$node->_attributes['data-dom-id'] = $k;
						
					}else{
						
							if($this->_domId[$k]===NULL){
							$attr = $node->_attributes;
							unset($attr['data-dom-id']);
							$node->_attributes = $attr;
							
							}else{
						$node->_attributes['data-dom-id'] = $this->_domId[$k];
							}
						
					}
					
				$newdoc = new domDocument;
				$dom = $node->dom()->get();
				$newdoc->loadhtml($dom->lastdom);
				$newdoc->removeChild($newdoc->doctype);
				$newdoc->normalize();
				
				$newdoc_get = $newdoc->getElementsByTagName($node->_name);
			
				//Finder
				$xpath = new DomXpath($doc);
				$find = $xpath->query($node->_path);
				
				
					
				if($find->length > 0){
					$frag = $doc->importNode($newdoc_get->item(0),true);
					
							if($find->item(0)->parentNode){
					$find->item(0)->parentNode->replaceChild($frag,$find->item(0));
							}
						
					/* $output = $doc->saveHTML();
					
					$hasHTML = (strip_tags($docm->__documentRaw,'<html>') !==$docm->__documentRaw);
					
			if($hasHTML===false){
				
				//Return just a partial html
				$docm->__documentRaw = str_ireplace(array('<html>','<body>','</html>','</body>','<head>','</head>'),'',$output);
			}else{
				$docm->__documentRaw = $output;
			} */
			$node->_attributes['data-dom-id'] = $this->_domId[$k];
			
				
			return $frag->getNodepath();
				}
				
				
				
			}
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
						$this->replaceWith($doc->saveHTML($find));
						
						$this->get_selector();
						return true;
					}else{
						$dom = $this->__toDomElement();
							if(is_a($dom,'DomElement')){
								$this->replaceWith($dom->ownerDocument->saveHTML($dom));
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
				return $node->find($args)->get();
		}
		
		public function __clone(){
			$node= $this->getNode();
			if(!is_a($node,jqmel))return;
			$node->_domId = NULL;
			$node->_path = NULL;
		}
	}

?>