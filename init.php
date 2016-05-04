<?php

require_once(__DIR__.DELIMITER_DIR.'/jqueryphpmanager.php');
require_once(__DIR__.'/abstracts/selector/CssSelectorConverter.php');
		use Symfony\Component\CssSelector\CssSelectorConverter as CssSelector;
		CssSelector::autoload();
JqueryBoxManager::autoload();
$backtrace = debug_backtrace();
	$namespaceTokens = isset($backtrace[2]) ? $backtrace[2] : NULL ;
	if(isset($namespaceTokens['class'])){
		JqueryBoxManager::setNamespace('Loader_'.$namespaceTokens['line'].'_'.$namespaceTokens['class']);
	}
self::$classes[self::$caller] = new JqueryBoxManager;
		if(!defined('jqmdoc')){
			define('jqmdoc','jqueryphp_abstracts_document');
		}
		if(!defined('jqmel')){
			define('jqmel','jqueryphp_abstracts_element');
		}
		if(!defined('jqmnull')){
			define('jqmnull','jqueryphp_abstracts_prevObject');
		}
		if(!defined('jqmlist')){
			define('jqmlist','jqueryphp_abstracts_nodelist');
		}
		if(!defined('jqmwin')){
			define('jqmwin','jqueryphp_abstracts_window');
		}
	if(!function_exists('jqm')){
		function jqm($input,$parent='*'){
			
				if(empty($input))return false;
				
				if(empty($parent))return false;
				
			$doc = new JqueryBoxManager;
			return $doc->load($input,$parent);
		}
	}
	if(!function_exists('jqm_ready')){
		function jqm_ready($callback){
			jQueryBoxManager::ready($callback);
		}
		
	}
	if(!function_exists('jqm_window')){
		function jqm_window($q=NULL,$qtype=NULL,$callback,$data){
			
			
			return jQueryBoxManager::window($q,$qtype,$callback,$data);
		}
		
	}
	if(!function_exists('jqm_var')){
		function jqm_var($var,&$variable){
			return jQueryBoxManager::setVar($var,$variable);
		}
		
	}
	if(!function_exists('jqm_use')){
		function jqm_use($var){
			return jQueryBoxManager::getVar($var);
		}
		
	}
	
	if(!function_exists('jq')){
		function jq($query){
			return jQueryBoxManager::document_ready_run($query);
		}
		
	}
	
?>