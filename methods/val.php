<?php
defined('SAFE')or die();

class jqueryphp_methods_val extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		private $dispatchedElements = array(
		'select',
		'textarea',
		'input'
		);
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($value=NULL){
			
				if(isset($value)){
					if($this->node->_name ==='input'){
						$attr = $this->node->_attributes;
							
						$attr['value'] = $value;
						if(in_array($attr['type'],array('radio','checkbox'))){
								$attr['checked'] = 'checked';
							}
						$this->node->_attributes = $attr;
						$save = $this->node->saveHtml(true);
					}elseif($this->node->_name ==='textarea'){
						
						//$this->node->_innerHtml = $value;
						//$this->node->_innerText = strip_tags($value);
						$this->node->html($value);
						//$save = $this->node->saveHtml(true);
					}elseif($this->node->_name ==='select'){
						$options = $this->node->children('option')->get();
						
						if($options->_length > 0){
							
							$options->removeAttr('selected');
							$select = $options->filter('[value='.strip_tags($value).']:first');
							$select->attr('selected',NULL);
							$par = $select->parent()->get();
								if(is_a($par,jqmel)){
									$this->node->_innerHtml = $par->_innerHtml;
									$this->node->_innerText = $par->_innerText;
									$this->node->saveHtml();
								}
						}
						
					}
					
			
					
				}
			return $this;
		}
		
		public function get(){
				if(!in_array($this->node->_name,$this->dispatchedElements))return NULL;
					if($this->node->_name ==='input'){
							if(in_array($this->node->_attributes['type'],array('radio','checkbox'))){
								if($this->node->_attributes['value'] ==NULL){
									$this->node->_attributes['value'] = 'off';
									if($this->node->is(':checked')->get()===true){
									$this->node->_attributes['value'] = 'on';
									}
								}
								
							}
			return isset($this->node->_attributes['value']) ? $this->node->_attributes['value'] : NULL;
					}elseif($this->node->_name ==='textarea'){
						return !empty($this->node->_innerHtml) ? $this->node->_innerHtml : NULL;
					}elseif($this->node->_name ==='select'){
						$options = $this->node->find('option[selected]:first:parent(select)')->get();
						if($options->_length > 0){
							return $options->current()->_attributes['value'];
						}
							return NULL;
					}
		}
		
		
}


?>