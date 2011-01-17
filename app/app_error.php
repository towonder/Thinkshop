<?php

/*

 * Thinkshop :  The most userfriendly open source webshopssytem.
 * Copyright 2010, To Wonder Multimedia
 *	
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright		To Wonder Multimedia
 * @link			http://www.getthinkshop.com Thinkshop Project
 * @license			http://www.opensource.org/licenses/mit-license.php The MIT License

*/

class AppError extends ErrorHandler {


	function error404($params) {
		$this->controller->layout = "error";
		parent::error404($params);
	}

	function missingController($params) {
		$this->controller->layout = "error";
		parent::missingController($params);        
	}
		
	function missingAction($params) {
		$this->controller->layout = "error";
		parent::missingAction($params);
	}
	
	function missingConnection($params){
		$ar = explode('/',$_SERVER['REQUEST_URI']);
		$middle = $ar[1];
		$url = 'http://'.$_SERVER['HTTP_HOST'].'/'. $middle;
		Header('Location: '.$url);
	}
}

?>