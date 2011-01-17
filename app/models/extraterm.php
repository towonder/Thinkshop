<?php
class Extraterm extends AppModel {

	var $name = 'Extraterm';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'Extravalue' => array('className' => 'Extravalue',
								'foreignKey' => 'extraterm_id',
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