<?php
defined('SAFE')or die();

	 class jqueryphp_abstracts_iterator extends stdClass{
		 
		 public function next(){
				if($this->_currentNode===false){
			 $this->seek(0);
				}
		$k = array_keys($this->__documentMap);
		++$k;
			if($this->offsetExists($k)){
		$this->_currentNode = $k;
		$item = $this->current();
		if(is_a($item,jqmel)){
				return new jqueryphp_abstracts_nodelist(array($k=>$item));
					}
			}
					return new jqueryphp_abstracts_prevObject($this->_selector.':next');
			}
			public function map($callback){
				if($this->count() < 1)return false;
			$is = (is_callable($callback) || function_exists($callback));
			
				if(!$is)return false;
				$e = $this->each($callback);
				
					if($e->length > 0){
						
				return $e->toArray();
					}
		}
			
			 public function last(){
			 $k = array_keys($this->__documentMap);
				$i = end($k);
				$item = $this->offsetGet($i);
				if(is_a($item,jqmel)){
				return new jqueryphp_abstracts_nodelist(array($i=>$item));
					}
					return new jqueryphp_abstracts_prevObject($this->_selector.':last');
			}
			 public function first(){
				
				$k = array_keys($this->__documentMap);
				$i = current($k);
				
				$item = $this->offsetGet($i);
				
				if(is_a($item,jqmel)){
				return new jqueryphp_abstracts_nodelist(array($i=>$item));
					}
					return new jqueryphp_abstracts_prevObject($this->_selector.':first');
			}
			 public function eq($index){
				if(is_numeric($index)){
					$index = (int)$index;
					$k = array_keys($this->__documentMap);
					$index = $k[$index];
				$item = $this->offsetGet($index);
					
					if(is_a($item,jqmel)){
						
				return new jqueryphp_abstracts_nodelist(array($index=>$item));
					}
					return new jqueryphp_abstracts_prevObject($this->_selector.':eq('
					.$index.')');
			}
			}
			 public function prev(){
				$k = array_keys($this->__documentMap);
				--$k;
					if($this->offsetExists($k)){
				$this->_currentNode = $k;
				
		$item = $this->current();
		if(is_a($item,jqmel)){
				return new jqueryphp_abstracts_nodelist(array($k=>$item));
					}
					}
					return new jqueryphp_abstracts_prevObject($this->_selector.':prev');
			}
			public function filter($query){
				
			$e = $this->each(function($i,$e,$query){
					
						if(is_callable($query) || function_exists($query)){
						$is = call_user_func($query,$e);
					}elseif(is_scalar($query)){
			$is = $e->is($query)->get();
					}
					if($is){
						
						return($e);
						}
				},$query);
				
				return $e;
		}
		public function not($query){
			$e = $this->each(function($i,$e,$query){
					
					if($e->not($query)->get()===true){
						
						return($e);
						}
				},$query);
				
				return $e;
		}
			public function index($selector='*'){
				$t = $this->count();
				if($selector ===NULL || $selector ==''){
						$selector = '*';
					}
				$k = array_keys($this->__documentMap);
					
			for($i=0;$t > $i;$i++){
						$this->seek($k[$i]);
						if($this->current()->_length ===false)continue;
							$is = $this->current()->is($selector);
							
							if($is->get() ===true){
									return $i;
								break;
							}
					}
				
				return -1;
			}
			public function slice($start=NULL,$end=NULL){
						$this->rewind();
					if($this->count()==1)return new jqueryphp_abstracts_nodelist(array($this->current()));
				$map = array_slice($this->__documentMap,$start,$end);
						if(is_array($map)){
					return new jqueryphp_abstracts_nodelist($map);
						}
						return new jqueryphp_abstracts_prevObject;
			}
			
			public function each($callback){
				
						if(!($this->count() > 0))return $this;
				$meta = new jqueryphp_abstracts_nodelist($this->__documentMap);
					$parse = call_user_func_array(array($meta,'each'),func_get_args());
					
					return $parse;
			}
			
			public function toArray(){
				return $this->export();
			}
		
		public function export(){
			return isset($this->__documentMap) ? $this->__documentMap : array();
		}
		
		public function __invoke(){
			
				if(is_a($this,jqmdoc)){
						$sp = func_get_arg(0);
						if(strip_tags($sp) != $sp){
							$dom = jqm($sp,'*',$this->isxml);
								$s = ':root';
								if(!$this->isXml AND strpos($sp,'<body') ===false){
									$s = 'html > body > *:first';
								}
							$node = $dom->find($s);
							
							return $node;
						}else{
						$node = $this->find($sp);
						}						
						if($node->length > 0){
							return new jqueryphp_abstracts_nodelist($this->export());
						}
				}
				
			return new jqueryphp_abstracts_prevObject;
			
		}
		
		
		public function __debugInfo(){
			
			return array(
			jqmdoc => $this->count()
			);
		}
	 }

?>