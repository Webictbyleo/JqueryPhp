<?php
defined('SAFE')or die();

class jqueryphp_methods_find extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($query){
				if(!is_null($query)){
			$regex = '/<([a-z0-9\-]*)\b(.*?)>(.*?)(<\/\1>)/is';
			$this->node->refreshDom();
			$html = $this->node->data('_innerHtml')->get();
			$document = jqm_use($this->node->_parentElement);
			
			$selector = $document->match_selector($query,false);
			
			if($selector){
			
				$jqm = new JqueryBoxManager;
				$tag = '*';
				
				$doc = $jqm->load($html,$tag);
					
					if(!is_a($doc,jqmdoc))return false;
					if($this->node->_name==='select'){
						//var_dump($doc->count());
					}
				$dom= $doc->search($query);
					
					if($dom->count() > 0){
						$this->node->_innerHtml = str_ireplace(array('<html>','<body>','</html>','</body>','<head>','</head>'),'',$doc->__documentRaw);
							$this->savehtml();
						$nodes = array();
						$t = $dom->count();
						jqm_use($dom->current()->_parentElement);
						
						//$dom->rewind();
						
						for($i=0;$t > $i;$i++){
							$dom->seek($i);
							$dom->current()->_token = $document->count()+1;
							
							
							
							$p = substr($dom->current()->_path,stripos($dom->current()->_path,'body')+4);
						$dom->current()->_path = $this->node->_path.'/'.$p;
							$dom->current()->_parentElement = $this->node->_parentElement;
							$dom->current()->_parent_path = $this->node->_path;
								
								if($dom->current()->_prev_path){
									$p = substr($dom->current()->_prev_path,stripos($dom->current()->_prev_path,'body')+4);
							$dom->current()->_prev_path = $dom->current()->_parent_path.'/'.$p;
								}
								if($dom->current()->_next_path){
							$p = substr($dom->current()->_next_path,stripos($dom->current()->_next_path,'body')+4);
							$dom->current()->_next_path = $dom->current()->_parent_path.'/'.$p;
								}
							//$document->offsetSet($document->count()+1,$dom->current());
							$nodes[] = $dom->current();
							
							//$dom->offsetUnset($i);
						}
					
						unset($dom);
						$this->node = new jqueryphp_abstracts_nodelist($nodes);
						
					}else{
						$this->node = new jqueryphp_abstracts_prevObject($selector['selectors']);
					}
			}
				}
			return $this->node;
		}
		
		
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>