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
		<?php echo WEBSITE_TITLE .' - ';?>
		<?php echo $title_for_layout; ?>	
	</title>
	<meta name="description" content="Thinkshop is het meest gebruiksvriendelijke webshopsysteem">
  	<meta name="author" content="To Wonder Multimedia">
  
	<!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  	<link rel="shortcut icon" href="<?php echo HOME?>/favicon.ico">
  	<link rel="apple-touch-icon" href="<?php echo HOME?>/apple-touch-icon.png">
  
	
	<link href="<?php echo HOME?>/css/admin.css" type="text/css" rel="stylesheet">	
	<!--[if IE 7]>
	<link href="<?php echo HOME?>/css/ie7_admin.css" rel="stylesheet" type="text/css"/>	
	<![endif]-->
	<!--[if IE 8]>
	<link href="<?php echo HOME?>/css/ie8_admin.css" rel="stylesheet" type="text/css"/>	
	<![endif]-->
	
	<?php
		// ALL PHP globals
		$year = date('Y');
		$month = date('m');
		$admin = $session->read('admin');
		if(!isset($id)){$id = ''; }; 
	?>
	
	<!-- set global javascript vars: -->
	<script type="text/javascript">
		var actionName = '<?php echo $this->action; ?>';
		var id = '<?php echo $id; ?>';
		var homeUrl = '<?php echo HOME?>';
	</script>		
	
	<!-- Grab Google CDN's jQuery, with a protocol relative URL; fall back to local if necessary -->
  	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.js"></script>
  	<script>window.jQuery || document.write('<script src="<?php echo HOME?>/js/jquery/jquery-1.5.1.min.js">\x3C/script>')</script>	
