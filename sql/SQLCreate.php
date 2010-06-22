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
// File: SQLCreate.php
//
// Description: Module specific SQL statements to create the tables.
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
-- SQL DDL for Dada
--
-- =============================================================================================

-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
--
-- Drop all tables first
--
DROP TABLE IF EXISTS {$db->_['DadaPerson']};
DROP TABLE IF EXISTS {$db->_['DadaOrganisation']};

-- Meta tables
DROP TABLE IF EXISTS {$db->_['DadaSchool']};
DROP TABLE IF EXISTS {$db->_['DadaDepartment']};
DROP TABLE IF EXISTS {$db->_['DadaDoS']};
DROP TABLE IF EXISTS {$db->_['DadaResearchGroup']};
DROP TABLE IF EXISTS {$db->_['DadaTeachingGroup']};
DROP TABLE IF EXISTS {$db->_['DadaTitle']};


-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
--
-- Table for Person
-- Only details really related to a person.
-- Organisational status is in own table, if suitable.
--
CREATE TABLE {$db->_['DadaPerson']} (

  -- Primary key(s)
  idPerson INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,

  -- Attributes
  akronymPerson CHAR({$db->_['CDadaSizeAkronym']}) NOT NULL UNIQUE,
  firstnamePerson CHAR({$db->_['CDadaSizeName']}) NULL,
  lastnamePerson CHAR({$db->_['CDadaSizeName']}) NULL,
  birthPerson DATE NULL
  
) ENGINE {$db->_['DadaDefaultEngine']} CHARACTER SET {$db->_['DadaDefaultCharacterSet']} COLLATE {$db->_['DadaDefaultCollate']};


-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
--
-- Table for Organisation ("Org" is used as shorter name)
-- A person belongs to a organisation and has some organisational status and belongings.
-- 
CREATE TABLE {$db->_['DadaOrganisation']} (

  -- Primary key(s)
  -- Foreign keys
  Org_idPerson INT UNSIGNED NOT NULL PRIMARY KEY,
  FOREIGN KEY (Org_idPerson) REFERENCES {$db->_['DadaPerson']}(idPerson),

  -- Attributes
  Org_idSchool INT UNSIGNED NULL DEFAULT 1,
  FOREIGN KEY (Org_idSchool) REFERENCES {$db->_['DadaSchool']}(idSchool),

  Org_idDepartment INT UNSIGNED NULL DEFAULT 1,
  FOREIGN KEY (Org_idDepartment) REFERENCES {$db->_['DadaDepartment']}(idDepartment),
  
  Org_idDoS INT UNSIGNED NULL DEFAULT 1,
  FOREIGN KEY (Org_idDoS) REFERENCES {$db->_['DadaDoS']}(idDoS),
  
  Org_idResearchGr INT UNSIGNED NULL DEFAULT 1,
  FOREIGN KEY (Org_idResearchGr) REFERENCES {$db->_['DadaResearchGroup']}(idResearchGr),
  
  Org_idTitle INT UNSIGNED NULL DEFAULT 1,
  FOREIGN KEY (Org_idTitle) REFERENCES {$db->_['DadaTitle']}(idTitle)
  
) ENGINE {$db->_['DadaDefaultEngine']} CHARACTER SET {$db->_['DadaDefaultCharacterSet']} COLLATE {$db->_['DadaDefaultCollate']};


-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
--
-- Table for School
--
CREATE TABLE {$db->_['DadaSchool']} (

  -- Primary key(s)
  idSchool INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,

  -- Attributes
  akronymSchool CHAR({$db->_['CDadaSizeAkronym']}) NOT NULL UNIQUE,
  descriptionSchool VARCHAR({$db->_['CDadaSizeDescription']}) NULL
  
) ENGINE {$db->_['DadaDefaultEngine']} CHARACTER SET {$db->_['DadaDefaultCharacterSet']} COLLATE {$db->_['DadaDefaultCollate']};


-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
--
-- Table for Department
--
CREATE TABLE {$db->_['DadaDepartment']} (

  -- Primary key(s)
  idDepartment INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,

  -- Attributes
  akronymDepartment CHAR({$db->_['CDadaSizeAkronym']}) NOT NULL UNIQUE,
  descriptionDepartment VARCHAR({$db->_['CDadaSizeDescription']}) NULL
  
) ENGINE {$db->_['DadaDefaultEngine']} CHARACTER SET {$db->_['DadaDefaultCharacterSet']} COLLATE {$db->_['DadaDefaultCollate']};


-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
--
-- Table for Director of Studies
--
CREATE TABLE {$db->_['DadaDoS']} (

  -- Primary key(s)
  idDoS INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,

  -- Attributes
  nameDoS CHAR({$db->_['CDadaSizeShortName']}) NOT NULL UNIQUE,
  descriptionDoS VARCHAR({$db->_['CDadaSizeDescription']}) NULL
  
) ENGINE {$db->_['DadaDefaultEngine']} CHARACTER SET {$db->_['DadaDefaultCharacterSet']} COLLATE {$db->_['DadaDefaultCollate']};


-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
--
-- Table for Research Group
--
CREATE TABLE {$db->_['DadaResearchGroup']} (

  -- Primary key(s)
  idReasearchGr INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,

  -- Attributes
  nameResearchGr CHAR({$db->_['CDadaSizeShortName']}) NOT NULL UNIQUE,
  descriptionResearchGr VARCHAR({$db->_['CDadaSizeDescription']}) NULL
  
) ENGINE {$db->_['DadaDefaultEngine']} CHARACTER SET {$db->_['DadaDefaultCharacterSet']} COLLATE {$db->_['DadaDefaultCollate']};


-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
--
-- Table for Teaching Group
--
CREATE TABLE {$db->_['DadaTeachingGroup']} (

  -- Primary key(s)
  idTeachingGr INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,

  -- Attributes
  nameTeachingGr CHAR({$db->_['CDadaSizeShortName']}) NOT NULL UNIQUE,
  descriptionTeachingGr VARCHAR({$db->_['CDadaSizeDescription']}) NULL
  
) ENGINE {$db->_['DadaDefaultEngine']} CHARACTER SET {$db->_['DadaDefaultCharacterSet']} COLLATE {$db->_['DadaDefaultCollate']};


-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
--
-- Table for Work Title
--
CREATE TABLE {$db->_['DadaTitle']} (

  -- Primary key(s)
  idTitle INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,

  -- Attributes
  nameTitle CHAR({$db->_['CDadaSizeShortName']}) NOT NULL UNIQUE,
  descriptionTitle VARCHAR({$db->_['CDadaSizeDescription']}) NULL
  
) ENGINE {$db->_['DadaDefaultEngine']} CHARACTER SET {$db->_['DadaDefaultCharacterSet']} COLLATE {$db->_['DadaDefaultCollate']};


EOD;


?>