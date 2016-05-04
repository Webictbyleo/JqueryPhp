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
								if(strip_tags($document) !==$document){
									$doc = new jqueryphp_abstracts_document($document,$tag);
								}
						break;
						case 'array':
						break;
						case 'object':
						break;
						
					}
					return $doc;
			
		}
		
		public static function registerEvent($e,$callback){
			
			
		}
		
		public function extend(){
			
			
		}
		//Depreciated
		public function document_ready_run(){
			
			
		}
		//Depreciated
		public static function ready(){
			
			
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
			unset(JqueryBoxManager::$__collectionList[$name]);
			unset($name);
			return $var;
		}
		//An obselete function for the jquery::ready callback
		public function isreadycall(){
			return NULL;
		}
		
		public static function loadClass($class){
					if(stripos($class,'jqueryphp') !==0)return false;
				$main = dirname(__DIR__);
			$cl = explode(DELIMITER_UNDER,$class);
				$realFile = implode(DELIMITER_DIR,$cl);
					
				if(file_exists($main.DIRECTORY_SEPARATOR.$realFile.'.php')){
					require($main.DIRECTORY_SEPARATOR.$realFile.'.php');
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
