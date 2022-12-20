<?php
defined('SAFE')or die();
use Symfony\Component\CssSelector;
	class jqueryphp_abstracts_document extends jqueryphp_abstracts_iterator  implements SeekableIterator, Countable, ArrayAccess{
		
			protected $__localLength;
			protected $__mapLength;
			protected $__documentMap;
			public $__documentRaw;
			protected $_currentNode;
			protected $_selector;
			protected $_multiselector;
			protected $_DOMMAP;
			protected $_DOMLINES;
			protected $_DOMLINEMAPS;
			public $_DOM;
			public $_length;
			public $length;
			private $__schema = array(
			'root'=>false,
			'rootPath'=>NULL,
			'rootIndex'=>NULL,
			'doctype'=>'<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">'
			);
			private $_namespace;
			public $isxml = false;
			private static $cssXpath;
		public function __construct($document,$tagname='*',$xml=false){
			
			
				$this->isxml = $xml;
				if(!is_scalar($document)){
					throw new Exception('Not a valid {JQMDoc} object');
				}
				$this->_namespace = microtime(true).uniqid();
				jqm_var($this->_namespace,$this);
			//$document = preg_replace('/\s+/',' ',$document);
			
			//Detect if $document is a valid full document
			
				self::$cssXpath = $x = new CssSelector\CssSelectorConverter(($xml ==false));
			$this->__documentMap = array();
			$DOM = new DOMDocument;
			
			
			$DOM->recover = true;
			 $DOM->preserveWhiteSpace = true;
			$DOM->substituteEntities = true;
			$DOM->formatOutput = true;
			$DOM->encoding = 'utf-8';
				$np = $xml==false?'html':'xml';
				if(is_file($document)){
				$DOM->load($document,LIBXML_PARSEHUGE);
				}else{
				$DOM->{'load'.$np}($document,LIBXML_PARSEHUGE);
				}
				
				
				
			
			$DOM->normalizeDocument();
			
			$this->__mapLength = false;
			$this->_length = false;
			$this->length = false;
				if($DOM->doctype){
			$DOM->removeChild($DOM->doctype);
				}
			
				$this->_DOM = $DOM;
			
				
			$this->_selector = $tagname;
			
		}
		public function getDocument(){
		return $this->_DOM;	
		}
		public function find($query){
			return $this->search($query);
		}
		//Return a compiled string
		public function __toString(){
			
			if(isset($this->_DOM)){
				
				$html = func_get_arg(0);
				$this->rewind();
				//Get the namespace in use
			
					$t = $this->count();
					
				$keys = array_keys($this->__documentMap);
				
				
				$hasHTML = ($html !==true);
						if(!$this->isxml){
				$this->__documentRaw = $this->_DOM->savehtml();
						}else{
						$this->__documentRaw = $this->_DOM->savexml();	
						}
				
			if($hasHTML){
				//Return just a partial html
				$this->__documentRaw = str_ireplace(array('<html>','<body>','</html>','</body>','<head>','</head>'),'',$this->__documentRaw);
				
			}
				$this->__documentRaw = preg_replace('/\s+data-dom-id\=(?:(?:[\'"])+[a-z0-9]+[\'"])/x','',$this->__documentRaw);
				$this->__mapLength = 0;
			/* unset($this->__documentMap);
			unset($this->_DOMMAP);
			unset($this->_DOM);
			unset($this->_DOMLINEMAPS);
			unset($this->_DOMLINES); */
			}
			
			return $this->__documentRaw;
		}
		
		
		public function search($query){
			$query = trim($query);
			
			$query_arg = $this->match_selector($query);
			
				if(empty($query_arg))return false;
				if(empty($query_arg['pattern']))return false;
				if(empty($query_arg['selectors']))return false;
				
					
				$all = $this->perform_query($query_arg);
					
					$count = count($all);
				
			
				
				$this->__documentMap = $all;
				
						if($count > 1){
				//Deselect 
				$this->_currentNode = false;
						}elseif($count ===1){
							//Select the current element
							$this->seek(0);
						}
				
				
				unset($ele);
				$this->__mapLength = $count;
				$this->_length = $this->length = $count;
				if($this->count() < 1)return new jqueryphp_abstracts_prevObject($query_arg);
				return new jqueryphp_abstracts_nodelist($this->__documentMap);
				
		}
		protected function matchAttributeSelectors(array &$attr,array &$against){
				
			$passed = false;
			$selector_classes = array_keys($attr);
			$t = count($selector_classes);
			//Sort accroding to operation priority
			rsort($selector_classes);
			
				for($i=0;$t > $i; $i++){
					$selector = $selector_classes[$i];
					
						foreach($attr[$selector] AS $key => $val){
							if($selector=="K_Not"){
								
								if(!array_key_exists($key,$against)){
									$passed  = true;
								}else{
									
									$passed = (in_array($against[$key],$val)===false);
									
								}
							}if($selector=="Like"){
								if(!array_key_exists($key,$against)){
									$passed  = false;
								}else{
								
								str_replace(explode(' ',$against[$key]),'*',$val,$c);
									$passed = ($c > 0);
								
								}
							}
							if($selector=="Inrange"){
								if(!array_key_exists($key,$against)){
									$passed  = false;
								}else{
								$passed = in_array($against[$key],$val);
								}
								
							}
							if($selector=="IN"){
								str_ireplace(explode(' ',$against[$key]),'*',$val,$c);
								$passed = ($c > 0);
							}
							if($selector=="EndsWith"){
								if(!array_key_exists($key,$against)){
									$passed  = false;
								}else{
									$passed = (substr($against[$key], -strlen($val)) === $val);
									
								}
							}
							if($selector=="BeginsWith"){
								if(!array_key_exists($key,$against)){
									$passed  = false;
								}else{
									$passed = (strpos($against[$key], $val) === 0);
									
								}
							}
						}
				}
				
				return $passed;
		}
		//Build the required preg for the query
		public function match_selector($params,$ns=null){
			//Check multiple query selectors
			/* if(strpos($params,',')){
				$this->_multiselector = explode(',',$params);
				$params = array_shift($this->_multiselector);
				
			} */
			$includeXpath=true;
			$selectors = array();
			preg_match('#(?<![\.\#\[\]])([A-Z0-9]+)?#is',$params,$findtag);
			
					if(!empty($findtag[1])){
						
						$tag = $findtag[1];
					}
					
					$attri = $selected_filters = array();
					if(!empty($tag)){
					$regex = '/<('.$tag.')\b(.*?)>(?:(.*?)(<\/\1>))?/xsi';	
					}else{
						$regex = '/<([a-z0-9\-]*)\b(.*?)>(?:(.*?)(<\/\1>))?/xsi';
					}
				
				//Match  deep selection
				
				if(str_replace(array(' ','>','<'),'',$params) !==$params){
					$regex = '/<([a-z0-9\-]*)\b(.*?)>(?:(.*?)(<\/\1>))?/xsi';
					
					
				}
					
					
					
			
				if($includeXpath===true){
			$xpath = $this->getXpath($params,(isset($ns) ? $ns :null));
				}
			
			return array('pattern'=>$regex,'selectors'=>$params,'specifier'=>$selectors,'filters'=>$selected_filters,'tag'=>$tag,'attributes'=>$attri,'xpath'=>$xpath);
				 
		}
		
		private function getChildrenQuote(&$param,$quote){
			
		}
		
		public function registerNamespace(string $prefix=null){
			if(!isset($prefix)){
			unset($this->namespacePrefix);
			return $this;	
			}
			$this->namespacePrefix = $prefix;
			return $this;
		}
		public function getXpath($query,$prefix=NULL){
			 $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '#:(contains|first|last|parent|gt|lt|submit|button|hidden|visible|has|eq)(?!-)\b([\(](.*?)[\)])?#x',    // Strip style tags properly
  );
  '/<('.$tag.'*)\b([^>]*)>(?:(.*?)(<\/\1>))?/ix';
			//$query = preg_replace($search,'',$query);
				
				if(!isset(self::$cssXpath)){
					self::$cssXpath = new CssSelector\CssSelectorConverter(($this->isxml ==false));
				}
				
		$path = (self::$cssXpath->toXPath($query,$prefix));
		if($this->isxml and isset($this->namespacePrefix)){
			$path = preg_replace('#\%ns#i',$this->namespacePrefix.':',$path);
		}else{
		$path = preg_replace('#\%ns#i','',$path);
		}
		
		return $path;
					
				
		}
		public function toElement(array $props){
			$ele = new jqueryphp_abstracts_element;
						$ele->_content = $props[0];
						//$attrString = preg_replace('/([\'"])+\s/i','$1&', $props[2]);
						preg_match_all('/([\w\_\-\:]+)(?:=["\']([^\"\']+){0,}["\']{0,}){0,}/i',$props[2],$mt);
						$attr = [];
						
						
						foreach($mt[1] as $i=>$k){
							$k = trim($k);
							$v = trim($mt[2][$i],' "\'');
							
							$attr[$k] = $v;
						}
						
						//Get style
						if(preg_match('/style=(?:([\'"])(.*?)\1|\'(.*?)\')/s',$props[2],$m)){
							
							$attr['style'] = $m[2];
						}
						
						
						
						$ele->_attrMap = $props[2];
						$ele->_name = $props[1];
						$ele->_nodeLevel = NULL;
						$ele->_innerHtml = $props[3];
						$ele->_innerText = str_replace(array("\n","\r"),'',strip_tags($props[3]));
						
						
						
						
						$ele->_attributes = $attr;
						
						
						if(isset($attr['style']) and !empty($attr['style'])){
							
							$style = array();
							$stl = $attr['style'];
							$stl = trim($stl,';').';';
							preg_match_all('/([a-z\_\-]+)\:([^;].*?);/i',$stl,$m);
							
							foreach($m[1] as $i=>$j){
								$n = strtolower($j);$v = trim($m[2][$i]);
								$style[$n] = $v;
							}
							//$ele->style = $style;
							
							$ele->_style = new jqueryphp_abstracts_cssStyle($style);
						}
						/* if(strlen($props[2])==497){
						//preg_match_all('/(\w)=([\'"]+)(.+)\2/',$props[2],$mt);
						//preg_match('/style=([\'"]+)(.+)\1/',$props[2],$m);
						
						var_dump($ele);
						die;
						} */
						return $ele;
		}
		public function Xpath(Domdocument $d){
			$x = new DomXpath($d);
			if($this->isxml){
				$ns= $d->firstChild->namespaceURI;
				$nk = $d->firstChild->nodeName;
				if(empty($ns) and isset($this->namespacePrefix) and $this->namespacePrefix==='svg'){
				$ns = 'http://www.w3.org/2000/svg';
				$nk = 'svg';
				}
				if(!empty($ns)){
					
					$x->registerNamespace($nk,$ns);	
				}
			}
			
			return $x;
		}
		public function perform_query($pattern){
			
			$d = $this->_DOM;
			$x = $this->Xpath($d);
			$namespace = $this->_namespace;
			
			$found = $x->query($pattern['xpath']);
			
				$t = $found->length;
				$eles = array();
				$count = 0;
				
				
				
				for($i=0;$t > $i; $i++){
					$ner = $found->item($i);
						if($this->isxml){
							$s = $d->saveXML($ner);
						}else{
					$s = $d->saveHTML($ner);
						}
					
					
					
					$se = preg_match('/<('.$ner->tagName.'*)\b(.*?)>/xsi',$s,$main);
					
						if($ner->childNodes->length > 0){
							
						$wrap = substr($s,strlen($main[0]));
						$wrap = substr($wrap,0,strripos($wrap,'</'.$ner->tagName.'>'));
						$main[3] = $wrap;
						$main[4] = '</'.$ner->tagName.'>';
						}
					
					if(empty($main))continue;
					 if($ner->nodeType !==1){
						 
						continue;
					}
					$all[0] = $s;
					$all[1] = $ner->tagName;
					$all[2] = $main[2];
					
					$map = (object)array('_path'=>NULL,'_prev_path'=>NULL,'_next_path'=>NULL,'_parent_path'=>NULL);
					
					if($ner->nextSibling){
						$map->_next_path = $ner->nextSibling->getNodePath();
					}
					if($ner->previousSibling){
						$map->_prev_path = $ner->previousSibling->getNodePath();
					}
					if($ner->parentNode){
						$map->_parent_path = $ner->parentNode->getNodePath();
					}
					$map->_path = $ner->getNodePath();
					$all[3] = $main[3];
					$all[4] = $main[4];
					if(!$this->isxml){
					$main[2] = str_replace("\n",'',$main[2]);
					}
					$attr = array();
					$repair = preg_replace('/=([\'"])\s/','=$1',$main[2]);
						
						preg_match_all('#([\w\-_]{1,}) =? (?:(?:[\'"])(.*?)[\'"])?#ix', $repair, $test);
							
							if(empty($test[1])){
								$attr = array();
							}else{
								$attr = @array_combine($test[1],$test[2]);
								
							}
						
						
				
				$ele = $this->toElement($all);
				$ele->_selector = $pattern['selectors'];
				$ele->_nodeLevel = $pattern['pattern'];
				$ele->_length = 1;
				$ele->length = 1;
				$ele->_localName = $all[4];
				$ele->_parentElement = $namespace;
				$ele->_token = $count;
				$ele->setDom($ner);
				$ele->_path = $map->_path;
				$ele->_prev_path = $map->_prev_path;
				$ele->_next_path = $map->_next_path;
				$ele->_parent_path = $map->_parent_path;
				//$ele->_attributes = $attr;
				$ele->selector = new jqueryphp_abstracts_selector($pattern);
				
				$ele->setDom($ner);
				$ele->setDomID($namespace.$i);
					$count++;
					$eles[] = $ele;
				}
			
				return $eles;
		}
		
		protected static function removeMatchDuplicates(&$all){
				if(!is_array($all))return array();
				if(empty($all[0]))return array();
			//Remove duplicates
				$filtered = array_unique($all[6]);
				$retained_keys = array_keys($filtered);
				$retained_i = count($retained_keys);
				//Contents
				
					$contents = array_intersect_key($all[0],$filtered);
					$contents = array_values($contents);
						
					 //tags
					 $tags = array_intersect_key($all[1],$filtered);
					 
					  $tags = array_values($tags);
					
					//Attributes
					$attributes = array_intersect_key($all[2],$filtered);
					$attributes = array_values($attributes);
				//Inline contents
				$inlines = array_intersect_key($all[3],$filtered);
					$inlines = array_values($inlines);
				//Closing tags
				$close = array_intersect_key($all[4],$filtered);
				$close = array_values($close);
				//Patterns
					if(isset($all[5])){
				$patterns = array_intersect_key($all[5],$filtered);
				$patterns = array_values($patterns);
					}
				$filtered = array_values($filtered);
				
				 $all[6] = $filtered;
				 $all[0] = $contents;
				$all[1] = $tags;
				$all[2] = $attributes;
				$all[3] = $inlines;
				$all[4] = $close;
				$all[5] = isset($patterns) ? $patterns : array();
				unset($filtered);
				unset($tags);
				unset($attributes);
				unset($inlines);
				unset($close);
				unset($patterns);
				unset($contents);
				
			return $all;
		}
		
		public function __call($method,$arg){
					if($this->count() < 1)return new jqueryphp_abstracts_prevObject;
			$class = 'jqueryphp_methods_'.$method;
				
			
			
				if($this->count() > 1 AND $this->key() ===false AND $method !=='each'){
					
					//We're working with dom collections
					$meta = new jqueryphp_abstracts_nodelist($this->__documentMap);
					
					
					$parse = call_user_func_array(array($meta,$method),$arg);	
					return $meta;
				}elseif($this->count() ===1){
					$node = $this->current();
					$call = new $class($node);
				 return $parse = call_user_func_array(array($call,'run'),$arg);	
				}
			return $call;
		}
		public function offsetExists($i){
			
				if(!is_numeric($i))return false;
				
			$search = array_key_exists($i,$this->__documentMap);
			
			return $search;
		}
		
		public function offsetGet($i){
			if(!$this->offsetExists($i))return false;
				
			return $this->__documentMap[$i];
		}
		
		
		
		public function offsetSet($i, $ele){
				if(is_object($ele) and !$ele instanceOf jqueryphp_abstracts_element)return false;
						if($this->offsetExists($i)){
						
				$this->__documentMap[$i] = $ele;
				return $i;
						}
					$prepend = func_get_arg(2);
					
				++$this->__mapLength;
				++$this->_length;
				++$this->length;
				
				$ele->data('_token',$this->length);	
				
					if($prepend===true){
						array_unshift($this->__documentMap,$ele);
						$k = array_keys($this->__documentMap);
						return $k[0];
					}else{
					$this->__documentMap[] = $ele;	
					$k = array_keys($this->__documentMap);
					return end($k);
					}
				
				
					
				return false;
			}
			public function offsetUnset($i){
			
			if(!$this->offsetExists($i)){
				return false;
			}
			
				
			unset($this->__documentMap[$i]);
			
			--$this->__mapLength;
			--$this->length;
			--$this->_length;
			$this->__documentMap = array_slice($this->__documentMap,0,$this->__mapLength,true);
			
			return true;
		}
		
		public function count(){
		return isset($this->__mapLength) ? $this->__mapLength : 0;
	}
	//Fulfil some jquery support
	public function length(){
		return $this->count();
	}
	public function _length(){
		return $this->count();
	}
	public function current(){
		if ($this->valid() === false) {
            return null;
        }
		
			$i = $this->_currentNode;
			
			if(!is_numeric($i))$i=0;
		return $this->offsetGet($i);
	}
		public function key(){
		return $this->_currentNode;
	}
	
	
	
	public function rewind(){
		$k = array_keys($this->__documentMap);
		$this->_currentNode = $k[0];
	}
	public function valid(){
		return ($this->offsetExists($this->_currentNode) AND $this->count() > 0);
	}
	public function seek($i){
		
		if($this->offsetExists($i)){
			
					$this->_currentNode = $i;
					return true;
				}
				return false;
	}
	
	public function trigger($event){
		
		$t = new jqueryphp_methods_trigger($this);
		$arg = func_get_args();
		$call =call_user_func_array(array($t,'run'),$arg);	
		
		return $call;
		
	}
	
	public function getNs(){
		return $this->_namespace;
	}
	public function __destruct(){
		unset($this->_DOMMAP);
		unset($this->_DOMLINEMAPS);
		unset($this->_DOM);
		}
	}

?>