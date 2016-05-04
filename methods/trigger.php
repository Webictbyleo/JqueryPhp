<?php
defined('SAFE')or die();

class jqueryphp_methods_trigger extends jqueryphp_abstracts_Window{
	
		
		protected static $node;
		private static $resultSet = array();
		private static $isDefaultPrevented = array();
		
		public  function __construct(&$ele){
			$this->node  = $ele;
		}
		
		public function run($eventname){
			
			if($eventname==NULL)return $this;
				
			if(!is_a($this->node->Window,jqmwin)){
				$ns = $this->node->data('_parentElement')->get();
				
					if(empty($ns))return $this;
					$document = jqm_use($ns);
				
					if(is_a($document->Window,jqmwin)){
						$this->node->data('Window',$document->Window);
					}else{
						return $this;
					}
			}
			
				if(!is_a($this->node->Window,jqmwin))return $this;
				if($this->node instanceOf jqueryphp_abstracts_document){
					$target = ':root';
					
				}elseif(is_a($this->node,jqmel)){
					$domid = key($this->node->data('_domId')->get());
					$target = '[data-dom-id="'.$domid.'"]';
					$tag = $this->node->data('_name')->get();
						if(!empty($tag)){
							$target = $tag.$target;
						}
				}
				
			//Preload the default events if loaded
				if(isset($this->node->Window->Event->{$eventname})){
					if(!isset($this->node->events->{$eventname})){
						$this->node->events->{$eventname} = $this->node->Window->Event->{$eventname};
					}else{
						$this->node->events->{$eventname} = array_merge($this->node->events->{$eventname},$this->node->Window->Event->{$eventname});
					}
				}
			
			if(!array_key_exists($eventname,$this->node->events))return false;
				$evs = $this->node->events->{$eventname};
				
				$c = count($evs);
				$keynames = array_keys($evs);
				
				for($i=0;$c > $i;$i++){
						if(!empty($evs[$keynames[$i]][2]) AND is_a($this->node,jqmel)){
							$selector = $evs[$keynames[$i]][2];
							$is = $this->node->is($selector)->get();
							if($is ==false)continue;
						}
						
							
					$e = new jqueryphp_abstracts_event($eventname,$target,$evs[$keynames[$i]][1]);
						if(self::$isDefaultPrevented[$eventname] ===true){
							$e->preventDefault = true;
						}
					$callback = $evs[$keynames[$i]][0];
					
						if(is_a($callback,'Closure')){
								
							$callback = Closure::bind($callback,$this->node);
							
						}
						
					$result = call_user_func($callback,$e);
					$e->result = $result;
					jqueryphp_methods_trigger::$resultSet[$eventname] = $result;
					$this->node->event = $e;
					
						self::$isDefaultPrevented[$eventname] = $e->preventDefault;
						
						if($evs[$keynames[$i]][3]===true){
							
							unset($evs[$keynames[$i]]);
							unset($this->node->events->{$eventname}[$keynames[$i]]);
							
						}
						
				}
				
			return $this;
			
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>