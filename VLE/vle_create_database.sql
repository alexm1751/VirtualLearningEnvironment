
/*
CREATE DATABASE vle;
*/
/*DROP TABLE STATEMENTS*/

DROP TABLE IF EXISTS vle_users;
DROP TABLE IF EXISTS vle_courses;
DROP TABLE IF EXISTS vle_timetables;
DROP TABLE IF EXISTS vle_announcements;
DROP TABLE IF EXISTS vle_modules;
DROP TABLE IF EXISTS vle_classes;
DROP TABLE IF EXISTS vle_attendance;
DROP TABLE IF EXISTS vle_submissions;
DROP TABLE IF EXISTS vle_coursework;
DROP TABLE IF EXISTS vle_module_allocation;
DROP TABLE IF EXISTS vle_allocation;


/*subject/teacher table?
*/

/*CREATE TABLE STATEMENTS*/

/*Update User details
Change password*/


/*USER TABLE*/
CREATE TABLE vle_users (
dbUniqueID INT(9)   AUTO_INCREMENT,
dbpass VARCHAR(70) NOT NULL,
dbEmail VARCHAR(50) NOT NULL,
dbFullName VARCHAR(100) NOT NULL,
dbAddress VARCHAR(100) NOT NULL,
dbNumber BIGINT(15) NOT NULL,
dbGender VARCHAR(10) NOT NULL,
dbRank INT(1) NOT NULL,
dbRecover_Hash VARCHAR(70),
dbregistration_date TIMESTAMP,
PRIMARY KEY (dbUniqueID)
);

ALTER TABLE vle_users AUTO_INCREMENT=1025;

/*Dummy entries*/
INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank,dbGender, dbRecover_Hash,dbregistration_date)
VALUES ('','Dummy', 'Dummy One',"The Moon",0123456789, 0,'', '', DEFAULT);
INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank,dbGender, dbRecover_Hash,dbregistration_date)
VALUES ('','Dummy', 'Dummy Two',"Jupiter",0123456789, 0, '','', DEFAULT);

/*Students*/
INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank,dbGender, dbRecover_Hash,dbregistration_date)
VALUES ('$2a$12$iqaGmuRer0trjLfa8Y1Ye.k32fAwS7qG13FXqCUXQIJGV4CT1Z.my','alex@mail.com', 'Alex Mason',"Leicester",012345678901, 1, 'Male','', DEFAULT);
INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank,dbGender, dbRecover_Hash,dbregistration_date)
VALUES ('$2a$12$iqaGmuRer0trjLfa8Y1Ye.k32fAwS7qG13FXqCUXQIJGV4CT1Z.my','mark@mail.com', 'Mark Corke',"Leicester",012345678901, 1, 'Male','', DEFAULT);
INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank,dbGender, dbRecover_Hash,dbregistration_date)
VALUES ('$2a$12$iqaGmuRer0trjLfa8Y1Ye.k32fAwS7qG13FXqCUXQIJGV4CT1Z.my','hayley@mail.com', 'Hayley Fisher',"Leicester",012345678901, 1, 'Female','', DEFAULT);
INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank,dbGender, dbRecover_Hash,dbregistration_date)
VALUES ('$2a$12$iqaGmuRer0trjLfa8Y1Ye.k32fAwS7qG13FXqCUXQIJGV4CT1Z.my','sarah@mail.com', 'Sarah Cooper',"Leicester",012345678901, 1, 'Female','', DEFAULT);
INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank,dbGender, dbRecover_Hash,dbregistration_date)
VALUES ('$2a$12$iqaGmuRer0trjLfa8Y1Ye.k32fAwS7qG13FXqCUXQIJGV4CT1Z.my','atty@mail.com', 'Herodes Atticus ',"Leicester",012345678901, 1, 'Male','', DEFAULT);
INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank,dbGender, dbRecover_Hash,dbregistration_date)

/*Teacher*/
VALUES ('$2a$12$iqaGmuRer0trjLfa8Y1Ye.k32fAwS7qG13FXqCUXQIJGV4CT1Z.my','ben@mail.co.uk','Ben Palmer',"Leicester",012345678901, 2,'Male', '', DEFAULT);
INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank,dbGender, dbRecover_Hash,dbregistration_date)

/*Admin*/
VALUES ('$2a$12$iqaGmuRer0trjLfa8Y1Ye.k32fAwS7qG13FXqCUXQIJGV4CT1Z.my','andrew@mail.pl', 'Andrew Sterling',"Leicester",012345678901, 3, 'Male','', DEFAULT);
INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank,dbGender, dbRecover_Hash,dbregistration_date)

