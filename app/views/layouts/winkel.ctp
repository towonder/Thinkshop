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
<!doctype html>
<html>
<head>
  	<meta charset="utf-8">
  	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
       	Remove this if you use the .htaccess -->
  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<title>
		<?php echo WEBSITE_TITLE .' - ';?>
		<?php echo $title_for_layout; ?>	
	</title>
	<meta name="description" content="Thinkshop is het meest gebruiksvriendelijke webshopsysteem">
  	<meta name="author" content="To Wonder Multimedia">
  
	<!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  	<link rel="shortcut icon" href="<?php echo HOME?>/favicon.ico">
  	<link rel="apple-touch-icon" href="<?php echo HOME?>/apple-touch-icon.png">
	
	<link href="<?php echo HOME?>/css/winkel.css" type="text/css" rel="stylesheet" />	
	<link href="<?php echo HOME?>/includes/css/breadcrumbs.css" type="text/css" rel="stylesheet" />
	<link href="<?php echo HOME?>/includes/css/searchengine.css" type="text/css" rel="stylesheet" />
	<!--[if IE 7]>
	<link href="<?php echo HOME?>/css/ie7_winkel.css" rel="stylesheet" type="text/css"/>	
	<![endif]-->
	<!--[if IE 8]>
	<link href="<?php echo HOME?>/css/ie8_winkel.css" rel="stylesheet" type="text/css"/>	
	<![endif]-->
	
	<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
  	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js"></script>
  	<script>window.jQuery || document.write('<script src="<?php echo HOME?>/js/jquery/jquery-1.5.1.min.js">\x3C/script>')</script>	
	
<?php
	// CART:
	$totalprice = 0;
	$amountInCart = 0;
	$totalPrice = 0;
	
	if($session->check('Cart')){
		foreach($session->read('Cart') as $item){
			foreach($item as $product){
				$amountInCart ++;
				$total = $product['price'] + ($product['price'] * $product['vat']);
				$totalPrice += $total;
				
			}
		}
	}
	$cartitems = $session->read('Cart');
?>
</head>
<body>
	
	<!-- Adminlink: 
	<div id="adminlink">
		<a href="<?php echo HOME?>/admin/">Beheren</a>
	</div>
	-->
	
	<div id="container">

		<div id="header">
			
			<div id="topmenu">
				
				<ul>
					<?php foreach($pages as $page):?>
						<?php if($page['Staticpage']['menu'] == 'top'):?>
						<a href="<?php echo HOME .'/winkel/pagina/'.$page['Staticpage']['id'].'/'. $page['Staticpage']['slug']?>"><li><?php echo $page['Staticpage']['title']?></li></a>
						<?php endif;?>
					<?php endforeach;?>
				</ul>
			</div>
			
		<?php include('includes/breadcrumbs.php');?>

		<div class="content">
			<?php if($session->check('Message.flash')):?>
			<div class="announcements">
				<div id="flash">
					<h3><?php $session->flash(); ?></h3>
				</div>	
			</div>
			<?php endif;?>

			<table cellspacing="0" cellpadding="0">
				<tr>
				<td valign="top">
				<div id="menu">
					<?php foreach($categories as $category):?>
						<?php if(!empty($category['Product'])):?>
						<a href="<?php echo HOME?>/winkel/categorie/<?php echo $category['Category']['id']?>">
						<div class="menuitem">
							<?php echo $category['Category']['name']?>
						</div>
						</a>
						<?php endif;?>
					<?php endforeach;?>
					
				</div>
				</td>
				<td id="main" valign="top">
					<table cellspacing="0" cellpadding="0"  style="padding-bottom:10px;border-bottom:1px solid #e17f9b">
						<tr>
							<td><h1><?php echo $pageheader; ?></h1></td>

							<td style="text-align:right;" valign="top">
								<?php include('includes/searchengine.php');?>
							</td>
						</tr>
					</table>
					<?php echo $content_for_layout; ?>
					<br/>
				</td>
				</tr>
			</table>

		</div>
		<div id="footer">
			<small>Powered by  &middot; <a href="http://www.getthinkshop.com">Thinkshop</a> &middot; </small>
		</div>
	</div>
  	<script type="text/javascript" src="<?php echo HOME?>/js/fancybox/jquery.fancybox-1.3.1.js"></script>
	<script type="text/javascript" src="<?php echo HOME?>/js/thinkshop/front_init.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo HOME?>/js/css/fancy.css" />
	
	<!--[if lt IE 7 ]>
	    <script src="<?php echo HOME; ?>/js/pngfix/dd_belatedpng.js"></script>
	    <script>DD_belatedPNG.fix('img, .png_bg'); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
	  <![endif]-->	
	
	<!-- This webshop is powered by Thinkshop version <?php echo VERSION?>, <?php echo VERSION_NAME?>. Created by To Wonder multimedia :: to-wonder.com -->
</body>
</html>