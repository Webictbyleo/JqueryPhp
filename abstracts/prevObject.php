<?php
defined('SAFE')or die();

	 class jqueryphp_abstracts_prevObject extends stdClass{
		 
		 public function __construct($selector){
			 $this->_selector = $selector;
			 $this->_length = false;
		 }
		 
		 public function __call($method,$arg){
			 return $this;
		 }
	 }

?>