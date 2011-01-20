<?php
class Product extends AppModel {

	var $name = 'Product';
	var $uses = array('Product', 'Category', 'CategoriesProduct');

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
			)
	);
	
	
	function findInCategory($id, $howToOrder = null){
		$cp = $this->CategoriesProduct->find('all', array('conditions' => array('CategoriesProduct.category_id' => $id)));
		$order = array();
		
		if(!empty($cp)){
		
			if($howToOrder == null){
				$howToOrder = 'asc';
			}
		
			$query = '';
			$i = 1;
			foreach($cp as $catproduct){
				if($i == count($cp)){
					$query .= 'Product.id = '. $catproduct['CategoriesProduct']['product_id'];
				}else{
					$query .= 'Product.id = '. $catproduct['CategoriesProduct']['product_id'] .' OR ';
				}
				$order[$catproduct['CategoriesProduct']['product_id']] = $catproduct['CategoriesProduct']['position'];
				$i++;
			}
		
			
			$products = $this->find('all', array('conditions' => array($query)));
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
	
	

}
?>