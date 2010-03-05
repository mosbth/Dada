<?php
// ===========================================================================================
//
// PTopicShow.php
//
// Show the content of a topic.
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
$topicId	= $pc->GETisSetOrSetDefault('id', 0);
$userId		= $_SESSION['idUser'];

// Always check whats coming in...
$pc->IsNumericOrDie($topicId, 0);


// -------------------------------------------------------------------------------------------
//
// Create a new database object, connect to the database, get the query and execute it.
// Relates to files in directory TP_SQLPATH.
//
$db 	= new CDatabaseController();
$mysqli = $db->Connect();

// Get the SP names
$spPGetTopicDetails = DBSP_PGetTopicDetails;

$query = <<< EOD
CALL {$spPGetTopicDetails}({$topicId});
EOD;

// Perform the query
$results = Array();
$res = $db->MultiQuery($query); 
$db->RetrieveAndStoreResultsFromMultiQuery($results);
	
// Get article details
$row = $results[0]->fetch_object();
$title 		= $row->title;
$content 	= $row->content;
$saved	 	= $row->latest;
$username 	= $row->username;
$owner	 	= $row->userid;
$results[0]->close(); 

// Get the list of articles
/*
$list = "";
while($row = $results[1]->fetch_object()) {    
	$list .= "<a title='{$row->info}' href='?p=article-show&amp;article-id={$row->id}'>{$row->title}</a><br>";
}
$results[1]->close(); 
*/
$mysqli->close();


// -------------------------------------------------------------------------------------------
//
// User is admin or is owner of this topic
//
$ownerMenu = "";
if($intFilter->IsUserMemberOfGroupAdminOrIsCurrentUser($owner)) {
	$ownerMenu = <<<EOD
[
<a href="?m=rom&amp;p=post-edit&amp;editor=markItUp&amp;id={$topicId}">edit</a>
]
EOD;
}


// -------------------------------------------------------------------------------------------
//
// Page specific code
//
$htmlMain = <<<EOD
<article class="general">
<h1 class="nostyle">{$title}</h1>
<p>{$content}</p>
<p class="notice">
Created by {$username}. Updated: {$saved}. {$ownerMenu}
</p>
</article>

EOD;

$htmlLeft 	= "";
$htmlRight	= <<<EOD
<h3 class='columnMenu'>About This Topic</h3>
<p>
Later...Created by, num posts, num viewed, latest accessed. Tags.
</p>
<h3 class='columnMenu'>Related Topics</h3>
<p>
Later...Do search, show equal (and hot/popular) topics
</p>
<h3 class='columnMenu'>About Author</h3>
<p>
Later...
</p>
<h3 class='columnMenu'>More by this author</h3>
<p>
Later...
</p>
EOD;

// Do not show articles that does not exists.
if(empty($username)) {
	$htmlRight 	= "";
	$htmlMain = <<<EOD
<article class="general">
<h1 class="nostyle">Article does not exists</h1>
<p>
<a href="?p=article-edit">Create new article...</a>
<p>
</article>
EOD;
}



// -------------------------------------------------------------------------------------------
//
// Create and print out the resulting page
//
$page = new CHTMLPage();

$page->printPage("Article: {$title}", $htmlLeft, $htmlMain, $htmlRight);
exit;

?>