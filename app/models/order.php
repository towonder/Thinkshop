<?php
class Order extends AppModel {

	var $name = 'Order';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'User' => array('className' => 'User',
								'foreignKey' => 'user_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

	var $hasAndBelongsToMany = array(
			'Product' => array('className' => 'Product',
						'joinTable' => 'orders_products',
						'foreignKey' => 'order_id',
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



	function getQuarter($huidigemaand){
		if($huidigemaand == '01' || $huidigemaand == '02' || $huidigemaand == '03'){
			$kwartaal = 1;
		}else if($huidigemaand == '04' || $huidigemaand == '05' || $huidigemaand == '06'){
			$kwartaal = 2;
		}else if($huidigemaand == '07' || $huidigemaand == '08' || $huidigemaand == '09'){
			$kwartaal = 3;
		}else if($huidigemaand == '10' || $huidigemaand == '11' || $huidigemaand == '12'){
			$kwartaal = 4;
		}else{
			$kwartaal = 1;
		}
		return $kwartaal;
	}


	function getStartQuarter($kwartaal, $jaar){
		if($kwartaal == 1){
			$start = $jaar.'-01-01 00:00:00';
		}elseif($kwartaal == 2){
			$start = $jaar.'-04-01 00:00:00';
		}elseif($kwartaal == 3){
			$start = $jaar.'-07-01 00:00:00';
		}else{
			$start = $jaar.'-10-01 00:00:00';
		}
	
		return $start;
	}


	function getEndQuarter($kwartaal, $jaar){
		if($kwartaal == 1){
			$end = $jaar.'-03-31 23:59:59';
		}elseif($kwartaal == 2){
			$end = $jaar.'-06-30 23:59:59'; 
		}elseif($kwartaal == 3){
			$end = $jaar.'-09-30 23:59:59';
		}else{
			$end = $jaar.'-12-31 23:59:59';
		}
		return $end;
	}


}
?>