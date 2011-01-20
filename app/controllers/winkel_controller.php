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


class WinkelController extends AppController {

	var $name = 'Winkel';
	var $uses = array('Product', 'Metaterm', 'Metavalue', 'MetavaluesProduct', 'Extraterm', 'Extravalue', 'User', 'Order', 'OrdersProducts', 'Option', 'Photo', 'Video', 'PhotosProduct', 'VideosProduct', 'Category', 'Admin', 'Post', 'Staticpage', 'Cost', 'Setting');
	var $helpers = array('Html', 'Form', 'Number', 'Javascript', 'Crumb');
	var $components = array('Email');
	var $layout = "winkel";
	var $paginate = array('limit' => 10);


	//Make sure we get the settings and put all variables for the layout in place:
	function beforeFilter(){		
		$this->fetchSettings();
		$this->setCategoriesAndPages();
		$this->callHooks('beforeFilter', null, $this, 'front');
	}

	/*
	//
		BASIC FUNCTIONS
	//
	*/


	function index(){
		// FIRST BREADCRUMBS + PAGETITLE VARIABLES:
		$this->setPage('Home', null, null);
		$this->delCrumbs();
		$this->set('pageheader','Welkom!');
		
		$this->set('products', $this->Product->find('all', array('conditions' => array('Product.parent_id' => '0', 'Product.hidden' => '0'), 'order' => 'Product.created DESC', 'limit' => AMOUNT_ON_PAGE)));
	}
	
	function product($id, $slug = null){
		
		$product = $this->Product->read(null, $id);
		if(!empty($_SERVER['HTTP_REFERER'])){
			$refer = $_SERVER['HTTP_REFERER'];
		}else{
			$refer = HOME;
		}
		
		if($refer == HOME){
			// refered for the homepage (level 1):
			$this->delCrumbs();
			$this->setPage($product['Product']['name'], null, '1');
		}else{
			// from a category (level 2):
			$this->setPage($product['Product']['name'], null, '2');
		}
		$this->pageTitle = $product['Product']['pagetitle'];
		$this->set('pageheader', $product['Product']['name']);
		
		$a = 0;
		$product['Extrafields'] = array();
		foreach($product['Extravalue'] as $value){
			$term = $this->Extraterm->read(null, $value['extraterm_id']);
			$product['Extrafields'][$a]['name'] = $term['Extraterm']['name'];
			$product['Extrafields'][$a]['value'] = $value['value'];
			$a++;
		}
		$this->set('product', $product);
	}
	
	
	function categorie($id){
		$cat = $this->Category->read(null, $id);
		$this->delCrumbs();
		$this->setPage($cat['Category']['name'], null, '1');
		$this->pageTitle = $cat['Category']['name'];
		$this->set('pageheader', $cat['Category']['name']);
		
		
		$this->paginate = array('order' => array('Product.position' => 'ASC'), 'limit' => AMOUNT_ON_PAGE);
		//$products = 
		$this->set('products', $this->paginate('Product', array('Product.category_id' => $id, 'Product.parent_id' => 0, 'Product.hidden' => '0')));
		
		$prods = $this->Product->find('all', array('Product.category_id' => $id, 'Product.parent_id' => 0, 'Product.hidden' => 0));
		$this->set('amountProducts', $prods);
	}
	
	
	//search:
	function zoeken(){
		$query = $_GET['q'];
		$this->set('pageheader','"'.ucwords($query).'"');
		$this->delCrumbs();
		$this->setPage('Zoeken', null, '1');
		
		
		if($query == ''){
			Header('Location '.$_SERVER['HTTP_REFERER']);
		}else{
			
			$custom_sql = "SELECT * FROM products WHERE name LIKE '%".$query."%' AND hidden = '0' AND parent_id = '0'";
			$results = $this->Product->query($custom_sql);

			$products = array();
			$i = 0;
			foreach($results as $product){
				$products[$i]['Product']['id'] = $product['products']['id'];
				$products[$i]['Product']['name'] = $product['products']['name'];
				$products[$i]['Product']['created'] = $product['products']['created'];
				$products[$i]['Product']['price'] = $product['products']['price'];
				$products[$i]['Product']['vat'] = $product['products']['vat'];
				$products[$i]['Product']['slug'] = $product['products']['slug'];
				
				if($product['products']['photo_id'] != null):
					$image = $this->Photo->read(null, $product['products']['photo_id']);
					$products[$i]['Image']['id'] = $image['Photo']['id'];
					$products[$i]['Image']['name'] = $image['Photo']['name'];
					$products[$i]['Image']['thumb'] = $image['Photo']['thumb'];
					$products[$i]['Image']['medium'] = $image['Photo']['large'];
					$products[$i]['Image']['large'] = $image['Photo']['large'];
				else:
					$products[$i]['Image']['id'] = '0';
					$products[$i]['Image']['thumb'] = HOME .'/img/no_picture_thumb.png';
					$products[$i]['Image']['large'] = HOME .'/img/no_picture_large.png';		
				endif;
				$i++;
			}
			
			$this->set('products', $products);
			$this->set('query', $query);
		}
		
		
	}
	
