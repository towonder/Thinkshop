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

class AppController extends Controller {
	
	var $helpers = array('Html', 'Form', 'Number');
	var $components = array('Thumb') ;
	
	/*
	//
		Admin functions
	//
	*/
	    
	
	function setTab($string){
		$this->Session->write('tab',$string);
	}

	function checkSession()
	{
		// If the session info hasn't been set...
		if (!$this->Session->check('admin') && $this->isGreenListed() == false){
			// Force the user to login
			Header('Location:'.HOME.'/admin/login');
			exit();
		}
	}
	

	function isGreenListed(){
		$greenlisted = false;
		$baseArray = array('login', 'passwordforgot', 'confirm', 'checkLogin', 'checkadminemail');
		$mediaArray = array('medialibrary', 'editmainpicture', 'addMediaToProduct', 'savemainpicture','getproductpictures','getmainpicture');
		
		foreach($baseArray as $ba){
			if($this->action == $ba){
				$greenlisted = true;
			}
		}
				
		foreach($mediaArray as $ma){
			if($this->action == $ma){
				$greenlisted = true;
			}
		}
		
		return $greenlisted;
	}


	function fetchSettings(){
	   //Loading model on the fly
		$this->loadModel('Setting');
	   	//Fetching All params
	   	$settings_array = $this->Setting->find('all', array('conditions' => array('Setting.load_on_start' => '1')));
	
		//Create a global for every setting:
		foreach($settings_array as $key=>$value){
			$constant = $value['Setting']['key'];
			$val = $value['Setting']['pair'];
			if(!defined($constant)){
				eval("DEFINE(\$constant, \$val);");
			}
		}
		
		
		//PAGE SETTINGS:

		//show searchbox in every view, standard.
		$this->set('showSearch', true);
		
		// in case you forget to place page variables:
		$this->set('pageheader','');
		$this->setPage('page', null, 'auto');	
		Configure::write('Config.language', LANGUAGE);
		$this->fetchMenuAddons();	
	}
	
	
	
	function fetchMenuAddons(){
		uses('Folder');
		$this->loadModel('Plugin');
		$actives = $this->Plugin->find('all', array('conditions' => array('Plugin.active' => '1')));
		
		$hookFiles = array();	
		foreach($actives as $plug){
			$Folder =& new Folder(APP.$plug['Plugin']['path']);
			$menuloc = $Folder->findRecursive('menu.php');
			if(!empty($menuloc)){
				$hookFiles[] = $menuloc[0];
			}
		}
		
		$this->set('menuFiles', $hookFiles);		
	}
	
	
	/*
	//
		PLUGIN functions:
	//
	*/
	
	function callHooks($hook, $pluginFilter = '.+', &$caller, $type = null){
		
		//all the plugins that have a hook.php file:
		static $hookPlugins = array();
		
		
		if(empty($pluginFilter)){
			$pluginFilter = '.+';
		}
		
		if($type == ''){
			$type = 'front';
		}
				
		$params = func_get_args();
		array_shift($params);
		array_shift($params);
		array_shift($params);
		
		
		if(empty($hookPlugins)){
			//not caches, we need to cache it:
			
			$cachePath = 'hook_files';
			$cacheExpires = '+60 seconds';
			
			$hookFiles = cache($cachePath, null, $cacheExpires);
			
			if(empty($hookFiles)){

				uses('Folder');
				$this->loadModel('Plugin');
				$actives = $this->Plugin->find('all', array('conditions' => array('Plugin.active' => '1')));
					
				foreach($actives as $plug){
					$Folder =& new Folder(APP.$plug['Plugin']['path']);
					$typeloc = $Folder->findRecursive($type.'.php');
					if(!empty($typeloc)){
						$hookFiles[] = $typeloc[0];
					}
				}
				
				
				cache($cachePath, serialize($hookFiles));				
			}else{
				$hookFiles = unserialize($hookFiles);
			}
			
			if(!empty($hookFiles)){
				foreach($hookFiles as $hookFile):

					list($plugin) = explode(DS, substr($hookFile, strlen(APP.'plugins'.DS)));
				
					if(file_exists($hookFile)){
						require($hookFile);
			
						if(preg_match('/'.$pluginFilter.'/iUs', $plugin)){
							$hookFunction = $plugin.$hook.'Hook';
							if(function_exists($hookFunction)){
								call_user_func_array($hookFunction, array_merge(array(&$caller), $params));
							}	
						}
					}	
				endforeach;
			}
		}else{
			//files are cached:
			foreach($hookPlugins as $plugin):
				if(preg_match('/'.$pluginFilter.'/iUs', $plugin)){
					$hookFunction = $plugin.$hook.'Hook';
					if(function_exists($hookFunction)){
						call_user_func_array($hookFunction, array_merge(array(&$caller), $params));
					}
				}
			endforeach;
		}
	}
	
	
	
