<?php

/*

 * Thinkshop :  The most userfriendly open source webshopssytem.
 * Copyright 2011, To Wonder Multimedia
 *	
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		To Wonder Multimedia
 * @link			http://www.getthinkshop.com Thinkshop Project
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License
 * @version			Thinkshop 2.2 - Hendrix

*/

class AppError extends ErrorHandler {

	//get sessions & settings before every function:
	function fetchSettings(){
	   //Loading model on the fly
		App::import('Model','Setting');
	   	//Fetching All params
		$setting = new Setting;
	   	$settings_array = $setting->find('all');
	
		//Create a global for every setting:
		foreach($settings_array as $key=>$value){
			$constant = $value['Setting']['key'];
			$val = $value['Setting']['pair'];
		
			if(!defined($constant)){
				eval("DEFINE(\$constant, \$val);");
			}
		}		
	}


	function error404($params) {
		$this->fetchSettings();
		$this->controller->layout = "error";
		parent::error404($params);
	}

	function missingController($params) {
		$this->fetchSettings();
		
		$this->controller->layout = "error";
		parent::missingController($params);        
	}
		
	function missingAction($params) {
		$this->fetchSettings();
		
		$this->controller->layout = "error";
		parent::missingAction($params);
	}
	
	function missingConnection($params){
		$this->fetchSettings();
		
		$ar = explode('/',$_SERVER['REQUEST_URI']);
		$middle = $ar[1];
		$url = 'http://'.$_SERVER['HTTP_HOST'].'/'. $middle;
		Header('Location: '.$url);
	}
}

?>