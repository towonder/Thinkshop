<?php
class Category extends AppModel {

	var $name = 'Category';
	var $uses = array('Category');


	var $belongsTo = array(
		'ParentCat' => array('className' => 'Category', 
		                  'foreignKey' => 'parent_id' 
		),
	);


	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Kids' => array('className' => 'Category', 
		          			'foreignKey' => 'parent_id' 
		),
		
		'Product' => array('className' => 'Product',
								'foreignKey' => 'category_id',
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

}
?>