	/*
	//
		Frontpage functions
	//
	*/
	
	function setCategoriesAndPages(){
		//We are using these in the layout, so pre-set them all the time:
		$this->loadModel('Category');		
		$this->set('categories', $this->Category->find('all', array('conditions' => array('Category.parent_id' => '0'))));
		$this->loadModel('Staticpage');
		$this->set('pages', $this->Staticpage->find('all', array('order'=>'Staticpage.position DESC')));
	}

	function setPage($string, $child, $position){
		//Set the breadcrumbs:
		$this->set('pagename', $string);
		$this->set('pagechild', $child);
		$this->set('pageposition', $position);
	}
	
	function delCrumbs(){
		//Delete the breadcrumbs:
		$this->Session->del('crumb_links') ; 
        $this->Session->del('crumb_titles') ; 
        $this->Session->del('crumb_levels') ; 
	}	




	/*
	// 
		FILE HANDELING:
	//
	*/
	
	function uploadPhotos($id = null){
		//Make sure we know what the HOME folder is
		$this->fetchSettings();
		$this->layout = '';
		
		//set errorstring to empty:
		$error = '';
		
	
		$this->loadModel('Photo');
		if(!empty($id)){
			$this->loadModel('Product');
		}
	
		
		if (!empty($_FILES)) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$filename = $_FILES['Filedata']['name'];
			$folder = 'files/';
			$targetPath = WWW_ROOT . $folder;
			
			if(!is_dir($targetPath)){
				mkdir($targetPath);
			}
			
			// Use Wordpress' fileing system:
			$targetPath .= '/'.date('Y');
		
		
			//add year:
			if(!is_dir($targetPath)) {
				mkdir($targetPath);
			}
			//add month:
			$targetPath .= '/'.date('m');
			if(!is_dir($targetPath)) {
				mkdir($targetPath);
			}
		
			//Also create a relative url:
			$rel_url = $folder .'/'.date('Y').'/'.date('m');
		
			if(!file_exists($targetPath.'/'.$filename)){
				// create full filename
				$full_url = str_replace('//', '/', $targetPath).'/'.$filename;
				$url = $rel_url.'/'.$filename;
				// upload the file
				$success = move_uploaded_file($tempFile, $url);
			} else {
				// create unique filename and upload file
				ini_set('date.timezone', 'Europe/Amsterdam');
				$now = date('YmdHis');
				$full_url = str_replace('//', '/',$targetPath).'/'.$now."_".$filename;
				$url = $rel_url.'/'.$now."_".$filename;
				$success = move_uploaded_file($tempFile, $url);
			}
		
			if($success) {
			
				// get the file type:
				$type = substr($filename,-4);				
		
				//create thumbnail:
				$thumbWidth = THUMB_SIZE;
				$thumbHeight = THUMB_SIZE;
				$thumbQuality = 70;
				$thumbZoom = 4;
				$thumb = $this->Thumb->generateThumbnail($url, WWW_ROOT.substr($url, 0, -4)."_thumb".$type, true, false, $thumbWidth, $thumbHeight, $thumbQuality, $thumbZoom);
				
				//create mediumsize:
				$mediumWith = MEDIUM_SIZE;
				$mediumHeight = MEDIUM_SIZE;
				$mediumQuality = 100;
				$mediumZoom = 0;
				$medium = $this->Thumb->generateThumbnail($url, WWW_ROOT.substr($url, 0, -4)."_medium".$type, true, false, $mediumWith, $mediumHeight, $mediumQuality, $mediumZoom);
			
				//generate fancy name:	
				$photoname = substr($filename, 0, -4);
				$photoname = str_replace('-', ' ', $photoname);
				$photoname = str_replace('_', ' ', $photoname);
				$photoname = ucwords($photoname);

				//apply to database:
				if($thumb && $medium){
					$this->Photo->create();
											
					$this->data['Photo']['name'] = $photoname;
					$this->data['Photo']['thumb'] = '/'. substr($url, 0, -4).'_thumb'. $type;
					$this->data['Photo']['medium'] = '/'. substr($url, 0, -4).'_medium'. $type;
					$this->data['Photo']['large'] = '/'. $url;
					if($this->Photo->save($this->data)){
						// tie it to a product if there's a product id given:
						if(!empty($id)){
							$this->data['Product']['id'] = $id;
							$this->data['Product']['photo_id'] = $this->Photo->getLastInsertId();
							$this->Product->save($this->data);
							//echo 1 for uploadify:
							$error = 'upload_okay';
						}else{
							//echo 1 for uploadify:
							$error = 'upload_okay';
						}
					}
				
				}else{
					//thumb + medium uploads didn't work
					$error = __('Het genereren van de thumbnails lukt niet (waarschijnlijk een probleem met PHP safe-mode)', true);
				}
			
			}else{
				// no upload
				$error = __('Upload slaagt niet (waarschijnlijk een probleem met PHP safe-mode)', true);				
			}
		}else{
			//no files
			$error = __('Dit zijn geen geldige bestanden', true);
		}
		
