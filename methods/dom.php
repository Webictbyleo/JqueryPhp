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
				
			$this->node->_attributes = $this->node->_attributes;
					$atts = urldecode(http_build_query($this->node->_attributes));
					
				 
				$atts = preg_replace('#([a-z]{1,}\w[=])+(.*?){0}#i','$1"', $atts);
		
		
				$atts = preg_replace('#([a-z]{1,}\w?<=[=\w\.;:\s])?[&]#i','$1"&', $atts);
			
				if(!empty($this->node->_attributes)){
					$atts .= "\"";
					
					parse_str($atts,$attr);
					$dom .= ' '.implode(' ',explode('&',$atts));
					
				}
					if(!empty($dom)){
			$dom = '<'.$dom;
					}
					
				if(!empty($this->node->_localName)){
					//is not inline
					
					$dom .= '>';
					$this->nodeType = 1;
						if(isset($this->node->_innerHtml)){
							$dom .= $this->node->_innerHtml;
						}
						
						$dom .= $this->node->_localName;
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
				$this->attr = $atts;
				
				$this->style = trim($this->node->_attributes['style'],'"\'');
				$this->id = trim($this->node->_attributes['id'],'"\'');
				$this->tagName = $this->node->_name;
				$this->modified = time();
				$this->innerHtml = $this->node->_innerHtml;
				$this->selector = $this->node->_selector;
				$this->path = $this->node->_path;
					
					if($this->nodeType ==1){
						$regex = '/<['.$this->node->_name.'+].*?>([a-z0-9\s]+)<\/'.$this->node->_name.'>/is';
						preg_match($regex,$dom,$text);
						$this->textContent = $text[1];
					}
						
					
				$this->lastdom = $dom;
					
						
							
						
				unset($this->node);
		}
	}
		public function get(){
			return $this;
		}
	
	}

?>