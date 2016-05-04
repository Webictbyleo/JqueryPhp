<?php
defined('SAFE')or die();

	class jqueryphp_abstracts_metadata extends options{
		
		protected $last_method;
		protected static $node;
			//Noww map every call to the collection
		public function __call($method,$args){
			$class = $method;
			$node = $this->toArray();
				$call = $node[key($node)];
				$this->set('last_method',$class);
				$this->set('last_method_args',$args);
				
				$call->each(function($i,$e){
					$method = $this->get('last_method');
					$args = $this->get('last_method_args');
					
					$run = call_user_func_array(array($e,$method),$args);
					
				});
				return $this;
				
				
		}
		public function run($method){
			//$this->toArray();
			$args = func_get_args();
			$method= array_shift($args);
			
				
			$call = $this->get($method);
			if(strpos($method,'jqueryphp_methods') !==false){
					$method = substr($method,18);
				}
				$this->set('last_method',$method);
				$this->set('last_method_args',$args);
				$call->each(function($i,$e){
					$method = $this->get('last_method');
					$args = $this->get('last_method_args');
					$run = call_user_func_array(array($e,$method),$args);
					
				});
			return $this;
		}
	}
?>