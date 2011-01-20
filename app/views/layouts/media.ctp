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
<!doctype html>
<html>
<head>
	<!--[if IE 7]>
	<link href="/think/css/ie7.css" rel="stylesheet" type="text/css"/>	
	<![endif]-->
	<link href="<?php echo HOME?>/css/admin.css" type="text/css" rel="stylesheet">	
	<link rel="stylesheet" type="text/css" href="<?php echo HOME?>/js/css/uploadify.css">	
</head>
<body style="background-color:#e5e5e5">	
	<div id="medialibrary">
	<?php echo $content_for_layout; ?>
	</div>
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js"></script>
  	<script>window.jQuery || document.write('<script src="<?php echo HOME?>/js/jquery/jquery-1.5.1.min.js">\x3C/script>')</script>	
	<script src="<?php echo HOME?>/js/thinkshop/media_init.js" type="text/javascript"></script>
</body>
</html>
