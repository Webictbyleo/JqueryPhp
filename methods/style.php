<?php
defined('SAFE')or die();
//Style Polyfill
	class jqueryphp_methods_style extends jqueryphp_abstracts_element{
		protected $node;
		public  function __construct(&$ele){
			
			$this->node  = $ele;
		}
		public function run($e=null){
			
		}
		public function __set(string $n,$v){
			if(!is_scalar($n))return false;
			if(!is_scalar($v))$v = (string)$v;
			//$n = $this->getCamelCase($n,'-');
			$this->css($n,$v);
			
		}
		
		public function __get($n){
			if(isset($this->node->_style->{$n}))return $this->node->_style->{$n};
			//$n = $this->getCamelCase($n,'-');
			//$n = strtolower($n);
			return $this->node->_style->{$n};
		}
		public function getPropertyValue(string $k){
			//$k = $this->getCamelCase($k,'-');
			return $this->__get($k);
		}
		public function hasProperty(string $k){
			//$k = $this->getCamelCase($k,'-');
			return isset($this->node->_style->{$k});
		}
		public function removeProperty(string $k){
			$this->__set($k,null);
			return $this;
		}
		public function setProperty(string $k,$v){
			$this->__set($k,$v);
			return $this;
		}
		private function getCamelCase(string $word,string $sep=null){
			$breaks = preg_split('/(?=[A-Z])/',$word,-1,PREG_SPLIT_NO_EMPTY);
			if(isset($sep)){
			$breaks = implode($sep,$breaks);
			$breaks = preg_replace('#\\'.$sep.'+#',$sep,$breaks);
			
			}
			return $breaks;
		}
		public function cssText(){
			return $this->node->_style->reduce();
		}
		public function toString(){
			return $this->node->_style->toString();
		}
		public function __toString(){
			return $this->toString();
		}
		public function get(){
			if(!isset($this->node->_style))return [];
			return $this->node->_style->toArray();
		}
	}
?>