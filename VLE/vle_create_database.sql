SET linesize 5000;

CREATE DATABASE vle;

/*DROP TABLE STATEMENTS*/

DROP TABLE vle_users;
DROP TABLE vle_courses;
DROP TABLE vle_timetables;
DROP TABLE vle_announcements;
DROP TABLE vle_modules;
DROP TABLE vle_classes;
DROP TABLE vle_attendance;
DROP TABLE vle_submissions;
DROP TABLE vle_coursework;

subject/teacher table?


/*CREATE TABLE STATEMENTS*/


/*USER TABLE*/
CREATE TABLE vle_users(
dbUniqueID				Number(9) NOT NULL,
dbpass					VARCHAR2(50) NOT NULL,
dbEmail					VARCHAR2(50) NOT NULL,
dbFullName				VARCHAR2(100) NOT NULL,
dbAuthority				Number(1) NOT NULL,
dbregistration_date		datetime,
CONSTRAINT vle_users_pk PRIMARY KEY (dbUniqueID)
);


/*Course TABLE*/
CREATE TABLE vle_courses(
dbCourseID				VARCHAR2(5), NOT NULL,
dbCourseName			VARCHAR2(50) NOT NULL, 
dbCredits				Number(4),
dbYears					Number(2),
dbModuleAmount			Number(2),
dbLecuturer?
);

/*Timetable TABLE*/
CREATE TABLE vle_allocation(
dbUniqueID				Number(9),
dbCourseID				VARCHAR2(5),
);

/*Timetable TABLE*/
CREATE TABLE vle_timetables(
dbtablepdf					BLOB,
dbCourseID				VARCHAR2(5),
dbYears 				VARCHAR2(15),		
);


/*Announcement TABLE*/
CREATE TABLE vle_announcements(
dbAnnouncementTitle
dbCourseID
dbModuleID
dbDescription
dbDate  
);


/*Modules TABLE*/
CREATE TABLE vle_modules(
dbModuleID
dbModuleTitle
dbModuleDescription
dbCourseID
);


/*Classes TABLE*/
CREATE TABLE vle_classes(
dbClassID
dbModuleID
dbDate
dbDescAndWeek
);


/*Attendance TABLE*/
CREATE TABLE vle_attendance(
dbClassID
dbUniqueID

);


/*Submissions TABLE*/
CREATE TABLE vle_submissions(

);


/*Coursework TABLE*/
CREATE TABLE vle_coursework(

);

