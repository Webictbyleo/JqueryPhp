<?php
defined('SAFE')or die();

class jqueryphp_methods_find extends jqueryphp_abstracts_element{
	
		
		protected static $node;
		
		public  function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run($query){
			if(empty($query)){
				$this->node = new jqueryphp_abstracts_prevObject(NULL);
				return ;
			}
				if(!is_null($query)){
			$regex = '/<([a-z0-9\-]*)\b(.*?)>(.*?)(<\/\1>)/is';
			
			$el = $this->__toDomElement();
			/* $query = explode(',',$query);
			foreach($query as $i=>$e){
				$e = trim($e,' ');
				if($e==''){
					unset($query[$i]);
					continue;
				}
				if(strpos($e,'>')!==0){
					$e = $this->node->_selector.' '.$e;
				}else{
					$e = $this->node->_selector.$e;
				}
				$query[$i] = $e;
			}
			$query = implode(',',$query); */
			$document = jqm_use($this->node->_parentElement);
			$selector = $document->match_selector($query,$el->getNodePath().'/descendant-or-self::*');
			
			if($selector['xpath']){
				
				$x = $document->xPath($el->ownerDocument);
				
				$dom = $x->query($selector['xpath']);
				
				if(!$dom->length){
					$this->node = new jqueryphp_abstracts_prevObject($selector);
					return;
				}
				$node = $this->node;
				$iterator = (range(0,$dom->length-1));
				
				$all = array_map(function($i)use($dom,$node,$document,$selector){
					$item = $dom->item($i);
					
					$ele = $node->exportNode($item);
					
					return $ele;
				},$iterator);
				
				$this->node = new jqueryphp_abstracts_nodelist($all);
					
			}else{
				$this->node = new jqueryphp_abstracts_prevObject($query);
					
			}
			
				}
			return $this->node;
		}
		
		
		
		public function get(){
			
			return $this->node;
		}
		
		
}


?>