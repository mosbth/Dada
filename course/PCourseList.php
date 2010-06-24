<?php
// ===========================================================================================
//
//		Persia (http://phpersia.org), software to build webbapplications.
//    Copyright (C) 2010  Mikael Roos (mos@bth.se)
//
//    This file is part of Persia.
//
//    Persia is free software: you can redistribute it and/or modify
//    it under the terms of the GNU General Public License as published by
//    the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.
//
//    Persia is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License
//    along with Persia. If not, see <http://www.gnu.org/licenses/>.
//
// File: PCoursesList.php
//
// Description:
// List all courses, present a search-entry to filter out the courses displayed.
//
// Author: Mikael Roos, mos@bth.se
//
// Known issues:
// -
//
// History: 
// 2010-06-23: Created.
//


// -------------------------------------------------------------------------------------------
//
// Get common controllers, uncomment if not used in current pagecontroller.
//
// $pc, Page Controller helpers. Useful methods to use in most pagecontrollers
// $uc, User Controller. Keeps information/permission on user currently signed in.
// $if, Interception Filter. Useful to check constraints before entering a pagecontroller.
// $db, Database Controller. Manages all database access.
//
$pc = CPageController::GetInstanceAndLoadLanguage(__FILE__);
$uc = CUserController::GetInstance();
$if = CInterceptionFilter::GetInstance();
$db = CDatabaseController::GetInstance();


// -------------------------------------------------------------------------------------------
//
// Perform checks before continuing, what's to be fullfilled to enter this controller?
//
$if->FrontControllerIsVisitedOrDie();


// -------------------------------------------------------------------------------------------
//
// Take care of _GET/_POST variables. Store them in a variable (if they are set).
// Always check whats coming in...
//
$s = $pc->GETisSetOrSetDefault('s');


// -------------------------------------------------------------------------------------------
//
// Connect to the database, create the query and execute it, take care of the results.
//
$mysqli = $db->Connect();
$s = $mysqli->real_escape_string($s);

$where = <<<EOD
	codeCourse LIKE '%{$s}%' OR
	code1Course LIKE '%{$s}%' OR
	code2Course LIKE '%{$s}%' OR
	nameCourse LIKE '%{$s}%' OR
	nameEnCourse LIKE '%{$s}%' OR
	pointsCourse = '$s' OR
	keywordCourse LIKE '%{$s}%' OR
	descriptionCourse LIKE '%{$s}%'
	
EOD;

// Create query and execute it
$query = <<<EOD
SELECT COUNT(idCourse) AS nrows
FROM {$db->_['DadaCourse']}
WHERE
	{$where};

SELECT idCourse, codeCourse, nameCourse, nameEnCourse, pointsCourse
FROM {$db->_['DadaCourse']}
WHERE
	{$where}
ORDER BY codeCourse;

EOD;
$results = $db->DoMultiQueryRetrieveAndStoreResultset($query);

// Get link to course details
global $gModule;
$linkCourseDetails = "?m={$gModule}&amp;p=download&amp;file=";

// Get number of hits
$row = $results[0]->fetch_object();
$rowsFound = sprintf($pc->lang['ROWS_FOUND'], $row->nrows);

//Get all hits into table rows
$htmlRows = '';
$i=0;
while($row = $results[1]->fetch_object()) {    
	$htmlRows .= "<tr class='r".($i++%2+1)."'>";
	$htmlRows .= <<<EOD
<td class='center'><a href='{$linkCourseDetails}{$row->idCourse}' title='{$pc->lang['CLICK_FOR_COURSEDETAILS']}'>{$row->codeCourse}</a></td>
<td>{$row->nameCourse}</td>
<td>{$row->nameEnCourse}</td>
<td class='number'>{$row->pointsCourse}</td>
</tr>
EOD;
}

// Display message if no hits
$htmlRowsAreEmpty = "";
if(empty($htmlRows)) {
	$htmlRowsAreEmpty = "<p><em>{$pc->lang['NO_HITS']}</e,></p>";
}

// Close it down
$results[0]->close();
$results[1]->close();
$mysqli->close();


// -------------------------------------------------------------------------------------------
//
// Create HTML for the page.
//
global $gModule;

$htmlMain = <<<EOD
<div class='section'>
</div> <!-- section -->

<div class='section'>
	<form method='get'>
		<input type='hidden' name='m' value='{$gModule}'>
		<input type='hidden' name='p' value='course'>
		<fieldset class='standard type-s'>
	 		<!-- <legend>{$pc->lang['COURSES_HEADER']}</legend> -->
		 	<div class='form-wrapper'>
				<!-- <label for='search'>{$pc->lang['SEARCH_LABEL']}</label> -->
				<input id='search' class='gravatar' name='s' type='text' value='{$s}' placeholder="{$pc->lang['SEARCH_BY_KEYWORD']}" autocomplete autofocus>
				<div class='buttonbar'>
					<button type='submit' name='do' value='do'>{$pc->lang['SEARCH']}</button>
				</div> <!-- buttonbar -->
				<div class='form-status'>{$rowsFound}</div> 
		 </div> <!-- wrapper -->
		</fieldset>
	</form>
</div> <!-- section -->

<div class='section'>
	<table class='standard full-width'>
		<caption></caption>
		<colgroup></colgroup>
		<thead>
			<th>{$pc->lang['COURSE_CODE']}</th>
			<th>{$pc->lang['COURSE_NAME']}</th>
			<th>{$pc->lang['COURSE_NAME_EN']}</th>
			<th>{$pc->lang['COURSE_POINTS']}</th>
		</thead>
		<tbody>{$htmlRows}</tbody>
		<tfoot></tfoot>
	</table>
	{$htmlRowsAreEmpty}
</div> <!-- section -->


EOD;

$htmlLeft = '';
$htmlRight = <<<EOD
<div class='section'>
	<h3 class='columnMenu'>{$pc->lang['COURSES_TAG_HEADER']}</h3>
	<p>Tag cloud...</p>
</div> <!-- section -->

<div class='section'>
	<h3 class='columnMenu'>{$pc->lang['COURSES_HELPER_HEADER']}</h3>
	<p>{$pc->lang['COURSES_HELPER_INFO']}</p>
</div> <!-- section -->

EOD;
//$htmlRight = '';


// -------------------------------------------------------------------------------------------
//
// Create and print out the resulting page
//
CHTMLPage::GetInstance()->printPage($pc->lang['COURSES_TITLE'], $htmlLeft, $htmlMain, $htmlRight);
exit;


?>