		$this->set('error', $error);
		
	}



	/*
	//
		HELPER FUNCTIONS:
	//
	*/
	
	
	function addMetatermsToProduct($product){
		//just a function to make acces to metaterms & values a little simpler:
		
		$a = 0;
		$metaTermsInProduct = array();
		$currentTerm = 0;
		$this->loadModel('Metaterm');
		
		$terms = $this->Metaterm->find('all', array('order' => 'Metaterm.id DESC'));
		foreach($product['Metavalue'] as $values){
			foreach($terms as $term){
				if($currentTerm != $term['Metaterm']['id'] && $term['Metaterm']['id'] == $values['id']){
					$metaTermsInProduct[$a]['id'] = $term['Metaterm']['id'];
					$metaTermsInProduct[$a]['name'] = $term['Metaterm']['name'];
					$metaTermsInProduct[$a]['plural'] = $term['Metaterm']['plural'];
					$metaTermsInProduct[$a]['multiselect'] = $term['Metaterm']['multiselect'];
					$metaTermsInProduct[$a]['icon'] = $term['Metaterm']['icon'];
					$currentTerm = $term['Metaterm']['id'];
					$a++;
				}
			}
		}
				
		$a = 0;
		foreach($metaTermsInProduct as $term_id){
			$i = 0;		
			foreach($product['Metavalue'] as $value){
				
				if($term_id['id'] == $value['metaterm_id']){
					$product['Options'][$a]['id'] = $term_id['id'];
					$product['Options'][$a]['name'] = $term_id['name'];
					$product['Options'][$a]['plural'] = $term_id['plural'];
				
					if($term_id['multiselect'] == '1'){
						$product['Options'][$a]['multiselect'] = true;
					}else{
						$product['Options'][$a]['multiselect'] = false;
					}
					
					if($term_id['icon'] == '1'){
						$product['Options'][$a]['icon'] = true;
					}else{
						$product['Options'][$a]['icon'] = false;
					}
					
					$product['Options'][$a]['Values'][$i]['id'] = $value['id'];
					$product['Options'][$a]['Values'][$i]['name'] = $value['name'];
					$product['Options'][$a]['Values'][$i]['value'] = $value['value'];
					$product['Options'][$a]['Values'][$i]['icon'] = $value['icon'];
					$i++;
				}
			}
			$a++;
		}
		
		return $product;
		
	}
	
	// Get all products in an Order, and get there options.
	function getOrderProducts($id, $overview = false){
		
		$this->loadModel('OrdersProducts');
		$this->loadModel('Product');
		
		$prods = $this->OrdersProducts->find('all', array('conditions' => array('OrdersProducts.order_id' => $id)));
		$i = 0;
		$products = array();
	
		if($overview == false){
			foreach($prods as $prod){
				$product = $this->Product->read(null, $prod['OrdersProducts']['product_id']);
				$products[$i]['Product']['price'] = $product['Product']['price'];
				$products[$i]['Product']['vat'] = $product['Product']['vat'];
				$products[$i]['Product']['sendcost'] = $product['Product']['sendcost'];
			
				if($product['Product']['parent_id'] != '0'){
					$parent = $this->Product->read(null, $product['Product']['parent_id']);
					$products[$i]['Product']['name'] = $parent['Product']['name'] .' - variatie '. $product['Product']['name'];
					$products[$i]['Image']['thumb'] = $parent['Image']['thumb'];
					$products[$i]['Image']['large'] = $parent['Image']['large'];
				}else{
					$products[$i]['Product']['name'] = $product['Product']['name'];
					$products[$i]['Image']['thumb'] = $product['Image']['thumb'];
					$products[$i]['Image']['large'] = $product['Image']['large'];
				
				}
			
				$products[$i]['Product']['Options'] = array();
				$a = 0;
				if(!empty($prod['Option'])){
					foreach($prod['Option'] as $option){
						$products[$i]['Options'][$a]['term'] = $option['term'];
						$products[$i]['Options'][$a]['value'] = $option['value'];
						$a++;
					}
				}
				$i++;
			}
		}else{
			foreach($prods as $prod){
				$product = $this->Product->read(null, $prod['OrdersProducts']['product_id']);
				$products[$i]['price'] = $product['Product']['price'];
				$products[$i]['vat'] = $product['Product']['vat'];
				$products[$i]['discount'] = $product['Product']['discount'];
				$products[$i]['sendcost'] = $product['Product']['sendcost'];
				
				$i++;
			}
		}

		return $products;
	}
	
	
	// Create temp passwords:
	function createCode($len){
		$pass = '';
		$lchar = 0;
		$char = 0;
		
			for($i = 0; $i < $len; $i++) {
				while($char == $lchar) {
					$char = rand(48, 109);
					if($char > 57) $char += 7;
					if($char > 90) $char += 6;
				}
				$pass .= chr($char);
				$lchar = $char;
			}
		return $pass;
	}
	
	// Create product slugs:
	function makeSlug($string){
		$slug = strtolower(str_replace(' ', '-', $string));
		$slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
		$slug = preg_replace('/-+/', "-", $slug);
		return $slug;
	}
	
	//get filetype: (uploads)
	function getType($file){
		if($file == 'image/jpeg' || $file == 'image/pjpeg'){
			$type = '.jpg';
		}else if($file == 'image/png' || $file == 'image/x-png' || $file == 'image/PNG' || $file == 'image/X-PNG'){
			$type = '.png';
		}else{
			$type = '.gif';
		}
		return $type;
	}
	
	
	// sort an array:
	function orderBy($data, $field, $order = null){
	
		if($order == null || $order == 'ASC'){
	  		$code = "return strnatcmp(\$a['$field'], \$b['$field']);";
	  	}else if($order == 'DESC'){
	  		$code = "return strnatcmp(\$b['$field'], \$a['$field']);";
		}
	
		uasort($data, create_function('$a,$b', $code));
		return $data;
	}
	
	
	
	// check if the given is an emailaddress:
	function isEmail($email) {
		return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
	
	
	//simple function to help debug:
	function pa($arr) {
		echo '<pre>';
		print_r($arr);
		echo '</pre>';
	}
	
	
}

?>