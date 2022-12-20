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
		private function closurize($callable) {
	if ($callable instanceof \Closure) {
		return $callable;
	}
	$is_callable = function($callable) {
		return \is_callable($callable);
	};
	$error = function() {
		$debug = \debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
		$fmt = 'Parameter 1 for closurize() must be callable ' .
		       'in %s on line %d (issued at %s on line %d)';
		$error = \sprintf($fmt, $debug[1]['file'], $debug[1]['line'],
		                       $debug[0]['file'], $debug[0]['line']);
		\trigger_error($error, \E_USER_WARNING);
		return function() {
			return null;
		};
	};
	$object = null;
	$class  = null;
	$debug = \debug_backtrace(\DEBUG_BACKTRACE_PROVIDE_OBJECT, 2);
	if (isset($debug[1]['object']) && \is_object($debug[1]['object'])) {
		$object = $debug[1]['object'];
		$class  = $debug[1]['class'];
		$is_callable = $is_callable->bindTo($object, $object);
	}
	if (!$is_callable($callable)) {
		if (isset($callable[0]) && is_object($callable[0])) {
			$is_callable = $is_callable->bindTo($callable[0], $callable[0]);
		} else if (isset($callable[0]) && \class_exists($callable[0])) {
			$is_callable = $is_callable->bindTo(null, $callable[0]);
		}
		if (!$is_callable($callable)) {
			return $error();
		}
	}
	if (\is_string($callable) && (\strpos($callable, '::') === false)) {
		$ref = new \ReflectionFunction($callable);
		return $ref->getClosure();
	} else if (\is_string($callable)) {
		$callable = \explode('::', $callable);
	}
	if (!\is_array($callable)) {
		throw new \UnexpectedValueException('Callable is not string, array, '.
		                                   'or Closure');
	}
	if (\is_object($callable[0])) {
		$ref = new \ReflectionMethod($callable[0], $callable[1]);
		return $ref->getClosure($callable[0]);
	}
	if (!\is_string($callable[0])) {
		throw new \UnexpectedValueException('Callable class is not string ' .
		                                   'or object');
	}
	switch ($callable[0]) {
		case 'self':
			if (!\is_object($object) && \is_null($class)) {
				return $error();
			}
			$self = function() {
				return \get_class();
			};
			$self = $self->bindTo($object, $class);
			$ref = new \ReflectionMethod($self(), $callable[1]);
			$callable[0] = $object;
			break;
		case 'static':
			if (!\is_object($object)) {
				return $error();
			}
			$static = function() {
				return \get_called_class();
			};
			$static = $static->bindTo($object, $class);
			$ref = new \ReflectionMethod($static(), $callable[1]);
			$callable[0] = $object;
			break;
		case 'parent':
			if (!\is_object($object)) {
				return $error();
			}
			$parent = function() {
				return \get_parent_class();
			};
			$parent = $parent->bindTo($object, $class);
			$ref = new \ReflectionMethod($parent(), $callable[1]);
			$callable[0] = $object;
			break;
		default:
			$ref = new \ReflectionMethod($callable[0], $callable[1]);
			break;
	}
	if (!$ref->isStatic() && \is_object($callable[0])) {
		return $ref->getClosure($callable[0]);
	} else if (!$ref->isStatic()) {
		throw new \UnexpectedValueException('Callable method is not static, ' .
		                                   'but no calling object available');
	}
	return $ref->getClosure();
}
		
		
}


?>