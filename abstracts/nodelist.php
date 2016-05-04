<?php
defined('SAFE')or die();

	class jqueryphp_abstracts_nodelist extends jqueryphp_abstracts_element{
		
		protected $nodeList;
		public $_length;
		public $length;
		private $tmparg;
		private $tmpmethod;
		private $keys;
		private $_ns;
			public function __construct(array $nodes,$_ns=NULL){
				if(empty($nodes))$nodes  =array();
				$this->nodeList = new ArrayIterator($nodes);
						if($this->nodeList->valid){
					$this->seek(0);
						}
					$this->_length = $this->length = $this->count();
					$this->keys = array_keys($nodes);
					if($this->length > 0){
						$ns  = $nodes[0];
							if(is_a($ns,jqmel)){
								$this->_ns = $ns->_parentElement;
							}elseif(!empty($_ns)){
								$this->_ns = $_ns;
							}
					}
			}
			
			public function __call($method,$arg){
				
					
					
						if($this->count() > 1){
							
						$this->tmparg = $arg;
						$this->tmpmethod = $method;
						
						$call = $this->each('jqueryphp_abstracts_nodelist::crf');
						
						}elseif($this->count() === 1){
							
							$call = call_user_func_array(array($this->current(),$method),$arg);
							//$n = $call->getNode();
							if($method==='parent'){
							//var_dump($call);
							}
						
							
						}
				
				return $call;
			}
			public function last(){
			
				$i = end($this->keys);
				$item = $this->nodeList->offsetGet($i);
				if(is_a($item,jqmel)){
				return new jqueryphp_abstracts_nodelist(array($i=>$item));
					}
					return new jqueryphp_abstracts_prevObject($this->_selector.':last');
			}
			 public function first(){
				
				
				$i = current($this->keys);
				$item = $this->nodeList->offsetGet($i);
				if(is_a($item,jqmel)){
				return new jqueryphp_abstracts_nodelist(array($i=>$item));
					}
					return new jqueryphp_abstracts_prevObject($this->_selector.':first');
			}
			protected function crf(){
				
				$this->current()->trace = $this->nodeList;
				
				$call = call_user_func_array(array($this->current(),$this->tmpmethod),$this->tmparg);
				
				unset($this->current()->trace);
					
				return $call;
			}
			public function index($selector='*'){
				$t = $this->count();
				if($selector ===NULL || $selector ==''){
						$selector = '*';
					}
			
			
			for($i=0;$t > $i;$i++){
						$this->seek($this->keys[$i]);
						if($this->current()->_length ===false)continue;
							$is = $this->current()->is($selector);
							
							if($is->get() ===true){
									return $i;
								break;
							}
					}
				
				return -1;
			
		}
		
		public function not($query){
			$e = $this->each(function($i,$e,$query){
					
					if($e->not($query)->get()===true){
						
						return($e);
						}
				},$query);
				
				return $e;
		}
		
		public function filter($query){
			$e = $this->each(function($i,$e,$query){
					if(is_callable($query) || function_exists($query)){
						$is = call_user_func($query,$e);
					}elseif(is_scalar($query)){
			$is = $e->is($query)->get();
					}
						
					if($is===true){
						
						return($e);
						}
				},$query);
				
				return $e;
		}
		public function eq($index){
			
			if(is_numeric($index)){
				$index = $this->keys[$index];
				$item = $this->nodeList->offsetGet($index);
				
					if(is_a($item,jqmel)){
						
				return new jqueryphp_abstracts_nodelist(array($item));
					}
					return new jqueryphp_abstracts_prevObject($this->_selector.':eq('
					.$index.')');
			}
		}
		
		public function map($callback){
					if($this->length < 1)return false;
			$is = (is_callable($callback) || function_exists($callback));
			
				if(!$is)return false;
				$e = $this->each($callback);
				
					if($e->length > 0){
				return $e->nodeList->getArrayCopy();
					}
		}
		
		public function end(){
			if($this->count() > 0){
				$this->nodeList->rewind();
				
			}
			return $this;
		}
			public function each($callback=''){
				
				if($this->nodeList->valid()){
					
					$t = $this->count();
					$args = func_get_args();
					$call = func_get_arg(0);
					$is_callable = (is_null($call)==false AND is_callable($call));
					
					$isMulti = ($this->count() > 1);
					for($i=0;$t > $i;$i++){
						$this->seek($this->keys[$i]);
						
						if($this->current()->_length ===false)continue;
						
							if($is_callable===true){
								
								unset($args[0]);
								
								$arg = array($i,$this->current());
								if(isset($args) AND is_array($args) AND !empty($args)){
									$arg = array_merge($arg,$args);
								}
								if($isMulti ===true){
									$this->current()->trace = $this->nodeList;
								}
							
								if(is_scalar($callback)){
									
								}
								
								if(is_a($callback,Closure)){
							$callback = Closure::bind($callback,$this->current());
								}
						$out[] = call_user_func_array($callback,$arg);
						unset($this->current()->trace);
								if($this->current()->_length ===false){
										
										--$this->length;
										--$this->_length;
										
								}
							}
						
					}
					
					$this->nodeList->rewind();
					if(isset($out) AND is_array($out)){
				$out = array_filter($out);
				$t = count($out);
				$out = array_splice($out,0,$t,false);
				
				$out = new jqueryphp_abstracts_nodelist($out);
				
				return $out;
					}	
					
					return $this;
				}
				return new jqueryphp_abstracts_prevObject();
			}
			public function count(){
				return $this->nodeList->count();
			}
			public function seek($i){
					try{
				return $this->nodeList->seek($i);
					}catch(Exception $e){
							
					}
			}
			public function current(){
				return $this->nodeList->current();
			}
			public function toArray(){
				return $this->nodeList->getArrayCopy();
			}
			public function refresh(){
				
			}
	}

?>