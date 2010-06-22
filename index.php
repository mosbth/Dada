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
	// Login, logout
	//
	case 'login':		require_once(TP_PAGESPATH . 'login/PLogin.php'); break;
	case 'loginp':	require_once(TP_PAGESPATH . 'login/PLoginProcess.php'); break;
	case 'logoutp':	require_once(TP_PAGESPATH . 'login/PLogoutProcess.php'); break;

	//
	// Install
	//
	case 'install':		require_once(TP_PAGESPATH . 'install/PInstall.php'); break;
	case 'installp':	require_once(TP_PAGESPATH . 'install/PInstallProcess.php'); break;

	// User Control Panel (UCP), default
	case 'ucp':			require_once(TP_PAGESPATH . 'ucp/PUserControlPanel.php'); break;

	// User Control Panel (UCP), Maintain account profile
	case 'ucp-account-settings':			require_once(TP_PAGESPATH . 'ucp/PAccountSettings.php'); break;
	case 'ucp-account-update':				require_once(TP_PAGESPATH . 'ucp/PAccountSettingsProcess.php'); break;

	// User Control Panel (UCP), Filearchive
	case 'ucp-filearchive':		require_once(TP_PAGESPATH . 'ucp/PFileArchive.php'); break;
	case 'ucp-fileupload':		require_once(TP_PAGESPATH . 'ucp/PFileUpload.php'); break;
	case 'ucp-fileuploadp':		require_once(TP_PAGESPATH . 'ucp/PFileUploadProcess.php'); break;
	case 'ucp-filedetails':		require_once(TP_PAGESPATH . 'ucp/PFileDetails.php'); break;
	case 'ucp-filedetailsp':	require_once(TP_PAGESPATH . 'ucp/PFileDetailsProcess.php'); break;

	// File download
	case 'download':		require_once(TP_PAGESPATH . 'file/PFileDownload.php'); break;
	case 'downloadp':		require_once(TP_PAGESPATH . 'file/PFileDownloadProcess.php'); break;

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