/*Super Admin*/
VALUES ('$2a$12$iqaGmuRer0trjLfa8Y1Ye.k32fAwS7qG13FXqCUXQIJGV4CT1Z.my','dolly@mail.com', 'Dolly Sachdev',"Leicester",012345678901, 4,'Female', '', DEFAULT);


/*Course TABLE*/
CREATE TABLE vle_courses(
dbCourseID INT(5)  AUTO_INCREMENT,
dbCourseName VARCHAR(50) NOT NULL, 
dbCourseDescription VARCHAR(500),
dbCredits INT(4),
dbYears INT(2),
dbDegreeType VARCHAR(20),
PRIMARY KEY (dbCourseID)
);

INSERT INTO vle_courses (dbCourseID,dbCourseName,dbCourseDescription, dbCredits , dbYears, dbDegreeType)
VALUES (1050,'Computer Science', 'The Study of Computer Science, this course provides the fundemental knowledge of computing. List of subject areas: Coding, Web Development, Databases, Computer Architecture, Data Structures, Ethics and many more.', 120, 3, 'Graduate');
INSERT INTO vle_courses (dbCourseID,dbCourseName,dbCourseDescription, dbCredits , dbYears, dbDegreeType)
VALUES (1051,'Computer Security', 'The Study of Computer Security, this course provides the fundemental knowledge of computing security. List of subject areas: Secure Applications, Vulnerabilities, Exploits, PenTesting, Ethics and many more.', 120, 3, "Graduate");
INSERT INTO vle_courses (dbCourseID,dbCourseName,dbCourseDescription, dbCredits , dbYears, dbDegreeType)
VALUES (2050,'Bio-Medical Science', 'The Study of Bio-Medical Science, this course provides the fundemental knowledge of Medicine. List of subject areas: Human Anatomy, Cellular Biology, Medicines, Ethics and many more.', 120, 3, "Graduate");
INSERT INTO vle_courses (dbCourseID,dbCourseName,dbCourseDescription, dbCredits , dbYears, dbDegreeType)
VALUES (2052,'Chemistry', 'The Study of Chemistry, this course provides the fundemental knowledge of Chemistry. List of subject areas: Atoms, Molecules and many more.', 120, 3, "Graduate");


/*Modules TABLE*/
CREATE TABLE vle_modules(
dbModuleID INT(5)  AUTO_INCREMENT,
dbModuleTitle VARCHAR(50),
dbModuleDescription VARCHAR(500),
dbCredits INT(4),
dbCourseID INT(5),
PRIMARY KEY (dbModuleID)
);
INSERT INTO vle_modules (dbModuleID,dbModuleTitle,dbModuleDescription,dbCredits,dbCourseID)
VALUES (2080,'Functional programming', 'The functional programming module focuses on practical problem solving methods with the use of functions and how it can be intergrated into Object Oriented Programming', 30, 1050);
INSERT INTO vle_modules (dbModuleID,dbModuleTitle,dbModuleDescription,dbCredits,dbCourseID)
VALUES (2090,'Artificial Inteligence', 'This module introduces foundational concepts of AI and knowledge based systems', 30, 1050);
INSERT INTO vle_modules (dbModuleID,dbModuleTitle,dbModuleDescription,dbCredits,dbCourseID)
VALUES (2095,'Web Development and Design', 'This Module focuses on the the fundamentals of Web development such as HTML5, CSS3 and basic JavaScript. Along side learning about information architecure and how people interact with websites.', 30, 1050);
INSERT INTO vle_modules (dbModuleID,dbModuleTitle,dbModuleDescription,dbCredits,dbCourseID)
VALUES (2100,'Database Systems', 'Introduction to SQL, involving practical experience and understanding of relational algebra.', 30, 1050);

/*0, 1 or Many relationship */

/*Timetable TABLE*/
CREATE TABLE vle_allocation(
dbTeaches BOOLEAN,
dbUniqueID INT(9),
dbCourseID INT(5),
dbModuleID INT(5),
PRIMARY KEY (dbUniqueID, dbCourseID, dbModuleID)
);
/*First student*/
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1027,1050,2080);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1027,1050,2090);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1027,1050,2095);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1027,1050,2100);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1028,1050,2080);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1028,1050,2090);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1028,1050,2095);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1028,1050,2100);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1029,1050,2080);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1029,1050,2090);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1029,1050,2095);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1029,1050,2100);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1030,1050,2080);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1030,1050,2090);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1030,1050,2095);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1030,1050,2100);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1031,1050,2080);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1031,1050,2090);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1031,1050,2095);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (0,1031,1050,2100);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (1,1032,1050,2080);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (1,1032,1050,2090);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (1,1032,1050,2095);
INSERT INTO vle_allocation(dbTeaches, dbUniqueID,dbCourseID,dbModuleID)
VALUES (1,1032,1050,2100);





