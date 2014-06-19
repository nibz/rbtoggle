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

if(defined('WB_URL')) {
	
	$database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."mod_rbtoggle_categories`");
	$mod_rbtoggle_categories = 'CREATE TABLE `'.TABLE_PREFIX.'mod_rbtoggle_categories` ( '
  		. '`section_id` INT(10) NOT NULL DEFAULT \'0\','
		. '`page_id` INT NOT NULL DEFAULT \'0\' ,'
		. '`cat_id` INT(10) NOT NULL AUTO_INCREMENT,'
		. '`cat_name` VARCHAR(255) NOT NULL DEFAULT \'\','
		. '`pos` INT(10) NOT NULL DEFAULT \'0\','
		. 'PRIMARY KEY  (cat_id)'
		. ')';
	$database->query($mod_rbtoggle_categories);

	$database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."mod_rbtoggle_questions`");
	$mod_rbtoggle_questions = 'CREATE TABLE `'.TABLE_PREFIX.'mod_rbtoggle_questions` ( '
		. '`section_id` INT(10) NOT NULL DEFAULT \'0\','
		. '`page_id` INT NOT NULL DEFAULT \'0\' ,'
		. '`question_id` INT(10) NOT NULL AUTO_INCREMENT,'
		. '`cat_id` INT(10) NOT NULL DEFAULT \'0\','
		. '`question` VARCHAR(255) NOT NULL DEFAULT \'\','
		. '`answer` TEXT NOT NULL,'
		. '`pos` INT(10) NOT NULL DEFAULT \'0\','
		. 'PRIMARY KEY (question_id)'
		. ')';
	$database->query($mod_rbtoggle_questions);
	
	$database->query("DROP TABLE IF EXISTS `".TABLE_PREFIX."mod_rbtoggle_settings`");
	$mod_rbtoggle_settings = 'CREATE TABLE `'.TABLE_PREFIX.'mod_rbtoggle_settings` ( '
		. '`section_id` INT(10) NOT NULL DEFAULT \'0\','
		. '`page_id` INT NOT NULL DEFAULT \'0\' ,'
		. '`header` TEXT NOT NULL,'
		. '`footer` TEXT NOT NULL,'
		. '`template_summary` TEXT NOT NULL,'
		. '`template_details` TEXT NOT NULL,'
		. 'PRIMARY KEY (section_id)'
		. ')';
	$database->query($mod_rbtoggle_settings);
	
	// Insert info into the search table
	// Module query info
	$field_info = array();
	$field_info['page_id'] = 'page_id';
	$field_info['title'] = 'page_title';
	$field_info['link'] = 'link';
	$field_info['description'] = 'description';
	$field_info['modified_when'] = 'modified_when';
	$field_info['modified_by'] = 'modified_by';
	$field_info = serialize($field_info);
	$database->query("INSERT INTO ".TABLE_PREFIX."search (name,value,extra) VALUES ('module', 'rbtoggle', '$field_info')");
	// Query start
	$query_start_code = "SELECT [TP]pages.page_id, [TP]pages.page_title,	[TP]pages.link, [TP]pages.description, [TP]pages.modified_when, [TP]pages.modified_by	FROM [TP]mod_rbtoggle_questions, [TP]pages WHERE ";
	$database->query("INSERT INTO ".TABLE_PREFIX."search (name,value,extra) VALUES ('query_start', '$query_start_code', 'rbtoggle')");
	// Query body
	$query_body_code = "
	[TP]pages.page_id = [TP]mod_rbtoggle_questions.page_id AND [TP]mod_rbtoggle_questions.question LIKE \'%[STRING]%\'
	OR [TP]pages.page_id = [TP]mod_rbtoggle_questions.page_id AND [TP]mod_rbtoggle_questions.answer LIKE \'%[STRING]%\' ";
	$database->query("INSERT INTO ".TABLE_PREFIX."search (name,value,extra) VALUES ('query_body', '$query_body_code', 'rbtoggle')");
	// Query end
	$query_end_code = "";	
	$database->query("INSERT INTO ".TABLE_PREFIX."search (name,value,extra) VALUES ('query_end', '$query_end_code', 'rbtoggle')");
	
	// Insert blank row (there needs to be at least on row for the search to work)
	$database->query("INSERT INTO ".TABLE_PREFIX."mod_rbtoggle_questions (page_id,section_id) VALUES ('0','0')");
	
}

?>
