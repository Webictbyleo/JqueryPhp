<?php
defined('SAFE')or die();
class jqueryphp_methods_show extends jqueryphp_abstracts_element{
		protected static $node;
		public function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run(){
			//$this->node->css('display','block');
			$css = $this->node->css()->get();
				if(is_array($css)){
					$css['display'] = 'block';
						if(array_key_exists('opacity',$css)){
							if(!is_numeric($css['opacity'])){unset($css['opacity']);}
							if($css['opacity'] < 1){
								unset($css['opacity']);
							}
						}
							if(!empty($css)){
					$attr = str_replace(array('=','&'),array(':',';'),http_build_query($css));
							$attri = $this->node->_attributes;
							$attri['style'] = urldecode($attr);
							$this->node->_attributes = $attri;
							$this->savehtml();
							}
				}
			
		}
		
		public function get(){
			
			return $this->node;
		}
	}
	
?>