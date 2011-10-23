<?php
Configure::write('Config.language', 'eng');

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
	if(isset($_POST['theprefix']) && $_POST['theprefix'] != ''){
		$prefix = $_POST['theprefix'];
		if(substr($prefix, 0, -1) != '_'){
			$prefix .= '_';
		}
	}else{
		$prefix = '';
	}
	
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
	$test = '';
	if($num_of_tables == 0){
		$file_content = file($url);
		//echo '<div id="sqldump">';
		foreach($file_content as $sql_line){
			if(trim($sql_line) != "" && strpos($sql_line, "--") === false){
				$sql_line = str_replace('CREATE TABLE `', 'CREATE TABLE `'.$prefix, $sql_line);
				$sql_line = str_replace('INSERT INTO `', 'INSERT INTO `'.$prefix, $sql_line);
				mysql_query($sql_line);
			}
		}
		
		$folder =  substr($_SERVER['REQUEST_URI'],0,-9);
		$path = $_SERVER['HTTP_ORIGIN'] . $folder;
		$sql1 = "INSERT INTO `".$prefix."settings` VALUES(3, 'HOME_FOLDER', '".$folder."', '1','2010-07-21 13:15:39');";
		$sql2 = "INSERT INTO `".$prefix."settings` VALUES(2, 'HOME', '".$path."', '1','2010-07-21 13:15:17');";
		$sql3 = "INSERT INTO `".$prefix."categories` VALUES(1, 'Uncategorized', '".date('Y-m-d H:i:s')."', 1, 0);";
		$sql4 = "INSERT INTO `".$prefix."products` VALUES (1, '', 'First product', '<p>Description</p>', '', '', '".date('Y-m-d H:i:s')."', '50.00', '1.50', '', '0.19', '', '0', '0', '0', '1', 'first-product', 'First product', '', '', '');";
		$sql5 = "INSERT INTO `".$prefix."categories_products` VALUES(1, 1, 1, 1);";
				
		mysql_query($sql1);
		mysql_query($sql2);
		mysql_query($sql3);
		mysql_query($sql4);
		mysql_query($sql5);
		
	//	echo '</div>';
	}
	
}else if($database_error == true && $dbfile_error == false){
	Header('Location: install4?error=nodbconnection');
	//echo 'no connection';
}else if($dbfile_error == true && $database_error == false){
	Header('Location: install4?error=dbfilewrite');
	//echo 'file not writeable';
};	

?>
<script type="text/javascript">

	function doSubmit(){
		$('#install2').submit();
	}

</script>

<?php if($error != ''):?>
<div class="announcements" style="margin-left:50px">
	<div id="flash">
		<?php if($error == 'email'):?>
		<h3><?php __('Uw e-mailadres is niet geldig')?>...</h3>
		<?php elseif($error == 'password'):?>
		<h3><?php __('De twee wachtwoorden zijn verschillend')?>...</h3>
		<?php endif;?>
	</div>	
</div>
<?php endif;?>
<h2><?php __('Stap')?> 2</h2>
<div id="installdiv">
<p><?php __('Geef de eerste instellingen op')?>:</p>
<form name="databaseinstall" action="install3" method="post" id="install2">
	<input type="hidden" name="theprefix" value="<?php echo $prefix;?>">
	<table>
		<tr>
			<td width="270px"><?php __('Website title')?>:</td>
			<td><input type="text" name="title" class="smaller_text"/></td>
		</tr>
		<tr>
			<td><?php __('Gebruikersnaam')?>:</td>
			<td><input type="text" name="username" class="smaller_text"/></td>
		</tr>
		<tr>
			<td valign="top">
				<?php __('Wachtwoord')?>, <?php __('tweemaal')?>:<br/>
				<small>(<?php __('als u niks invult wordt er een<br/> automatisch wachtwoord gegenereerd')?>)</small>
			</td>
			<td>
				<input type="password" name="password1" class="smaller_text"/><br/>
				<input type="password" name="password2" class="smaller_text"/>
			</td>
		</tr>
		<tr>
			<td><?php __('Je e-mailadres')?>:<br/>
			</td>
			<td>
				<input type="text" name="email"  class="smaller_text"/></td>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:right">
				<br/>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:right">
				<a href="#" onClick="doSubmit()" class="giant pill button"><?php __('Opslaan')?></a>
			</td>
		</tr>
		
	</table>
</form>
</div>