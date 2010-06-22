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
// File: SQLInstall.php
//
// Description: Module specific SQL statements to install default content into database.
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
//$pc = CPageController::GetInstanceAndLoadLanguage(__FILE__);
//$uc = CUserController::GetInstance();
//$if = CInterceptionFilter::GetInstance();
$db = CDatabaseController::GetInstance();

// Create the query
$query = <<<EOD
-- =============================================================================================
--
-- SQL DML for Dada, default values
--
-- =============================================================================================

-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
--
-- Insert default School(s)
--
INSERT INTO {$db->_['DadaSchool']} 
	(akronymSchool, descriptionSchool)
	VALUES
	('---', 'No School is choosen'),
	('COM', 'School of Computing');
	
	
-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
--
-- Insert default Department(s)
--
INSERT INTO {$db->_['DadaDepartment']} 
	(akronymDepartment, descriptionDepartment)
	VALUES
	('---', 'No Department is choosen'),
	('APS', '-'),
	('AIS', '-'),
	('ATM', '-');


-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
--
-- Insert default DoS(s) (Director of Studies) 
--
INSERT INTO {$db->_['DadaDoS']} 
	(nameDoS, descriptionDoS)
	VALUES
	('---', 'No Director of Studies is choosen'),
	('BHR', 'Birgitta Hermansson'),
	('ANE', 'Anders Nelson');


-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
--
-- Insert default ResearchGroup(s)
--
INSERT INTO {$db->_['DadaResearchGroup']} 
	(nameResearchGr, descriptionResearchGr)
	VALUES
	('---', 'No Research group is choosen'),
	('CCS-LAB', 'Computer and Communication Systems Research Laboratory'),
	('DISL', 'Distributed and Intelligent Systems Laboratory'),
	('GSIL', 'Game Systems and Interaction research Laboratory'),
	('SERL', 'Software Engineering Research Laboratory');


-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
--
-- Insert default TeachingGroup(s)
--
INSERT INTO {$db->_['DadaTeachingGroup']} 
	(nameTeachingGr, descriptionTeachingGr)
	VALUES
	('---', 'No Teaching group is choosen');


-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
--
-- Insert default Title(s)
--
INSERT INTO {$db->_['DadaTitle']} 
	(nameTitle, descriptionTitle)
	VALUES
	('---', 'No Title is choosen'),
	('Professor', '-'),
	('Docent', '-'),
	('Universitetslektor', '-'),
	('Lektor', '-'),
	('Doktorand', '-'),
	('Industridoktorand', '-'),
	('Universitetsadjunkt', '-'),
	('Amanuens', '-'),
	('Timanställd', '-'),
	('Projektassistent', '-'),
	('Sektionschef', '-');


-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
--
-- Insert default Person(s) with organisational belonging
--
INSERT INTO {$db->_['DadaPerson']} 
	(akronymPerson, firstnamePerson, lastnamePerson, birthPerson)
	VALUES
	('DOE', 'John/Jane', 'Doe', NOW());
	
INSERT INTO {$db->_['DadaOrganisation']} 
	(Org_idPerson)
	VALUES
	(LAST_INSERT_ID());


EOD;


?>