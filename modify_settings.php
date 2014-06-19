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

// Include WB admin wrapper script
require(WB_PATH.'/modules/admin.php');

// include core functions of WB 2.7 to edit the optional module CSS files (frontend.css, backend.css)
@include_once(WB_PATH .'/framework/module.functions.php');

// Load Language file
if(LANGUAGE_LOADED) {
    require_once(WB_PATH.'/modules/rbtoggle/languages/EN.php');
    if(file_exists(WB_PATH.'/modules/rbtoggle/languages/'.LANGUAGE.'.php')) {
        require_once(WB_PATH.'/modules/rbtoggle/languages/'.LANGUAGE.'.php');
    }
}

// Get header and footer
$query_settings = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_rbtoggle_settings WHERE section_id='$section_id'");
$fetch_settings = $query_settings->fetchRow();



// check if backend.css file needs to be included into the <body></body> of modify.php
if(!method_exists($admin, 'register_backend_modfiles') && file_exists(WB_PATH ."/modules/form/backend.css")) {
	echo '<style type="text/css">';
	include(WB_PATH .'/modules/form/backend.css');
	echo "\n</style>\n";
}


// include the button to edit the optional module CSS files (function added with WB 2.7)
// Note: CSS styles for the button are defined in backend.css (div class="mod_moduledirectory_edit_css")
// Place this call outside of any <form></form> construct!!!
if(function_exists('edit_module_css')) {
	edit_module_css('rbtoggle');
}
?>

<form name="edit" action="<?php echo WB_URL; ?>/modules/rbtoggle/save_settings.php" method="post" style="margin: 0;">

<input type="hidden" name="section_id" value="<?php echo $section_id; ?>">
<input type="hidden" name="page_id" value="<?php echo $page_id; ?>">

<table class="row_a" cellpadding="2" cellspacing="0" border="0" align="center" width="100%">
<tr>
	<td colspan="2"><strong><?php echo $FQTEXT['SETTINGS']; ?></strong></td>
</tr>
<tr>
	<td class="setting_name" style="width: 200px">
		<?php echo $TEXT['HEADER']; ?>:
	</td>
	<td class="setting_name">
		<textarea name="header" style="width: 98%;"><?php echo $admin->strip_slashes($fetch_settings['header']); ?></textarea>
	</td>
</tr>
<tr>
	<td class="setting_name" style="width: 200px">
		<?php echo $TEXT['FOOTER']; ?>:
	</td>
	<td class="setting_name">
		<textarea name="footer" style="width: 98%;"><?php echo $admin->strip_slashes($fetch_settings['footer']); ?></textarea>
	</td>
</tr>

<!--
<tr>
	<td class="setting_name" style="width: 200px">
		<?php echo $FQTEXT['TEMPLATE_FAQ']; ?>:
	</td>
	<td class="setting_name">	
		<textarea name="template_summary" style="width: 98%; height: 200px;"><?php echo $admin->strip_slashes($fetch_settings['template_summary']); ?></textarea>
	</td>
</tr>
-->

<tr>
	<td class="setting_name" style="width: 200px">
		<?php echo $FQTEXT['TEMPLATE_DETAIL']; ?>:
	</td>
	<td class="setting_name">	
		<textarea name="template_details" style="width: 98%; height:200px;"><?php echo $admin->strip_slashes($fetch_settings['template_details']); ?></textarea>
	</td>
</tr>
</table>

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
