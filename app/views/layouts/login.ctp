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
  	<meta charset="utf-8">
  	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
       	Remove this if you use the .htaccess -->
  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<title>
		<?php echo WEBSITE_TITLE .'-';?>
		<?php echo $title_for_layout; ?>	
	</title>
	
	<!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  	<link rel="shortcut icon" href="<?php echo HOME?>/favicon.ico">
  	<link rel="apple-touch-icon" href="<?php echo HOME?>/apple-touch-icon.png">
	<link href="<?php echo HOME?>/css/login.css" type="text/css" rel="stylesheet">	
	<!--[if IE 7]>
	<link href="<?php echo HOME?>/css/ie7.css" rel="stylesheet" type="text/css"/>	
	<![endif]-->
	
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js"></script>
  	<script>window.jQuery || document.write('<script src="<?php echo HOME?>/js/jquery/jquery-1.5.1.min.js">\x3C/script>')</script>	
	<script type="text/javascript" src="<?php echo HOME?>/js/jquery-ui/jquery-ui-1.8.9.custom.min.js"></script>
	
</head>
<body>
	
	
	
	<div id="container">
			<div class="content">
				<div class="logincontainer">
					<div id="logintop"><p><?php echo $type; ?></p></div>
					<div id="loginmiddle">
						<?php echo $content_for_layout; ?>
				</div>
			
		
			</div>
					

		
	</div>
</body>
</html>