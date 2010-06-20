<?php
// ===========================================================================================
//
// index.php
//
// Modulecontroller. An implementation of a PHP module frontcontroller (module controller). 
// This page is called from the global frontcontroller. Its function could be named a 
// sub-frontcontroller or module frontcontroller. I call it a modulecontroller.
//
// All requests passes through this page, for each request a pagecontroller is choosen.
// The pagecontroller results in a response or a redirect.
//
// Author: Mikael Roos, mos@bth.se
//

// -------------------------------------------------------------------------------------------
//
// Redirect to the choosen pagecontroller.
//
$currentDir = dirname(__FILE__) . '/';
global $gPage;

switch($gPage) {
	
	//
	// Dada
	//
	case 'home':			require_once(TP_PAGESPATH . 'home/PEmpty.php'); break;
	case 'empty':			require_once(TP_PAGESPATH . 'home/PEmpty.php'); break;

	//
	// Dada
	//
	case 'install':		require_once($currentDir . 'install/PInstall.php'); break;
	case 'installp':	require_once($currentDir . 'install/PInstallProcess.php'); break;

	//
	// Directory listning
	//
	case 'ls':	require_once(TP_PAGESPATH . 'viewfiles/PListDirectory.php'); break;
	
	//
	// Default case, trying to access some unknown page, should present some error message
	// or show the home-page
	//
	default:			require_once(TP_PAGESPATH . 'home/P404.php'); break;
}


?>