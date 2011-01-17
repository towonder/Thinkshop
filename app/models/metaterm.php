<?php
class Metaterm extends AppModel {

	var $name = 'Metaterm';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'Metavalue' => array('className' => 'Metavalue',
								'foreignKey' => 'metaterm_id',
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