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

require('../../config.php');

// Get id
if(!isset($_GET['category_id']) OR !is_numeric($_GET['category_id'])) {
	header("Location: ".ADMIN_URL."/pages/index.php");
} else {
	$category_id = $_GET['category_id'];
}

// Include WB admin wrapper script
require(WB_PATH.'/modules/admin.php');

// Load Language file
if(LANGUAGE_LOADED) {
    require_once(WB_PATH.'/modules/rbtoggle/languages/EN.php');
    if(file_exists(WB_PATH.'/modules/rbtoggle/languages/'.LANGUAGE.'.php')) {
        require_once(WB_PATH.'/modules/rbtoggle/languages/'.LANGUAGE.'.php');
    }
}

// Get info on question
$query_category = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_rbtoggle_categories WHERE cat_id='$category_id'");
$fetch_category = $query_category->fetchRow();

?>

<style type="text/css">
.setting_name {
	vertical-align: top;
}
</style>

<form name="modify" action="<?php echo WB_URL; ?>/modules/rbtoggle/save_category.php" method="post" style="margin: 0;">

<input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
<input type="hidden" name="page_id" value="<?php echo $page_id; ?>">
<input type="hidden" name="category_id" value="<?php echo $category_id; ?>">

<table class="row_a" cellpadding="2" cellspacing="0" border="0" align="center" width="100%">
<tr>
	<td class="setting_name" width="80">
		<label for="cat_name" accesskey="n"><b><?php echo $FQTEXT['NAME']; ?>:</b></label>
	</td>
	<td class="setting_name">
		<input type="text" name="cat_name" id="cat_name" value="<?php echo $admin->strip_slashes($fetch_category['cat_name']); ?>" style="width: 98%;" maxlength="255" />
	</td>
</tr>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr>
	<td align="left">
		<input name="save" type="submit" value="<?php echo $TEXT['SAVE']; ?>" style="width: 100px; margin-top: 5px;"></form>
	</td>
	<td align="right">
		<input type="button" value="<?php echo $TEXT['CANCEL']; ?>" onclick="javascript: window.location = '<?php echo ADMIN_URL; ?>/pages/modify.php?page_id=<?php echo $page_id; ?>';" style="width: 100px; margin-top: 5px;" />
	</td>
</tr>
</table>

<?php

// Print admin footer
$admin->print_footer();

?>
