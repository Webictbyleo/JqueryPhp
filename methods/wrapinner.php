<?php
defined('SAFE')or die();

class jqueryphp_methods_wrapInner extends jqueryphp_abstracts_element{

protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($str=nULL){
			$chd = $this->node->contents()->get()->current();
			$str = preg_replace('/\s+/',' ',$str);
			
				if(preg_match('/<([a-z0-9\-]+)(.*?)>(?:(.*?)(<\/\1>))?/xsi',$str,$match)){
					$match[2] = rtrim($match[2],'/');
					
				}
				if(!empty($match[1])){
					$np = 'html';
					if($this->node->isXml()){
						$np = 'xml';
			$inner = ($chd->ownerDocument->saveXml($chd));
			}else{
				$inner = ($chd->ownerDocument->savehtml($chd));
			}
			$wrap = '<'.$match[1].$match[2].'>';
					if(isset($match[3])){
						$wrapi = substr($str,strlen('<'.$match[1].$match[2].'>'));
						
						$match[3] = substr($wrapi,0,strripos($wrapi,'</'.$match[1].'>'));
						
						$wrap .= $match[3];
						
					}
				$wrap .= $inner;
				$wrap .= '</'.$match[1].'>';
				
					$newdoc = new domDocument;
					
					$newdoc->{'load'.$np}($wrap,LIBXML_PARSEHUGE);
					$newdoc_get = $newdoc->getElementsByTagName($match[1]);
					$frag = $chd->ownerDocument->importNode($newdoc_get->item(0),true);
					$chd->parentNode->replaceChild($frag,$chd);
					
				}
			
			
					
		}
}