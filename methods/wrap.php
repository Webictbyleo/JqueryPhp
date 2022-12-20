<?php
defined('SAFE')or die();

class jqueryphp_methods_wrap extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($str=nULL){
			if(!is_null($str)){
			
					if(is_a($str,jqmel)){
						$str = $str->dom()->get()->lastdom;
					}elseif(is_callable($str)){
						$str = call_user_func($str,array());
					}
				$str = preg_replace('/\s+/',' ',$str);
					$regex = '/<([a-z0-9\-]+)(.*?)>(?:(.*?)(<\/\1>))?/xsi';
				if(preg_match($regex,$str,$match)){
					$match[2] = rtrim($match[2],'/');
				}
				$document = jqm_use($this->node->_parentElement);
					
					
					$par = $this->node->parent();
					$wrap = $str;
					
					if(!is_a($par->get(),jqmel)){
							return;
						}
						
					
					$find = $this->node->__toDomElement();
					
					
					if($find){
						$rec = $find->ownerDocument;
						$child = new domDocument;
							if($this->node->isxml()){
						$child->loadxml($wrap,LIBXML_PARSEHUGE);
							}else{
							$child->loadhtml($wrap,LIBXML_PARSEHUGE);	
							}
						if($child->doctype){
						$child->removeChild($child->doctype);
						}
						$chf = $child->getElementsByTagName($match[1]);
						
						
						$frag = $child->importNode($find,true);
						
						$depth = $this->getDeepest($chf->item(0));
						
						$save = $depth->appendChild($frag);
						
						//Import to document
					 $frag = $rec->importNode($chf->item(0),true);
						//var_dump($rec->savehtml($find),$find);
						
						 $newsave = $find->parentNode->replaceChild($frag,$find);
						 
							$this->node->_path = $this->node->getpathByid(); 
							
							
							$xp = $document->xpath($rec);
							$this->node->setDom($xp->query($this->node->_path)->item(0));
						
					}
					
			}
		}
		
		private function getDeepest(&$node){
					$childT = $node->childNodes->length;
					
						if($childT ==0 ){return $node;}
						
							//if($node->childNodes->item(0)->childNodes->length ==0)return $node;
					$x = new Domxpath($node->ownerDocument);
						$depth = $x->query($node->getNodepath().'/descendant::*[last()]');
						return $depth->item(0);
				
		}
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>