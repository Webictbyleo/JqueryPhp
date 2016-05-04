<?php
defined('SAFE')or die();

	class jqueryphp_abstracts_event{
		
		protected $data;
		protected $type;
		protected $timeStamp;
		protected $namespace;
		protected $target;
		public $result;
		protected $isTrigger;
		protected $currentTarget;
		var $preventDefault =false;
		
		public function __construct($type,$target,$data,$isTrigger=true,$namespace=NULL){
			$this->type = $type;
			$this->data = $data;
			$this->target = $target;
			$this->timeStamp = microtime(true).uniqid();
			$this->isTrigger = $isTrigger;
				if(!empty($namespace)){
					$this->type .= '.'.$namespace;
				}
			
		}
		
		public function __get($n){
			return $this->{$n};
		}
		
	}
	

?>