<?php
defined('SAFE')or die();

class jqueryphp_methods_css extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		protected $key;
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($key=NULL,$val=NULL){
			$opts = func_get_args();
			if(empty($key)){
					return isset($this->node->_attributes['style'])?$this->node->_attributes['style']:NULL;
				}
				$this->key = $key;
				$attri = $this->node->_attributes;
				$attr = $this->node->_attributes['style'];
				
					if(empty($attr))$attr=array();
						if(is_scalar($attr)){
							parse_str(str_replace(array(':',';'),array('=','&'),$attr),$attr);
						}
						
						if(!is_null($key) AND is_scalar($key) AND isset($val)){
							$attr[$this->key] = $val;
							
							$attr = str_replace(array('=','&'),array(':',';'),http_build_query($attr));
							
							$attri['style'] = urldecode($attr);
							
							$this->node->_attributes = $attri;
							$this->node->saveHtml();
						}elseif(is_array($key)){
							if(is_array($attr)){
								$key = array_merge($attr,$key);
							}
							$attr = str_replace(array('=','&'),array(':',';'),http_build_query($key));
							$attri['style'] = urldecode($attr);
							$this->node->_attributes = $attri;
							$this->node->saveHtml();
							
						}
						
					
					
			return $this;
		}
		
		public function get(){
			$attr = $this->node->_attributes['style'];
			if(is_scalar($attr)){
							parse_str(str_replace(array(':',';'),array('=','&'),$attr),$attr);
							if(is_array($this->key)){
								
								$attr = array_intersect_key($attr,$this->key);
								return $attr;
							}elseif(is_scalar($this->key) AND array_key_exists($this->key,$attr)){
								return $attr[$this->key];
							}
						}
						
			return $attr;
		}
		
		
}


?>