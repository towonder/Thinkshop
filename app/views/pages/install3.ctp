<?php

//if the post array isn't empty:
$installdone = false;
$error = false;

if(!empty($_POST)){
	
	$title = $_POST['title'];
	$username = $_POST['username'];
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	$email = $_POST['email'];
	$date = date('Y-m-d H:i:s');
	
	if(!isEmail($email)){
		Header('Location: install2?error=email');
		exit();
		//echo 'Email no good';
		//$error = true;
	}

	if($password1 != $password2){
		Header('Location: install2?error=password');		
		exit();
		//$error = true;
	}else{
		
		if($password1 == ''){
			$password1 = createCode(7);
		}
		
		$password = Security::hash($password1);
		echo $password;
	}
	
	if($error == false){
		uses('model' . DS . 'connection_manager');
		$db = ConnectionManager::getInstance();
		@$connected = $db->getDataSource('default');
	
		$sql1 = "INSERT INTO `settings` VALUES(1, 'WEBSITE_TITLE', '".$title."', '".date('Y-m-d H:i:s')."')";
		$sql2 = "INSERT INTO `settings` VALUES(15, 'CONTACT_EMAIL', '".$email."', '".date('Y-m-d H:i:s')."');";
		$sql3 = "INSERT INTO `admins` VALUES(1, '".$username."', '".$password."', '".$email."', '".$date."');";
		mysql_query($sql1);
		mysql_query($sql2);
		mysql_query($sql3);
	
		$installdone = true;
	}

}else{
	$installdone = true;
}

if($installdone == true){
	Header('Location: install5?pass='.$password1.'&admin='.$username);
}




function isEmail($email) {
	return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}

function createCode($len){
	$pass = '';
	$lchar = 0;
	$char = 0;
	
		for($i = 0; $i < $len; $i++) {
			while($char == $lchar) {
				$char = rand(48, 109);
				if($char > 57) $char += 7;
				if($char > 90) $char += 6;
			}
			$pass .= chr($char);
			$lchar = $char;
		}
	return $pass;
}
?>