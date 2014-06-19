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


// Get settings
$query_settings = $database->query("SELECT * FROM `".TABLE_PREFIX."mod_rbtoggle_settings` WHERE section_id='$section_id' LIMIT 1");
$fetch_settings = $query_settings->fetchRow();

$header= $admin->strip_slashes($fetch_settings['header']);
$footer= $admin->strip_slashes($fetch_settings['footer']);

$template_details = $admin->strip_slashes($fetch_settings['template_details']);

$stage1 = explode("[category]", $template_details );
$stage1 = $stage1[1];
$stage1 = explode("[/category]", $stage1 );
// Semi-Important one!
$stage1 = $stage1[0];

$stage2 = explode("[question]", $stage1 );
// Important one!
$category_detail_first = $stage2[0];

$stage3 = explode("[/question]", $stage1 );
// Important one!
$category_detail_last = $stage3[1];

$stage4 = explode("[question]", $stage1 );
$stage4 = $stage4[1];
$stage4 = explode("[/question]", $stage4 );
// Important one!
$question_detail_final = $stage4[0];


// Print header
if ( $header <> "" ) {
	echo $header;
	//echo '<br/><br/>';
}

// Add a top anchor
echo '<a name="top"></a>';

// Loop through existing categories
$query_cats = $database->query("SELECT * FROM `".TABLE_PREFIX."mod_rbtoggle_categories` WHERE section_id='".$section_id."' ORDER BY pos ASC");

if($query_cats->numRows() > 0)
{
	while($cat = $query_cats->fetchRow())
	{
		
		$query_quests = $database->query("SELECT * FROM `".TABLE_PREFIX."mod_rbtoggle_questions` WHERE cat_id='".$cat['cat_id']."' and section_id='".$section_id."' ORDER BY pos ASC");
		if($query_quests->numRows() > 0)
		{
			while($quest = $query_quests->fetchRow())
			{
				$question=$admin->strip_slashes($quest['question']);
				$wb->preprocess($question);

				$replace_pattern = array('{QUESTION}' => $question, '{LINK}' => "#question_".$quest['question_id']);
				
			}
		}
		
	}
}



/** **/
/** End of the summary :-) **/
/** **/

//echo '<hr>';

// Loop through existing categories
$query_cats = $database->query("SELECT * FROM `".TABLE_PREFIX."mod_rbtoggle_categories` WHERE section_id='".$section_id."' ORDER BY pos ASC");

if($query_cats->numRows() > 0)
{
	while($cat = $query_cats->fetchRow())
	{
		$category = $admin->strip_slashes($cat['cat_name']);
		$category = '<div class="category">'.$category.'</div>';
		echo strtr($category_detail_first, array('{CATEGORY}' => $category));
		$query_quests = $database->query("SELECT * FROM `".TABLE_PREFIX."mod_rbtoggle_questions` WHERE cat_id='".$cat['cat_id']."' AND section_id='".$section_id."' ORDER BY pos ASC");
		if($query_quests->numRows() > 0)
		{
			echo '<div id="accordion">';
			while($quest = $query_quests->fetchRow())
			{
				$content=$quest['answer'];
				$qid = $quest['question_id'];
				$wb->preprocess($content);
				
				$content = '<div class="pane">'.$content.'</div>';
				
				$question = $admin->strip_slashes($quest['question']);
				$question = str_replace('<p>','',$question);
				$question = str_replace('</p>','',$question);
				$question = '<h2>'.$question.'</h2>';

				
				$replace_pattern = array('{QUESTION}' => $question, '{LINK}' => "question_".$quest['question_id'], '{ANSWER}' => $content);
				echo strtr($question_detail_final, $replace_pattern);
				}
		}
		echo '</div>';
		echo $category_detail_last;
	}
}

// Print footer
if ( $footer <> "" ) {
	echo $footer;
}

?>
