<?php
class Product extends AppModel {

	var $name = 'Product';
	var $uses = array('Product');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Category' => array('className' => 'Category',
								'foreignKey' => 'category_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
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
			)
			

	);
	
	function findAllProducts(){
		return $this->find('all');
	}
	
	

}
?>