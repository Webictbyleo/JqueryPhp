<?php
defined('SAFE')or die();

class jqueryphp_methods_is extends jqueryphp_abstracts_document{
	
		
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
					return $this->done = (call_user_func($new,$this->node) ==true);
				}else{
					$query = $this->match_selector($new,'self::',false);
				}
				
				$attr = $this->node->data('_attributes')->get();
				$path = $this->node->data('_path')->get();
				$ns = $this->node->data('_parentElement')->get();
				$tag = $this->node->data('_name')->get();
				$done = false;
				$d = jqm_use($ns);
					$this->query_arg = $query;
					if(array_key_exists('button',$query['filters'])){
						if(!in_array($tag,array('input','button')))return $this->done =false;
						if($tag =='input' AND !array_key_exists('type',$attr))return $this->done =false;
						if($tag =='input' AND $attr['type'] !=='button')return $this->done =false;
					}
					
					if(array_key_exists('header',$query['filters'])){
						$regex = '/h1|h2|h3|h4|h5|h6|h[1-9]/ix';
						if(preg_match($regex,$tag)==false)return $this->done =false;
					}
					if(array_key_exists('first',$query['filters'])){
						if(!isset($this->node->trace)){$this->done = true;}else{
							$i = key($this->node->trace);
							$first = $this->node->trace[$i];
								if($first !== $this->node)return $this->done =false;
						}
					}
					if(array_key_exists('last',$query['filters'])){
						if(!isset($this->node->trace)){$this->done = true;}else{
							
							$last = end($this->node->trace);
								if($last !== $this->node)return $this->done =false;
						}
					}
					if(array_key_exists('checked',$query['filters'])){
							
							if($tag !=='input')return $this->done =false;
								if(!in_array($attr['type'],array('radio','checkbox'))){
									return $this->done =false;
								}
					}
					if(array_key_exists('file',$query['filters'])){
						if($tag !=='input')return $this->done =false;
						if($attr['type'] !=='file')return $this->done =false;
					}
					if(array_key_exists('text',$query['filters'])){
						if($tag !=='input')return $this->done =false;
						if($attr['type'] !=='text')return $this->done =false;
					}
					if(array_key_exists('submit',$query['filters'])){
						if(!in_array($tag,array('input','button')))return $this->done =false;
						if($attr['type'] !=='submit')return $this->done =false;
					}
					if(array_key_exists('checkbox',$query['filters'])){
						if($tag !=='input')return $this->done =false;
						if($attr['type'] !=='checkbox')return $this->done =false;
					}
					if(array_key_exists('radio',$query['filters'])){
						if($tag !=='input')return $this->done =false;
						if($attr['type'] !=='radio')return $this->done =false;
					}
					if(array_key_exists('selected',$query['filters'])){
						if($tag !=='option')return $this->done =false;
						if(!array_key_exists('selected',$attr))return $this->done =false;
							$query['filters']['parent'] = 'select';
					}
					if(array_key_exists('has',$query['filters'])){
						$html = $this->node->html()->get();
						if(empty($html) || (strip_tags($html) ==$html))return $this->done =false;
							if(!empty($query['filters']['has'])){
								if(preg_match('/<('.$query['filters']['has'].')\b(.*?)>(?:(.*?)(<\/\1>))?/ix',$html)==false){
									return $this->done =false;
								}
							}
						
					}
					if(array_key_exists('disabled',$query['filters']) AND !array_key_exists('disabled',$attr)){
						return $this->done =false;
					}
					if(array_key_exists('contains',$query['filters'])){
						$html = $this->node->html()->get();
						$html = strip_tags($html);
						if(empty($html))return $this->done =false;
								if(!empty($query['filters']['contains'])){
							if(strpos($html,jqueryphp_abstracts_element::escape($query['filters']['contains'])) ===false){
								return $this->done =false;
							}
								
								}
						
					}
					if(array_key_exists('visible',$query['filters'])){
						
							if($this->isHidden() ===true){
								return $this->done =false;
							}
					}
					if(array_key_exists('hidden',$query['filters'])){
						if($this->isHidden() ===false){
								return $this->done =false;
							}
					}
					
					if(array_key_exists('only-child',$query['filters'])){
						$doc = $d->_DOM;
						
						$xpath = new domXpath($doc);
						$node = $xpath->query($path);
						
							if($node->length < 1)return $this->done =false;
							if(!$node->item(0)->parentNode)return $this->done =false;
							if(!$node->item(0)->parentNode->childNodes)return $this->done =false;
							if($node->item(0)->parentNode->childNodes->length > 1)return $this->done =false;
					}
					
					
					if(array_key_exists('nth-child',$query['filters'])){
						
						if($query['filters']['nth-child'] ==NULL || strlen($query['filters']['nth-child'])===0)return $this->done =false;
						$pos = strrpos($path,'[');
						
							if($pos ===false)return $this->done =false;
							if($pos == (strlen($path)-1))return $this->done =false;
							
							$pos = trim(substr($path,$pos),'[]');
							
								if(!is_numeric($pos))return $this->done =false;
									$pos = (int)$pos;
										
									if(is_numeric($query['filters']['nth-child'])){
										if(((int)$query['filters']['nth-child']) < 1)return $this->done =false;
										if($pos !== (int)$query['filters']['nth-child'])return $this->done =false;
									}elseif($query['filters']['nth-child'] ==='even'){
										if(($pos % 2==0) ==false)return $this->done =false;
									}elseif($query['filters']['nth-child']==='odd'){
										if(($pos % 2==0) ==true)return $this->done =false;
									}else{
										
										return $this->done =false;
									}
					}
					if(array_key_exists('nth-last-child',$query['filters'])){
						$doc = $d->_DOM;
						
						$xpath = new domXpath($doc);
						$node = $xpath->query($path);
						if($node->length < 1)return $this->done =false;
						if(!$node->item(0)->parentNode)return $this->done =false;
						$cht = $node->item(0)->parentNode->childNodes->length;
							if(is_numeric($query['filters']['nth-last-child'])){
								$pos = (int)$query['filters']['nth-last-child'];
								if($pos < 1)return $this->done =false;
								$pos = ($cht - $pos);
							}elseif(in_array($query['filters']['nth-last-child'],array('even','odd'))){
								$pos = strrpos($path,'[');
							if($pos ===false)return $this->done =false;
							if($pos == (strlen($path)-1))return $this->done =false;
							$pos = trim(substr($path,$pos),'[]');
							if(!is_numeric($pos))return $this->done =false;
							$pos = (int)$pos;
							if($query['filters']['nth-last-child'] ==='even'){
								if((($cht - $pos) % 2==0) ===true){
									return $this->done =false;
									}
								}
								if($query['filters']['nth-last-child'] ==='odd'){
								if((($cht - $pos) % 2==0) ===false){
									return $this->done =false;
									}
								}
							}else{
								return $this->done =false;
							}
							
								if($pos > $cht)return $this->done =false;
								
									if($pos < 0)return $this->done =false;
									$chd = $node->item(0)->parentNode->childNodes->item($pos-1);
										if(!$chd)return $this->done =false;
									if($node->item(0)->isSameNode($chd)===false)return $this->done =false;
									unset($chd);
					}
					if(array_key_exists('only-of-type',$query['filters'])){
						$doc = $d->_DOM;
						
						$xpath = new domXpath($doc);
						$node = $xpath->query($path);
						
							if($node->length < 1)return $this->done =false;
							if($node->item(0)->childNodes){
								
							if($node->item(0)->childNodes->length > 0  AND $node->item(0)->childNodes->item(0)->nodeType !==3) return $this->done =false;	
							}
							
					}
					
					
				
					if(array_key_exists('first-child',$query['filters'])){
						$doc = $d->_DOM;
						
						$xpath = new domXpath($doc);
						$node = $xpath->query($path);
						
							if($node->length < 1)return $this->done =false;
							if(!$node->item(0)->parentNode)return $this->done =false;
							if($node->item(0)->parentNode->firstChild->isSameNode($node->item(0))===false)return $this->done =false;
					}
					if(array_key_exists('last-child',$query['filters'])){

						$doc = $d->_DOM;
						
						$xpath = new domXpath($doc);
						$node = $xpath->query($path);
							
							if($node->length < 1)return $this->done =false;
							
							if(!$node->item(0)->parentNode)return $this->done =false;
							
							if($node->item(0)->parentNode->lastChild->isSameNode($node->item(0))===false)return $this->done =false;
					}
					if(isset($query['specifier'])){
						$v = array_intersect_key($query['specifier'],$attr);
							
							if(isset($query['tag'])){
								
								$ipt = explode('|',$query['tag']);
								
									if(!in_array($this->node->data('_name')->get(),$ipt)){
										return $this->done= false;
									}
									
							}
							
						if(count($query['specifier']) >0 and empty($v))return $this->done= false;
					}
					
						//Find Has attr
						
						if(array_key_exists('id',$query['specifier'])){
							if($query['specifier']['id'] !== $v['id'])return $this->done= false;
						}
						
						if(array_key_exists('class',$query['specifier'])){
								$classes = $v['class'];
								
								$hasclass= $this->node->hasClass($classes)->get();
								if($hasclass){
									$v['class'] = $attr['class'];
									
								}
								
							}
							
							$this->matched = $v;
							
						$v = count(array_intersect($v,$attr)) >= count($query['specifier']);
						
							if($v===false){
								return $this->false= true;
							}
							
							if(!empty($query['attributes'])){
					
						$found = false;
						$attrkeys = array_keys($attr);
						
							if(isset($query['attributes']['colExists'])){
							$validAttr = array_intersect($query['attributes']['colExists'],$attrkeys);	
						$found = ($validAttr);
						$found = (count($validAttr) > 0 AND  count($validAttr) === count($query['attributes']['colExists']));
							}
							if(isset($query['attributes']['colNotExists'])){
								$validAttr = array_diff($query['attributes']['colNotExists'],$attrkeys);
								
									$found = (!empty($found) AND $validAttr == $query['attributes']['colNotExists']);
									
							}
							
							
							$check  =$query['attributes'];
							unset($check['colNotExists']);
							unset($check['colExists']);
							if(isset($check) AND is_array($check) AND !empty($check)){
								
								$found = $this->matchAttributeSelectors($check,$attr);
							
							}
						
							
						if(!$found){$this->done= false;return;}
						
					}
					
					
					if(!empty($query['filters'])){
						$path = $this->node->data('_path')->get();
					if(array_key_exists('empty',$query['filters']) 
					){
					$inner = $this->node->data('_innerHtml')->get();
							if(!empty($inner)){
							return $this->done= false;	
							}
						
					}
					if(array_key_exists('parent',$query['filters'])){
						
								if(isset($query['filters']['parent']) AND !empty($query['filters']['parent'])){
									$parents = explode('/',$path);
									array_pop($parents);
									$ps = strpos(end($parents),$query['filters']['parent']);
									if($ps ===false)$this->done= false;return;
									if($ps !==0){
										$this->done= false;return;
									}
								}
								$inner = $this->node->data('_innerHtml')->get();
								
									if(empty($inner))return $this->done= false;
							
								if(strlen($inner) < 1){
									
									$this->done= false;return;
								}
								
								
							$this->done= true;
							
						
					}
					if(strripos($path,']') == strlen($path)-1){
$path = substr($path,strripos($path,'['));

if(preg_match('/\[(\d)\]/',$path,$match)){
$path = $match[1];
	}else{
		$path = 1;
	}
					}else{
						$path = 1;
					}
					
					if(is_numeric($path)){
			$i = (Int)$path - 1;
			
			unset($path);
			
				if($i < 0){$this->done= false;return;}
				
			if(array_key_exists('eq',$query['filters']) AND is_numeric($query['filters']['eq'])){
						
						if($query['filters']['eq'] != $i){
							$this->done= false;
							return;
						}
						
					}
					if(array_key_exists('gt',$query['filters']) AND is_numeric($query['filters']['gt'])){
						
						if(($i > (int)$query['filters']['gt']) ==false){
							$this->done= false;return;
						}
					}
					if(array_key_exists('lt',$query['filters']) AND is_numeric($query['filters']['lt'])){
						
						if(($i < (int)$query['filters']['lt']) ==false){
							$this->done= false;return;
						}
					}
					if(array_key_exists('odd',$query['filters'])){
						
						if(($i % 2==0) ==true){
							$this->done= false;return;
						}
					}
					if(array_key_exists('even',$query['filters'])){
						
						if(($i % 2==0) ==false){
							$this->done= false;return;
						}
					}
					
		}
					}
		
			return $this->done= true;
			
		}
		
		public function get(){
			$this->negate();
			return $this->done;
		}
		
		public function __toString(){
			$this->negate();
			return isset($this->done) ? false:false;
		}
		
		private function isHidden(){
			$css = $this->node->css()->get();
			$tag = $this->node->data('_name')->get();
			$attr = $this->node->attr()->get();
						$hidden = false;
						
						if($tag ==='input' AND $attr['type'] ==='hidden'){
								return $this->done =true;
						}
						
						if(in_array($tag,array('option','script','link','title','head','meta'))){
							return $this->done =true;
						}
							if(is_a($this->node->parents(':hidden:first')->get(),jqmel)){
								return $this->done = true;
							}
							if($css['display']==='hidden'){
									return $this->done =true;
								}
							
							if($this->node->width()->get()===0){
									return $this->done =true;
								}
							if($this->node->height()->get()===0){
									return $this->done =true;
								}
							if(array_key_exists('opacity',$css) AND $css['opacity'] < 1){
								return $this->done =true;
							}
							
							if($hidden !==true){
								
									return $this->done =false;
								
							}
							return $this->done = $hidden;
		}
		private function Negate(){
			if(array_key_exists('not',$this->query_arg['filters'])){
						//Negate
						
							if($this->done ==false){
							return $this->done = true;
							}else{
								return $this->done = false;
							}
					}
		}
}


?>