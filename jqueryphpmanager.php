<?php
defined('SAFE')or die('Not allowed');
/**
Jqueryphpmanager Xml/html manipulation  tool created by Leo Anthony
This project is still under review and not an opensource.
However,if you find the need to use this work on your 
project,please contact the author 
ifayce@gmail.com. Proudly Nigerian!
Note: This library does not do html/xml parsing for you. Meaning that any malfunctioned tag will 
not be touched
*/
	class JqueryBoxManager{
		
		
		private static $__collectionList;
		private static $__namespace;
		private static $__collectionToken;
		private static $readyCallbacks = array();
		private static $DOM;
		public function __construct(array $boxParams = array()){
			
			
		}
		
		public function __toString(){
			
		}
		
		public static function autoload(){
			 if (($funcs = spl_autoload_functions()) === false) {
		 
            spl_autoload_register(array('JqueryBoxManager', 'loadClass'),true,true);
        }else{
		spl_autoload_register(array('JqueryBoxManager', 'loadClass'));
		
		 foreach ($funcs as $func) {
                    spl_autoload_register($func);
                }
				
		}
			
		}
		
		
		
		public static function load(&$document,$tag){
			
				$type = getType($document);
				
					switch($type){
						
						case 'string':
						case 'integer':
						case 'int':
						case 'float':
							//Traversible check
								
									$doc = new jqueryphp_abstracts_document($document,$tag);
								
						break;
						case 'array':
						break;
						case 'object':
						//Normalize Jqm objects
				
					if(is_a($document,jqmdoc)){
						$document = $document->__documentRaw;
					}elseif(is_a($document,jqmel)){
						$document = $document->dom()->get()->lastdom;
					}
					$doc = new jqueryphp_abstracts_document($document,$tag);
						break;
						
					}
					return $doc;
			
		}
		
		public static function registerEvent($e,$callback){
			
			
		}
		public function window($request,$requestType='file',$onloadCallback,$data){
			$w = new jqueryphp_abstracts_window;
				if(isset($request)){
						if(isset($onloadCallback)){
							
							$w->onload($onloadCallback,$data);
						}
					$w->load($request,$requestType);
				}
			return $w;
		}
		public function extend(){
			
			
		}
		
		protected function document_ready_run($query){
			
			
		}
		
		public static function ready($callback){
			
			if(is_callable($callback) || function_exists($callback)){
					$loaded = WebBaker::_getResponse();
					$id = time().uniqid();
					
					JqueryBoxManager::$readyCallbacks[$id] = $callback;
					
						if(!is_object($loaded)){
							//Not loaded
							return ;
						}
						
						
						
						if(array_key_exists('hooks::content_is_found',Registry::getInstance()->LOADED_EVENT_HOOKS)){
							
							$doc = $loaded->theme->getContent();
							if($doc ===NULL || empty($doc))return;
							if(preg_match('/<([a-z0-9\-]+)(.*?)>(.*?)(<\/\1>)/is',$doc,$match)){
								if(!isset(JqueryBoxManager::$DOM) || !is_a(JqueryBoxManager::$DOM,jqmdoc)){
							JqueryBoxManager::$DOM = jqm($doc,'*');
							
								}
								
								$dom = JqueryBoxManager::$DOM;
								//Make sure this is a valid jqueryphpmanager object
								if(is_a($dom,jqmdoc)){
									if(isset(JqueryBoxManager::$readyCallbacks) AND is_array(JqueryBoxManager::$readyCallbacks)){
										$c = count(JqueryBoxManager::$readyCallbacks);
										$keys = array_keys(JqueryBoxManager::$readyCallbacks);
										
										for($i=0;$c > $i;$i++){
											
											if(empty(JqueryBoxManager::$readyCallbacks[$keys[$i]]))continue;
											call_user_func(JqueryBoxManager::$readyCallbacks[$keys[$i]],$dom);
											unset(JqueryBoxManager::$readyCallbacks[$keys[$i]]);
											
										}
										
									}
								}
							}
						}
				
			}
		}
		public function setVar($name,$var){
				if(is_scalar($name)){
			JqueryBoxManager::$__collectionList[$name] = $var;
			return true;
				}
		}
		
		public function getVar($var){
			$name = $var;
			$var = JqueryBoxManager::$__collectionList[$var];
			//unset(JqueryBoxManager::$__collectionList[$name]);
			//unset($name);
			return $var;
		}
		//An obselete function for the jquery::ready callback
		public function isreadycall(){
			return NULL;
		}
		
		public static function loadClass($class){
					if(stripos($class,'jqueryphp') !==false){
				$main = dirname(__DIR__);
			$cl = explode(DELIMITER_UNDER,$class);
				$realFile = implode(DELIMITER_DIR,$cl);
				if(file_exists($main.DIRECTORY_SEPARATOR.$realFile.'.php')){
					require($main.DIRECTORY_SEPARATOR.$realFile.'.php');
				}
					}
		}
		
		public function setNamespace($name){
				if(!empty($name)){
					if(!isset(self::$__namespace)){
						self::$__namespace = array();
						self::$__namespace[] = $name;
						
					}else{
						self::$__namespace[] = $name;
					}
					$temp = array_flip(self::$__namespace);
					
					self::$__collectionToken = $temp[end(self::$__namespace)];
				}
		}
		
	}

?>