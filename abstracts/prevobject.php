<?php
	defined('SAFE')or die();
	
	class jqueryphp_abstracts_prevObject extends stdClass implements Iterator, Countable, ArrayAccess{
		
		public function __construct($selector=null){
			$this->_selector = $selector;
			$this->_length = false;
		}
		
		public function __call($method,$arg){
			
			return null;
		}
		
		public function get(){
			return $this;
		}
		
		public function valid(){
			return false;
		}
		
		public function offsetExists($offset) {
			return false;
		}
		
		public function offsetGet($offset) {
			
			return false;
		}
		
		public function current(){
		return null;	
		}
		public function next(){
		return null;	
		}
		public function key(){
		return null;	
		}
		public function end(){
		return null;	
		}
		public function rewind(){
		return null;	
		}
		public function offsetSet($i,$a){
		return null;	
		}
		public function offsetUnset($i){
		return null;	
		}
		
		public function count(){
		return 0;	
		}
	}
	
?>