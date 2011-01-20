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


class AdminController extends AppController {

	var $name = 'Admin';
	var $uses = array('Product', 'Metaterm', 'Metavalue', 'MetavaluesProduct', 'Extraterm', 'Extravalue', 'User', 'Order', 'Photo', 'Video', 'OrdersProducts', 'CategoriesProduct', 'PhotosProduct', 'VideosProduct', 'Category', 'Admin', 'Post', 'Staticpage', 'Cost', 'Setting', 'Plugin');
	var $helpers = array('Html', 'Form', 'Number', 'Javascript');
	var $components = array('Email','Thumb');
	var $layout = "admin";
	var $paginate = array('limit' => 10);
	
	
	//get sessions & settings before every function:
	function beforeFilter(){
		$this->fetchSettings();
		$this->checkSession();
		$this->callHooks('beforeFilter', null, $this, 'admin');
	}
		

	/*
		DASHBOARD:
	*/


	//
	//	Index page (i need more help with this, since Google Analytics slows this function WAY down...);
	//
	function index(){

		$this->pageTitle = 'Overzicht';
		$this->setTab('dash');		
		$admin = $this->Session->read('admin');
		$orders =  $this->Order->find('all', array('conditions' => array('Order.created >=' => $admin['lastvisited'])));
		
		
		if(date('Y-m-d', strtotime($admin['lastvisited'])) != date('Y-m-d')){	
			$date = date('Y-m-d G:i:s');
			$this->add['Admin']['lastvisited'] = $date;
			$this->add['Admin']['id'] = $admin['id'];
			$this->Admin->save($this->add);
		}
		
		$huidigemaand = date('m');
		$kwartaal = $this->Order->getQuarter($huidigemaand);
		$jaar = date('Y');
		
		$start = $this->Order->getStartQuarter($kwartaal, $jaar);
		$end = $this->Order->getEndQuarter($kwartaal, $jaar);
		
		//get all new orders:		
		$allOrders = $this->Order->find('all', array('conditions' => array('Order.paid' => '1', 'Order.created BETWEEN ? AND ?' => array($start, $end)),'order' => 'Order.created DESC'));
		$costs = $this->Cost->find('all', array('conditions' => array('Cost.created BETWEEN ? AND ?' => array($start, $end)),'order' => 'Cost.created DESC'));
		
		$totalin = 0;
		$totalcost = 0;
		
		foreach($allOrders as $order){	
			foreach($order['Product'] as $product){
				$totalin += $product['price'];
			}
		}
		
		foreach($costs as $cost){
			$totalcost += $cost['Cost']['prijs'];
		}
		
		$login = GOOGLE_LOGIN;
		$pass = GOOGLE_PASSWORD;
		$gaid = ANALYTICS_ID;
		
		$startStats = date('Y-m-d', strtotime($start));
		$endStats = date('Y-m-d');
		
		$totalVisits = 0;
		$totalDirectSource = 0;
		$totalReferSource = 0;
		$totalSearchSource = 0;
		$totalDirectVisits = 0;
		$totalSearchVisits = 0;
		$totalReferVisits = 0;
		
		if(!empty($login) && !empty($pass) && !empty($gaid)){
			app::import('Vendor','googleAnalytics',array('file'=>'googleAnalytics'.DS.'class.php'));
		
			$ga = new GoogleAnalytics($login, $pass);
			$ga->setProfile('ga:'.$gaid);			
			$ga->setDateRange($startStats,$endStats);
			$report = $ga->getReport(
				array('dimensions'=>urlencode('ga:date,ga:source'),
					'metrics'=>urlencode('ga:pageviews,ga:visits'),
					'sort'=>'-ga:pageviews'
					)
				);

			foreach($report as $rep){
				$totalVisits += $rep['ga:visits'];
				
				if($rep['ga:source'] == '(direct)'){
					$totalDirectSource += $rep['ga:visits'];
				}else if($rep['ga:source'] == 'google'){
					$totalSearchSource += $rep['ga:visits'];
				}else{
					$totalReferSource += $rep['ga:visits'];
				}				
			}
			$googleanalytics = true;
			$totalDirectVisits = $totalDirectSource / $totalVisits * 100;
			$totalSearchVisits = $totalSearchSource / $totalVisits * 100;
			$totalReferVisits = $totalReferSource / $totalVisits * 100;
			
		}else{
			$googleanalytics = false;
		}

		
		
		$allOrders = $this->Order->find('all', array('limit' => '5', 'order' => 'Order.created DESC'));
		$allProducts = $this->Product->find('all', array('limit' => '5', 'order' => 'Product.created DESC', 'conditions' => array('Product.parent_id' => 0)));
		$allPosts = $this->Post->find('all', array('limit' => '5', 'order' => 'Post.created DESC'));
		$this->set('ga', $googleanalytics);
		$this->set('amountProducts', $this->Product->findCount());
		$this->set('amountPages', $this->Staticpage->findCount());
		$this->set('amountCategories', $this->Category->findCount());
		$this->set('amountPosts', $this->Post->findCount());
		
		$this->set('amountOrders', count($orders));
		$this->set('orders', $allOrders);
		$this->set('products', $allProducts);
		$this->set('posts', $allPosts);
		
		$this->set('amountIn', $totalin);
		$this->set('amountOut', $totalcost);

		$this->set('totalVisits', $totalVisits);
		$this->set('totalDirectVisits', substr($totalDirectVisits,0,2));
		$this->set('totalSearchVisits', substr($totalSearchVisits,0,1));
		$this->set('totalReferVisits', substr($totalReferVisits,0,2));
		$this->set('gaid', $gaid);
	}
	
	
	
	/*
	//
	//		PRODUCT FUNCTIONS:
	//
	*/
	
	function products($cat = null){

		$this->pageTitle = 'Producten';

		if($this->data['cat_id'] != null){
			$cat_id = $this->data['cat_id'];
		}else if($cat != null){
			$cat_id = $cat;
		}else{
			$c = $this->Category->find('first', array('Category.id' => 'ASC'));
			$cat_id = $c['Category']['id'];
		}

		//$this->paginate = array('order' => array('Product.position' => 'ASC'), 'limit' => AMOUNT_ON_PAGE);
		$this->Category->recursive = 2;
		$category = $this->Category->read(null, $cat_id);
				
		$this->Category->recursive = 2;
		$category = $this->Category->read(null, $cat_id);
		
		$this->set('products', $this->Product->findInCategory($cat_id));
		$this->set('category', $category);

		$cate = $this->Category->find('all');
		
		
		$this->set('categories', $cate);
		$this->setTab('products');
	}
	

	function addproduct() {
		
		$this->data['Product']['name'] = "Product naam";
			
		if ($this->Product->save($this->data)) {
			$id = $this->Product->getLastInsertId();
			
			$this->CategoriesProduct->create();
			$this->da['CategoriesProduct']['category_id'] = '1';
			$this->da['CategoriesProduct']['product_id'] = $id;
			$this->CategoriesProduct->save($this->da);
			
			Header('Location: '.HOME.'/admin/editproduct/'. $id);
		} else {
			$this->Session->setFlash($this->data['Product']['name'].' kon niet worden bewaard!');
			Header('Location: '.HOME.'/admin/projects');
		}

	}

	
	function editproduct($id){
		
		$this->pageTitle = 'Product bewerken';

		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Product', true));
			Header('Location: '.HOME.'/admin/index/');
		}
		
		$this->set('categories', $this->Category->find('all', array('conditions' => array('Category.parent_id' => 0))));
		$this->set('catkids', $this->Category->find('all', array('conditions' => array('Category.parent_id != ' => 0))));
		$product = $this->Product->read(null, $id);
		$a = 0;
		$terms = array();
		
		foreach($product['Extravalue'] as $value){
			$term = $this->Extraterm->read(null, $value['extraterm_id']);
			$terms[$a] = $term['Extraterm']['id'];
			$product['Extrafield'][$a]['id'] = $value['id']; 
			$product['Extrafield'][$a]['name'] = $term['Extraterm']['name'];
			$product['Extrafield'][$a]['value'] = $value['value'];
			$a++;
		}
		
