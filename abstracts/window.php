<?php
defined('SAFE')or die();

	class jqueryphp_abstracts_window{
		
			
		
		public function __construct(){
			$this->Event = new stdClass;
			$this->Event->onload = array();
			$this->Event->click[] = array('jqueryphp_abstracts_window::onclick',NULL,'a,:button');
			$this->Event->mouseover['Window.default'] = array();
			$this->Event->mousedown['Window.default'] = array();
			$this->Event->mouseout['Window.default'] = array();
			$this->Event->keydown['Window.default'] = array(NULL,'input,textarea');
			$this->Event->keypress['Window.default'] = array(NULL,'input,textarea');
			$this->Event->keyup['Window.default'] = array(NULL,'input,textarea');
		}
		
		public function __set($name,$data){
			$this->{$name} = $data;
		}
		
		public function onclick($e){
			if($e->preventDefault===true)return;
			
				$this->css('border','solid 2px red');
		}
		
		//Support 3 input types
		/**
		BlobData =  Raw string
		File = Local file in the filesystem
		Http = Self determined request type
		**/
		public function load($request,$type='Http'){
			$type = strtolower($type);
			switch($type){
				case 'file':
					if(!file_exists($request)){
						throw new Exception('File:://'.$request.' [Not Found]');
					}
					$data = file_get_contents($request);
				$this->request = 'File:://'.$request;
				$this->DOM = jqm($data,'*');
				$this->DOM->search(':root:first');
				$this->propagate();
				
				$this->load_Location();
				$this->DOM->trigger('onload');
				
				break;
				case 'http':
						try{
							$data = file_get_contents($request);
					if($data){
						$this->request = $request;
						$this->DOM = jqm($data,'*');
				
				$this->DOM->search(':root:first');
				$this->propagate();
				$this->load_Location();
				$this->DOM->trigger('onload');
					}
						}catch(Exception $e){
							
						}
				
				break;
				case 'blobdata':
				$data = $request;
					if($data){
						$this->DOM = jqm($data,'*');
						$this->DOM->search(':root:first');
				$this->propagate();
				$this->DOM->trigger('onload');
					}
				break;
				default:
				throw new Exception('Request protocol not supported');
			}
			return $this;
		}
		
		public function reload(){
			
				if(isset($this->Location)){
					$type = $this->Location->protocol;
					$this->load($this->Location->href,$type);
				}
			
		}
		
		private function propagate(){
			$this->DOM->Window = $this;
			
			/* $doc = jqm_use($this->DOM->getNs());
			if(is_a($doc,jqmdoc)){
				$doc->Window = $this;
			} */
		}
		
		private function load_Location(){
			$this->Location = new stdclass;
				$url = parse_url($this->request);
				
				$this->Location->protocol = $url['scheme'];
				$this->Location->hash = $url['fragment'];
				$this->Location->host = $url['host'];
				$this->Location->hostname = $url['host'];
					if(isset($url['host'])){
				$this->Location->origin = $url['scheme'].'://'.$url['host'];
		}else{
			$this->Location->origin  = NULL;
		}
				$this->Location->port = $url['port'];
				$this->Location->href = $this->request;
				$this->Location->pathname = $url['path'];
				$this->Location->search = isset($url['query']) ? $url['query'] : NULL;
		}
		
		public function onload($callback,$data=NULL){
			$callable = (is_callable($callback) || function_exists($callback));
				if($callable){
			$this->Event->onload['window.load'] = array($callback,$data);
				}
		}
	}

?>