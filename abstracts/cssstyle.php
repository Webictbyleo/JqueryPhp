<?php
	defined('SAFE')or die();
	
	class jqueryphp_abstracts_cssStyle{
		private $style = array();
		
		public function __construct($styles){
			$this->setArray($styles);
		}
		
		public function __get($name){
			if(!isset($this->style))return null;
			$name = $this->getCamelCase($name);
			if(array_key_exists($name,$this->style))return $this->style[$name];
			return null;
		}
		
		public function __isset($name){
			$name = $this->getCamelCase($name);
			
			return array_key_exists($name,$this->style);
		}
		private function isEmptyValue($v){
			if(!is_scalar($v))return true;
			if(is_numeric($v))return false;
			$v = trim(preg_replace('/\s+/','',$v));
			return $v==='';
		}
		public function __set($name,$val){
			if(!is_scalar($name))return $this;
			$name = $this->getCamelCase($name);
			
			if($val===null || $val===''){
			$this->remove($name);
			return $this;	
			}
			$this->style[$name] = $val;
			return $this;
		}
		
		public function toArray(array $filter=null){
			if(isset($filter))return array_intersect_key($this->style,$filter);
			return $this->style;
		}
		
		public function isEmpty(){
			return empty($this->style);	
		}
		
		public function remove($key){
			$key = $this->getCamelCase($key);
			unset($this->style[$key]);
			return $this;
		}
		
		public function join($input){
			$input = self::parseInput($input);
			if($input){
				$this->style = array_merge($this->style,$input);
			}
			$this->style = array_filter($this->style,function($v){
				return $this->isEmptyValue($v)==false;
			});
			
			return $this;
		}
		
		public function setArray($input){
			$input = self::parseInput($input);
			if($input){
				$this->style = array_filter($input,function($v){
				return $this->isEmptyValue($v)==false;
				});
			}
			return $this;
		}
		
		private  function parseInput($input){
			if(is_object($input) and $input InstanceOf jqueryphp_abstracts_element){
				$input = $input->attr('style')->get();
			}
			if(is_scalar($input) and !is_null($input)){
				$input = trim($input,';').';';
				if(preg_match_all('/([a-z\_\-]+)\:([^;].*?);/i',$input,$m)){
					$input = array();
					
					foreach($m[1] as $i=>$j){
						$n = strtolower($j);
						$v = trim($m[2][$i]);
						$n = $this->getCamelCase($n);
						$input[$n] = $v;
					}
					}else{
					return false;
				}
				
				}else if(is_array($input)){
					$keys = array_keys($input);
					$keys = array_map('self::getCamelCase',$keys);
					$input = array_combine($keys,array_values($input));
					
			}
			
			if(!is_array($input))return false;
			return $input;
			
		}
		
		public function evaluate(jqueryphp_abstracts_element &$node){
			
		}
		private function getCamelCase(string $word){
			$breaks = preg_split('/(?=[A-Z])/',$word,-1,PREG_SPLIT_NO_EMPTY);
			if(!empty($breaks)){
			$breaks = implode('-',$breaks);
			$breaks = preg_replace('#\\-+#','-',$breaks);
			$word = strtolower($breaks);
			}
			
			return $word;
		}
		public function reduce(){
			if(empty($this->style))return '';
			$a = [];
			foreach($this->style as $n=>$v){
				$a[] = $n.':'.$v;
			}
			return implode('; ',$a);
		}
		
		public function toString(){
			$a = $this->reduce();
			if($a=='')return null;
			return 'style="'.$a.'"';
		}
		
		public function __toString(){
			return $this->toString();
		}
	}
?>