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
// File: PLogin.php
//
// Description: Show a login-form, ask for user name and password.
//
// Author: Mikael Roos, mos@bth.se
//
// Known issues:
// -
//
// History: 
// 2010-06-22: New structure.
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
// Remember accountname if login failed
$account	= strip_tags($pc->GetAndClearSessionMessage('loginAccount'));


// -------------------------------------------------------------------------------------------
//
// If came here by accessing protected page, then redirect to protected page again.
// Else redirect to home.
//
$redirectTo = $pc->GetAndClearSessionMessage('redirectOnSignin', $pc->UrlToModuleAndPage('','home'));


// -------------------------------------------------------------------------------------------
//
// Show the login-form
//
global $gModule;

$action 			= "?m={$gModule}&amp;p=loginp";
$redirect 		= $redirectTo;
$redirectFail = "?m={$gModule}&amp;p=login";

// Get and format messages from session if they are set
$helpers = new CHTMLHelpers();
$messages = $helpers->GetHTMLForSessionMessages(
	Array(), 
	Array('loginFailed'));

// Only display local login button if enabled.
$loginButton = "<button type='submit' name='submit' value='login-local'>{$pc->lang['LOGIN']}</button>";
$loginButton = LOCAL_LOGIN ? $loginButton : '';

// Only display LDAP login button if LDAP is enabled.
$ldapButton = "<button type='submit' name='submit' value='login-ldap'>{$pc->lang['LOGIN_LDAP']}</button>";
$ldapButton = defined('LDAP_AUTH_SERVER') ? $ldapButton : '';

// Only display if enabled
$createNewUser = "[<a href='?m={$gModule}&amp;p=account-create'>{$pc->lang['CREATE_NEW_ACCOUNT']}</a>] ";
$createNewUser = CREATE_NEW_ACCOUNT ? $createNewUser : '';

// Only display if enabled
$forgotPassword = "[<a href='?m={$gModule}&amp;p=account-forgot-pwd'>{$pc->lang['FORGOT_PASSWORD']}</a>] ";
$forgotPassword = FORGOT_PASSWORD ? $forgotPassword : '';


// Create main HTML
$htmlMain = <<<EOD
<div class='section'>
	<h1>{$pc->lang['LOGIN']}</h1>
	<p>{$pc->lang['LOGIN_INTRO_TEXT']}</p> 
</div> <!-- section -->

<div class='section'>
	<form action='{$action}' method='post'>
		<input type='hidden' name='redirect' 			value='{$redirect}'>
		<input type='hidden' name='redirect-fail' value='{$redirectFail}'>
		
		<fieldset class='standard type-1'>
	 		<!--<legend></legend>-->
		 	<div class='form-wrapper'>

				<p></p>
				
				<label for="account">{$pc->lang['USER']}</label>
				<input class='account' type='text' name='account' value='{$account}' autofocus>
				
				<label for="password">{$pc->lang['PASSWORD']}</label>
				<input class='password' type='password' name='password'>
				
				<div class='buttonbar'>
					{$loginButton}
					{$ldapButton}
				</div> <!-- buttonbar -->

				<div class='form-status'>{$messages['loginFailed']}</div> 
		 </div> <!-- wrapper -->
		</fieldset>
	</form>
<p>{$createNewUser}{$forgotPassword}</p>
</div> <!-- section -->

EOD;

$htmlLeft 	= "";
$htmlRight	= <<<EOD
<div class='section'>
	<h3 class='columnMenu'>{$pc->lang['LOGIN_SIDEBAR_TITLE']}</h3>
	<p>{$pc->lang['LOGIN_SIDEBAR_INFO']}</p>
</div> <!-- section -->

EOD;


// -------------------------------------------------------------------------------------------
//
// Create and print out the resulting page
//
CHTMLPage::GetInstance()->printPage($pc->lang['LOGIN'], $htmlLeft, $htmlMain, $htmlRight);
exit;


?>