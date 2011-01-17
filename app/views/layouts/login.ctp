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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $html->charset(); ?>
	<title>
		<?php echo WEBSITE_TITLE .'-';?>
		<?php echo $title_for_layout; ?>	
	</title>
	
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	
	<?php


		echo $scripts_for_layout;
	?>

	<!--[if IE 7]>
	<link href="<?php echo HOME?>/css/ie7.css" rel="stylesheet" type="text/css"/>	
	<![endif]-->
	<link href="<?php echo HOME?>/css/login.css" type="text/css" rel="stylesheet">
	
	
</head>
<body>
	
	
	
	<div id="container">
			<div class="content">
				<div class="announcements">
					<div id="flash">
						<?php echo $content_for_layout; ?>
					</div>	
				</div>
			
		
			</div>
					

		
	</div>
</body>
</html>