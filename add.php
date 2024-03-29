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

// These are the default setting
$template_summary = '';

$template_details = '
[category]
{CATEGORY}
<div class="style1">
[question]
{QUESTION}
{ANSWER}
[/question]
</div>
[/category]';

$database->query("INSERT INTO ".TABLE_PREFIX."mod_rbtoggle_settings (section_id,page_id,template_summary,template_details) VALUES ('$section_id', '$page_id', '$template_summary', '$template_details')");

?>
