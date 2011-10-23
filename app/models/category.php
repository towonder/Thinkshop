<?php
class Category extends AppModel {

	var $name = 'Category';
	var $uses = array('Category');


	var $belongsTo = array(
		'ParentCat' => array('className' => 'Category', 
		                  'foreignKey' => 'parent_id' 
		),
	);

	var $hasMany = array(
		'Kids' => array('className' => 'Category', 
		          			'foreignKey' => 'parent_id' 
		)		
	);
	
	
	var $hasAndBelongsToMany = array(
			'Product' => array('className' => 'Product',
						'joinTable' => 'categories_products',
						'foreignKey' => 'category_id',
						'associationForeignKey' => 'product_id',
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
	
	function findLatestID(){
		$cat = $this->find('first', array('order' => 'Category.created DESC'));
		if(!empty($cat['Product'])){
			return $cat['Category']['id'];
		}else{
			return '1';
		}
	}
	

}
?>