	function pagina($id, $name = null){
		
		$pag = $this->Staticpage->read(null, $id);
		$this->delCrumbs();
		$this->setPage($pag['Staticpage']['title'], null, '1');
		$this->pageTitle = $pag['Staticpage']['title'];
		$this->set('pageheader', $pag['Staticpage']['title']);
		
	}


	/*
	//
		CART FUNCTIONS:
	//
	*/
	
	function winkelwagen(){
		$this->set('pageheader','Winkelwagen');
		$this->delCrumbs();
		$this->setPage('Winkelwagen', null, '1');
		
		$this->set('cart', $this->Session->read('Cart'));
	}
	
	function delcart(){
		$this->Session->delete('Cart');
		$this->Session->delete('Order');
		Header('Location: '.HOME.'/winkel/');
	}
	
	
	function addtocart($id){
		// Add to cart is the fuction that filters the
		// different products and sends the product to the right 'product to cart session'-function
		$product = $this->Product->read(null, $id);
		
		if(!empty($product['Children']) || !empty($product['Metavalue'])){
			// select child & options
			Header('Location: '.HOME.'/winkel/opties/'.$id);
		}else{	
			// add directly:		
			Header('Location: '.HOME.'/winkel/ordertosession/'.$id);
		}

	}
		
		
	function ordertosession($id){
		
		//check if it's already ordered:
		$alreadyin = $this->alreadyOrdered($id);
		
		if($alreadyin == false){
			$i = 0;
		}else{
			
			$i = array_pop(array_keys($this->Session->read('Cart.'.$id))) + 1;
		}
			
		$product = $this->Product->read(null, $id);
		
		//CART SESSION:
		$cart = 'Cart.'.$id.'.'.$i;
		$cartArray = array();
		$cartArray['id'] = $id;
		if(empty($product['Parent']['name'])){
			$cartArray['name'] = $product['Product']['name'];
		}else{
			$cartArray['name'] = $product['Parent']['name'] .' - '. $product['Product']['name'];
		}
		
		$cartArray['price'] = $product['Product']['price'];
		$cartArray['vat'] = $product['Product']['vat'];
		$cartArray['sendcost'] = $product['Product']['sendcost'];
		if($product['Product']['photo_id'] != '0'){ 
			$cartArray['thumb'] = $product['Image']['thumb'];
			$cartArray['large'] = $product['Image']['large'];
		}else{
			if(!empty($product['Parent']['photo_id'])){
				if($product['Parent']['photo_id'] != '0'){
					$photo = $this->Photo->read(null, $product['Parent']['photo_id']);
					$cartArray['thumb'] = $photo['Photo']['thumb'];
					$cartArray['large'] = $photo['Photo']['large'];
				}else{
					$cartArray['thumb'] = '/img/no_picture_thumb.png';
					$cartArray['large'] = '/img/no_picture_large.png';
				}
			}else{
				$cartArray['thumb'] = '/img/no_picture_thumb.png';
				$cartArray['large'] = '/img/no_picture_large.png';
			}
		}
		
		$options = $this->Session->read('OptionsForProduct');

		if(!empty($options)){
			$a = 0;
			
			foreach($options['Values'] as $value){
 				$cartArray['Options'][$a]['term_id'] = $value['metaterm_id'];
				$cartArray['Options'][$a]['value_id'] = $value['metavalue_id'];
				$metaterm = $this->Metaterm->read(null, $value['metaterm_id']);
				$metavalue = $this->Metavalue->read(null, $value['metavalue_id']);
				$cartArray['Options'][$a]['name'] = $metaterm['Metaterm']['name'];
				$cartArray['Options'][$a]['value'] = $metavalue['Metavalue']['name'];
				$cartArray['Options'][$a]['value_short'] = $metavalue['Metavalue']['value'];
				$a++;
			}
			$this->Session->delete('OptionsForProduct');
		}
	
		
		$this->Session->write($cart, $cartArray);
		Header('Location: '.HOME.'/winkel/winkelwagen');
		
	}
	
	
	function removeFromCart($id, $position = null){
		
		if(empty($position)){
			$position = array_pop(array_keys($this->Session->read('Cart.'.$id)));
		}
		
		$this->Session->del('Cart.'.$id.'.'.$position);
		if($position == '0'){
			$this->Session->del('Cart.'.$id);
		}
				
		Header('Location: '.HOME.'/winkel/winkelwagen');
	}
	
	
	function alreadyOrdered($id){
		
		if($this->Session->check('Cart.'.$id)){
			return true;
		}else{
			return false;
		}
		
		return $alreadyordered;
	}
	
	
	
