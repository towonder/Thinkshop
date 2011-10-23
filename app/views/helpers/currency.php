<?php  
class CurrencyHelper extends Helper{ 

	function getSymbol($currency){
		
		$text = '';
		if($currency == 'EUR'){
			$text = '&euro;';
		}else if($currency == 'USD'){
			$text = '$';
		}else if($currency == 'GBP'){
			$test = '&pound;';
		}
		
		return($text);
	}


} 
?>
