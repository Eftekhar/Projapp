<?php
	######### IN THE NAME OF ALLAH ##########
	## Project Name: Projapp               ##
	## File name:    index.php             ##
	## Author:       Mohammad Mahdi Naderi ##
	## Project Site: projapp.mmnaderi.ir   ##
	#########################################
	include('config.php');
	include('libraries.php');
	
	// check if Projapp not installed (in database isn't any table)
	if(mysql_num_rows(mysql_query("SHOW TABLES")) == 0) {
		echo($not_installed);
		exit;
	}
	
	// include header of theme
	include($themeurl.'/header.pt');
	
	// check if developer doesn't have any project
	$rows = mysql_result(mysql_query("SELECT COUNT(*) FROM `projects`"), 0);
	if(!$rows) { echo($lang['no_project']); }
	
	// start categories
	$categories_query = mysql_query("SELECT * FROM `categories`");
	while($categories = mysql_fetch_array($categories_query)) {
	$counter = 1;
	if($categories['name'] != 'Without Category') {
		echo('<h2 class="category-title">'.$categories['name'].'</h2>');
	}
	
	// start projects in any categories
	$empty_category = mysql_result(mysql_query("SELECT * FROM `projects` WHERE `category`='".$categories['name']."'"), 0);
	if (!$empty_category && $categories['name'] != 'Without Category') { echo("<span class=\"note\">{$lang['no_project_in_cat']}</span>"); }
	$projects_query = mysql_query("SELECT * FROM `projects` WHERE `category`='".$categories['name']."'");
	while($projects = mysql_fetch_array($projects_query)) {
?>
			<li>
				<span class="name"><?php
					echo($counter.". ".$projects['name']);
					$counter=$counter+1;
				?></span>
				<span class="description"><?php echo($projects['description']); ?></span>
				<div class="percent-full"><?php
					if ($projects['percent'] == 100) {
						echo('<img src="admin/images/complete.png" alt="'.$lang['complete'].'" title="'.$lang['complete'].'" />');
					}
					else {
						echo('<img src="admin/images/indevelop.png" alt="'.$lang['in_develop'].'" title="'.$lang['in_develop'].'" />');
					}
				?>
					<div class="percent-text"><?php echo($projects['percent']); ?>%</div>
				</div>
				<div class="type"><?php
					if ($projects['type'] == 'public') {
						if($projects['file'] == $info['url'].'/public/') {
							echo('<img src="admin/images/download.png" alt="'.$lang['public'].'" title="'.$lang['public'].'" />');
						}
						else {
							echo('<a href="'. $info['url'] .'/public/'. $projects['file'] .'"><img src="admin/images/download.png" alt="'.$lang['public'].'" title="'.$lang['public'].'" /></a>');
						}
					}
					elseif ($projects['type'] == 'sale') {
						echo('<a href="mailto:'. $info['developermail'] .'"><img src="admin/images/sale.png" alt="'.$lang['sale'].'" title="'.$lang['sale'].'" /></a>');
					}
					else {
						echo('<img src="admin/images/private.png" alt="'.$lang['private'].'" title="'.$lang['private'].'" />');
					}
				?></div>
			</li>
<?php } } ?>
<?php include($themeurl.'/footer.pt'); ?>