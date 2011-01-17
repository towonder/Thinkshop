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
	<link href="<?php echo HOME?>/css/admin.css" type="text/css" rel="stylesheet">	
	<!--[if IE 7]>
	<link href="<?php echo HOME?>/css/ie7_admin.css" rel="stylesheet" type="text/css"/>	
	<![endif]-->
	<!--[if IE 8]>
	<link href="<?php echo HOME?>/css/ie8_admin.css" rel="stylesheet" type="text/css"/>	
	<![endif]-->
	
	
	<?php
	//JAVASCRIPTS (and there CSS FILES):
		echo $scripts_for_layout; 
		$year = date('Y');
		$month = date('m');
	?>
	
	<script src="<?php echo HOME?>/js/tiny_mce/tiny_mce.js" language="javascript"></script>
	<script type="text/javascript" src="<?php echo HOME?>/js/uploadify/jquery-1.3.2.min.js"></script>
	<script type="text/javascript" src="<?php echo HOME?>/js/jquery.fancybox-1.0.0.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo HOME?>/js/uploadify/uploadify.css">
	<link rel="stylesheet" type="text/css" href="<?php echo HOME?>/js/css/fancy2.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo HOME?>/js/css/quickflip.css" />
	

	
	<script type="text/javascript">
		// FANCYBOXES:
	
		$(function(){
			$(".lbOn").fancybox({ 'zoomSpeedIn': 500, 'zoomSpeedOut': 500, 'overlayShow': true }); 
		});
		
		$(function(){
			$(".addcostbox").fancybox({ 'zoomSpeedIn': 500, 'zoomSpeedOut': 500, 'overlayShow': true, 'frameHeight': 250, 'enableEscapeButton' : true }); 
		});
		
		$(function(){
			$(".medialibary").fancybox({ 'zoomSpeedIn': 500, 'zoomSpeedOut': 500, 'overlayShow': true, 'frameHeight': 700, 'frameWidth': 800, 'enableEscapeButton' : true }); 
		});
		
		
		$(function(){
			$(".viewvid").fancybox({ 'zoomSpeedIn': 500, 'zoomSpeedOut': 500, 'overlayShow': true, 'frameHeight': 360, 'frameWidth':480, 'enableEscapeButton' : true }); 
		});
			
				
		//SMART EMPTY OF NEW INPUTFIELDS
		function doSmartEmpty(id, string){
			if($(id).val() == string){
				$(id).val('');
				$(id).focus();
			}
		}
		
		function deleteSomething(id, what, div, sentence){
			var urlAddon = 'delete'+what;
			var conf = confirm("Weet u zeker dat u "+ sentence+" wilt verwijderen?");
			
			if(conf){
				$.ajax({ 
					url: "<?php echo HOME?>/admin/"+urlAddon+"/"+id,
			  		success: function(data) {
						$(div).fadeOut();	
			  		}
				});
			}
		}
		
	  
		tinyMCE.init({
		    theme : "advanced",
		    mode : "textareas",
		    convert_urls : false,
			theme_advanced_resizing : true,
			width : '564',
			editor_selector : 'mceEditor'
		});
				
		tinyMCE.init({
		    theme : "advanced",
		    mode : "textareas",
		    convert_urls : false,
			theme_advanced_resizing : true,
			width : '564',
			height : '370',
			editor_selector : 'mceEditor_big'
		});
		
		
	
	</script>
