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
if(!isset($_GET['question_id']) OR !is_numeric($_GET['question_id'])) {
	if(!isset($_GET['category_id']) OR !is_numeric($_GET['category_id'])) {
		header("Location: index.php");
	} else {
		$id = $_GET['category_id'];
		$id_field = 'cat_id';
		$table = TABLE_PREFIX.'mod_rbtoggle_categories';
	}
} else {
	$id = $_GET['question_id'];
	$id_field = 'question_id';
	$table = TABLE_PREFIX.'mod_rbtoggle_questions';
}

// Include WB admin wrapper script
require(WB_PATH.'/modules/admin.php');

// Include the ordering class
require(WB_PATH.'/framework/class.order.php');

// Create new order object an reorder
$order = new order($table, 'pos', $id_field, 'section_id');
if($order->move_down($id)) {
	$admin->print_success($TEXT['SUCCESS'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
} else {
	$admin->print_error($TEXT['ERROR'], ADMIN_URL.'/pages/modify.php?page_id='.$page_id);
}

// Print admin footer
$admin->print_footer();

?>
