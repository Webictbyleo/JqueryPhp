<?php
defined('SAFE')or die();

class jqueryphp_methods_each extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_document &$ele){
			$this->node  = $ele;
			
			
		}
		
		public function run($callback){
			$total = $this->node->count();
			$k = array_keys($this->node->export());
				
			for($i=0;$total > $i;$i++){
				$this->node->seek($k[$i]);
					if(is_callable($callback)){
						$out[] = call_user_func_array($callback,array($i,$this->node->current()));
					}
			}
			if(isset($out) AND is_array($out)){
				$out = array_filter($out);
				$t = count($out);
				$out = array_splice($out,0,$t,false);
				
				$out = new jqueryphp_abstracts_nodelist($out);
				return $out;
			}
			
		}
		
		public function get(){
			
			return $this->node->_content;
		}
		
		
}


?>