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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title><?php echo WEBSITE_TITLE; ?> - Uh-owh...</title>
	
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link href="<?php echo HOME?>/css/error.css" type="text/css" rel="stylesheet" />	
	<!--[if IE 7]>
	<link href="<?php echo HOME?>/css/ie7_error.css" rel="stylesheet" type="text/css"/>	
	<![endif]-->
	<!--[if IE 8]>
	<link href="<?php echo HOME?>/css/ie8_error.css" rel="stylesheet" type="text/css"/>	
	<![endif]-->
	
</head>
<body>
	<div id="container">
		<?php echo $content_for_layout; ?>
	</div>
</body>
</html>