	/*
	//
		ORDER FUNCTIONS:
	//
	*/

	function checkBestelling(){
		$this->set('pageheader','Klopt je bestelling?');
		$this->delCrumbs();
		$this->setPage('Check je bestelling', null, '1');
		$this->set('showSearch', false);
		
		if(!$this->checkLoggedIn()){
			//De sessie is verlopen of bestaat niet eens:
			Header('Location:'.HOME.'/winkel/login');
			exit();
		}
		$user_ses = $this->Session->read('User');
		$user_id = $user_ses['id'];
		$this->set('cart',$this->Session->read('Cart'));
		$this->set('user', $this->User->read(null, $user_id));
	}
	
	
	
	function betalen($method = null){
		$this->set('pageheader','Betaalmethodes');
		$this->setPage('Betaalmethode', null, '2');
		$this->set('showSearch', false);
		
		if($method == null){
			$method = '';
			$this->set('method', '');
		}else if($method == 'ideal'){
			$method = 'ideal';
			Header('Location: '.HOME.'/winkel/orderToDatabase/false/ideal');
			
		}else if($method == 'afterwards'){
			$method = 'afterwards';
			Header('Location: '.HOME.'/winkel/orderToDatabase/false/overmaken');
		}
	}

	
	
	function orderToDatabase($paid, $method){
		
		if($paid == 'true'){
			$this->payment['Order']['paid'] = '1';
			$this->payment['Order']['paid_on'] = date('Y-m-d H:i:s');
		}else{
			$this->payment['Order']['paid'] = '0';
		}
		
		$this->payment['Order']['method'] = $method;
		
		$user = $this->Session->read('User');
		$user_id = $user['id'];
		$this->payment['Order']['user_id'] = $user_id;
		$this->Order->create();
		
		if($this->Order->save($this->payment)){
			
			$order_id = $this->Order->getLastInsertID();
			foreach($this->Session->read('Cart') as $products){
				foreach($products as $item){
					$this->OrdersProducts->create();
					$this->prod['OrdersProducts']['order_id'] = $order_id;
					$this->prod['OrdersProducts']['product_id'] =	$item['id']; 
					$this->OrdersProducts->save($this->prod);
					$ord_id = $this->OrdersProducts->getLastInsertID();
					
					if(!empty($item['Options'])):
					foreach($item['Options'] as $option){
						
						$this->Option->create();
						
						$this->option['Option']['orders_products_id'] = $ord_id;
						$this->option['Option']['value_id'] = $option['value_id'];
						$this->option['Option']['term_id'] = $option['term_id'];
						$this->option['Option']['term'] = $option['name'];
						$this->option['Option']['value'] = $option['value'];
						$this->option['Option']['value_small'] = $option['value_short'];
						 
						$this->Option->save($this->option);
					}
					endif;
				}
			}
			if($method == 'overmaken'){
				$this->Session->del('Cart');
				Header('Location: '.HOME.'/winkel/bevestigOrder/'.$order_id.'/'.$method);
			}else{
				Header('Location: '.HOME.'/ideal');
			}
		}		
	}
	
	
	function bevestigOrder($order_id, $method){
	
		$sellerNotified = $this->notifySeller($order_id);
		$buyerNotified = $this->notifyBuyer($order_id);
		
		if($sellerNotified == true && $buyerNotified == true){
			$this->set('pageheader','Bestelling geplaatst!');
			$this->delCrumbs();
			$this->setPage('Succes', null, 'auto');
			$this->set('showSearch', true);
			$this->set('method', $method);
		}
	}
	
	
	function notifySeller($order_id){
		
		$order = $this->Order->read(null, $order_id);
		$products = $this->getOrderProducts($order_id);


		$this->set('order', $order);
		$this->set('products', $products);
		
		$this->Email->template = 'seller';
        $this->Email->to = CONTACT_EMAIL;
		$this->Email->sendAs = 'both';
		$this->Email->from = 'system@'.strtolower(WEBSITE_TITLE).'.nl';
        $this->Email->subject = 'Een nieuwe bestelling'; 

		if($this->Email->send()){ 
			return true;
		}else{
			return false;
		}
		
	}
	
