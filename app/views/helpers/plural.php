<?php
class PluralHelper extends AppHelper {

	function get($string, $addendum, $amount){
		if($amount == 1){
			return $amount .' '. $string;
		}else{
			return $amount .' '. $string . $addendum;
		}
		
	}
}