<?php $admin = $session->read('admin');?>	
</head>
<body>
	
	
	
	<div id="container">
		<div id="topmenu">
			<a href="<?php echo HOME?>/" alt="Bekijk webwinkel" title="Bekijk webwinkel">
				<div id="logo"></div>
			</a>
			<div class="hello">
				<small>Welkom terug, <?php echo $admin['naam']?>!<br/>
				<a href="<?php echo HOME?>/admin/logout">logout</a></small>
			</div>
		</div>

			<div class="content">
				<?php if($session->check('Message.flash')):?>
				<div class="announcements">
					<div id="flash">
						<h3><?php $session->flash(); ?></h3>
					</div>	
				</div>
				<?php endif;?>
					
					<div id="menu">
						<?php if($session->read('tab') == "dash"):?>
						<a href="<?php echo HOME?>/admin/">
							<div id="dashboard_active">
							</div>
						</a>
						<?php else: ?>
						<a href="<?php echo HOME?>/admin/">
							<div id="dashboard">
							</div>
						</a>
						<?php endif;?>
						
						<hr/>
						
						<?php if($session->read('tab') == "products"):?>
						<a href="<?php echo HOME?>/admin/products">
							<div id="products_active" class="productpool">
							</div>
						</a>
						<div class="submenu">
							<ul>
								<li><a href="<?php echo HOME?>/admin/addproduct/">Nieuw product</a></li>
								<li><a href="<?php echo HOME?>/admin/categories/">Categorieën beheer</a></li>
								<?php if(ADVANCED == 'true'):?>
								<li></li>								
								<li><a href="<?php echo HOME?>/admin/productoptions/">Keuzelijsten beheer</a></li>
								<li><a href="<?php echo HOME?>/admin/extrafields/">Extra velden beheer</a></li>
								<?php endif; ?>
							</ul>
						</div>
						<?php else:?>
						<a href="<?php echo HOME?>/admin/products">
							<div id="products" class="productpool">
							</div>
						</a>
						<?php endif;?>
						
						<?php if($session->read('tab') == "news"):?>
						<a href="<?php echo HOME?>/admin/news">
							<div id="news_active" class="productpool">
							</div>
						</a>
						<div class="submenu">
							<ul>
								<li><a href="<?php echo HOME?>/admin/addpost/">Nieuw bericht</a></li>
							</ul>
						</div>
						
						<?php else: ?>
						<a href="<?php echo HOME?>/admin/news">
							<div id="news" class="productpool">
							</div>
						</a>
						<?php endif;?>
						
						<?php if($session->read('tab') == 'page'):?>
						<a href="<?php echo HOME?>/admin/pages">
							<div id="pages_active" class="productpool">
							</div>
						</a>
						<div class="submenu">
							<ul>
								<li><a href="<?php echo HOME?>/admin/addpage/">Nieuwe pagina</a></li>
							</ul>
						</div>						
						<?php else:?>
						<a href="<?php echo HOME?>/admin/pages">
							<div id="pages" class="productpool">
							</div>
						</a>
						<?php endif;?>
						
						<?php if($session->read('tab') == 'media'):?>
						<a href="<?php echo HOME?>/admin/media">
							<div id="media_active" class="productpool"></div>
						</a>
						<div class="submenu" id="financesub">
							<ul>
								<li><a href="<?php echo HOME?>/admin/addmedia/">Nieuwe Foto's</a></li>
								<li><a href="<?php echo HOME?>/admin/addmedia/video">Nieuwe Video</a></li>
							</ul>
						</div>						
						<?php else: ?>
						<a href="<?php echo HOME?>/admin/media">
							<div id="media" class="productpool">
							</div>
						</a>
						<?php endif;?>
						
						<hr/>
						<?php if($session->read('tab') == "orders"):?>
						<a href="<?php echo HOME?>/admin/orders">
							<div id="orders_active">
							</div>
						</a>						
						<?php else: ?>
						<a href="<?php echo HOME?>/admin/orders">
							<div id="orders">
							</div>
						</a>
						<?php endif?>
						
						<?php if($session->read('tab') == "finance"):?>
						<a href="<?php echo HOME?>/admin/finance">
							<div id="finance_active">
							</div>
						</a>
						<div class="submenu" id="financesub">
							<ul>
								<li><a href="<?php echo HOME?>/admin/finance/">In & uit</a></li>
								<li><a href="<?php echo HOME?>/admin/sales/">Verkopen</a></li>
							</ul>
						</div>						
						<?php else:?>
						<a href="<?php echo HOME?>/admin/finance">
							<div id="finance">
							</div>
						</a>
						<?php endif;?>
						
						<hr/>
						<?php if($session->read('tab') == "users"):?>
						<a href="<?php echo HOME?>/admin/users">
							<div id="users_active">
							</div>
						</a>
						<div class="submenu">
							<ul>
								<li><a href="<?php echo HOME?>/admin/adduser/">Nieuwe gebruiker</a></li>
							</ul>
						</div>
						
						<?php else:?>
						<a href="<?php echo HOME?>/admin/users">
							<div id="users">
							</div>
						</a>
						<?php endif;?>

						<?php if($session->read('tab') == 'plugins'):?>
						<a href="<?php echo HOME?>/admin/plugins">
							<div id="plugins_active">
							</div>
						</a>
						<?php else: ?>
						<a href="<?php echo HOME?>/admin/plugins">
							<div id="plugins">
							</div>
						</a>	
						<?php endif; ?>
						
						
						<?php if($session->read('tab') == "settings"):?>
						<a href="<?php echo HOME?>/admin/settings">
							<div id="settings_active"></div>
						</a>
						<?php else:?>
						<a href="<?php echo HOME?>/admin/settings">
							<div id="settings">
							</div>
						</a>
						<?php endif;?>
						
						<?php
						
						if(!empty($menuFiles)){
							echo '<div id="spacer"><hr/></div>';
						}
						
						foreach($menuFiles as $menuFile):
							//list($plugin) = explode(DS, substr($hookFile, strlen(APP.'plugins'.DS)));
							require($menuFile);
							echo '<div id="smallspacer"></div>';
						endforeach;
						
						
						?>
				
					</div>
			
			
			
				<div id="main">
					
				
					
					<?php echo $content_for_layout; ?>
				</div>
			</div>
					<div id="footer">
						<small>Thinkshop wordt gemaakt en vernieuwd door <a href="http://www.to-wonder.com" target="_blank">To Wonder</a>.<br/>Thinkshop is Open Source zou niet bestaan zonder <a href="http://cakephp.org" target="_blank">Cake PHP</a> en <a href="http://www.jquery.org" target="_blank">jQuery</a></small>
					</div>
					

		
	</div>
</body>
</html>