	function notifyBuyer($order_id){
		
		$order = $this->Order->read(null, $order_id);
		$products = $this->getOrderProducts($order_id);
		
		$this->set('order', $order);
		$this->set('products', $products);
		
		$this->Email->template = 'buyer';
		$this->Email->to = $order['User']['email'];
		$this->Email->sendAs = 'both';
		$this->Email->from = 'noreply@'.strtolower(WEBSITE_TITLE).'.nl';
		$this->Email->subject = 'Bedankt voor uw bestelling';
		
		if($this->Email->send()){
			return true;
		}else{
			return false;
		}
	}


	function opties($id){
		$product = $this->Product->read(null, $id);
		
		$this->set('pageheader','Opties');
		$this->setPage('Opties', null, 'auto');
		$this->set('showSearch', false);
		
		$product = $this->addMetatermsToProduct($product);	
		
		
		$i = 0;
		if(!empty($product['Children'])){
			foreach($product['Children'] as $child){
				if($child['photo_id'] != '0'){
					$photo = $this->Photo->read(null, $child['photo_id']);
				}else{
					$photo = $this->Photo->read(null, $product['Product']['photo_id']);
				}
				
				$product['Children'][$i]['Image']['id'] = $photo['Photo']['id'];
				$product['Children'][$i]['Image']['thumb'] = $photo['Photo']['thumb'];
				$i++;
			}
		}
		
			
		$this->set('product', $product);
		
		if(!empty($this->data)){
			if(!empty($this->data['child_id'])){
				$prod_id = $this->data['child_id'];
			}else{
				$prod_id = $id;
			}
			
			if(!empty($this->data['Metavalue'])){
				//save metadata to a session
				
				$string = "OptionsForProduct.";
				$product = $string ."product_id";
				$this->Session->write($string ."id", $prod_id);
				
				$i = 0;
				foreach($this->data['Metavalue'] as $value){
					// NOG EVEN GEEN MULTISELECT + ICONS:
					
					//
					$this->Session->write($string.'Values.'.$i.'.product_id', $prod_id);
					$this->Session->write($string.'Values.'.$i.'.metaterm_id', $value['id']);
					$this->Session->write($string.'Values.'.$i.'.metavalue_id', $value['select']);
					$i++;
				}
			}
			
			Header('Location: '.HOME.'/winkel/ordertosession/'.$prod_id);
		}		
	}

	
	/*
	//
		USER FUNCTIONS:
	//
	*/
	
