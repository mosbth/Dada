<?php
// ===========================================================================================
//
// config.php, config-sample.php
//
// Module specific configurations. This file is the default config-file for all modules. 
// It can be overidden by another config.php-file residing in the module library. 
// For example, a file: modules/core/config.php would replace this file. 
// This way, each module can have their own settings. 
//
// Author: Mikael Roos, mos@bth.se
//
// TBD: This file is not lang-supported, how to enable that?
//


// -------------------------------------------------------------------------------------------
//
// Settings for the database connection
//
define('DB_HOST', 			'localhost');		// The database host
define('DB_USER', 			'mos');					// The username of the database
define('DB_PASSWORD', 	'secret');			// The users password
define('DB_DATABASE', 	'sr_01');			// The name of the database to use
define('DB_PREFIX', 		'dada_');		    	// Prefix to use infront of tablename and views


// -------------------------------------------------------------------------------------------
//
// Settings for this website (WS), some used as default values in CHTMPLPage.php
//
define('WS_SITELINK',   'http://dev.phpersia.org/dada/'); 	// Link to site.
define('WS_TITLE', 			'Dada');		    										// The title of this site.
define('WS_STYLESHEET', 'style/plain/stylesheet_liquid.css');	// Default stylesheet of the site.
define('WS_IMAGES',			WS_SITELINK . 'img/'); 								// Images
define('WS_FAVICON', 		WS_IMAGES . 'favicon.ico'); 					// Small icon to display in browser
define('WS_FOOTER', 		'Dada with Persia &copy; 2010 by Mikael Roos Home Copyrights Privacy About');	// Footer at the end of the page.
define('WS_VALIDATORS', TRUE);	            		// Show links to w3c validators tools.
define('WS_TIMER', 			TRUE);              		// Time generation of a page and display in footer.
define('WS_CHARSET', 		'utf-8');           		// Use this charset
define('WS_LANGUAGE', 	'en');              		// Default language
define('WS_JAVASCRIPT',	WS_SITELINK . '/js/');	// JavaScript code


// -------------------------------------------------------------------------------------------
//
// Define the application navigation menu.
//
$menuApps = Array (
	'GitHub' 			=> 'http://github.com/mosbth/Dada',
	'Dada 1.0'		=> 'http://dada.tek.bth.se/sr',
	'Dada 2.0' 		=> 'http://dada.tek.bth.se/2',
);
define('MENU_APPLICATION', 		serialize($menuApps));


// -------------------------------------------------------------------------------------------
//
// Define the navigation menu.
//
$menuNavBar = Array (
	'Home' 				=> '?m=dada&amp;p=home',
	'Courses'		 	=> '?m=dada&amp;p=empty',
	'Staff' 			=> '?m=dada&amp;p=empty',
	'Reports'			=> '?m=dada&amp;p=empty',
	'Install' 		=> '?m=dada&amp;p=install',
	'Sourcecode' 	=> '?m=dada&amp;p=ls',
);
define('MENU_NAVBAR', 		serialize($menuNavBar));


// -------------------------------------------------------------------------------------------
//
// Choose the hashing algoritm to use for storing new passwords. Can be changed during
// execution since various methods is simoultaneously supported by the database.
//
// Changing to PLAIN may imply writing an own function in PHP to encode the passwords. 
// Storing is then done as plaintext in the database, withouth using a salt.
//
// This enables usage of more complex hashing and encryption algoritms that are currently not
// supported within MySQL.
//
#define('DB_PASSWORDHASHING', 'MD5');
define('DB_PASSWORDHASHING', 'SHA-1');
#define('DB_PASSWORDHASHING', 'PLAIN');


// -------------------------------------------------------------------------------------------
//
// Server keys for reCAPTCHA. Get your own keys for your server.
// http://recaptcha.net/whyrecaptcha.html
//

// dev.phpersia.org
//define('reCAPTCHA_PUBLIC',	'6LcswbkSAAAAAN4kRL5qcAdiZLRo54fhlCVnt880');	
//define('reCAPTCHA_PRIVATE',	'6LcswbkSAAAAACFVN50SNO6lOC8uAlIB2cJwxknl');	

// www.student.bth.se
//define('reCAPTCHA_PUBLIC',	'6LeUxbkSAAAAADjelI32xn2VdBwsMJLLiBO2umtO');	
//define('reCAPTCHA_PRIVATE',	'6LeUxbkSAAAAAPRDQ8cAvEOgXMJZwb1rY2C5XauB');	


// -------------------------------------------------------------------------------------------
//
// Set the default email adress to be used as from in mail sent from the system to 
// account users. Be sure to set a valid domain to avoid spamfilters.
//
define('WS_MAILFROM', 				'Dada Development Team <no-reply@phpersia.org>');
define('WS_MAILSUBJECTLABEL', '[Dada] ');
define('WS_MAILSIGNATURE', 	
	"\n\nBest regards,\n" .
	"The Development Team Of Dada\n" .
	"http://phpersia.org/dada\n"
);


// -------------------------------------------------------------------------------------------
//
// Display the following actions if they are enabled.
// Set true to enable, false to disable.
// 
define('LOCAL_LOGIN', false);
define('CREATE_NEW_ACCOUNT', false);
define('FORGOT_PASSWORD', false);

// User Control Panel
define('USER_CHANGE_PASSWORD', false);
define('USER_AVATAR', false);
define('USER_GRAVATAR', true);


// -------------------------------------------------------------------------------------------
//
// Settings for LDAP and LDAP authentication.
// Disable/enable LDAP by commenting/uncommenting the following lines.
//
//define('LDAP_AUTH_SERVER', 'ldaps://ldap.bth.se');
//define('LDAP_AUTH_BASEDN', 'ou=staff,o=bth');
define('LDAP_AUTH_SERVER', 'ldap://phpersia.org');
define('LDAP_AUTH_BASEDN', 'dc=dbwebb,dc=se');


// -------------------------------------------------------------------------------------------
//
// Settings for Google Analytics.
// http://www.google.com/analytics/
//
//define('GA_DOMAIN', '.phpersia.org');
//define('GA_TRACKERID', 'UA-6902244-4');


// -------------------------------------------------------------------------------------------
//
// Settings for file upload and file archive.
// Disable/enable file upload by commenting/uncommenting the following lines.
//
define('FILE_ARCHIVE_PATH', '/usr/home/mos/archive/'); // Must be writable by webserver
define('FILE_MAX_SIZE', 30000000); // Filesize in bytes


?>