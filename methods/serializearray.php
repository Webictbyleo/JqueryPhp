<?php
defined('SAFE')or die();
class jqueryphp_methods_serializeArray extends jqueryphp_abstracts_element{
		protected static $node;
		private $data;
		public function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run(){
				
				if($this->node->is('form:parent')->get()){
					$inputs = $this->find(':input[name][name!=""][type!=submit]')->get();
				}elseif($this->node->is(':input')->get()){
					$nodes= array($this->node);
					$inputs = new jqueryphp_abstracts_nodelist($nodes);
				}
					if($inputs->_length > 0){
						$t = $inputs->_length;
						$values  = array();
						$named = array();
						for($i=0;$t > $i; $i++){
							$inputs->seek($i);
							$ele = $inputs->current();
							if($ele->_name ==='button')continue;
								
								if(array_key_exists('disabled',$ele->_attributes))continue;
								$n = $ele->_attributes['name'];
									if(!in_array($n,$named)){
								$values[] = array('name'=>$n,'value'=>$ele->val()->get());
								array_push($named,$n);
									}
						}
					
						$this->data = (object)$values;
					}
			}

			public function get(){
			
				return isset($this->data) ? $this->data : (new stdClass);
			}
			
		}
		
		
	
?>