	function account(){
		
		if (!$this->Session->check('User')){
			// User is logged in, he can go to the Order Check:
			Header('Location: '.HOME.'/winkel/login/true');
			exit();
		}
		
		$this->set('pageheader','Uw Account');
		$this->delCrumbs();
		$this->setPage('Account', null, '1');
		$user = $this->Session->read('User');
		$user_id = $user['id'];
		$this->set('user', $user);
		$orders = $this->Order->find('all', array('conditions' => array('Order.user_id' => $user_id), 'order' => 'Order.created DESC'));
		$i = 0;
		foreach($orders as $order){
			$a = 0;
			foreach($order['Product'] as $product){
				
				$photo = $this->Photo->read(null, $product['photo_id']);
				
				if($product['parent_id'] != '0'){
					$parent = $this->Product->read(null, $product['parent_id']);
					$orders[$i]['Product'][$a]['name'] = $parent['Product']['name'] .' - '. $product['name'];
					if($product['photo_id'] == '0'){
						$orders[$i]['Product'][$a]['Image']['thumb'] = $parent['Image']['thumb'];
						$orders[$i]['Product'][$a]['Image']['large'] = $parent['Image']['large'];
					}else{
						$orders[$i]['Product'][$a]['Image']['thumb'] = $photo['Photo']['thumb'];
						$orders[$i]['Product'][$a]['Image']['large'] = $photo['Photo']['large'];
					}
				}else{
					$orders[$i]['Product'][$a]['Image']['thumb'] = $photo['Photo']['thumb'];
					$orders[$i]['Product'][$a]['Image']['large'] = $photo['Photo']['large'];
				}
				$a++;
			}
			$i++;
		}
		
		$this->set('orders', $orders);
	}
	
	
	function accountBewerken(){
		if (!$this->Session->check('User')){
			// User is logged in, he can go to the Order Check:
			Header('Location: '.HOME.'/winkel/login/true');
			exit();
		}
		
		$this->set('pageheader','Account bewerken');
		$this->setPage('Bewerken', null, '2');
		$user = $this->Session->read('User');
		$user = $this->User->read(null, $user['id']);
		$this->set('data', $user);
		
		$noproblems = true;
		
		if(!empty($this->data)){
			$someone = $this->User->read(null, $this->data['User']['id']);
						
			if($this->data['User']['password'] != ''){
				if(Security::hash($this->data['User']['password']) == $someone['User']['password']){
					if($this->data['User']['password1'] == $this->data['User']['password2']){
						if(strlen($this->data['User']['password1']) >= 6 && strlen($this->data['User']['password1']) <= 10){
							$this->data['User']['password'] = Security::hash($this->data['User']['password1']);
						}else{
							//wachtwoorden te lang
							$noproblems = false;
							$this->data['User']['password'] = 'error';
							$this->data['User']['password1'] = $this->data['User']['password2'] = 'error';
							$this->set('data', $this->data);
							$error['title'] = 'Woops!';
							$error['body'] = 'Uw nieuwe wachtwoord is te kort of te lang. Minimaal 6 en maximaal 10 karakters alstublieft.';
							$this->set('error', $error);					
							
						}
					}else{
						//2 wachtwoorden verschillend
						$noproblems = false;
						$this->data['User']['password'] = 'error';
						$this->data['User']['password1'] = $this->data['User']['password2'] = 'error';
						$this->set('data', $this->data);
						$error['title'] = 'Woops!';
						$error['body'] = 'De twee wachtwoorden zijn verschillend!';
						$this->set('error', $error);					
						
					}
				}else{
					//huidide password niet goed
					$noproblems = false;
					$this->data['User']['password'] = 'error';
					$this->data['User']['password1'] = $this->data['User']['password2'] = 'error';
					$this->set('data', $this->data);
					$error['title'] = 'Woops!';
					$error['body'] = 'Uw huidige wachtwoord is niet correct!';
					$this->set('error', $error);					
				}
			}
			
			if($this->data['User']['email'] != $someone['User']['email']){
				if ($this->User->isUnique('email', $this->data['User']['email'], null)){  
					$noproblems = true;
				}else{
					//bestaat al
					$noproblems = false;
					$this->data['User']['email'] = 'error';
					$this->data['User']['password1'] = $this->data['User']['password2'] = '';
					$this->set('data', $this->data);
					$error['title'] = 'Woops!';
					$error['body'] = 'Dit e-mailadres komt al voor in onze database!';
					$this->set('error', $error);					
				}
			}
			
			
			if($noproblems == true){
				if($this->User->save($this->data)){
					$us = $this->User->read(null, $this->data['User']['id']);
					$us['User']['password'] = '';
					$us['User']['password1'] = '';
					$us['User']['password2'] = '';
					$this->set('data', $us);
					
					$error['title'] = 'Geslaagd!';
					$error['body'] = 'Alles is goed opgeslagen.';
					$this->set('error', $error);					

				}else{
					$us['User']['password'] = '';
					$us['User']['password1'] = '';
					$us['User']['password2'] = '';
					$error['title'] = 'Het opslaan is mislukt...';
					$error['body'] = 'Probeer het later nog eens';
					$this->set('error', $error);					
				}
			}
			
			
		}//anders is $this->data leeg.
	}
	
	
	
