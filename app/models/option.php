<?php

class Option extends AppModel {

	var $name = 'Option';
	var $uses = array('Option');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'OrdersProducts' => array('className' => 'OrdersProduct',
								'foreignKey' => 'orders_products_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);
	
}
?>