<?php

/*
 Website Baker Project <http://www.websitebaker.org/>
 Copyright (C) 2004-2007, Ryan Djurovich

 Website Baker is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 Website Baker is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with Website Baker; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// Must include code to stop this file being access directly
if(defined('WB_PATH') == false) { exit("Cannot access this file directly"); }

// Load Language file
if(LANGUAGE_LOADED) {
    require_once(WB_PATH.'/modules/rbtoggle/languages/EN.php');
    if(file_exists(WB_PATH.'/modules/rbtoggle/languages/'.LANGUAGE.'.php')) {
        require_once(WB_PATH.'/modules/rbtoggle/languages/'.LANGUAGE.'.php');
    }
}

//Delete empty records
$database->query("DELETE FROM ".TABLE_PREFIX."mod_rbtoggle_categories  WHERE section_id = '$section_id' and cat_name=''");

$query_settings = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_rbtoggle_settings WHERE section_id='$section_id'");
if( $query_settings->numRows() == 0 ) {
	$database->query("INSERT INTO ".TABLE_PREFIX."mod_rbtoggle_settings VALUES($section_id,'','','','')");
}

?>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td align="left" width="33%">
		<input type="button" value="<?php echo $FQTEXT['ADD_QUESTION_ANSWER']; ?>" onclick="javascript: window.location = '<?php echo WB_URL; ?>/modules/rbtoggle/add_question.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>';" style="width: 100%;" />
	</td>
	<td align="center" width="33%">
		<input type="button" value="<?php echo $FQTEXT['NEW_CATEGORY']; ?>" onclick="javascript: window.location = '<?php echo WB_URL; ?>/modules/rbtoggle/add_category.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>';" style="width: 100%;" />
	</td>
	<td align="center" width="33%">
		<input type="button" value="<?php echo $FQTEXT['SETTINGS']; ?>" onclick="javascript: window.location = '<?php echo WB_URL; ?>/modules/rbtoggle/modify_settings.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>';" style="width: 100%;" />
	</td>
</tr>
</table>

<br /><br />

<?php

// Loop through existing links
$query_cats = $database->query("SELECT * FROM `".TABLE_PREFIX."mod_rbtoggle_categories` WHERE section_id='$section_id' ORDER BY pos ASC");

if($query_cats->numRows() > 0) {
	$j = 1;
	while($cat = $query_cats->fetchRow()) {
		?>
		<h2><?php echo $admin->strip_slashes($cat['cat_name']);?>
			<a href="<?php echo WB_URL; ?>/modules/rbtoggle/modify_category.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&category_id=<?php echo $cat['cat_id']; ?>">
				<img src="<?php echo ADMIN_URL; ?>/images/modify_16.png" border="0" alt="Modify - " />
			</a>
			<a href="<?php echo WB_URL; ?>/modules/rbtoggle/move_up.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&category_id=<?php echo $cat['cat_id']; ?>" title="<?php echo $TEXT['MOVE_UP']; ?>">
				<?php if($j > 1) { ?>
				<img src="<?php echo ADMIN_URL; ?>/images/up_16.png" border="0" alt="^" />
				<?php ;} ?>
			</a>
			<a href="<?php echo WB_URL; ?>/modules/rbtoggle/move_down.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&category_id=<?php echo $cat['cat_id']; ?>" title="<?php echo $TEXT['MOVE_DOWN']; ?>">
				<?php if($j < $query_cats->numRows()) { ?>
				<img src="<?php echo ADMIN_URL; ?>/images/down_16.png" border="0" alt="v" />
				<?php ;} ?>
			</a>
			<a href="#" onclick="javascript: confirm_link('<?php echo $FQTEXT['ARE_YOU_SURE']; ?>', '<?php echo WB_URL; ?>/modules/rbtoggle/delete_category.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&category_id=<?php echo $cat['cat_id']; ?>');" title="<?php echo $TEXT['DELETE']; ?>">
				<img src="<?php echo ADMIN_URL; ?>/images/delete_16.png" border="0" alt="X" />
			</a>
		</h2>
		<table cellpadding="2" cellspacing="0" border="0" width="100%">
		<?php
		$query_quests = $database->query("SELECT * FROM `".TABLE_PREFIX."mod_rbtoggle_questions` WHERE section_id='$section_id' AND cat_id='".$cat['cat_id']."' ORDER BY pos ASC");

		if($query_quests->numRows() > 0) {
			$row = 'a';
			$i = 1;
			while($quest = $query_quests->fetchRow()) {
			?>
			<tr class="row_<?php echo $row; ?>" height="20">
				<td width="20">
					<a href="<?php echo WB_URL; ?>/modules/rbtoggle/modify_question.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&question_id=<?php echo $quest['question_id']; ?>">
						<img src="<?php echo ADMIN_URL; ?>/images/modify_16.png" border="0" alt="Modify - " />
					</a>
				</td>
				<td width="180">
					<a href="<?php echo WB_URL; ?>/modules/rbtoggle/modify_question.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&question_id=<?php echo $quest['question_id']; ?>">
						<?php echo $admin->strip_slashes(substr(strip_tags($quest['question']),0,40)); ?>..
					</a>
				</td>
				<td width="280">
					<?php echo $admin->strip_slashes(substr(strip_tags($quest['answer']),0,50)); ?>..
				</td>
				<td width="18">
					<a href="<?php echo WB_URL; ?>/modules/rbtoggle/move_up.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&question_id=<?php echo $quest['question_id']; ?>" title="<?php echo $TEXT['MOVE_UP']; ?>">
						<?php if($i > 1) { ?>
						<img src="<?php echo ADMIN_URL; ?>/images/up_16.png" border="0" alt="^" />
						<?php ;} ?>
					</a>
				</td>
				<td width="18">
					<a href="<?php echo WB_URL; ?>/modules/rbtoggle/move_down.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&question_id=<?php echo $quest['question_id']; ?>" title="<?php echo $TEXT['MOVE_DOWN']; ?>">
						<?php if($i < $query_quests->numRows()) { ?>
						<img src="<?php echo ADMIN_URL; ?>/images/down_16.png" border="0" alt="v" />
						<?php ;} ?>
					</a>
				</td>
				<td width="18">
					<a href="#" onclick="javascript: confirm_link('<?php echo $TEXT['ARE_YOU_SURE']; ?>', '<?php echo WB_URL; ?>/modules/rbtoggle/delete_question.php?page_id=<?php echo $page_id; ?>&section_id=<?php echo $section_id; ?>&question_id=<?php echo $quest['question_id']; ?>');" title="<?php echo $TEXT['DELETE']; ?>">
						<img src="<?php echo ADMIN_URL; ?>/images/delete_16.png" border="0" alt="X" />
					</a>
				</td>
			</tr>
			<!-- end of ONE question! -->
			<?php
			// Alternate row color
			if($row == 'a') { $row = 'b'; } else { $row = 'a'; }
			$i++;
		}
	} else {
		echo '<i>'.$TEXT['NONE_FOUND'].'</i>';
	}
	?>

	</table>
	<br /><br />
	
	<!-- new category next, yippee! :-) -->

	<?php
	$j++;
	}
} else {
	echo '<i>'.$TEXT['NONE_FOUND'].'</i>';
}

?>
