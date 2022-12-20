<?php
defined('SAFE')or die();

class jqueryphp_methods_text extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($str=NULL){
			
				if(!is_null($str) AND is_scalar($str)){
					
					$this->node->_innerHtml = str_replace(array("\n","\r"),'',strip_tags($str));
					$this->node->_innerText = $this->node->_innerHtml;
					$dom = $this->node->__toDomElement();
					$dom->nodeValue = $this->node->_innerText;
				}else{
				$dom = ($this->node->__toDomElement());
				$this->node->_innerText = $dom->nodeValue;
				}
			return $this;
		}
		
		public function get(){
			
			return $this->node->_innerText;
		}
		
		
}


?>