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

*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		Thinkshop installeren
	</title>
	
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link href="css/admin.css" type="text/css" rel="stylesheet">	
  	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js"></script>
  	<script>window.jQuery || document.write('<script src="/js/jquery/jquery-1.5.1.min.js">\x3C/script>')</script>	
</head>
<body>	
	<div id="container">
		<div id="topmenu">
				<div id="logo"></div>
		</div>

			<div class="content">
				<div id="main_center">
					<?php echo $content_for_layout; ?>
				</div>
			</div>
			<div id="footer">
				<small>
					created by <a href="http://www.to-wonder.com" target="_blank">To Wonder Multimedia</a>&nbsp;|&nbsp;
					<a href="http://www.opensource.org/licenses/mit-license.php"><?php __('MIT License')?></a>
				</small>
			</div>		
	</div>
</body>
</html>