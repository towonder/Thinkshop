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
		<?php echo WEBSITE_TITLE .' - ';?>
		<?php echo $title_for_layout; ?>	
	</title>
	
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
	<link href="<?php echo HOME?>/css/winkel.css" type="text/css" rel="stylesheet" />	
	<link href="<?php echo HOME?>/includes/css/breadcrumbs.css" type="text/css" rel="stylesheet" />
	<link href="<?php echo HOME?>/includes/css/searchengine.css" type="text/css" rel="stylesheet" />
	<!--[if IE 7]>
	<link href="<?php echo HOME?>/css/ie7_winkel.css" rel="stylesheet" type="text/css"/>	
	<![endif]-->
	<!--[if IE 8]>
	<link href="<?php echo HOME?>/css/ie8_winkel.css" rel="stylesheet" type="text/css"/>	
	<![endif]-->
	
	<script type="text/javascript" src="<?php echo HOME?>/js/uploadify/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="<?php echo HOME?>/js/jquery.fancybox-1.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo HOME?>/js/css/fancy.css" />
	
	
	<script type="text/javascript">
		// FANCYBOXES:
		     
		function fancybox(href, width, height){
			$.fancybox({
				'zoomSpeedIn': 500,
				'zoomSpeedOut': 500,
				'overlayShow': true,
				'width': width,
				'height': height,
				'autoDimensions': false,
				'padding': 0,
				'href':href
			}); 
		}
		   
		
		$(function(){
			$(".viewvid").fancybox({
				'zoomSpeedIn': 500,
				'zoomSpeedOut': 500,
				'overlayShow': true,
				'autoDimensions': false,
				'height': 360,
				'width':480,
				'padding': 0,
				'enableEscapeButton' : true,			
			}); 
		});
		
		
						
		//SMART EMPTY OF NEW INPUTFIELDS
		function doSmartEmpty(id, string){
			if($(id).val() == string){
				$(id).val('');
				$(id).focus();
			}
		}
		
		
		
		
		/*function showCart(){
			$('#cart').slideToggle('fast');	
		}*/
		
		$(function(){
			$('#cartbutton').mouseleave(function() {
				$('#cart').slideUp('fast');
			});
			
			$('#cartbutton').mouseenter(function(){
				$('#cart').slideDown('fast');
			})
		})		
		
		
	</script>
	
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
	//echo $articles Artikel(en) (echo $number->currency($amount, 'EUR'));

/*
	echo '<pre>';
	print_r($session->read('Cart'));
	echo '</pre>';
*/
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
				<!-- 
				<ul>
					<?php foreach($pages as $page):?>
						<?php if($page['Staticpage']['menu'] == 'top'):?>
						<a href="<?php echo HOME .'/'. $page['Staticpage']['title']?>"><li><?php echo $page['Staticpage']['title']?></li></a>
						<?php endif;?>
					<?php endforeach;?>
				</ul>
			-->
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
</body>
</html>