<?php
class Extravalue extends AppModel {

	var $name = 'Extravalue';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Product' => array('className' => 'Product',
								'foreignKey' => 'product_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'Extraterm' => array('className' => 'Extraterm',
								'foreignKey' => 'extraterm_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>