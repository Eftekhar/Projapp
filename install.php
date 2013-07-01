<?php
	######### IN THE NAME OF ALLAH ##########
	## Project Name: Projapp               ##
	## File name:    install.php           ##
	## Author:       Mohammad Mahdi Naderi ##
	## Project Site: projapp.mmnaderi.ir   ##
	#########################################
	include('admin/../config.php');
	if (isset($_POST['developer_name']) && $_POST['developer_name'] != '' && isset($_POST['developer_mail']) && $_POST['developer_mail'] != '') {
		mysql_query ('CREATE TABLE projects( '.
			'`id` INT NOT NULL AUTO_INCREMENT,'.
			'`name` TEXT NOT NULL, '.
			'`description` TEXT NOT NULL , '.
			'`type` TEXT NOT NULL , '.
			'`percent` INT NOT NULL , '.
			'`file` TEXT NOT NULL , '.
			'`category` TEXT NOT NULL , '.
			'PRIMARY KEY(id))');
		mysql_query ('CREATE TABLE categories( '.
			'`id` INT NOT NULL AUTO_INCREMENT,'.
			'`name` TEXT NOT NULL, '.
			'PRIMARY KEY(id))');
		mysql_query ('CREATE TABLE info( '.
			'`id` INT NOT NULL AUTO_INCREMENT,'.
			'`url` TEXT NOT NULL, '.
			'`username` TEXT NOT NULL, '.
			'`password` TEXT NOT NULL, '.
			'`developername` TEXT NOT NULL, '.
			'`developermail` TEXT NOT NULL, '.
			'`theme` TEXT NOT NULL, '.
			'`language` TEXT NOT NULL, '.
			'PRIMARY KEY(id))');
		$insertinfo = mysql_query ("INSERT INTO `info` (`id`,`url`,`username`,`password`,`developername`,`developermail`,`theme`,`language`) VALUES ('', 'http://".dirname($_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'])."','".$_POST['username']."','".$_POST['password']."','".$_POST['developer_name']."','".$_POST['developer_mail']."','".$_POST['theme']."','".$_POST['language']."')");
		$insertcategory = mysql_query ("INSERT INTO `categories` (`id`,`name`) VALUES ('','Without Category')");
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Projapp | Install</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link href="admin/favicon.ico" rel="shortcut icon">
		<link href="admin/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="container">
			<a href="index.php" title="Projapp"><img src="admin/images/logo-full.png" alt="Projapp" /></a>
			<div class="wrapper">
				<h1 class="page-title"><font size="5">{</font>Install Projapp}</h1>
				<form action="install.php" method="POST">
					<?php
						if (isset($insertinfo) && isset($insertcategory) && mysql_query("SELECT * FROM `info`") && mysql_query("SELECT * FROM `projects`") && mysql_query("SELECT * FROM `categories`")) {
					?>
					<p><img src="admin/images/complete.png" alt="Complete" /><font color="green"> Fantastic! Prpjapp is install successfully.</font></p>
					<p>you can go to <a href="index.php" title="Home page">Home page</a> or your <a href="admin" title="Admin panel">Admin panel</a>.</p>
					<?php
						}
						else {
							error_reporting(E_ERROR);
							if(isset($connect) && $connect) {
					?>
					<p><img src="admin/images/complete.png" alt="Complete" /><font color="green"> Perfect! Projapp can connect to MySql.</font></p>
					<p>Install Projapp in <strong>5 Seconds!</strong> :D</p>
					<p class="part">Username: <input type="text" name="username" /></p>
					<p class="part">Password: <input type="password" name="password" /></p>
					<hr color="#CCC" />
					<p class="part">Developer Name: <input type="text" name="developer_name" /></p>
					<p class="part">Developer E-Mail: <input type="text" name="developer_mail" /></p>
					<hr color="#CCC" />
					<p class="part">Language: 
					<select name="language">
					<?php
					foreach (glob("languages/*.pl") as $filename) {
						$filename = str_replace("languages/","",$filename);
						$filename = str_replace(".pl","",$filename);
						if($filename == 'en_US') {
							echo "<option selected=\"selected\">{$filename}</option>";
						}
						else {
							echo "<option>{$filename}</option>";
						}
					}
					?>
					</select>
					</p>
					<p class="part">Theme: 
					<select name="theme">
						<?php
							$path = 'themes/';
							$results = scandir($path);
							foreach ($results as $result) {
								if ($result === '.' or $result === '..') continue;
								if (is_dir($path . '/' . $result)) {
									if($result == 'default') {
										echo("<option selected=\"selected\" value=\"{$result}\">{$result}</option>");
									}
									else {
										echo("<option value=\"{$result}\">{$result}</option>");
									}
								}
							}
						?>
					</select>
					</p>
					<input type="hidden" name="request" value="true" />
					<div class="submit-project"><input type="submit" value="Install Projapp »" /></div>
					<?php } else { ?>
					<p><img src="admin/images/error.png" alt="Error" /><font color="red"> Unfortunately Projapp cannot connect to MySql.</font></p>
					<p>First you must edit config.php file in this folder for connect to MySql.</p>
					<?php } } ?>
				</form>
				<div class="clearfix"></div>
			</div>
		</div>
	</body>
</html>
