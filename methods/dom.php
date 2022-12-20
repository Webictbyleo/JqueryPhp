<?php
defined('SAFE')or die('Not allowed');
	
	class jqueryphp_methods_dom extends jqueryphp_abstracts_element{
	var $selector;
	var $length;
	var $size;
	var $className;
	var $attr;
	var $style;
	var $accessKey;
	var $childElementCount;
	var $childNodes;
	var $id;
	var $nodeType;
	var $prefix;
	var $position;
	var $tagElements;
	var $title;
	var $textContent;
	var $tagName;
	var $version;
	var $modified;
	var $innerHtml;
	var $anchors;
	var $images;
	var $children;
	var $onclick;
	var $onmousedown;
	var $onhover;
	var $lastdom;
	var $worker;
	var $path;
	private $node;
	
	public function __construct(jqueryphp_abstracts_element &$dom){
		if(!is_object($dom))throw Exception('Dom argument must be a valid jqm abstract object');
			if(!$dom instanceOf jqueryphp_abstracts_document AND !$dom instanceof jqueryphp_abstracts_element){
				throw Exception('Dom argument must be a valid jqm abstract object');
			}
			$this->node = $dom;
	}
	public function run(){
		if($this->node instanceOf jqueryphp_abstracts_element){
			$dom = $this->node->_name;
			
			$attr = $this->node->_attributes;
			array_walk($attr,function(&$v,$k){
				$v = $k.'="'.str_replace('"','\'',$v).'"';
			});
			
			
				
				if(!empty($this->node->_attributes)){
					$this->attr = implode(' ',$attr);
					$dom .= ' '.$this->attr;
					
				}
				
			
					if(!empty($dom)){
			$dom = '<'.$dom;
					}
					
				if(!is_null($this->node->_innerHtml) AND is_scalar($this->node->_innerHtml)){
					//is not inline
					
					$dom .= '>';
					$this->nodeType = 1;
						if(isset($this->node->_innerHtml)){
							$s = $this->node->toString();
							$se = preg_match('/<('.$this->node->_name.'*)\b(.*?)>/xsi',$s,$r);
							
							$wrap = substr($s,strlen($r[0]));
						$dom .= substr($wrap,0,strripos($wrap,'</'.$this->node->_name.'>'));
								
							//$dom .= $this->node->_innerHtml;
						}
						
						$dom .= '</'.$this->node->_name.'>';
				}else{
						
					//Is inline
						if(!empty($this->node->_name)){
					$dom .='/>';
					$this->nodeType = 0;
						}
				}
				
					if($this->node->_attributes['title']){
				$this->title = trim($this->node->_attributes['title'],'"\'');
					}
				$this->size  =strlen($dom);
				$this->length  =$this->node->_length;
				$this->className =trim($this->node->_attributes['class'],'"\'');
				
				
				$this->style = trim($this->node->_attributes['style'],'"\'');
				$this->id = trim($this->node->_attributes['id'],'"\'');
				$this->tagName = $this->node->_name;
				$this->modified = time();
				$this->innerHtml = $this->node->_innerHtml;
				$this->textContent = $this->node->text()->get();
				$this->selector = $this->node->_selector;
				$this->path = $this->node->_path;
					
						
					
				$this->lastdom = $dom;
					
						
							
						
				unset($this->node);
		}
	}
		public function get(){
			return $this;
		}
	
	}

?>