	function login($redirectToAccount = false){
		
		if ($this->Session->check('User')){
			// User is logged in, he can go to the Order Check:
			Header('Location: '.HOME.'/winkel/checkBestelling');
			exit();
		}
		
		$this->set('pageheader','Inloggen');
		$this->delCrumbs();
		$this->setPage('Login', null, '1');
		$this->set('showSearch', false);
		
		//User is not logged in:
		$error = null;
		$this->set('redirectToAccount', $redirectToAccount);
		if(!empty($this->data)){
			//if he filled in the form:
			
			$mail = $this->data['User']['email'];
			$someone = $this->User->find('first',array('conditions'=>array('User.email'=>$mail)));

			if(!empty($someone['User'])){
				if($someone['User']['password'] == Security::hash($this->data['User']['wachtwoord'])){				
					// build some basic session information to remember this user as 'logged-in'.
					$this->Session->write('User', $someone['User']);
					if($redirectToAccount == false){	
						Header('Location: '.HOME.'/winkel/checkBestelling');
					}else{
						Header('Location: '.HOME.'/winkel/account');
					}
					
				}else{
					//wrong password;
					$error = 'U heeft een fout wachtwoord opgegeven...';
				}
			}else{
				// No User with that mailadres:
				$error = 'Uw emailadres komt niet in ons systeem voor...';
			}
		}
		$this->set('error', $error);
	}
	
	
	function logout(){
		$this->Session->delete('User');
		Header('Location: '.HOME);
	}
	
	
	function nieuwAccount(){
		//Nieuw account:
		$this->set('pageheader','Nieuw Account');
		$this->delCrumbs();
		$this->setPage('Nieuw Account', null, '1');
		$this->set('showSearch', false);
		
		
		if(!empty($this->data)){
			
			if($this->data['User']['password1'] == $this->data['User']['password2']){
				//long passwords (against random spam):
				if(strlen($this->data['User']['password1']) >= 6 && strlen($this->data['User']['password1']) <= 10){
					if ($this->User->isUnique('email', $this->data['User']['email'], null)){  
						if($this->isEmail($this->data['User']['email'])){
					
							$this->User->create();
							$this->data['User']['password'] = Security::hash($this->data['User']['password1']);
							$this->data['User']['lastvisited'] = date('Y-m-d H:i:s');
							$this->data['User']['activated'] = '1';
						
							if($this->User->save($this->data)){
								$this->data['User']['id'] = $this->User->getLastInsertID();
								$this->Session->write('User', $this->data['User']);
								Header('Location: '.HOME.'/winkel/welkomNieuweGebruiker');
							}else{
								$this->data['User']['email'] = 'error';
								$this->data['User']['password1'] = $this->data['User']['password2'] = '';
								$this->set('data', $this->data);
								$error['title'] = 'Het opslaan is niet gelukt';
								$error['body'] = 'Probeer het later nog eens...';
								$this->set('error', $error);					
							}
					
						}else{
							//no valid emailaddress
							$this->data['User']['email'] = 'error';
							$this->data['User']['password1'] = $this->data['User']['password2'] = '';
							$this->set('data', $this->data);
							$error['title'] = 'Woops!';
							$error['body'] = 'U heeft geen geldig e-mailadres ingevuld!';
							$this->set('error', $error);					
						}
					}else{
						//geen unieke email
						$this->data['User']['email'] = 'error';
						$this->data['User']['password1'] = $this->data['User']['password2'] = '';
						$this->set('data', $this->data);
						$error['title'] = 'Woops!';
						$error['body'] = 'Dit emailadres komt al voor in onze database!<br/>';
						$error['body'] .= 'U bent wellicht uw wachtwoord vergeten<br/>';
						$error['body'] .= '<a href="'.HOME.'/winkel/wachtwoordvergeten">Klik hier om een nieuw wachtwoord aan te vragen &raquo;</a>';
						$this->set('error', $error);					
					}
				}else{
					// te kort wachtwoord;
					$this->data['User']['password1'] = 'error';
					$this->data['User']['password2'] = 'error';
					$this->set('data', $this->data);

					$error['title'] = 'Woops!';
					$error['body'] = 'Uw wachtwoord is te kort. Een wachtwoord moet uit minimaal 6,';
					$error['body'] .= 'en maximaal 10 karakters bestaan!';
 					$this->set('error', $error);					
				}
			}else{
				// verschillende wachtwoorden
				$this->data['User']['password1'] = 'error';
				$this->data['User']['password2'] = 'error';
				$this->set('data', $this->data);
				
				$error['title'] = 'Woops!';
				$error['body'] = 'De twee wachtwoorden zijn verschillend!';
				$this->set('error', $error);					
			}
			
		}else{
			
			$data['User']['firstname'] = 'Voornaam';
			$data['User']['lastname'] = 'Achternaam';
			$data['User']['email'] = '';
			$data['User']['address'] = 'Straat & huisnummer';
			$data['User']['zipcode'] = 'Postcode';
			$data['User']['city'] = 'Woonplaats';
		
			$this->set('data', $data);
		}
		
	}
	
	
	function welkomNieuweGebruiker(){
		$this->set('pageheader','Account aangemaakt!');
		$this->delCrumbs();
		$this->setPage('Welkom nieuwe gebruiker', null, '1');
		$this->set('showSearch', false);
		
		$fullCart = false;
		if($this->Session->check('Cart')){
			$fullCart = true;
		}
		$this->set('cartFull', $fullCart);
	}
	
	
	function bewerkAccount($id){
		//Nieuw account:
		$this->set('pageheader','Bewerk Account');
		$this->setPage('Bewerken', null, '2');
		$this->set('showSearch', false);
		
	}
	
	
	
