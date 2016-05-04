<?php
defined('SAFE')or die();

class jqueryphp_methods_off extends jqueryphp_abstracts_Window{
	
		
		protected static $node;
		
		public  function __construct(&$ele){
			$this->node  = $ele;
		}
		
		public function run($event,$selector=NULL){
				
			if($event==NULL)return $this;
				
				if(!is_a($this->node,jqmel))return $this;
				$ns = $this->node->data('_parentElement')->get();
					if(empty($ns))return $this;
					$document = jqm_use($ns);
				
					
			if(!isset($document->Window) AND !is_a($document->Window,jqmwin))return false;
			if(!array_key_exists($event,$this->node->events))return false;
			
						if(empty($selector)){
					$this->node->events->{$event} = array();
						}else{
							$evs = $this->node->events->{$event};
							$c = count($evs);
							for($i=0;$c > $i;$i++){
								if(!empty($evs[$i][2]) AND is_a($this->node,jqmel)){
							
							$is = $this->node->is($selector)->get();
								if($is !==true)continue;
									unset($this->node->events->{$event}[$i]);
						}
							}
							
						}
				
				
			
			
				
			return $this;
			
		}
		
		public function get(){
			
			return $this;
		}
		
		
}


?>