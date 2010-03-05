<?php
// ===========================================================================================
//
// PPostEdit.php
//
// A post editor. Create or edit a post.
//
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
$intFilter->UserIsSignedInOrRecirectToSignIn();
//$intFilter->UserIsMemberOfGroupAdminOrDie();


// -------------------------------------------------------------------------------------------
//
// Take care of _GET/_POST variables. Store them in a variable (if they are set).
//
$editor		= $pc->GETisSetOrSetDefault('editor', 'plain');
$postId		= $pc->GETisSetOrSetDefault('id', 0);
$userId		= $_SESSION['idUser'];

// Always check whats coming in...
$pc->IsNumericOrDie($postId, 0);
$pc->IsStringOrDie($editor);


// -------------------------------------------------------------------------------------------
//
// Create a new database object, connect to the database, get the query and execute it.
// Relates to files in directory TP_SQLPATH.
//
$title 		= "";
$content 	= "";

// Connect
$db 	= new CDatabaseController();
$mysqli = $db->Connect();

// Get the SP names
$spPGetPostDetails = DBSP_PGetPostDetails;

$query = <<< EOD
CALL {$spPGetPostDetails}({$postId});
EOD;

// Perform the query
$results = Array();
$res = $db->MultiQuery($query); 
$db->RetrieveAndStoreResultsFromMultiQuery($results);

// Get article details
$row = $results[0]->fetch_object();
$title 		= empty($row->title) 	? 'New title' : $row->title;
$content 	= empty($row->content) 	? '' : $row->content;
$saved	 	= empty($row->latest) 	? 'Not yet' : $row->latest;
$results[0]->close(); 

$mysqli->close();


// -------------------------------------------------------------------------------------------
//
// Use a JavaScript editor
//
$jseditor;
$jseditor_submit = "";

switch($editor) {

	case 'markItUp': {
		$jseditor = new CWYSIWYGEditor_markItUp('text', 'text');
	}
	break;

	case 'WYMeditor': {
		$jseditor = new CWYSIWYGEditor_WYMeditor('text', 'text');
		$jseditor_submit = 'class="wymupdate"'; 
	}
	break;

	case 'NicEdit': {
		$jseditor = new CWYSIWYGEditor_NicEdit('text', 'size98percentx300');
	}
	break;

	case 'plain':
	default: {
		$jseditor = new CWYSIWYGEditor_Plain('text', 'size98percentx300');
	}
}


// -------------------------------------------------------------------------------------------
//
// Page specific code
//
$htmlMain = <<<EOD
<form class='article' action='?m=rom&p=post-save' method='POST'>
<input type='hidden' name='redirect_on_success' value='?m=rom&amp;p=post-edit&amp;editor={$editor}&amp;id=%1\$d'>
<input type='hidden' name='redirect_on_failure' value='?m=rom&amp;p=post-edit&amp;editor={$editor}&amp;id=%1\$d'>
<input type='hidden' name='article_id' value='{$postId}'>
<p>
Title: <input class='title' type='text' name='title' value='{$title}'>
</p>
<p>
<textarea id='{$jseditor->iCSSId}' class='{$jseditor->iCSSClass}' name='content'>{$content}</textarea>
</p>
<p class='notice'>
Saved: {$saved}
</p>
<p>
<input type='submit' {$jseditor_submit} value='Save'>
<input type='button' value='Delete' onClick='if(confirm("Do you REALLY want to delete it?")) {form.action="?p=article-delete"; form.redirect_on_success.value="?m=rom&amp;p=topics"; submit();}'>
</p>
<p class='small'>
Edit this using 
<a href='?m=rom&amp;p=post-edit&amp;editor=plain&amp;id={$postId}'>Plain</a> | 
<a href='?m=rom&amp;p=post-edit&amp;editor=NicEdit&amp;id={$postId}'>NicEdit</a> |
<a href='?m=rom&amp;p=post-edit&amp;editor=WYMeditor&amp;id={$postId}'>WYMeditor</a> |
<a href='?m=rom&amp;p=post-edit&amp;editor=markItUp&amp;id={$postId}'>markItUp!</a> 
</p>
</form>

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
EOD;


// -------------------------------------------------------------------------------------------
//
// Create and print out the resulting page
//
$page = new CHTMLPage();

$page->PrintPage("Create/edit post", $htmlLeft, $htmlMain, $htmlRight, $jseditor->GetHTMLHead());
exit;

?>