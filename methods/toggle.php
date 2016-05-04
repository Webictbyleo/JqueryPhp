<?php
defined('SAFE')or die();
class jqueryphp_methods_toggle extends jqueryphp_abstracts_element{
		protected static $node;
		public function __construct(jqueryphp_abstracts_element &$ele){
			$this->node  = $ele;
		}
		
		public function run(){
			$i = $this->node->css('display')->get();
			$ii = $this->node->css('opacity')->get();
				if($i ==='hidden' || $ii < 1){
					//Hidden
					$this->node->show();
				}else{
					$this->node->hide();
				}
			
		}
		
		public function get(){
			
			return $this->node;
		}
	}
	
?>