		$extraterms = $this->Extraterm->find('all');
		foreach($extraterms as $term){
			
			$inSystem = false;
			
			foreach($terms as $id){
				if($term['Extraterm']['id'] == $id){
					$inSystem = true;
				}
			}
			
			if($inSystem == false){
				$product['Extrafield'][$a]['id'] = $term['Extraterm']['id'];
				$product['Extrafield'][$a]['name'] = $term['Extraterm']['name'];				
				$product['Extrafield'][$a]['value'] = null;
				$a++;
			}
		}
		
		$this->set('extrafields', $this->Extraterm->find('all'));
		$this->set('product', $product);
		$this->set('id', $id);
		
		$products = $this->Product->find('all', array('conditions' => array('Product.parent_id' => '0', 'Product.id !=' => $id)));
		$this->set('products', $products);
			
		$metaterms = array();
		$currentTerm = 0;
		
	
		$this->set('metaterms', $this->Metaterm->find('all'));
		$this->set('extrafields', $this->Extraterm->find('all'));
		
		$this->setTab('products');
		
	}
	
	//created a seperate save function to keep the edit function a bit cleaner:
	function saveProduct($id){
		
		// PRICES:
		if(!empty($this->data['Product']['price'])){
			$this->data['Product']['price'] = str_replace(',','.', $this->data['Product']['price']);	
		}
		
		if(!empty($this->data['Product']['sendcost'])){
			$this->data['Product']['sendcost'] = str_replace(',','.', $this->data['Product']['sendcost']);
		}
		
		if($this->data['Product']['discount'] != ''){
			$this->data['Product']['discount'] = $this->data['Product']['discount'] / 100;
		}
		
		$prod = $this->Product->read(null, $id);
					
		
		// PARENT / CHILD:
		if(empty($this->data['Product']['parent'])){
			$this->data['Product']['parent_id'] = 0;
			
			//SEO:
			if($this->data['Product']['slug'] == 'product-naam' || $this->data['Product']['slug'] == 'eerste-product'){
				$this->data['Product']['slug'] = $this->makeSlug($this->data['Product']['name']);	
				$this->data['Product']['pagetitle'] = $this->data['Product']['name'];			
			}
		}
				
		//HIDDEN / VISIBLE
		if(empty($this->data['Product']['save'])){
			$this->data['Product']['hidden'] = "0";
		}else if(empty($this->data['Product']['publish'])){
			$this->data['Product']['hidden'] = "1";
		}	
		
				
		//SAVE EVERYTHING:
		
		if($this->Product->save($this->data)){
			
			//after save, we need to save all the additional data (extrafields, metavalues, categories).
			
			//META ITEMS:
			if(empty($this->data['Metaterm'])){
				$this->data['Metaterm'] = array();
			}if(empty($this->data['DeletedMeta'])){
				$this->data['DeletedMeta'] = array();
			}

			$this->saveMetaData($this->data['Metaterm'], $this->data['DeletedMeta'], $this->data['Product']['id']);		

			//EXTRA FIELDS:
			if(!empty($this->data['Extrafield'])){
				$this->saveExtrafields($this->data['Extrafield']);
			}

			$prodcats = array();		
			$prodname = $this->data['Product']['name'];

			if(!empty($this->data['ProdCats'])){
				$prodcats = $this->data['ProdCats'];
			}
						
			if($this->saveCategories($prodcats, $id)){
				if($this->Session->check('catnum')){
					$cat_id = $this->Session->read('catnum');
					$this->Session->del('catnum');
				}else{
					$cat_id = '1';
				}
				
				$this->Session->setFlash($prodname.' is bewaard!');
				Header('Location: '.HOME.'/admin/products/'. $cat_id);
			}else{
				$this->Session->setFlash('Er ging iets mis bij het opslaan... probeer later nog eens');
				Header('Location: '.HOME.'/admin/products/1');
			}
			
		
		}
	}
	
	
	function removeMediaItem($id, $product_id ,$type){
		if($type == 'video'){
			$vid = $this->VideosProduct->find('first', array('conditions'=>array('VideosProduct.product_id' => $product_id, 'VideosProduct.video_id' => $id)));
			if(!empty($vid)){
				$vid_id = $vid['VideosProduct']['id'];
				$this->VideosProduct->del($vid_id);
			}
		}else if($type == 'photo'){
			$phot = $this->PhotosProduct->find('first',
														array('conditions' => array(
															'PhotosProduct.product_id' => $product_id, 
															'PhotosProduct.photo_id' => $id)));

			if(!empty($phot)){
				$phot_id = $phot['PhotosProduct']['id'];
				$this->PhotosProduct->del($phot_id);
			}
		}
	}
	
		
	
	function saveMetaData($metaterm, $deleted, $product_id){
		//CREATE NEW:
		if(!empty($metaterm)):
			
			foreach($metaterm as $term){
			if(!empty($term['Metavalue'])):
				foreach($term['Metavalue'] as $value){
				
					$meta = $this->MetavaluesProduct->find('first', 
													array('conditions' => array(
															'MetavaluesProduct.product_id' => $product_id, 
															'MetavaluesProduct.metavalue_id' => $value['id'])));
					if(empty($meta)){
						$this->MetavaluesProduct->create();
					
						$this->meta['MetavaluesProduct']['product_id'] = $product_id;
						$this->meta['MetavaluesProduct']['metavalue_id'] = $value['id'];
						$this->MetavaluesProduct->save($this->meta);
					}	
				}
			endif;
			}
			
		endif;
		
		//Delete old:
		if(!empty($deleted)):
			foreach($deleted as $delete){
				$meta = $this->MetavaluesProduct->find('first',
															array('conditions' => array(
																'MetavaluesProduct.product_id' => $product_id, 
																'MetavaluesProduct.metavalue_id' => $delete['id'])));
			
				if(!empty($meta)){
					$meta_id = $meta['MetavaluesProduct']['id'];
					$this->MetavaluesProduct->del($meta_id);
				}
			}
		endif;
	}
	
	
	function saveExtraFields($extrafields){
		foreach($extrafields as $field){
			if($field['blank'] == "true" && !empty($field['value'])){
				// new value:
				$this->Extravalue->create();
				$this->extra['Extravalue']['value'] = $field['value'];
				$this->extra['Extravalue']['product_id'] = $field['product_id'];
				$this->extra['Extravalue']['extraterm_id'] = $field['id'];
				$this->Extravalue->save($this->extra);
			}else if($field['blank'] == "false" && !empty($field['value'])){
				//old value:				
				$this->extra['Extravalue']['value'] = $field['value'];
				$this->extra['Extravalue']['id'] = $field['id'];
				$this->Extravalue->save($this->extra);
			}else if($field['blank'] == "false" && empty($field['value'])){
				//remove value:
				$this->Extravalue->del($field['id']);
			}
		}
	}
	
	
	function saveCategories($catproducts, $id){
		
		$product = $this->Product->read(null, $id);
		if($product['Product']['parent_id'] == '0'):
			$catprod = $this->CategoriesProduct->find('all', array('conditions' => array('CategoriesProduct.product_id' => $id)));
			$wop = '';
			$positions = array();
		
	
		
			$first = $this->CategoriesProduct->find('first', array('conditions' => array('CategoriesProduct.category_id' => '1'), 'order' => 'CategoriesProduct.position DESC', 'limit' => '1'));
		
			if(!empty($catprod)){
				foreach($catprod as $cp){
					$positions[$cp['CategoriesProduct']['category_id']] = $cp['CategoriesProduct']['position'];
					//$positions[] = $cp['CategoriesProduct']['position'];
					$this->CategoriesProduct->del($cp['CategoriesProduct']['id']);
				}
			}
		
			$newcat = '1';		
			$a = 0;
			if(!empty($catproducts)){
			
				foreach($catproducts as $cp){
					$this->CategoriesProduct->create();
					$this->bu['CategoriesProduct']['product_id'] = $id;
					$this->bu['CategoriesProduct']['category_id'] = $cp;

					if(!empty($positions[$cp])){
						$this->bu['CategoriesProduct']['position'] = $positions[$cp];
					}else{
						$f = $this->CategoriesProduct->find('first', array('conditions' => array('CategoriesProduct.category_id' => $cp), 'order' => 'CategoriesProduct.position DESC', 'limit' => '1'));
					
						$this->bu['CategoriesProduct']['position'] = $f['CategoriesProduct']['position'] + 1;
					}
					$this->CategoriesProduct->save($this->bu);
				
					$a++;
				}
			}else{
				$this->CategoriesProduct->create();
				$this->co['CategoriesProduct']['product_id'] = $id;
				$this->co['CategoriesProduct']['category_id'] = '1';
			
			
				$this->co['CategoriesProduct']['position'] = $first['CategoriesProduct']['position'] + 1;
				$this->CategoriesProduct->save($this->co);
			}
		
			return true;
		else:
			return true;
		endif;
	}
	
	
	
	function saveProductPositions(){
		
		$this->layout = '';
		$message = '';
		if(!empty($_GET)){
			$products = $_GET['prod'];
			$cat = $_GET['catid'];
		
			$i = 1;
			foreach($products as $prod){
				//$this->CategoriesProduct->contain('');
				$catprod = $this->CategoriesProduct->find('first', array('conditions' => array('CategoriesProduct.category_id' => $cat, 'CategoriesProduct.product_id' => $prod)));
				$this->d['CategoriesProduct']['id'] = $catprod['CategoriesProduct']['id'];
				$this->d['CategoriesProduct']['position'] = $i;
				$this->CategoriesProduct->save($this->d);
				$i++;
			}
		}

		$this->set('message', $message);
	}
	
		
	
	function deleteproduct($id = null) {
		if (!$id) {
			$this->Session->setFlash('Dit product kon niet worden gevonden.');
			Header('Location: '.HOME.'/admin/products/');
		}
		if ($this->Product->del($id)) {
			$this->Session->setFlash('Het product is verwijderd.');
			Header('Location: '.HOME.'/admin/products/');
		}
		$this->setTab('products');
	}
	
	
	function productoptions(){
		
		$this->pageTitle = 'Keuzelijsten';
		
		$this->set('metaterms',$this->Metaterm->find('all'));
		$this->setTab('products');		
	}
	
	
	function addoption(){
		
		$this->pageTitle = 'Keuzelijst toevoegen';

		if (!empty($this->data)) {
			$this->Metaterm->create();
			if ($this->Metaterm->save($this->data)) {
				$this->Session->setFlash('"'.$this->data['Metaterm']['plural'].'" zijn bewaard!');
				Header('Location: '.HOME.'/admin/productoptions/');
			} else {
				$this->Session->setFlash('"'.$this->data['Metaterm']['plural'].'" konden niet worden bewaard!');
			}
		}
		
		$this->setTab('products');
	}
	

	function editoption($id){
		
		$this->pageTitle = 'Keuzelijst bewerken';
		
		if(!empty($id)){
						
			if($this->Metaterm->save($this->data)){
				$this->Session->setFlash('"'.$this->data['Metaterm']['plural'].'" zijn bewaard!');
				Header('Location: '.HOME.'/admin/productoptions/');
			}else{
				$this->Session->setFlash('"'.$this->data['Metaterm']['plural'].'" konden niet worden bewaard!');
				Header('Location: '.HOME.'/admin/editoption/'.$id);
			}
		}
	}
	
	
	function deleteoption($id){
		
		if(!$id){
			$this->Session->setFlash('Deze keuzelijst bestaat niet!');
			Header('Location: '.HOME.'/admin/productoptions/');
		}else{
			
			$term = $this->Metaterm->read(null, $id);
			foreach($term['Metavalue'] as $value){
				
				$values = $this->MetavaluesProduct->find('all', array('conditions' => array('MetavaluesProduct.metavalue_id' => $value['id'])));
				foreach($values as $val){
					$this->MetavaluesProduct->del($val['MetavaluesProduct']['id']);
				}
				
				$this->Metavalue->del($value['id']);
			}
			
			
			
			$this->Metaterm->del($id);
			Header('Location: '.HOME.'/admin/productoptions/');
		}
		
	}
	
	
	function addvalue($id){
		
		$this->pageTitle = 'Keuze toevoegen';

		if (!empty($this->data)) {
			$this->Metavalue->create();
			
			if($this->data['Metavalue']['name'] != 'Waarde naam' && $this->data['Metavalue']['value'] != 'Waarde'){	
				if ($this->Metavalue->save($this->data)) {
					$this->Session->setFlash('"'.$this->data['Metavalue']['name'].'" is bewaard!');
					Header('Location: '.HOME.'/admin/productoptions/');
				} else {
					$this->Session->setFlash('"'.$this->data['Metavalue']['name'].'" kon niet worden bewaard!');
				}
			}
		}else{
			$this->set('id', $id);
		}
	}
	
	function editvalue($id){
	
		$this->pageTitle = 'Keuze bewerken';
		
		if(!empty($id)){
			if(!empty($this->data)){
			
				if($this->Metavalue->save($this->data)){
					$this->Session->setFlash('"'.$this->data['Metavalue']['name'].'" is bewaard!');
					Header('Location: '.HOME.'/admin/productoptions/');
				}else{
					$this->Session->setFlash('"'.$this->data['Metavalue']['name'].'" kon niet worden bewaard!');
					Header('Location: '.HOME.'/admin/editvalue/'.$id);
				}
			}else{
				$this->set('id', $id);
				$this->set('term', $this->Metavalue->read(null, $id));
			}
		}
	}
	
	function deletevalue($id = null) {
		if (!$id) {
			$this->Session->setFlash('Deze optie kon niet worden gevonden.');
			Header('Location: '.HOME.'/admin/productoptions/');
		}
		if ($this->Metavalue->del($id)) {
			
			$values = $this->MetavaluesProduct->find('all', array('conditions' => array('MetavaluesProduct.metavalue_id' => $id)));
			if(!empty($values)):	
				foreach($values as $value){
					$value_id = $value['MetavaluesProduct']['id'];
					$this->MetavaluesProduct->del($value_id);
				}
			endif;			
			$this->Session->setFlash('De optie is verwijderd.');
			Header('Location: '.HOME.'/admin/productoptions/');
		}
		$this->setTab('products');
	}
	
	
	function extrafields(){
		
		$this->pageTitle = 'Extra velden';
		$this->set('extrafields', $this->Extraterm->find('all'));
		
	}
	
	function addextrafield(){
		$this->pageTitle = 'Extra veld toevoegen';
		
		if (!empty($this->data)) {
			$this->Extraterm->create();
			if ($this->Extraterm->save($this->data)) {
				$this->Session->setFlash('"'.$this->data['Extraterm']['name'].'" is bewaard!');
				Header('Location: '.HOME.'/admin/extrafields/');
			} else {
				$this->Session->setFlash('"'.$this->data['Extraterm']['name'].'" kon niet worden bewaard!');
			}
		}
		
		$this->setTab('products');
	}
	
	
	function editextrafield($id){
		
		$this->pageTitle = 'Extra veld bewerken';
		
		if(!empty($id)){
			if(!empty($this->data)){
			
				if($this->Extraterm->save($this->data)){
					$this->Session->setFlash('"'.$this->data['Extraterm']['name'].'" is bewaard!');
					Header('Location: '.HOME.'/admin/extrafields/');
				}else{
					$this->Session->setFlash('"'.$this->data['Extraterm']['name'].'" kon niet worden bewaard!');
					Header('Location: '.HOME.'/admin/editextrafields/'.$id);
				}
			}else{
				$this->set('id', $id);
				$this->set('field', $this->Extraterm->read(null, $id));
			}
		}
	}
	
	function deleteextrafield($id = null) {
		if (!$id) {
			$this->Session->setFlash('Het veld kon niet worden gevonden.');
			Header('Location: '.HOME.'/admin/extrafields/');
		}
		
		//delete values:
		$extravalues = $this->Extravalue->find('all', array('conditions' => array('Extravalue.extraterm_id' => $id)));
		foreach($extravalues as $value){
			$this->Extravalue->del($value['Extravalue']['id']);
		}
		
		//delete term:
		if ($this->Extraterm->del($id)) {			
			$this->Session->setFlash('Het veld is verwijderd.');
			Header('Location: '.HOME.'/admin/extrafields/');
		}
		$this->setTab('products');
	}
	
	
	
	/*
	//
	//		CATEGORY FUNCTIONS:
	//
	*/
	
	
	
	function categories(){
		
		$this->pageTitle = 'Categorieën';
		
		$this->set('categories', $this->Category->find('all', array('conditions' => array('Category.parent_id' => '0'))));
	}
	
	function addcategory(){
		
		$this->pageTitle = 'Categorie toevoegen';
		$this->set('categories', $this->Category->find('all', array('conditions' => array('Category.parent_id' => '0'))));
		
		if (!empty($this->data)) {
			$this->Category->create();
			if ($this->Category->save($this->data)) {
				$this->Session->setFlash('"'.$this->data['Category']['name'].'" is bewaard!');
				Header('Location: '.HOME.'/admin/categories/');
			} else {
				$this->Session->setFlash('"'.$this->data['Category']['name'].'" kon niet worden bewaard!');
			}
		}
		
		$this->setTab('products');
	}
	
	function quickaddcategory($name){
		
		$this->layout = '';
		$latest = $this->Category->find('first', array('order' => 'Category.position DESC', 'conditions' => array('Category.parent_id' => '0')));
		
		$this->Category->create();
		$this->data['Category']['name'] = $name;
		$this->data['Category']['position'] = $latest['Category']['position'] + 1;
		$this->Category->save($this->data);
		
		$catid = $this->Category->getLastInsertID();
		$this->set('catid', $catid);
		
	}
		
	
	
	function editcategory($id){
		
		$this->pageTitle = 'Categorie bewerken';
		$this->set('categories', $this->Category->find('all', array('conditions' => array('Category.parent_id' => '0'))));
		
		
		if(!empty($id)){
			if(!empty($this->data)){
			
				if($this->Category->save($this->data)){
					$this->Session->setFlash('"'.$this->data['Category']['name'].'" is bewaard!');
					Header('Location: '.HOME.'/admin/categories/');
				}else{
					$this->Session->setFlash('"'.$this->data['Category']['name'].'" kon niet worden bewaard!');
					Header('Location: '.HOME.'/admin/editcategory/'.$id);
				}
			}else{
				$this->set('id', $id);
				$this->set('cat', $this->Category->read(null, $id));
			}
		}
	}
	
	function deletecategory($id = null) {
		
		$cps = $this->CategoriesProduct->find('all', array('conditions' => array('CategoriesProduct.category_id' => $id)));
		foreach($cps as $c){
			$this->CategoriesProduct->del($c['CategoriesProduct']['id']);
		}
		
		if (!$id) {
			$this->Session->setFlash('Deze categorie kon niet worden gevonden.');
			Header('Location: '.HOME.'/admin/categories/');
		}
		if ($this->Category->del($id)) {			
			$this->Session->setFlash('De categorie is verwijderd.');
			Header('Location: '.HOME.'/admin/categories/');
		}
		$this->setTab('products');
	}
	
	
	
	
	
	/*
	
			MEDIA:
		
	*/

	function media($videos = false){
		//$this->set('mediaitems', $this->Photo->find('all'));	
		$this->pageTitle = 'Media';	
		$this->set('movie', $videos);
		
		if($videos == true){
			$amount = $this->Video->findCount();
			$this->paginate = array('order' => array('Video.created' => 'DESC'), 'limit' => AMOUNT_ON_PAGE);
			$this->set('videos', $this->paginate('Video'));
		}else{
			$amount = $this->Photo->findCount();
			$this->paginate = array('order' => array('Photo.created'=>'DESC'), 'limit' => AMOUNT_ON_PAGE);
			$this->set('photos', $this->paginate('Photo'));
			
		}
		$this->set('amount', $amount);
		$this->setTab('media');
	}
	
	
	function addmedia($type = 'photo'){
		
		//
		//	Since version 0.6 photo's will be saved through the app_controller via Uploadify
		//
		
		if(!empty($this->data)){
			//it's a video
			$videoServiceValid = true;
				
			$embed = $this->data['File']['info'];
	
			$explode = explode('http://', $embed);
			$explode2 = explode('/', $explode[1]);
			$videoService = $explode2[0];
			//youtube:
			if($videoService == 'www.youtube.com'){
				$this->data['Video']['type'] = 'youtube';
				preg_match('/youtube\.com\/v\/([\w\-]+)/', $embed, $match);
				$this->data['Video']['file_id'] = $match[1];
				if(THUMB_SIZE <= 120){
					$this->data['Video']['thumb'] = "http://img.youtube.com/vi/".$match[1]."/2.jpg";
				}else{
					$this->data['Video']['thumb'] = "http://img.youtube.com/vi/".$match[1]."/0.jpg";
				}
			//vimeo:	
			}else if($videoService == 'vimeo.com'){
				$this->data['Video']['type'] ='vimeo';
				$explode3 = explode('clip_id=', $explode2[1]);
				$explode4 = explode('&', $explode3[1]);
				$this->data['Video']['file_id'] = $explode4[0];
				$file_id = $explode4[0];
				
				$hash = unserialize(file_get_contents("http://vimeo.com/api/v2/video/$file_id.php"));
				if(THUMB_SIZE <= 100){
					$this->data['Video']['thumb'] = $hash[0]['thumbnail_small'];
				}else if(THUMB_SIZE <= 200 && THUMB_SIZE > 100){
					$this->data['Video']['thumb'] = $hash[0]['thumbnail_medium'];
				}else if(THUMB_SIZE > 200){
					$this->data['Video']['thumb'] = $hash[0]['thumbnail_large'];
				}
			}else{
				$videoServiceValid = false;
			}
		
			if($videoServiceValid == true){
				if($this->Video->save($this->data)){
					$this->Session->setFlash('De video "'.$this->data['Video']['title'].'" is toegevoegd!');
					Header('Location: '.HOME.'/admin/media/true');
				}else{
					$this->Session->setFlash('De video "'.$this->data['Video']['title'].'" kon niet worden toegevoegd!');
				}
			}else{
				// Service is not valid
			}
		}
		
		//no data:
		$this->pageTitle = 'Media toevoegen';
		$this->set('type', $type);
		$this->setTab('media');
	}
	
	
	function editmedia($id, $type = 'photo'){
		
		$this->pageTitle = 'Media bewerken';
		
		if($type == 'photo'){
			
			if(!empty($this->data)){
				
				if(!empty($this->data['Photo']['W']) && !empty($this->data['Photo']['H']) && !empty($this->data['Photo']['X']) && !empty($this->data['Photo']['Y'])){
					$this->generateNewThumbnail($this->data);
				}
				if($this->Photo->save($this->data)){
					$this->Session->setFlash('De foto "'.$this->data['Photo']['name'].'" is bewerkt!');
					Header('Location: '.HOME.'/admin/media/');
				}else{
					$this->Session->setFlash('De foto "'.$this->data['Photo']['name'].'" kon niet worden bewerkt!');
				}
			}
		
			$this->set('photo', $this->Photo->read(null, $id));
		
		}else if($type == 'video'){
			if(!empty($this->data)){
				if($this->Video->save($this->data)){
					$this->Session->setFlash('De video "'.$this->data['Video']['title'].'" is bewerkt!');
					Header('Location: '.HOME.'/admin/media/true');
				}else{
					$$this->Session->setFlash('De video "'.$this->data['Video']['title'].'" kon niet worden bewerkt!');
				}
			}
			$this->set('video', $this->Video->read(null, $id));
		
		}
		
		$this->set('type', $type);
		$this->setTab('media');		
	}
	
	
	function deletephoto($id){
		if(!$id){
			$this->Session->setFlash('Deze foto bestaat niet!');
			Header('Location: '.HOME.'/admin/media/');
		}else{
			
			$photo = $this->Photo->read(null, $id);
			unlink(WWW_ROOT.$photo['Photo']['thumb']);
			unlink(WWW_ROOT.$photo['Photo']['medium']);
			unlink(WWW_ROOT.$photo['Photo']['large']);
			
			$links = $this->PhotosProduct->find('all', array('conditions'=> array('PhotosProduct.photo_id' => $id)));
			foreach($links as $link){
				$this->PhotosProduct->del($link['PhotosProduct']['id']);
			}
			
			$products = $this->Product->find('all', array('conditions' => array('Product.photo_id' => $id)));
			foreach($products as $prod){
				$this->prod['Product']['id'] = $prod['Product']['id'];
				$this->prod['Product']['photo_id'] = '0';
				$this->Product->save($this->prod);
			}
			
			$this->Photo->del($id);			
						
		}			
	}
	
	
	function deletevideo($id){
		if(!$id){
			$this->Session->setFlash('Deze video bestaat niet!');
			Header('Location: '.HOME.'/admin/media/true');
		}else{
			
			$links = $this->VideosProduct->find('all', array('conditions'=> array('VideosProduct.video_id' => $id)));
			foreach($links as $link){
				$this->VideosProduct->del($link['VideosProduct']['id']);
			}
			
			if($this->Video->del($id)) {			
				$this->Session->setFlash('De video is verwijderd.');
				Header('Location: '.HOME.'/admin/media/true');
			}			
		}			
		
	}
	
	function generateNewThumbnail($data){
		$w = $data['Photo']['W'];
		$h = $data['Photo']['H'];
		$x = $data['Photo']['X'];
		$y = $data['Photo']['Y'];
		
		$image = $this->Photo->read(null, $data['Photo']['id']);
	
		$targ_w = $targ_h = THUMB_SIZE;
		$quality = 70;

		$src = HOME . $image['Photo']['large'];
		$thumb = WWW_ROOT . $image['Photo']['thumb'];
		$type = strtolower(substr($image['Photo']['large'],-3));
		/*
		if(file_exists($thumb)){
			unlink($thumb);
		}*/
		
		if($type == 'png'){
			$quality = 9;
			$img_r = imagecreatefrompng($src);
			$dst_r = imagecreatetruecolor($targ_w, $targ_h);
			
			imagealphablending($dst_r, false);
			imagesavealpha($dst_r, true);
			imagecopyresampled($dst_r,$img_r,0,0,$x,$y,$targ_w,$targ_h,$w,$h);
			imagepng($dst_r, $thumb, $quality);
		}else if($type == 'jpg' || $type == 'jpeg'){
			$img_r = imagecreatefromjpeg($src);
			$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

			imagecopyresampled($dst_r,$img_r,0,0,$x,$y,$targ_w,$targ_h,$w,$h);
			imagejpeg($dst_r, $thumb ,$quality);
		}
	}
	
	
	
	function medialibrary($id, $autoclose = null){
		$product = $this->Product->read(null, $id);
		$this->set('product', $product);
		$this->layout = 'media';
		
		$this->set('photos', $this->Photo->find('all', array('order' => 'Photo.created DESC')));
		$this->set('videos', $this->Video->find('all', array('order' => 'Video.created DESC')));
		$this->set('autoclose', $autoclose);
	}
	
	
	function addMediaToProduct($id){
			
		if(!empty($this->data)){
			
			// FIRST ADD THE PHOTOS:
			if(!empty($this->data['AddedPhotos'])){
				foreach($this->data['AddedPhotos'] as $photo){
					$this->PhotosProduct->create();
				
					$this->photo['PhotosProduct']['product_id'] = $id;
					$this->photo['PhotosProduct']['photo_id'] = $photo['id'];
					$this->PhotosProduct->save($this->photo);					
				}
			}
			if(!empty($this->data['AddedVideos'])){
				foreach($this->data['AddedVideos'] as $video){
					$this->VideosProduct->create();
				
					$this->video['VideosProduct']['product_id'] = $id;
					$this->video['VideosProduct']['video_id'] = $video['id'];
					$this->VideosProduct->save($this->video);					
				}
			}
			Header('Location: '.HOME.'/admin/medialibrary/'. $id .'/true');
		}else{
			Header('Location: '.HOME.'/admin/medialibrary/'. $id .'/true');
		}
	}
	
	

	function editmainpicture($id, $type){
		$this->layout = 'media';
		
		if($type == 'product'){
			$object = $this->Product->read(null, $id);
		}else if($type == 'post'){
			$object = $this->Post->read(null, $id);
		}else if($type == 'page'){
			$object = $this->Staticpage->read(null, $id);
		}else if($type == 'user'){
			$object = $this->User->read(null, $id);
		}else if($type == 'metavalue'){
			$object = $this->Metavalue->read(null, $id);
		}else if($type == 'category'){
			$object = $this->Category->read(null, $id);	
		}else{
			$type = 'product';
			$object = $this->Product->read(null, $id);			
		}
		
		$photos = $this->Photo->find('all', array('order' => 'Photo.created DESC'));
		$this->set('photos', $photos);
		$this->set('object', $object);
		$this->set('type', $type);
		
		
	}

	
	function savemainpicture($id, $object, $type){
		$this->layout = '';
		if($type == 'product'){
			$this->data['Product']['photo_id'] = $id;
			$this->data['Product']['id'] = $object;
			$this->Product->save($this->data);
		}
		
		$this->set('url', $this->Photo->read(null, $id));
	}
	
	
	function getproductpictures($id){
		$this->layout = '';
		$this->set('product', $this->Product->read(null, $id));
	}
	
	function getmainpicture($id){
		$this->layout = '';
		$p = $this->Product->read(null, $id);
		$this->set('url', $p['Image']['large']);
	}
	
	
	
	/*
	//
	//	NEWS FUNCTIONS:
	//
	*/
	
	function news(){
		
		$this->pageTitle = 'Nieuws';
		$this->paginate = array('order' => array('Post.created' => 'DESC'), 'limit' => AMOUNT_ON_PAGE);		
		$this->set('posts', $this->paginate('Post'));
 		$this->set('amount', $this->Post->findCount());
		$this->setTab('news');
	}
	
	function addpost(){

		$this->data['Post']['title'] = 'Nieuw bericht';
		$this->data['Post']['hidden'] = '1';
		$this->data['Post']['created'] = date('Y-m-d H:i:s');
	
		$this->Post->create();
		if($this->Post->save($this->data)){
			$id = $this->Post->getLastInsertID();
			Header('Location: '.HOME.'/admin/editpost/'.$id);
			exit();
		}else{
			$this->Session->setFlash('Het bericht kon niet worden bewaard!');
			Header('Location: '.HOME.'/news/');
			exit();
		}

		$this->pageTitle = 'Nieuw bericht';

		if (!empty($this->data)) {
			$this->Post->create();
			
			$this->data['Post']['edited'] = date('Y-m-d H:i:s');
			if(empty($this->data['Post']['save'])){
				$this->data['Post']['hidden'] = "0";
			}else if(empty($this->data['Post']['publish'])){
				$this->data['Post']['hidden'] = "1";
			}
			
			$this->data['Post']['slug'] = $this->makeSlug($this->data['Post']['title']);	
			$this->data['Post']['pagetitle'] = $this->data['Post']['title'];
			
			if ($this->Post->save($this->data)) {
				$this->Session->setFlash($this->data['Post']['title'].' is bewaard!');
				Header('Location: '.HOME.'/admin/news/');
			} else {
				$this->Session->setFlash($this->data['Post']['title'].' kon niet worden bewaard!');
			}
		}
		
		$this->setTab('news');
	}
	
	function editpost($id){
		
		$this->pageTitle = 'Bewerk bericht';

		if (!empty($this->data)) {
			
			if(empty($this->data['Post']['save'])){
				$this->data['Post']['hidden'] = "0";
			}else if(empty($this->data['Post']['publish'])){
				$this->data['Post']['hidden'] = "1";
			}
			
			$pos = $this->Post->read(null, $id);
			if($pos['Post']['slug'] != ''){
				$this->data['Post']['slug'] = $this->makeSlug($this->data['Post']['slug']);	
			}else{
				$this->data['Post']['slug'] = $this->makeSlug($this->data['Post']['title']);
				$this->data['Post']['pagetitle'] = $this->data['Post']['title'];
			}
			
			$this->data['Post']['edited'] = date('Y-m-d H:i:s');
			
			if ($this->Post->save($this->data)) {
				$this->Session->setFlash($this->data['Post']['title'].' is bewaard!');
				Header('Location: '.HOME.'/admin/news/');
			} else {
				$this->Session->setFlash($this->data['Post']['title'].' kon niet worden bewaard!');
			}

		}
		if (empty($this->data)) {
			$this->set('post', $this->Post->read(null, $id));
		}
		$this->setTab('news');
		
		
	}
	
	function deletepost($id){
		
		if (!$id) {
			$this->Session->setFlash('Deze post kon niet worden gevonden.');
			Header('Location: '.HOME.'/admin/news/');
		}
		if ($this->Post->del($id)) {
			$this->Session->setFlash('De post is verwijderd.');
			Header('Location: '.HOME.'/admin/news/');
		}
		$this->setTab('news');
		
	}
	
	
	/*
	//
		PAGES:
	//	
	*/
	
	function pages(){
		$this->pageTitle = 'Pagina\'s';
		$this->paginate = array('limit' => AMOUNT_ON_PAGE, 'page' => 1, 'order'=>array('Staticpage.created'=>'DESC')); 
		
		$this->set('pages', $this->paginate('Staticpage'));	
	   	$this->set('amountPages', $this->Staticpage->findCount());
		$this->setTab('page');
	}
	
	function addpage(){
		$this->data['Staticpage']['title'] = 'Nieuwe pagina';
		$this->data['Staticpage']['hidden'] = '1';
		$this->data['Staticpage']['menu'] = '';
		$this->Staticpage->create();
		if($this->Staticpage->save($this->data)){
			$id = $this->Staticpage->getLastInsertID();
			Header('Location: '.HOME.'/admin/editpage/'.$id);
			exit();
		}else{
			$this->Session->setFlash('De pagina kon niet worden bewaard!');
			Header('Location: '.HOME.'/pages/');
			exit();
		}
	}

	
	function editpage($id){
		$this->pageTitle = 'Bewerk pagina';
		$this->setTab('page');
		
		if (!empty($this->data)) {
			
			if(empty($this->data['Staticpage']['save'])){
				$this->data['Staticpage']['hidden'] = "0";
			}else if(empty($this->data['Staticpage']['publish'])){
				$this->data['Staticpage']['hidden'] = "1";
			}
			
			if(empty($this->data['Staticpage']['topmenu'])){
				$this->data['Staticpage']['menu'] = '';
			}else{
				$this->data['Staticpage']['menu'] = 'top';
			}
			
			if(empty($this->data['Staticpage']['form'])){
				$this->data['Staticpage']['form'] = '0';
			}else{
				$this->data['Staticpage']['form'] = '1';
			}
			
			if(empty($this->data['Staticpage']['use_captcha'])){
				$this->data['Staticpage']['use_captcha'] = '0';
			}else{
				$this->data['Staticpage']['use_captcha'] = '1';
			}
			
			
			$pag = $this->Staticpage->read(null, $id);
			if($pag['Staticpage']['slug'] != ''){
				$this->data['Staticpage']['slug'] = $this->makeSlug($this->data['Staticpage']['slug']);	
			}else{
				$this->data['Staticpage']['slug'] = $this->makeSlug($this->data['Staticpage']['title']);
				$this->data['Staticpage']['pagetitle'] = $this->data['Staticpage']['title'];
			}
			
			
			if ($this->Staticpage->save($this->data)) {
				$this->Session->setFlash($this->data['Staticpage']['title'].' is bewaard!');
				Header('Location: '.HOME.'/admin/pages/');
			} else {
				$this->Session->setFlash($this->data['Staticpage']['title'].' kon niet worden bewaard!');
			}

		}
		if (empty($this->data)) {
			$this->set('page', $this->Staticpage->read(null, $id));
		}
		$this->setTab('page');
		
	}
	
	
	function deletepage($id){
		if (!$id) {
			$this->Session->setFlash('Deze pagina kon niet worden gevonden.');
			Header('Location: '.HOME.'/admin/pages/');
		}
		if ($this->Staticpage->del($id)) {
			$this->Session->setFlash('De pagina is verwijderd.');
			Header('Location: '.HOME.'/admin/pages/');
		}
		$this->setTab('page');
	}
	
	
	/*
	//
		ORDER FUNCTIONS:
	//	
	*/
	
	
	function orders(){
		$this->pageTitle = 'Orders';
	   	$this->paginate = array('limit' => AMOUNT_ON_PAGE, 'page' => 1, 'order'=>array('Order.created'=>'DESC')); 		
		$orders = $this->paginate('Order');
		
		$i = 0;
		foreach($orders as $order){
			$orders[$i]['Product'] =  $this->getOrderProducts($order['Order']['id'], true);
			$i++;
		}
		$this->set('orders', $orders);
		$this->set('amountOrders', $this->Order->findCount());
		$this->setTab('orders');
	}
	
	
	function vieworder($id){
		$this->pageTitle = 'Bekijk order';
		
		$order = $this->Order->read(null, $id);
		$this->set('order', $order);
		
		$products = $this->getOrderProducts($id);
		
		$this->set('products', $products);
		$this->setTab('orders');

	}
	
	
	function printorder($id){
		$this->pageTitle = 'Print order';
		
		$this->layout = 'print';
		
		$order = $this->Order->read(null, $id);
		$this->set('order', $order);
		
		$products = $this->getOrderProducts($id);
		$this->set('products', $products);

	}
	
	
	
	function orderpaid($id){
		
		$order = $this->Order->read(null, $id);
		if($order['Order']['paid'] == '0'){
			$this->data['Order']['paid'] = '1';
			if($this->Order->save($this->data)){
				$this->Session->setFlash('De order is betaald.');
				Header('Location: '.HOME.'/admin/orders/');
			}else{
				$this->Session->setFlash('Er is iets mis gegaan!');
				Header('Location: '.HOME.'/admin/orders/');
			}
		}else{
			$this->data['Order']['paid'] = '0';
			if($this->Order->save($this->data)){
				$this->Session->setFlash('De order is gevlagd als niet betaald.');
				Header('Location: '.HOME.'/admin/orders/');
			}else{
				$this->Session->setFlash('Er is iets mis gegaan!');
				Header('Location: '.HOME.'/admin/orders/');
			}
			
		}
		
	}
	
	
	
	
	/*
	//
		FINANCE
	//
	*/
	
	function finance($kwartaal = null, $jaar = null){
		$this->pageTitle = 'In & Uit';
		
		$this->setTab('finance');
	
		if(empty($kwartaal) && empty($jaar)){
			$huidigemaand = date('m');
			
			if($huidigemaand == '01' || $huidigemaand == '02' || $huidigemaand == '03'){
				$kwartaal = 1;
			}else if($huidigemaand == '04' || $huidigemaand == '05' || $huidigemaand == '06'){
				$kwartaal = 2;
			}else if($huidigemaand == '07' || $huidigemaand == '08' || $huidigemaand == '09'){
				$kwartaal = 3;
			}else if($huidigemaand == '10' || $huidigemaand == '11' || $huidigemaand == '12'){
				$kwartaal = 4;
			}
			$jaar = date('Y');
		}	
		$prevjaar = $jaar;
		$nextjaar = $jaar;
		
		if($kwartaal == 1){
			$start = $jaar.'-01-01 00:00:00';
			$end = $jaar.'-03-31 23:59:59';
			$nextkwartaal = 2;
			$prevkwartaal = 4;
			$prevjaar = $jaar - 1;
		}elseif($kwartaal == 2){
			$start = $jaar.'-04-01 00:00:00';
			$end = $jaar.'-06-30 23:59:59'; 
			$nextkwartaal = 3;
			$prevkwartaal = 1;
		}elseif($kwartaal == 3){
			$start = $jaar.'-07-01 00:00:00';
			$end = $jaar.'-09-30 23:59:59';
			$nextkwartaal = 4;
			$prevkwartaal = 2;
		}elseif($kwartaal == 4){
			$start = $jaar.'-10-01 00:00:00';
			$end = $jaar.'-12-31 23:59:59';
			$nextkwartaal = 1;
			$prevkwartaal = 3;
			$nextjaar = $jaar + 1;
		}
		
		
		$orders = $this->Order->find('all', array('conditions' => array('Order.paid' => '1', 'Order.created BETWEEN ? AND ?' => array($start, $end)),'order' => 'Order.created DESC'));
		$costs = $this->Cost->find('all', array('conditions' => array('Cost.created BETWEEN ? AND ?' => array($start, $end)),'order' => 'Cost.created DESC'));
		
		$this->set('orders', $orders);
		$this->set('costs', $costs);
		$this->set('prevkwartaal', $prevkwartaal);
		$this->set('nextkwartaal', $nextkwartaal);
		$this->set('prevjaar', $prevjaar);
		$this->set('nextjaar', $nextjaar);
		$this->set('kwartaal', $kwartaal);
		$this->set('jaar', $jaar);
	}
	
	
	function sales(){
		$this->pageTitle = 'Verkopen';
		
		$products = $this->Product->find('all');
		$orders = $this->Order->find('all', array('conditions'=>array('Order.paid' => '1')));
		$this->set('orders', $orders);
		$this->set('products', $products);
	}
	
	
	/*
	//
		COSTS:
	//
	*/
	
	function addcost(){
		
		$this->layout = 'lightbox';
		
		if (!empty($this->data)) {
			$this->Cost->create();
			
			$this->data['Cost']['prijs'] = str_replace(',','.', $this->data['Cost']['prijs']);
			$this->data['Cost']['hoeveelheid'] = '1';
			$this->data['Cost']['created'] = $this->data['Cost']['jaar'].'-'.sprintf("%01d",$this->data['Cost']['maand']).'-'.sprintf("%01d",$this->data['Cost']['dag']) ;
			
			if ($this->Cost->save($this->data)) {
				Header('Location:'.HOME.'/admin/costbevestiging/');
			} else {
				$this->set('error', 'Er is iets mis gegaan. De inkoop kon niet worden bewaard.');
			}
		}		
		$this->setTab('finance');
	}
	
	function costbevestiging(){
		$this->layout = 'lightbox';
	}
	
	
	/*
	//	
		USER FUNCTIONS:
	//
	*/


	function users(){
		$this->pageTitle = 'Gebruikers';

		$users = $this->Admin->find('all');		
		$this->set('users', $users);
		$this->setTab('users');
	}
	
	
	function adduser(){
		$this->pageTitle = 'Gebruiker toevoegen';
		
		if(!empty($this->data)){
			
			$this->Admin->create();
			$this->data['Admin']['wachtwoord'] = Security::hash($this->data['Admin']['wachtwoord']);
			
			if($this->Admin->save($this->data)){
				$this->Session->setFlash('Gebruiker '. $this->data['Admin']['naam'] .' aangemaakt');		
				Header('Location: '.HOME.'/admin/users');
			}else{
				$this->Session->setFlash('Gebruiker '. $this->data['Admin']['naam'] .' kon niet worden aangemaakt, probeer het later nog eens');		
				Header('Location: '.HOME.'/admin/users');
			}
			
		}
	}
	
	
	function edituser($id){
		$this->pageTitle = 'Gebruiker bewerken';
		$admin = $this->Admin->read(null, $id);
		
		if(!empty($this->data)){
			if(!empty($this->data['Admin']['wachtwoord'])){
				$this->data['Admin']['wachtwoord'] = Security::hash($this->data['Admin']['wachtwoord']);
			}else{
				$this->data['Admin']['wachtwoord'] = $admin['Admin']['wachtwoord'];
			}
			if($this->Admin->save($this->data)){
				$this->Session->setFlash('Gebruiker '. $this->data['Admin']['naam'] .' is bewerkt');		
				Header('Location: '.HOME.'/admin/users');
			}else{
				$this->Session->setFlash('Gebruiker '. $this->data['Admin']['naam'] .' kon niet worden bewerkt, probeer het later nog eens');		
				Header('Location: '.HOME.'/admin/users');
			}
		}
		
		$this->set('admin', $admin);
	}
	
	function deleteuser($id){
		
		if(!empty($id)){
			$this->Admin->del($id);
			$this->Session->setFlash('Gebruiker verwijderd.');		
			Header('Location: '.HOME.'/admin/users');
		}else{
			$this->Session->setFlash('Gebruiker kon niet worden verwijderd.');		
			Header('Location: '.HOME.'/admin/users');
		}
	}

	function login() {
		$this->pageTitle = 'Inloggen';
		$this->layout = 'login';
		$this->set('type', 'Inloggen alstublieft...');
			
		if (!empty($this->data)){

			$naam = $this->data['Admin']['naam'];
			$someone = $this->Admin->find('first',array('conditions'=>array('Admin.naam'=>$naam)));

			// build some basic session information to remember this user as 'logged-in'.
			$this->Session->write('admin', $someone['Admin']);	
			$this->Session->setFlash('Welkom terug, '. $someone['Admin']['naam']);		
			Header('Location: '.HOME.'/admin/index');

		}
	}	
	
	
	function checkLogin($username = null, $password = null){
		
		$this->layout = '';
		$message = 'login_okay';
		
		
		$someone = $this->Admin->find('first', array('conditions' => array('Admin.naam' => $username)));
		if(empty($someone)){
			$message = 'Deze gebruiker bestaat niet.';
		}else{

			if(Security::hash($password) != $someone['Admin']['wachtwoord']){
				$message = 'Uw wachtwoord is niet juist.';
			}else{
				$message = 'login_okay';
			}
		}
		
		if($username == '' || $password == ''){
			$message = 'U heeft een of meerdere velden niet ingevuld.';
		}
		
		
		$this->set('message', $message);
	}
	

	function logout(){
		$this->Session->delete('admin');
		Header('Location: '.HOME.'/admin/login');
	}
	
	
	
	function passwordforgot() {
		$this->pageTitle = 'Wachtwoord vergeten';
		$this->layout = 'login';
		$this->set('type', 'Wachtwoord vergeten');
		
		 if(!empty($this->data)) {
			
			$user = $this->Admin->find('first', array('conditions' => array('Admin.email' => $this->data['Admin']['email'])));
			
			if($user) {
				$user['Admin']['tmp_password'] = $this->createCode(7);
			
				$user['Admin']['wachtwoord'] = Security::hash($user['Admin']['tmp_password']);

		
				if($this->Admin->save($user)) {
					
					$this->Email->template = 'forgotadmin';

					$this->set('password',$user['Admin']['tmp_password']);
					$this->set('user', $user);

		            $this->Email->to = $user['Admin']['email']; 
					$this->Email->from = 'noreply@'.strtolower(WEBSITE_TITLE).'.nl';
		            $this->Email->subject = 'Uw nieuwe wachtwoord.'; 

					if($this->Email->send()){ 
						Header('location: '.HOME.'/admin/confirm/');
		  			}
					
					
				}
			}
		}
	}
	
	
	function checkadminemail($mail = null){
		
		$this->layout = '';
		$user = $this->Admin->find('first', array('conditions' => array('Admin.email' => $mail)));
		
		if(empty($user)){
			$message = 'Dit e-mailadres komt niet voor in de database';
		}else{
			$message = 'email_okay';
		}
		
		if($mail == null){
			$message = 'U hebt niks ingevuld!';
		}
		
		$this->set('message', $message);
	}
	
	
	function confirm(){
		$this->layout = 'login';
		$this->set('type', '');
	}
	
	/*
	//
		PLUGIN FUNCTIONS:
	//
	*/
	
	
	function plugins(){
		
		$this->pageTitle = 'Plugins';
		$this->setTab('plugins');
				
		//check for new plugins:
			$Folder =& new Folder(APP.'plugins');
			$Contents = $Folder->read();
			$dirs = $Contents[0];
			$plugs = $this->Plugin->find('all');
			$this->createNewPlugins($dirs, $plugs);		
		
		
		$this->paginate = array('order' => array('Plugin.name' => 'ASC'), 'limit' => AMOUNT_ON_PAGE);
		$this->set('plugins', $this->paginate('Plugin'));
		
		$amount = count($this->Plugin->find('all'));
		$this->set('amount', $amount);
			
	}

	
	
	function activateplugin($id = null){
						
		if($id == null){
			Header('Location: '.HOME.'/admin/plugins');
		}else{	
			
			//check for install.php
			$plugin = $this->Plugin->read(null, $id);
			$installfile = APP .'plugins/'.$plugin['Plugin']['dir'].'/install.php';	
			
			if(file_exists($installfile)){
				require($installfile);
			}
					
			$this->data['Plugin']['id'] = $id;
			$this->data['Plugin']['active'] = '1';
			
			if($this->Plugin->save($this->data)){
				$this->Session->setFlash('De plugin is geactiveerd!');
				Header('Location: '.HOME.'/admin/plugins');
			}else{
				$this->Session->setFlash('Er ging iets fout! Probeer het later nog eens...');
				Header('Location: '.HOME.'/admin/plugins');
			}
		}
	}
	
	
	
	function deactivateplugin($id = null){
		
		if($id == null){
			Header('Location: '.HOME.'/admin/plugins');
		}else{			
						
			$this->data['Plugin']['id'] = $id;
			$this->data['Plugin']['active'] = '0';
			
			if($this->Plugin->save($this->data)){
				$this->Session->setFlash('De plugin is gedeactiveerd!');
				Header('Location: '.HOME.'/admin/plugins');
			}else{
				$this->Session->setFlash('Er ging iets fout! Probeer het later nog eens...');
				Header('Location: '.HOME.'/admin/plugins');
			}
		}
	}
	

	
	function deleteplugin($id = null){
		
		if($id == null){
			Header('Location: '.HOME.'/admin/plugins');
		}else{			

			//check voor uninstall.php
			$plugin = $this->Plugin->read(null, $id);
			$uninstallfile = APP .'plugins/'.$plugin['Plugin']['dir'].'/uninstall.php';	
			
			if(file_exists($uninstallfile)){
				require($uninstallfile);
			}

			//Start by collecting all the files and folders:
			$Folder =& new Folder(APP.'plugins/'.$plugin['Plugin']['dir']);
			$files = $Folder->tree(APP.'/plugins/'.$plugin['Plugin']['dir'], false, 'file');
			$dirs = $Folder->tree(APP.'/plugins/'.$plugin['Plugin']['dir'], false, 'dir');
						
			
			//clear out all the files:
			if(!empty($files)){
				foreach($files as $file){
					unlink($file);
				}
			}
			
			//we need to start with the deepers directories, otherwise errors occur:
			if(!empty($dirs)){
				$lenght = array();
				$i = 0;
				
				//get the depth of each directory:
				foreach($dirs as $dir){
					$count = count(explode('/', $dir)) -1;
					$length[$i]['length'] = $count;
					$length[$i]['key'] = $i;
					$i++;
				}
				
				//order the array by depth:
				$length = $this->orderBy($length, 'length', 'DESC');
			
				//and clear all the directories:
				foreach($length as $len){
					if($len['length'] != 0){
						$dir = $dirs[$len['key']];
						rmdir($dir);
					}
				}
			}
			
			//then delete the database reference:
			if($this->Plugin->del($id)){
				$this->Session->setFlash('De plugin is verwijderd!');
				Header('Location: '.HOME.'/admin/plugins');
			}else{
				$this->Session->setFlash('Er ging iets fout! Probeer het later nog eens...');
				Header('Location: '.HOME.'/admin/plugins');
			}
		}
	}
	
	
	function createNewPlugins($dirs, $plugs){
		foreach($dirs as $dir){
			$exists = false;
			
			//check if there's allready a plugin with that name in the database:
			if(!empty($plugs)){
				foreach($plugs as $plugin){
					if(strtolower($dir) == strtolower($plugin['Plugin']['dir'])){
						$exists = true;
					}
				}
			}
			
			//if it doens't exist, make a new plugin:
			if($exists == false){
				
				$this->da = array();
				$this->da['Plugin'] = array();
				$this->da['Plugin']['name'] = '';
				$this->da['Plugin']['creator'] = '';
				
				//check if there's an info file:			
				if(file_exists(APP.'plugins/'.$dir.'/info.txt')){
					
					//break the file open:
					$infostring = '';
					$infos = file(APP.'plugins/'.$dir.'/info.txt');
					
					//create an array out of each sentence:
					foreach($infos as $info){
						$strings = explode(": ", $info);
						//get all the information:
						if($strings[0] == 'creator'){
							$this->da['Plugin']['creator'] = trim($strings[1]);
						}else if($strings[0] == 'settingspath'){
							$this->da['Plugin']['settingspath'] = trim($strings[1]);
						}else if($strings[0] == 'pluginname'){
							$this->da['Plugin']['name'] = trim($strings[1]);
						}else{
							if($strings[0] != ''){
								$this->da['Plugin']['info'] .= trim($strings[1]) .', ';
							}
						}
					}
				}
				
				//probably no file, or it hasn't been filled:
				if($this->da['Plugin']['name'] == ''){
					$this->da['Plugin']['name'] = ucwords($dir);
				}
				
				if($this->da['Plugin']['creator'] == ''){
					$this->da['Plugin']['creator'] = 'unknown';
				}
				
				$this->da['Plugin']['dir'] = $dir;
				$this->da['Plugin']['path'] = 'plugins/'.$dir;
				$this->da['Plugin']['active'] = '0';
				
				//save this plugin:
				$this->Plugin->save($this->da);
				
			}
		}
		
	}
	
	
	
	/*
	//	
		SETTINGS FUNCTIONS:
	//	
	*/
		
	
	function settings(){
		/*
		$admin = $this->Session->read('admin');
		if($admin['id'] != '3'){
			Header('Location: '.HOME.'/admin/nosettings');
			exit();
		}*/
		
		$this->pageTitle = 'Instellingen';
		
		$this->setTab('settings');
		
		if(!empty($this->data)){
			
			$advanced = false;
			$captcha = false;
			$sendcost = false;
			$keys = array_keys($this->data['Setting']);
			$i = 0;
			
			foreach($this->data['Setting'] as $key){
				$this->setting['Setting']['id'] = $keys[$i];
				if($keys[$i] == '11'){
					$this->setting['Setting']['pair'] = substr($key,0,2);
				}elseif($keys[$i] == '4'){
					$this->setting['Setting']['pair'] = 'true';
					$advanced = true;
				}elseif($keys[$i] == '16'){
					$this->setting['Setting']['pair'] = 'true';
					$captcha = true;
				}elseif($keys[$i] == '17'){
					$this->setting['Setting']['pair'] = 'true';
					$sendcost = true;
				}elseif($keys[$i] == '18'){
					$key = str_replace(',','.', $key);
					$key = str_replace('€','', $key);
					$this->setting['Setting']['pair'] = str_replace(' ','', $key);
				}
				
				
				else{
					$this->setting['Setting']['pair'] = $key;
				}

				$this->Setting->save($this->setting);
				$i++;
			}
			
			if($advanced == false){
				$this->setting['Setting']['id'] = 4;
				$this->setting['Setting']['pair'] = 'false';
				$this->Setting->save($this->setting);
			}

			if($captcha == false){
				$this->setting['Setting']['id'] = 16;
				$this->setting['Setting']['pair'] = 'false';
				$this->Setting->save($this->setting);
			}
			
			if($sendcost == false){
				$this->setting['Setting']['id'] = 17;
				$this->setting['Setting']['pair'] = 'false';
				$this->Setting->save($this->setting);
			}
			
			$this->Session->setFlash('De gegevens zijn bewerkt.');
		}
		
		$this->set('settings', $this->Setting->find('all', array('order' => 'Setting.id ASC')));
	}
	
	
	/*
		Some static pages:
	*/
	
	function about(){
		$this->setTab('');
	}
	
	function license(){
		$this->setTab('');		
	}
	

	//fancybox bug needs to redirect to a new file to close it:	
	function closeBox(){
		$this->layout = '';
	}
	


}
?>