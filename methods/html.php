<?php
defined('SAFE')or die();

class jqueryphp_methods_html extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($new =Null){
				//If its a document element
			if(!is_null($new) and is_scalar($new)){
					if(is_a($new,jqmel)){
						
					}
					$dom = $this->node->toString();
			$se = preg_match('/<('.$this->node->_name.'*)\b(.*?)>/xsi',$dom,$r);
			
			if($se){
				if(isset($r[0])){
					$new = $r[0].$new.'</'.$this->node->_name.'>';
					
					$this->node->replaceWith($new,func_get_arg(1));
				}
			}
				
				
			}else{
				return $this->node->_innerHtml;
			}
			
		}
		
		public function get(){
			
			return $this->node->_innerHtml;
		}
		
		
}


?>