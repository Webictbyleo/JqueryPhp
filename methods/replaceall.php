<?php
defined('SAFE')or die();
class jqueryphp_methods_replaceAll extends jqueryphp_abstracts_element{
		protected static $node;
		
		public function __construct(jqueryphp_abstracts_element $ele){
			$this->node  = $ele;
		}
		
		public function run($query){
				if(is_scalar($query)){
			$query = str_replace(array(':last',':first'),'',strip_tags($query));
			$query .= ':first';
			$document = jqm_use($this->node->_parentElement);
			
			$str = $this->node->dom()->get()->lastdom;
			$ele = $document->find($query)->current();
			
					if(is_a($ele,jqmel)){
						$ele->replaceWith($str);
						
					}
				
				}
			
		}
		
		public function get(){
			
			return $this->node;
		}
	}
	
?>