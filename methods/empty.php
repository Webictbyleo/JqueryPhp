<?php
defined('SAFE')or die();

class jqueryphp_methods_empty extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run(){
				if($this->node->__toDomElement()->childNodes->length  < 1)return;
			$dom = $this->node->toString();
			$se = preg_match('/<('.$this->node->_name.'*)\b(.*?)>/xsi',$dom,$r);
			if($se){
				if(isset($r[0])){
					$new = $r[0].'</'.$this->node->_name.'>';
					$this->node->replaceWith($new);
				}
			}
			$this->node->_innerHtml = NULL;
			$this->node->_innerText = NULL;
			
			return $this;
		}
		
		public function get(){
			
			return true;
		}
		
		
}


?>