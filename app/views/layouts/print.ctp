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
	<!--[if IE 7]>
	<link href="/think/css/ie7.css" rel="stylesheet" type="text/css"/>	
	<![endif]-->
	<link href="/think/css/admin.css" type="text/css" rel="stylesheet">	
	<style>
	
		html{
			background-color:#ffffff;
		}
		
		th{
			padding-bottom:10px;
			padding-top:10px;
			border-bottom:1px dotted #555;
			border-top:1px dotted #555;
		}


	</style>
</head>
<body style="background-color:#fff;color:#666">
<?php echo $content_for_layout; ?>
</body>
</html>