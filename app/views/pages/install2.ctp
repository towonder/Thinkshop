<?php

$database_error = false;
$dbfile_error = false;

$error = '';

if(isset($_GET['error'])){
	$error = $_GET['error'];
}


//add error mentions in the form!;


//if the post array isn't empty:
if(!empty($_POST)){
	
	$name = $_POST['name'];
	$user = $_POST['user'];
	$password = $_POST['password'];
	$host = $_POST['host'];
	$prefix = '';
	
	//check connection..
	$link = mysql_connect($host, $user, $password);

	if (!mysql_select_db($name, $link)) {
		//no connection:
		$database_error = true;
	}else{
		//we have a connection:
		$url = CONFIGS.'database.php';

		if(!file_exists($url)){
		//only if the file doens't exits:
			$contents = "<?php ";
			$contents .= "class DATABASE_CONFIG {";
			$contents .= "var \$default = array(";
			$contents .= "'driver' => 'mysql',";
			$contents .= "'persistent' => false,";
			$contents .= "'host' => '".$host."',";
			$contents .= "'login' => '".$user."',";
			$contents .= "'password' => '".$password."',";
			$contents .= "'database' => '".$name."',";
			$contents .= "'prefix' => '".$prefix."',";
			$contents .= ");";

			$contents .= "var \$test = array(";
			$contents .= "'driver' => 'mysql',";
			$contents .= "'persistent' => false,";
			$contents .= "'host' => '".$host."',";
			$contents .= "'login' => '".$user."',";
			$contents .= "'password' => '".$password."',";
			$contents .= "'database' => '".$name."',";
			$contents .= "'prefix' => '".$prefix."',";
			$contents .= ");";
			$contents .= "} ?>";

			$file = fopen($url, 'w');
			
			if(is_writable($url)){
				fwrite($file, $contents);
				fclose($file);
			}else{
				$dbfile_error = true;
			}
		}
	}	
}



if($database_error == false && $dbfile_error == false){
	//run sql... if there are no tables:
		 	
	$url = CONFIGS.DS.'sql'.DS.'think.sql';
	uses('model' . DS . 'connection_manager');
	$db = ConnectionManager::getInstance();
	@$connected = $db->getDataSource('default');
	
	$sql = "SHOW TABLES"; 
 	$result = mysql_query($sql); 
 	$num_of_tables = mysql_num_rows($result);  
	
	if($num_of_tables == 0){
		$file_content = file($url);
		echo '<div id="sqldump">';
		foreach($file_content as $sql_line){
			if(trim($sql_line) != "" && strpos($sql_line, "--") === false){
				echo $sql_line . '<br><br/>';
				mysql_query($sql_line);
			}
		}
		
		$folder =  substr($_SERVER['REQUEST_URI'],0,-9);
		$path = $_SERVER['HTTP_ORIGIN'] . $folder;
		$sql1 = "INSERT INTO `settings` VALUES(3, 'HOME_FOLDER', '".$folder."', '2010-07-21 13:15:39');";
		$sql2 = "INSERT INTO `settings` VALUES(2, 'HOME', '".$path."', '2010-07-21 13:15:17');";
		$sql3 = "INSERT INTO `categories` VALUES(1, 'Eerste categorie', '".date('Y-m-d H:i:s')."', 1, 0);";
		$sql4 = "INSERT INTO `products` VALUES(1, '', 'Eerste product', '<p>Beschrijving</p>', '', '', '".date('Y-m-d H:i:s')."', '50.00', '1.50', '0.19', 1, 0, 0, 'eerste-product', 'Eerste product', '', 1, 0, 0);";
		
		mysql_query($sql1);
		mysql_query($sql2);
		mysql_query($sql3);
		mysql_query($sql4);
		
		echo '</div>';
	}
	
}else if($database_error == true && $dbfile_error == false){
	Header('Location: install4?error=nodbconnection');
	//echo 'no connection';
}else if($dbfile_error == true && $database_error == false){
	Header('Location: install4?error=dbfilewrite');
	//echo 'file not writeable';
};	

?>

<?php if($error != ''):?>
<div class="announcements" style="margin-left:50px">
	<div id="flash">
		<?php if($error == 'email'):?>
		<h3>Uw e-mailadres is niet geldig...</h3>
		<?php elseif($error == 'password'):?>
		<h3>De twee wachtwoorden zijn verschillend...</h3>
		<?php endif;?>
	</div>	
</div>
<?php endif;?>

<h2>Stap 2</h2>
<div id="installdiv">
<p>Geef de eerste instellingen op:</p>
<form name="databaseinstall" action="install3" method="post">
	<table>
		<tr>
			<td width="270px">Website title:</td>
			<td><input type="text" name="title" class="smaller_text"/></td>
		</tr>
		<tr>
			<td>Gebruikersnaam:</td>
			<td><input type="text" name="username" class="smaller_text"/></td>
		</tr>
		<tr>
			<td valign="top">
				Wachtwoord, tweemaal:<br/>
				<small>(als u niks invult wordt er een<br/> automatisch wachtwoord gegenereerd)</small>
			</td>
			<td>
				<input type="password" name="password1" class="smaller_text"/><br/>
				<input type="password" name="password2" class="smaller_text"/>
			</td>
		</tr>
		<tr>
			<td>Je e-mailadres:<br/>
			</td>
			<td>
				<input type="text" name="email"  class="smaller_text"/></td>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:right">
				<input type="submit" name="Opslaan" Value="Opslaan" class="submitbutton" />
			</td>
		</tr>
	</table>
</form>
</div>