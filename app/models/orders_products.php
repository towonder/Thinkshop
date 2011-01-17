<?php

class OrdersProducts extends AppModel {

	var $name = 'OrdersProducts';
	
	var $hasMany = array(
			'Option' => array('className' => 'Option',
								'foreignKey' => 'orders_products_id',
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