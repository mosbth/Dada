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
// File: config.php 
//
// Description: 
// Module specific database methods and settings.
// Define the names for the database (tables, views, procedures, functions, triggers)
// Defining all in an array and making them accessable through the CDatabaseController.
//
// Author: Mikael Roos, mos@bth.se
//
// Known issues:
// -
//
// History:
// 2010-06-21: Created.
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
$pc = CPageController::GetInstance();
//$pc = CPageController::GetInstanceAndLoadLanguage(__FILE__);

$DB_Tables_And_Procedures = Array(

	// -------------------------------------------------------------------------------------------
	//
	// Module Dada
	//
	'DadaDefaultEngine'				=> 'MyISAM',
	'DadaDefaultCharacterSet'	=> 'utf8',
	'DadaDefaultCollate'			=> 'utf8_unicode_ci',

	'CDadaSizeAkronym' 					=> 3,
	'CDadaSizeName'	 						=> 80,
	'CDadaSizeDescription'			=> 80,
	'CDadaSizeDescriptionLong'	=> 200,
	'CDadaSizeShortName'				=> 20,
	'CDadaSizeCourseCode'				=> 6,


	'DadaPerson'			 				=> DB_PREFIX . 'DadaPerson',
	'DadaOrganisation'			 	=> DB_PREFIX . 'DadaOrganisation',
	'DadaSchool'			 				=> DB_PREFIX . 'DadaSchool',
	'DadaDepartment'			 		=> DB_PREFIX . 'DadaDepartment',
	'DadaDoS'							 		=> DB_PREFIX . 'DadaDoS',
	'DadaResearchGroup'			 	=> DB_PREFIX . 'DadaResearchGroup',
	'DadaTeachingGroup'			 	=> DB_PREFIX . 'DadaTeachingGroup',
	'DadaTitle'							 	=> DB_PREFIX . 'DadaTitle',

	'DadaCourse'							=> DB_PREFIX . 'DadaCourse',

);


?>