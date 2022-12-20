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
			
				$this->key = $key;
				$attri = $this->node->_attributes;
				$attr = $this->node->_attributes['style'];
					if(isset($this->node->_style) and $this->node->_style InstanceOf jqueryphp_abstracts_cssStyle){
					$this->node->_style->setArray($attr);	
					}else{
						$this->node->_style = new jqueryphp_abstracts_cssStyle($attr);
					}
					if(empty($attr))$attr=array();
						
						
						if(!is_null($key) AND is_scalar($key) and $val !==null){
							
							
							$this->node->_style->{$this->key} = $val;
							
							if($this->node->_style->isempty()){
							$this->node->__toDomElement()->removeAttribute('style');
							unset($attri['style']);
							}else{
							$attri['style'] = $this->node->_style->reduce();
							$this->node->__toDomElement()->setAttribute('style',$attri['style']);
							}
							$this->node->_attributes = $attri;
							//$this->node->saveHtml();
						}elseif(is_array($key)){
							$this->node->_style->join($key);
							
							if($this->node->_style->isEmpty()){
								unset($attri['style']);
							}else{
								
							$attri['style'] = $this->node->_style->reduce();
							}
							if(empty($attri['style'])){
							$this->node->__toDomElement()->removeAttribute('style');
							}else{
							$this->node->_attributes = $attri;
							$this->node->__toDomElement()->setAttribute('style',$attri['style']);
							}
							//$this->node->saveHtml();
							
						}
						
					
					
			return $this;
		}
		
		public function get(){
			
							
							if(is_array($this->key) and isset($this->node->_style)){
								$attr = $this->node->_style->toArray($this->key);
								return $attr;
							}elseif(is_scalar($this->key)){
								return $this->node->_style->{$this->key};
							}else if(is_null($this->key)){
							return $this->node->_style->toArray();
							}
						
						
			return $this->node;
		}
		
		
}


?>