/*Timetable TABLE*/
CREATE TABLE vle_timetables(
dbTimeTableID INT(5)  AUTO_INCREMENT,
dbtablepdf BLOB,
dbCourseID INT(5) NOT NULL,
PRIMARY KEY (dbTimeTableID)	
);


/*Announcement TABLE*/
CREATE TABLE vle_announcements(
dbAnnouncementID INT(5)  AUTO_INCREMENT,
dbAnnouncementTitle VARCHAR(50),
dbCourseID INT(5),
dbModuleID INT(5),
dbDescription VARCHAR(500),
dbDate DATE,
PRIMARY KEY (dbAnnouncementID)

);


/*Modules TABLE*/
CREATE TABLE vle_module_allocation(
dbModuleID INT(5),
dbCourseID INT(5),
PRIMARY KEY (dbModuleID,dbCourseID)

);


/*Classes TABLE*/
CREATE TABLE vle_classes(
dbClassID INT(5)  AUTO_INCREMENT,
dbModuleID INT(5),
dbDate DATE,
dbDescAndWeek VARCHAR(50),
PRIMARY KEY (dbClassID)
);


/*Attendance TABLE*/
CREATE TABLE vle_attendance(
dbClassID INT(5),
dbUniqueID INT(9),
attended BOOLEAN,
PRIMARY KEY (dbClassID,dbUniqueID)

);


/*Submissions TABLE*/
CREATE TABLE vle_submissions(
dbSubmissionID INT(5),
dbFeedback VARCHAR(500),
dbDate DATE,
dbSubPdf BLOB,
dbUniqueID INT(9),
dbCourseWorkID INT(5),
PRIMARY KEY (dbSubmissionID)

);

/*Coursework TABLE*/
CREATE TABLE vle_coursework(
dbCourseWorkID INT(5)  AUTO_INCREMENT,
dbDescription VARCHAR(200),
dbPostDate DATE,
dbDealine DATE,
dbbrief BLOB,
dbModuleID INT(5),
PRIMARY KEY (dbCourseWorkID)
);

/* FOREIGN KEYS*/
ALTER TABLE vle_modules ADD FOREIGN KEY (dbCourseID) REFERENCES vle_courses(dbCourseID);
ALTER TABLE vle_allocation ADD FOREIGN KEY (dbUniqueID) REFERENCES vle_users(dbUniqueID);
ALTER TABLE vle_allocation ADD FOREIGN KEY (dbCourseID) REFERENCES vle_courses(dbCourseID);
ALTER TABLE vle_allocation ADD FOREIGN KEY (dbModuleID) REFERENCES vle_modules(dbModuleID);
ALTER TABLE vle_timetables ADD FOREIGN KEY (dbCourseID) REFERENCES vle_courses(dbCourseID);
ALTER TABLE vle_coursework ADD FOREIGN KEY (dbModuleID) REFERENCES vle_modules(dbModuleID);
ALTER TABLE vle_submissions ADD FOREIGN KEY (dbUniqueID) REFERENCES vle_users(dbUniqueID);
ALTER TABLE vle_submissions ADD FOREIGN KEY (dbCourseWorkID) REFERENCES vle_coursework(dbCourseWorkID);
ALTER TABLE vle_classes ADD FOREIGN KEY (dbModuleID) REFERENCES vle_modules(dbModuleID);
ALTER TABLE vle_module_allocation ADD FOREIGN KEY (dbModuleID) REFERENCES vle_modules(dbModuleID);
ALTER TABLE vle_module_allocation ADD FOREIGN KEY (dbCourseID) REFERENCES vle_courses(dbCourseID);
ALTER TABLE vle_announcements ADD FOREIGN KEY (dbCourseID) REFERENCES vle_courses(dbCourseID);
ALTER TABLE vle_announcements ADD FOREIGN KEY (dbModuleID) REFERENCES vle_modules(dbModuleID);
ALTER TABLE vle_attendance ADD FOREIGN KEY (dbClassID) REFERENCES vle_classes(dbClassID);
ALTER TABLE vle_attendance ADD FOREIGN KEY (dbUniqueID) REFERENCES vle_users(dbUniqueID);

/*Join QUERIES*/

/*Course Module User Master Query*/

SELECT z.dbUniqueID, a.dbFullName, z.dbCourseID, b.dbCourseName, z.dbModuleID,z.dbTeaches, c.dbModuleTitle
FROM vle_allocation z, vle_users a, vle_courses b , vle_modules c
WHERE z.dbUniqueID = a.dbUniqueID 
AND z.dbCourseID = b.dbCourseID 
AND z.dbModuleID = c.dbModuleID;