</head>
<body>
	
	
	<div id="container">
		<div id="topmenu">
			<a href="<?php echo HOME?>/" alt="Bekijk webwinkel" title="Bekijk webwinkel">
				<div id="logo"></div>
			</a>
			<div class="hello">
				<p>Hallo <?php echo $admin['naam']?></p> |
				<a href="<?php echo HOME?>/admin/logout" style="padding-bottom:1px" class="pill button">Uitloggen</a>
			</div>
		</div>

			<div class="content">
				<?php if($session->check('Message.flash')):?>
				<div class="announcements" style="display:none">
					<div id="flash">
						<h3><?php $session->flash(); ?></h3>
					</div>	
				</div>
				<?php endif;?>
					
				<div id="menu">							
						<a href="<?php echo HOME?>/admin/">
							<?php if($session->read('tab') == 'dash'):?>
								<div id="dashboard" class="menubutton active"><span class="icon dash"> </span>Overzicht</div>	
							<?php else: ?>
								<div id="dashboard" class="menubutton"><span class="icon dash"> </span>Overzicht</div>
							<?php endif; ?>
						</a>
						
						<hr/>
						
						<?php if($session->read('tab') == "products"):?>
						<a href="<?php echo HOME?>/admin/products">
							<div id="products" class="menubutton active sub"><span class="icon prod"> </span>Producten</div>
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
							<div id="products" class="menubutton"><span class="icon prod"></span>Producten</div>
						</a>
						<?php endif;?>
						
						<?php if($session->read('tab') == "news"):?>
						<a href="<?php echo HOME?>/admin/news">
							<div id="news" class="menubutton active sub"><span class="icon news"></span>Nieuws</div>
						</a>
						<div class="submenu">
							<ul>
								<li><a href="<?php echo HOME?>/admin/addpost/">Nieuw bericht</a></li>
							</ul>
						</div>
						
						<?php else: ?>
						<a href="<?php echo HOME?>/admin/news">
							<div id="news" class="menubutton"><span class="icon news"></span>Nieuws</div>
						</a>
						<?php endif;?>
						
						<?php if($session->read('tab') == 'page'):?>
						<a href="<?php echo HOME?>/admin/pages">
							<div id="pages" class="menubutton active sub"><span class="icon page"></span>Pagina's</div>
						</a>
						<div class="submenu">
							<ul>
								<li><a href="<?php echo HOME?>/admin/addpage/">Nieuwe pagina</a></li>
							</ul>
						</div>						
						<?php else:?>
						<a href="<?php echo HOME?>/admin/pages">
							<div id="pages" class="menubutton"><span class="icon page"></span>Pagina's</div>
						</a>
						<?php endif;?>
						
						<?php if($session->read('tab') == 'media'):?>
						<a href="<?php echo HOME?>/admin/media">
							<div id="media" class="menubutton active sub"><span class="icon media"></span>Media</div>
						</a>
						<div class="submenu" id="sub">
							<ul>
								<li><a href="<?php echo HOME?>/admin/addmedia/">Nieuwe Foto's</a></li>
								<li><a href="<?php echo HOME?>/admin/addmedia/video">Nieuwe Video</a></li>
							</ul>
						</div>						
						<?php else: ?>
						<a href="<?php echo HOME?>/admin/media">
							<div id="media" class="menubutton"><span class="icon media"></span>Media</div>
						</a>
						<?php endif;?>
						
						<hr/>
						
						<a href="<?php echo HOME?>/admin/orders">
							<?php if($session->read('tab') == "orders"):?>
							<div id="orders" class="menubutton active"><span class="icon orde"></span>Orders</div>
							<?php else:?>
							<div id="orders" class="menubutton"><span class="icon orde"></span>Orders</div>	
							<?php endif;?>
						</a>						
						
						<?php if($session->read('tab') == "finance"):?>
						<a href="<?php echo HOME?>/admin/finance">
							<div id="finance" class="menubutton active sub"><span class="icon fina"></span>Financiën</div>
						</a>
						<div class="submenu" id="sub">
							<ul>
								<li><a href="<?php echo HOME?>/admin/finance/">In & uit</a></li>
								<li><a href="<?php echo HOME?>/admin/sales/">Verkopen</a></li>
							</ul>
						</div>						
						<?php else:?>
						<a href="<?php echo HOME?>/admin/finance">
							<div id="finance" class="menubutton"><span class="icon fina"></span>Financiën</div>
						</a>
						<?php endif;?>
						
						<hr/>
						<?php if($session->read('tab') == "users"):?>
						<a href="<?php echo HOME?>/admin/users">
							<div id="users" class="menubutton active sub"><span class="icon user"></span>Beheerders</div>
						</a>
						<div class="submenu">
							<ul>
								<li><a href="<?php echo HOME?>/admin/adduser/">Nieuwe gebruiker</a></li>
							</ul>
						</div>
						
						<?php else:?>
						<a href="<?php echo HOME?>/admin/users">
							<div id="users" class="menubutton"><span class="icon user"></span>Beheerders</div>
						</a>
						<?php endif;?>

						
						<a href="<?php echo HOME?>/admin/plugins">
							<?php if($session->read('tab') == 'plugins'):?>
							<div id="plugins" class="menubutton active"><span class="icon plug"></span>Plugins</div>
							<?php else: ?>
							<div id="plugins" class="menubutton"><span class="icon plug"></span>Plugins</div>	
							<?php endif;?>
						</a>
						
						
						<a href="<?php echo HOME?>/admin/settings">
							<?php if($session->read('tab') == "settings"):?>
							<div id="settings_button" class="menubutton active"><span class="icon sett"></span>Instellingen</div>
							<?php else:?>
							<div id="settings_button" class="menubutton"><span class="icon sett"></span>Instellingen</div>	
							<?php endif;?>
						</a>
						
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
						<small>
							&copy; 2011 <a href="http://www.to-wonder.com" target="_blank">To Wonder Multimedia</a>&nbsp;|&nbsp;
							<a href="<?php echo HOME?>/admin/about">Over Thinkshop</a>&nbsp;|&nbsp;<a href="<?php echo HOME?>/admin/license">MIT Licentie</a>
						</small>
					</div>
	</div>
	
	<script src="<?php echo HOME?>/js/tiny_mce/tiny_mce.js" language="javascript"></script>
	<script type="text/javascript" src="<?php echo HOME?>/js/jquery-ui/jquery-ui-1.8.9.custom.min.js"></script>
	
	<script type="text/javascript" src="<?php echo HOME?>/js/fancybox/jquery.fancybox-1.3.1.js"></script>
	<script type="text/javascript" src="<?php echo HOME?>/js/thinkshop/admin_init.js"></script>
	
	<link rel="stylesheet" type="text/css" href="<?php echo HOME?>/js/css/uploadify.css">
	<link rel="stylesheet" type="text/css" href="<?php echo HOME?>/js/css/fancy.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo HOME?>/js/css/quickflip.css" />
	<script type="text/javascript">
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
	</script>
	
	
</body>
</html>