	function checkLoggedIn(){
		if ($this->Session->check('User')){
			return true;
		}else{
			return false;
		}		
	}
	
	function wachtwoordVergeten() {
		$this->pageTitle = 'Wachtwoord vergeten';
		$this->set('pageheader','Wachtwoord vergeten');
		$this->delCrumbs();
		$this->setPage('Wachtwoord vergeten', null, '1');
		$this->set('showSearch', false);
		$error = null;
		
		 if(!empty($this->data)) {
			
			$user = $this->User->find('first', array('conditions' => array('User.email' => $this->data['User']['email'])));
			
			if($user) {
				$user['User']['tmp_password'] = $this->createCode(10);
			
				$user['User']['password'] = Security::hash($user['User']['tmp_password']);

		
				if($this->User->save($user)) {
					
					$this->Email->template = 'forgot';

					$this->set('password',$user['User']['tmp_password']);
					$this->set('user', $user);

		            $this->Email->to = $user['User']['email']; 
					$this->Email->from = 'noreply@getthinkshop.com';
		            $this->Email->subject = 'Uw nieuwe wachtwoord.'; 

					if($this->Email->send()){ 
						Header('location: '.HOME.'/winkel/wachtwoordVerzonden/');
		  			}
					
					
				}
			}else{
				$error = 'Dit is een ongeldig e-mail adres!';
			}
		}
		$this->set('error', $error);
	}
	
	
	

	/*
	//
		MEDIA FUNCTIONS:
	//
	*/
	
	function viewPhoto($id){
		$photo = $this->Photo->read(null, $id);
		$this->layout = 'viewmedia';
		$this->set('image', HOME . $photo['Photo']['large']);
	}
	
	function viewVideo($id){
		
		$video = $this->Video->read(null, $id);
		$this->layout = 'viewmedia';
		
		$embedcode = $video['Video']['file_id'];
		
		if($video['Video']['type'] == 'youtube'){
			$embed = '<object width="480" height="360"><param name="movie" value="http://www.youtube.com/v/'.$embedcode.'&amp;hl=nl_NL&amp;fs=1"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/'.$embedcode.'&amp;hl=nl_NL&amp;fs=1" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="480" height="360"></embed></object>';
		}else if($video['Video']['type'] == 'vimeo'){
			$embed = '<object width="480" height="360"><param name="allowfullscreen" value="true" /><param name="allowscriptaccess" value="always" /><param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id='.$embedcode.'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=ff9933&amp;fullscreen=1" /><embed src="http://vimeo.com/moogaloop.swf?clip_id='.$embedcode.'&amp;server=vimeo.com&amp;show_title=0&amp;show_byline=0&amp;show_portrait=0&amp;color=ff9933&amp;fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="480" height="360"></embed></object>';
		}
		
		$this->set('embed', $embed);
		
	}





}
?>