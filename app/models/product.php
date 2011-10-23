<?php
class Product extends AppModel {

	var $name = 'Product';
	var $uses = array('Product', 'Category', 'CategoriesProduct', 'Tag', 'TagsProduct');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Parent' =>array('className' => 'Product',
									'foreignKey' => 'parent_id'
			),
			'Image' => array('className' => 'Photo',
									'foreignKey' => 'photo_id'
			)
			
	);

	var $hasMany = array(
			'Children' => array('className' => 'Product',
								'foreignKey' => 'parent_id'
			),
			'Extravalue' => array('className' => 'Extravalue',
								'foreignKey' => 'product_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
			
			
	);

	var $hasAndBelongsToMany = array(
			'Metavalue' => array('className' => 'Metavalue',
						'joinTable' => 'metavalues_products',
						'foreignKey' => 'product_id',
						'associationForeignKey' => 'metavalue_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => '',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			),
			'Order' => array('className' => 'Order',
						'joinTable' => 'orders_products',
						'foreignKey' => 'product_id',
						'associationForeignKey' => 'order_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => '',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			),
			'Photo' => array('className' => 'Photo',
						'joinTable' => 'photos_products',
						'foreignKey' => 'product_id',
						'associationForeignKey' => 'photo_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => '',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			),
			'Video' => array('className' => 'Video',
						'joinTable' => 'videos_products',
						'foreignKey' => 'product_id',
						'associationForeignKey' => 'video_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => '',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			),
			'Category' => array('className' => 'Category',
						'joinTable' => 'categories_products',
						'foreignKey' => 'product_id',
						'associationForeignKey' => 'category_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => '',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			),
			'Tag' => array('className' => 'Tag',
						'joinTable' => 'tags_products',
						'foreignKey' => 'product_id',
						'associationForeignKey' => 'tag_id',
						'unique' => true,
						'conditions' => '',
						'fields' => '',
						'order' => '',
						'limit' => '',
						'offset' => '',
						'finderQuery' => '',
						'deleteQuery' => '',
						'insertQuery' => ''
			),
			

	);
	
	
	function findInCategory($id, $howToOrder = null, $conceptToo = true){
		$this->CategoriesProduct->recursive = -1;
		$cp = $this->CategoriesProduct->find('all', array('conditions' => array('CategoriesProduct.category_id' => $id)));
		$order = array();
		
		if(!empty($cp)){
		
			if($howToOrder == null){
				$howToOrder = 'asc';
			}else{
				$howToOrder = strtolower($howToOrder);
			}
		
			$query = array();
			$i = 1;
			
			foreach($cp as $catproduct){
				$query[]['Product.id'] = $catproduct['CategoriesProduct']['product_id']; 
				$order[$catproduct['CategoriesProduct']['product_id']] = $catproduct['CategoriesProduct']['position'];
				$i++;
			}
			
			//Filter out concept products:
			if($conceptToo == true){
				$products = $this->find('all', array('conditions' => array('Product.hidden' => '0', 'AND' => array('OR'=> $query))));
			}else{
				$products = $this->find('all', array('conditions' => array('Product.hidden' => '0', 'Product.concept' => '0', 'AND' => array('OR' => $query))));
			}
			
			
			$i = 0;
			foreach($products as $product){
			
				$products[$i]['Product']['position'] = $order[$product['Product']['id']];
				$i++;
			}
		
			return Set::sort($products, '{n}.Product.position', $howToOrder);
			
		}else{
			return array();
		}
	}
	
	
	function totalAmount($hidden = false){
		$this->recursive = -1;
		$conditions = '';
		
		if($hidden == true){
			$conditions = array('conditions' => array('Product.hidden' => '1')); 
		}
		
		$prods = $this->find('all', $conditions);
		return count($prods);
	}
	
	
	function getRelated($id = null, $limit = null, $howToOrder = null){
		if($id == null){
			return array();
			die();
		}
		
		if($howToOrder == null){
			$howToOrder = 'desc';
		}else{
			$howToOrder = strtolower($howToOrder);
		}
		
		
		$this->TagsProduct->recursive = -1;
		$this->CategoriesProduct->recursive = -1;
		$tp = $this->TagsProduct->find('all', array('conditions' => array('TagsProduct.product_id' => $id)));
		$cp = $this->CategoriesProduct->find('all', array('conditions' => array('CategoriesProduct.product_id' => $id)));
		
		$tagsQuery = array();
		$tags = array();
		$catQuery = array();
		$cats = array();
		
		foreach($tp as $tagproduct){
			$tagsQuery[]['Tag.id'] = $tagproduct['TagsProduct']['tag_id']; 
		}
				
		foreach($cp as $catproduct){
			$catQuery[]['Category.id'] = $catproduct['CategoriesProduct']['category_id']; 
		}
		
		if(!empty($tagsQuery)){
			$tags = $this->Tag->find('all', array('conditions' => array('OR' => $tagsQuery)));
		}
		
		$results = array();
		
		if(!empty($tags)){
			foreach($tags as $tag){
				foreach($tag['Product'] as $product){
					if($product['id'] != $id){
						if(array_key_exists($product['id'], $results)){
							//already in array;
							$results[$product['id']]['Product']['score'] = $results[$product['id']]['Product']['score'] + 1;
						}else{
							$prod = $this->read(null, $product['id']);
							$results[$product['id']] = array();
							$results[$product['id']] = $prod;
							$results[$product['id']]['Product']['score'] = 1;
						}
					}
				}
			}
		}
		
		if(!empty($catQuery)){
			$cats = $this->Category->find('all', array('conditions' => array('OR' => $catQuery)));
		}
		
		if(!empty($cats)){
			foreach($cats as $cat){
				foreach($cat['Product'] as $product){
					if($product['id'] != $id){
						if(array_key_exists($product['id'], $results)){
							//already in array;
							$results[$product['id']]['Product']['score'] = $results[$product['id']]['Product']['score'] + 1;
						}else{
							$prod = $this->read(null, $product['id']);
							$results[$product['id']] = array();
							$results[$product['id']] = $prod;
							$results[$product['id']]['Product']['score'] = 1;
						}
					}
				}
			}
		}
		
		
		$newResults = array();
		$i = 0;
		foreach($results as $res){
			$newResults[] = $res;
			$i++;
			
			if($limit != null){
				if($i == $limit){
					break;
				}
			}
		}
		return Set::sort($newResults, '{n}.Product.score', $howToOrder);
	}
}
?>