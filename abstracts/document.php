<?php
defined('SAFE')or die();
use Symfony\Component\CssSelector\CssSelectorConverter;
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
		public function __construct($document,$tagname='*'){
			
			
				
				if(!is_scalar($document)){
					throw new Exception('Not a valid {JQMDoc} object');
				}
				$this->_namespace = microtime(true).uniqid();
				jqm_var($this->_namespace,$this);
			//$document = preg_replace('/\s+/',' ',$document);
			
			//Detect if $document is a valid full document
			$hasHTML = (stripos($document,'<html') !==false);
				
			$this->__documentMap = array();
			$DOM = new DOMDocument;
			$DOM->encoding = 'utf-8';
			$DOM->recover = true;
			$DOM->preserveWhiteSpace = false;
			$DOM->formatOutput = true;
			$DOM->loadHTML($document,LIBXML_NOERROR | LIBXML_NOWARNING | LIBXML_COMPACT);
			
			
			
			//$DOM->normalizeDocument();
			$html = $DOM->getElementsByTagName($tagname);
			//Determine root / pieced map
			$hasRoot = false;
			
			if($html->item(0)->childNodes->length > 0){
				
				$hasRoot = false;
				$html_tmp = $html;
					if($html->item(0)->tagName =='html'){
						$html_tmp = $html->item(0)->childNodes->item(0);
					}
					
				if(!$hasHTML AND $html_tmp->childNodes->length ==1){
					$hasRoot = true;
						if($html_tmp->childNodes->item(0)->firstChild){
					$root = $html_tmp->childNodes->item(0)->firstChild->getNodePath();
						}else{
						$root = $html_tmp->childNodes->item(0)->getNodePath();	
						}
				}
			}
			$this->__schema['root'] = $hasRoot;
			$this->__schema['rootPath'] = $root;
			
			
			
			
			
			$this->__mapLength = false;
			$this->_length = false;
			$this->length = false;
				if($DOM->doctype){
					//$this->__schema['doctype'] = $DOM->saveHTML($DOM->doctype);
			$DOM->removeChild($DOM->doctype);
				}
			
				
			//$output = $DOM->saveHTML();
			
			//$this->__documentRaw = $output;
				$this->_DOM = $DOM;
	
				
			$this->_selector = $tagname;
			
				
				
				
				
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
				
				/* for($i=0;$t > $i;$i++){
					
					$this->seek($keys[$i]);
					
					
						if($this->current()->data('_length')->get() ===false){
							continue;
						}
						
			
			$domId = $this->current()->data('_domId')->get();
					
					$k = key($domId);
					
					
					$idk[] =  $k;
					$idv[] =  $domId[key($domId)];
					$this->current()->data('_length',false);
				} */
				
				$hasHTML = ($html !==true);
				
				$this->__documentRaw = $this->_DOM->savehtml();
				
			if($hasHTML){
				//Return just a partial html
				$this->__documentRaw = str_ireplace(array('<html>','<body>','</html>','</body>','<head>','</head>'),'',$this->__documentRaw);
				
			}
				
				$this->__mapLength = 0;
			unset($this->__documentMap);
			unset($this->_DOMMAP);
			unset($this->_DOM);
			unset($this->_DOMLINEMAPS);
			unset($this->_DOMLINES);
			}
			
			return $this->__documentRaw;
		}
		
		
		public function search($query){
			$query = trim($query);
			$query_arg = $this->match_selector($query);
			
				if(empty($query_arg))return false;
				if(empty($query_arg['pattern']))return false;
				if(empty($query_arg['selectors']))return false;
				
					
					
					$namespace = $this->_namespace;
				$count = 0;
				
				$all = $this->perform_query($query_arg);
		
				$ismulti = false;
					
				$totals[$query_arg['selectors']] = count($all[1]);
				
					if(isset($this->_multiselector) AND is_array($this->_multiselector)){
						$query_args = array($query_arg['selectors'] => $query_arg);
						$matches = $all;
						if(empty($matches)){
						$matches = array_fill(0,7,array());
						
							}
						
						
						$matches[5] = array_fill(0,$totals[$query_arg['pattern']],$query_arg['pattern']);
								if($matches[5] ===false || empty($matches[5])){
									$matches[5] = array();
								}
							foreach($this->_multiselector as $pattern){
								$arg =  $this->match_selector($pattern);
								
								$query_args[$arg['selectors']] = $arg;
								$ar = $this->perform_query($arg);
								
								array_shift($this->_multiselector);
									if(empty($ar) || empty($ar[0]))continue;
								$matches[0] = array_merge($matches[0],$ar[0]);
								$matches[1] = array_merge($matches[1],$ar[1]);
								$matches[2] = array_merge($matches[2],$ar[2]);
								$matches[3] = array_merge($matches[3],$ar[3]);
								$matches[4] = array_merge($matches[4],$ar[4]);
								$matches[6] = array_merge($matches[6],$ar[6]);
								$totals[$arg['selectors']] = count($ar[1]);
								$fills = array_fill(0,$totals[$arg['pattern']],$arg['pattern']);
								$matches[5] = array_merge($matches[5],$fills);
								
								
								unset($arg);
								unset($ar);
							}
							
						$ismulti = true;$all = $matches;
						unset($matches);
						
					}
					
					$this->removeMatchDuplicates($all);
						
					$counts = count($totals);
					
						
				$total = count($all[1]);
			$stops = $stop2 = array();
			for($i=0;$total > $i;$i++){
				
			$m = array($all[0][$i],$all[1][$i],$all[2][$i],$all[3][$i],$all[4][$i]);
			$paths = explode('|',$all[6][$i]);
					if($ismulti AND isset($query_args) AND is_array($query_args) AND isset($query_args[$all[5][$i]])){
					$query_arg = $query_args[$all[5][$i]];
					}
				--$totals[$query_arg['selectors']];
				if(empty($m))continue;
				 	 if(array_key_exists('first',$query_arg['filters'])){
					
							 if(!empty($stops) AND in_array($query_arg['selectors'],$stops)){
								continue;
							}
						
				}
				
				
				 	 
					
					
				
						if(array_key_exists('contains',$query_arg['filters']) AND !empty($query_arg['filters']['contains'])){
						if(strpos(strip_tags($m[3]),jqueryphp_abstracts_element::escape($query_arg['filters']['contains'])) ===false){
							continue;
						}
					}
					
					$repair = preg_replace('/=([\'"])\s/','=$1',$m[2]);
					
					
						
						if(preg_match_all('#([\w\-_]{2,}) =* (?:(?:[\'"])(.*?)[\'"])?#ix', $repair, $test)){
							
							if(empty($test[1])){
								$attr = array();
							}else{
								$attr = @array_combine($test[1],$test[2]);
								
							}
						}
						
					
					
					
					if(array_key_exists('button',$query_arg['filters']) AND in_array($m[1],array(
							'input','button'
							))){
								
								if($m[1] ==='input' AND (!isset($attr['type']) || $attr['type']!=='button'))
									continue;
									}
						if(array_key_exists('not',$query_arg['filters']) AND $found==false){
								
										if(!empty($query_arg['filters']['not'])){
											
										}else{
										$found = true;
										}
									}
					
					
					if(array_key_exists('eq',$query_arg['filters']) AND is_numeric($query_arg['filters']['eq'])){
						
						if($query_arg['filters']['eq'] != $i){
							continue;
						}
					}
					if(array_key_exists('gt',$query_arg['filters']) AND is_numeric($query_arg['filters']['gt'])){
						
						if(($i > (int)$query_arg['filters']['gt']) ==false){
							continue;
						}
					}
					if(array_key_exists('lt',$query_arg['filters']) AND is_numeric($query_arg['filters']['lt'])){
						
						if(($i < (int)$query_arg['filters']['lt']) ==false){
							continue;
						}
					}
					if(array_key_exists('odd',$query_arg['filters'])){
						
						if(($i % 2==0) ==true){
							continue;
						}
					}
					if(array_key_exists('even',$query_arg['filters'])){
						
						if(($i % 2==0) ==false){
							continue;
						}
					}
					
					if(array_key_exists('parent',$query_arg['filters'])){
						
								if(isset($query_arg['filters']['parent']) AND !empty($query_arg['filters']['parent'])){
									$parents = explode('/',$paths[3]);
									
									
									
									$ps = strpos(end($parents),$query_arg['filters']['parent']);
										if($ps ===false)continue;
									if($ps !==0){
										continue;
									}
								}
									if(empty($m[3]))continue;
							
								if(strlen($m[3]) < 1){
									continue;
								}
								
							
						
					}
					if(array_key_exists('has',$query_arg['filters'])){
						if(empty($m[3]))continue;
						if(strip_tags($m[3]) == $m[3])continue;
							if(!empty($query_arg['filters']['has'])){
						if(preg_match('/<('.$query_arg['filters']['has'].'+)\b(.*?>?:(.*?)<\/\1>)?/ix',strip_tags($m[3],'<'.$query_arg['filters']['has'].'>')) !=true){
							continue;
						}
							}
					}
					
					 if(array_key_exists('first',$query_arg['filters'])){
					
								$stops[] = $query_arg['selectors'];
						}
						if(array_key_exists('last',$query_arg['filters'])){
								
							if($totals[$query_arg['selectors']]===0){
								$stop2[] = $query_arg['selectors'];
								
							}
							
					}
					if(array_key_exists('last',$query_arg['filters'])){
					 if(!empty($stop2) AND in_array($query_arg['selectors'],$stop2)){
							
							}else{
								continue;
							}
				}
				$ele = $this->toElement($m);
				$ele->_selector = $this->_selector.' '.$query_arg['selectors'];
				$ele->_nodeLevel = $query_arg['pattern'];
				$ele->_length = 1;
				$ele->length = 1;
				$ele->_localName = $all[4][$i];
				$ele->_parentElement = $namespace;
				$ele->_token = $count;
				
				
				$ele->_path = $paths[0];
				$ele->_prev_path = $paths[1];
				$ele->_next_path = $paths[2];
				$ele->_parent_path = $paths[3];
				$ele->_attributes = $attr;
				$ele->selector = new jqueryphp_abstracts_selector($query_arg);
				
				$ele->setDomID($namespace.$i);
					$count++;
					$eles[] = $ele;
					
				}
				
				$this->__documentMap = $eles;
				
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
				
				return $this;
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
		public function match_selector($params,$xpathPrefix='descendant-or-self::',$includeXpath=true){
			//Check multiple query selectors
			if(strpos($params,',')){
				$this->_multiselector = explode(',',$params);
				$params = array_shift($this->_multiselector);
				
			}
			$selectors = array();
			preg_match('#(?<![\.\#\[\]])([A-Z0-9]+)?#is',$params,$findtag);
			
					if(!empty($findtag[1])){
						
						$tag = $findtag[1];
					}
					
					$attri = $selected_filters = array();
					if(!empty($tag)){
					$regex = '/<('.$tag.')\b(.*?)>(?:(.*?)(<\/\1>))?/ix';	
					}else{
						$regex = '/<([a-z0-9\-]*)\b(.*?)>(?:(.*?)(<\/\1>))?/ix';
					}
				
				//Match  deep selection
				
				if(str_replace(array(' ','>','<'),'',$params) !==$params){
					$regex = '/<([a-z0-9\-]*)\b(.*?)>(?:(.*?)(<\/\1>))?/ix';
					
					
				}
					//Match special selectors e.g psudo,filter
					if(strpos($params,':') !==false){
						$filters = array('first','last','input','even','not','odd',
							'first-child','last-child','visible','hidden','parent','empty','button','checked','file','text','disabled','submit','checkbox','selected','radio','has','contains','eq','gt','lt','nth-child','first-of-type','last-of-type','nth-last-child','nth-of-type','nth-last-of-type','only-child','only-of-type','header'
						);
						$regexp = '/\:+([A-Z0-9\-]+)*([\(](.*?)[\)])?/ix';
						$pseudo = preg_match_all($regexp,$params,$query);
						
						if($pseudo){
						
						$selected_filters = array_intersect($query[1],$filters);
						$selected_filters = array_fill_keys($selected_filters,NULL);
						
						
						if(strpos(implode(' ',str_replace(array('has','contains','eq','gt','lt','parent','nth-child','nth-last-child','nth-of-type','nth-last-of-type'),'*',array_keys($selected_filters))),'*')!==false){
							
							/* $funcs = array_intersect_key($selected_filters,array('has'=>NULL,'contains'=>NULL,'eq'=>NULL,'gt'=>NULL,'lt'=>NULL,'parent'=>NULL)); */
							
							$selected_filters = array_intersect_key(array_combine($query[1],$query[3]),$selected_filters);
							
							
						}
						
						if(array_key_exists('last-of-type',$selected_filters) || array_key_exists('first-of-type',$selected_filters) || array_key_exists('nth-of-type',$selected_filters) || array_key_exists('nth-last-of-type',$selected_filters)){
							
								if(empty($tag) || $tag ==='*'){
									throw new Exception('Selector requires ElementType. But not found.');
								}
							$params=  str_replace(array(':last-of-type',':first-of-type','nth-of-type','nth-last-of-type'),array('last-child','first-child','nth-child','nth-last-child'),$params);
							if(isset($selected_filters['nth-of-type'])){
								$selected_filters['nth-child'] = $selected_filters['nth-of-type'];
								unset($selected_filters['nth-of-type']);
							}
							if(isset($selected_filters['last-of-type'])){
								$selected_filters['last-child'] = $selected_filters['last-of-type'];
								unset($selected_filters['last-of-type']);
							}
							if(isset($selected_filters['first-of-type'])){
								$selected_filters['first-child'] = $selected_filters['first-of-type'];
								unset($selected_filters['first-of-type']);
							}
							if(isset($selected_filters['nth-last-of-type'])){
								$selected_filters['nth-last-child'] = $selected_filters['nth-last-of-type'];
								unset($selected_filters['nth-last-of-type']);
							}
							
							
						}
						if(array_key_exists('input',$selected_filters)){
							$tag = 'input|select|textarea|button';
							$regex = '/<('.$tag.'*)\b([^>]*)>(?:(.*?)(<\/\1>))?/ix';
							$t = 'input%s,select%s,textarea%s,button%s';
							$tt = $params;
							$start = strrpos($params,':input');
								if($start !==false AND $start > 0){
									$start = substr($params,0,$start);
									$t = $start.'input%s,'.$start.'select%s,'.$start.'textarea%s,'.$start.'button%s';
									$tt = substr($params,strlen($start));
									
								}
								$others = str_replace(':input','',$tt);
								if(empty($others)){
									$others = '';
								}
								
								$t = str_replace('%s',$others,$t);
								
							$params=  $t;
							
						}
							if(array_key_exists('header',$selected_filters)){
							$tag = 'h1|h2|h3|h4|h5|h6';
							$regex = '/<('.$tag.'*)\b([^>]*)>(?:(.*?)(<\/\1>))?/ix';
							
							$t = 'h1%s,h2%s,h3%s,h4%s,h5%s,h6%s';
							$tt = $params;
							$start = strrpos($params,':header');
								if($start !==false AND $start > 0){
									$start = substr($params,0,$start);
									$t = $start.'h1%s,'.$start.'h2%s,'.$start.'h3%s,'.$start.'h4%s,'.$start.'h5%s,'.$start.'h6%s';
									$tt = substr($params,strlen($start));
								}
								$others = str_replace(':header','',$tt);
								if(empty($others)){
									$others = '';
								}
								
								$t = str_replace('%s',$others,$t);
								
							$params=  $t;
							}
							
						if(array_key_exists('checked',$selected_filters)){
							$tag = 'input';
							$regex = '/<('.$tag.'*)\b([^>]*)>(?:(.*?)(<\/\1>))?/ix';
							$attri['colExists'][] = 'type';
							$attri['Like']['type'] = 'radio checkbox';
							$attri['K_Not']['type'] = array('radio checkbox');
							$attri['colExists'][] = 'checked';
						}
						
						if(array_key_exists('selected',$selected_filters)){
							$tag = 'option';
							$regex = '/<('.$tag.'*)\b([^>]*)>(?:(.*?)(<\/\1>))?/ix';
							$selected_filters['parent'] = 'select';
							$attri['colExists'][] = 'selected';
							
						}
						
						
						if(array_key_exists('file',$selected_filters) || array_key_exists('text',$selected_filters)){
							$tag = 'input';
							if(array_key_exists('file',$selected_filters)){
							$params = str_replace(':file','[type=file]',$params);
							}else{
								$params = str_replace(':text','[type=text]',$params);
							}
						}
						if(array_key_exists('submit',$selected_filters)){
							
							$regex = '/<(input|button*)\b([^>]*)>(?:(.*?)(<\/\1>))?/ix';
							$t = 'button[type=submit]%s,input[type=submit]%s';	
							$tag = 'input|button';
							$tt = $params;
							$start = strrpos($params,':submit');
								if($start !==false AND $start > 0){
									$start = substr($params,0,$start);
									$t = $start.'button[type=submit]%s,'.$start.'input[type=submit]%s';
									$tt = substr($params,strlen($start));
								}
								$others = str_replace(':submit','',$tt);
								if(empty($others)){
									$others = '';
								}
								$t = str_replace('%s',$others,$t);
							$params=  $t;
						}
						
						
						
						if(array_key_exists('button',$selected_filters)){
							$tag = 'input|button';
							
								
							$regex = '/<('.$tag.'*)\b([^>]*)>(?:(.*?)(<\/\1>))?/ix';
							$t = 'button%s,input[type=button]%s';	
							$tt = $params;
							$start = strrpos($params,':button');
							
								if($start !==false AND $start > 0){
									$start = substr($params,0,$start);
									
									$t = $start.'button%s,'.$start.'input[type=button]%s';
									$tt = substr($params,strlen($start));
									
								}
								$others = str_replace(':button','',$tt);
								if(empty($others)){
									$others = '';
								}
								
								$t = str_replace('%s',$others,$t);
							$params=  $t;
							
							
						}
						
				}
					}
					
					
			if(strpos($params,'#') !==false){
				//Has id
				
				if(preg_match('/(\#+[A-Z0-9_-]+)/i',$params,$query)){
					//Has another declaration
					$selectors['id'] = trim($query[1],'#');
				}
				
			}
			//Match tag class
			$r = '#\.+([A-Z0-9_-]+)(?![^\[]*\])#i';
			if(preg_match_all($r,$params,$query)){
				//Has class
				
					$selectors['class'] = str_replace('.','',implode('|',$query[1]));
					
			}
			
			//Match tag attributes
				
				
			if(preg_match_all('/\[(.*?)\]/',$params,$query)){
				
			
				if(preg_match_all('#\[([\w\-]{2,})\=(.*?)\]#',$params,$ts)){
				$attr = array_combine($ts[1],$ts[2]);
				$selectors = array_merge($selectors,$attr);
				
				}
				$ts = NULL;
				//Get Prefix tag attributes |=
				if(preg_match_all('#\[([\w\-]{2,})(\*=|\|=|\!=|\~=|\$=|\^=)+(.*?)\]#x',$params,$ts)){
				//Get contains substring tag attributes  *=
				//Get contains word tag attributes ~=
				//Get ends with substring tag attributes $=
				////Get dont have substring tag attributes !=
				//Get starts with substring tag attributes ^=
				//Get Has attribute [attr]
			
					$f = count($ts[2]);
					for($i=0;$f > $i;$i++){
						switch($ts[2][$i]){
							case '*=':
							if(isset($attri['IN'][$ts[1][$i]])){
								
							$attri['IN'][$ts[1][$i]][]= $ts[3][$i];
								}else{
								$attri['IN'][$ts[1][$i]]= array($ts[3][$i]);	
								}
							break;
							case '!=':
								if(isset($attri['K_Not'][$ts[1][$i]])){
							$attri['K_Not'][$ts[1][$i]][]= $ts[3][$i];
								}else{
								$attri['K_Not'][$ts[1][$i]]= array($ts[3][$i]);	
								}
							break;
							case '~=':
							$attri['Like'][$ts[1][$i]]= $ts[3][$i];
							break;
							case '|=':
							$attri['Inrange'][$ts[1][$i]]= array_filter(explode(' ',$ts[3][$i]));
							break;
							case '$=':
							$attri['EndsWith'][$ts[1][$i]]= $ts[3][$i];
							break;
							case '^=':
							
							$attri['BeginsWith'][$ts[1][$i]]= $ts[3][$i];
							break;
							default:
							continue;
						}
					}
				}
				$ts = NULL;
				if(preg_match_all('#\[([\w\-]{2,})\]#x',$params,$ts)){
					$attri['colExists'] = $ts[1];
				}
				$ts = NULL;
				if(preg_match_all('#\[\!+([\w\-]{2,})\]#x',$params,$ts)){
					$attri['colNotExists'] = $ts[1];
				}
				$ts = NULL;
				
				
				
				
			}
				if($includeXpath===true){
			$xpath = $this->getXpath($params,$xpathPrefix);
				}
			
			return array('pattern'=>$regex,'selectors'=>$params,'specifier'=>$selectors,'filters'=>$selected_filters,'tag'=>$tag,'attributes'=>$attri,'xpath'=>$xpath);
				 
			
			
		}
		private function getChildrenQuote(&$param,$quote){
			
		}
		public function getXpath($query,$prefix=NULL){
			 $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '#:(contains|first|last|parent|gt|lt|submit|button|hidden|visible|has|eq)(?!-)\b([\(](.*?)[\)])?#x',    // Strip style tags properly
  );
  '/<('.$tag.'*)\b([^>]*)>(?:(.*?)(<\/\1>))?/ix';
			$query = preg_replace($search,'',$query);
				
			$x = new CssSelectorConverter;
		$path = ($x->toXPath($query,$prefix));
		//var_dump(func_get_arg(0).'=>'.$query);
		return $path;
					
				
		}
		public function toElement(array $props){
			$ele = new jqueryphp_abstracts_element;
						$ele->_content = $props[0];
						$attrString = preg_replace('/([\'"])+\s/i','$1&', $props[2]);
					
						parse_str($attrString,$attr);
						$ele->_attrMap = $props[2];
						$ele->_name = $props[1];
						$ele->_nodeLevel = NULL;
						$ele->_innerHtml = $props[3];
						$ele->_innerText = strip_tags($props[3]);
						//Transverse the children
						$compact = trim($props[3]);
						$ishtml = (($pos = strpos($compact,'<'))===0);
							if($ishtml){
								//try to get the first tag used
								$pos = strcspn($compact,' ');
								$ele->_childElement = str_replace('>','',trim(substr($compact,1,$pos)));
							}
						
						
						$ele->_attributes = $attr;
						return $ele;
		}
		
		private function perform_query($pattern){
			//$ner =$this->_DOMLINEMAPS;
			$d = $this->_DOM;
			
			$x = new DomXpath($d);
			
			$found = $x->query($pattern['xpath']);
			
			if(isset($this->__schema) AND $this->__schema['root']===true){
				
			//Move the top to the botton
					
			}
			
				
				$t = $found->length;
				$all = array();
				for($i=0;$t > $i; $i++){
					$ner = $found->item($i);
					
					$s = $d->saveHTML($ner);
					preg_match($pattern['pattern'], str_replace(array("\n","\t","\r"),'',$s), $test);
					
					if(empty($test))continue;
					 if($ner->nodeType !==1){
						continue;
					}
					$all[0][$i] = $test[0];
					$all[1][$i] = $test[1];
					$all[2][$i] = $test[2];
					
					//If has inline element, do a woraround to get the proper inline element
					
					/*  if(!empty($test[3])){
						$e = '<'.$test[1].$test[2].'>';
						
						$e = substr($ner[$i],strlen($e));
						
									
						$inline = substr($e,0,-(strlen($test[4])));
						$test[3] = $inline;
									
						
					} */ 
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
					$all[3][$i] = $test[3];
					$all[4][$i] = $test[4];
					$all[6][$i] = implode('|',array($map->_path,$map->_prev_path,$map->_next_path,$map->_parent_path));
					
					
				}
			
				return $all;
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