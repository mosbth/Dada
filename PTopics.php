<?php
// ===========================================================================================
//
// PTopics.php
//
// Show the title of all/some topics
//
// Author: Mikael Roos, mos@bth.se
//


// -------------------------------------------------------------------------------------------
//
// Get pagecontroller helpers. Useful methods to use in most pagecontrollers
//
$pc = new CPageController();
//$pc->LoadLanguage(__FILE__);


// -------------------------------------------------------------------------------------------
//
// Interception Filter, controlling access, authorithy and other checks.
//
$intFilter = new CInterceptionFilter();

$intFilter->FrontControllerIsVisitedOrDie();
//$intFilter->UserIsSignedInOrRecirectToSignIn();
//$intFilter->UserIsMemberOfGroupAdminOrDie();


// -------------------------------------------------------------------------------------------
//
// Take care of _GET/_POST variables. Store them in a variable (if they are set).
//
//$articleId	= $pc->GETisSetOrSetDefault('article-id', 0);
$userId		= $_SESSION['idUser'];

// Always check whats coming in...
//$pc->IsNumericOrDie($articleId, 0);


// -------------------------------------------------------------------------------------------
//
// Create a new database object, connect to the database, get the query and execute it.
// Relates to files in directory TP_SQLPATH.
//
$db 	= new CDatabaseController();
$mysqli = $db->Connect();

// Get the SP names
$spPGetTopicList = DBSP_PGetTopicList;

$query = <<< EOD
CALL {$spPGetTopicList}();
EOD;

// Perform the query
$results = Array();
$res = $db->MultiQuery($query); 
$db->RetrieveAndStoreResultsFromMultiQuery($results);

// Get the list of articles
$list = <<<EOD
<table width='99%'>
<tr>
<th width='60%'>
Topic
</th>
<th>
By
</th>
<th>
When
</th>
</tr>
EOD;
while($row = $results[0]->fetch_object()) {    
	$list .= <<<EOD
<tr>
<td>
<a href='?m=rom&amp;p=topic&amp;id={$row->id}'>{$row->title}</a>
</td>
<td>
<p class='small'>
{$row->username}
</p>
</td>
<td>
<p class='small'>
{$row->latest}
</p>
</td>
</tr>
EOD;
}
$list .= "</table>";

$results[0]->close(); 
$mysqli->close();


// -------------------------------------------------------------------------------------------
//
// Page specific code
//
$htmlMain = <<<EOD
<h1>Latest discussions</h1>
{$list} 

EOD;

$htmlLeft 	= "";
$htmlRight	= <<<EOD
<h3 class='columnMenu'>Categories</h3>
<p>
Later...
</p>
<h3 class='columnMenu'>Hot Tags</h3>
<p>
Later... Complete Tag Cloud
</p>
<h3 class='columnMenu'>Recent Activity</h3>
<p>
Later...
</p>
EOD;


// -------------------------------------------------------------------------------------------
//
// Create and print out the resulting page
//
$page = new CHTMLPage();

$page->PrintPage("Topics", $htmlLeft, $htmlMain, $htmlRight);
exit;

?>