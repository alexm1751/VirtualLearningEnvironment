
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
dbNumber INT(13) NOT NULL,
dbRank INT(1) NOT NULL,
dbRecover_Hash VARCHAR(70),
dbregistration_date TIMESTAMP,
PRIMARY KEY (dbUniqueID)
);

ALTER TABLE vle_users AUTO_INCREMENT=1025;


INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank, dbRecover_Hash,dbregistration_date)
VALUES ('$2a$12$iqaGmuRer0trjLfa8Y1Ye.k32fAwS7qG13FXqCUXQIJGV4CT1Z.my','alex@mail.com', 'Alex Mason',"Leicester",012345678901, 1, '', DEFAULT);
INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank, dbRecover_Hash,dbregistration_date)
VALUES ('$2a$12$iqaGmuRer0trjLfa8Y1Ye.k32fAwS7qG13FXqCUXQIJGV4CT1Z.my','alex@mail.co.uk','Alex Mason',"Leicester",012345678901, 2, '', DEFAULT);
INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank, dbRecover_Hash,dbregistration_date)
VALUES ('$2a$12$iqaGmuRer0trjLfa8Y1Ye.k32fAwS7qG13FXqCUXQIJGV4CT1Z.my','alex@mail.pl', 'Alex Mason',"Leicester",012345678901, 3, '', DEFAULT);


/*Course TABLE*/
CREATE TABLE vle_courses(
dbCourseID INT(5)  AUTO_INCREMENT,
dbCourseName VARCHAR(50) NOT NULL, 
dbCourseDescription VARCHAR(500),
dbCredits INT(4),
dbYears INT(2),
dbModuleAmount INT(2),
PRIMARY KEY (dbCourseID)
);


/*Modules TABLE*/
CREATE TABLE vle_modules(
dbModuleID INT(5)  AUTO_INCREMENT,
dbModuleTitle VARCHAR(50),
dbModuleDescription VARCHAR(500),
dbCredits INT(4),
dbCourseID INT(5),
PRIMARY KEY (dbModuleID)
);


/*0, 1 or Many relationship */

/*Timetable TABLE*/
CREATE TABLE vle_allocation(
dbTeaches BOOLEAN,
dbUniqueID INT(9),
dbCourseID INT(5) ,
PRIMARY KEY (dbUniqueID, dbCourseID)
);


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


ALTER TABLE vle_modules ADD FOREIGN KEY (dbCourseID) REFERENCES vle_courses(dbCourseID);
ALTER TABLE vle_allocation ADD FOREIGN KEY (dbUniqueID) REFERENCES vle_users(dbUniqueID);
ALTER TABLE vle_allocation ADD FOREIGN KEY (dbCourseID) REFERENCES vle_courses(dbCourseID);
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

