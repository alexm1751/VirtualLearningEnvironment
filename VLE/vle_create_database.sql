
/*
CREATE DATABASE vle;
*/
/*DROP TABLE STATEMENTS*/
DROP TABLE IF EXISTS vle_allocation;
DROP TABLE IF EXISTS vle_learning;
DROP TABLE IF EXISTS vle_module_allocation;
DROP TABLE IF EXISTS vle_submissions;
DROP TABLE IF EXISTS vle_attendance;
DROP TABLE IF EXISTS vle_classes;
DROP TABLE IF EXISTS vle_coursework;
DROP TABLE IF EXISTS vle_announcements;
DROP TABLE IF EXISTS vle_timetables;
DROP TABLE IF EXISTS vle_modules;
DROP TABLE IF EXISTS vle_courses;
DROP TABLE IF EXISTS vle_users;

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
dbregistration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (dbUniqueID)
);

ALTER TABLE vle_users ADD UNIQUE (dbEmail);

ALTER TABLE vle_users AUTO_INCREMENT=1025;

/*Dummy entries*/
INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank,dbGender, dbRecover_Hash,dbregistration_date)
VALUES ('','Dummy', 'Dummy One',"The Moon",0123456789, 0,'', '', DEFAULT);
INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank,dbGender, dbRecover_Hash,dbregistration_date)
VALUES ('','Dummy2', 'Dummy Two',"Jupiter",0123456789, 0, '','', DEFAULT);

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


/*Teacher*/
INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank,dbGender, dbRecover_Hash,dbregistration_date)
VALUES ('$2a$12$iqaGmuRer0trjLfa8Y1Ye.k32fAwS7qG13FXqCUXQIJGV4CT1Z.my','ben@mail.com','Ben Palmer',"Leicester",012345678901, 2,'Male', '', DEFAULT);

/*Admin*/
INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank,dbGender, dbRecover_Hash,dbregistration_date)
VALUES ('$2a$12$iqaGmuRer0trjLfa8Y1Ye.k32fAwS7qG13FXqCUXQIJGV4CT1Z.my','andrew@mail.com', 'Andrew Sterling',"Leicester",012345678901, 3, 'Male','', DEFAULT);

/*Super Admin*/
INSERT INTO vle_users (dbpass,dbEmail,dbFullName, dbAddress,dbNumber,dbRank,dbGender, dbRecover_Hash,dbregistration_date)
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
VALUES (1050,'Computer Science', 'The Study of Computer Science, this course provides the fundamental knowledge of computing. List of subject areas: Coding, Web Development, Databases, Computer Architecture, Data Structures, Ethics and many more.', 120, 3, 'Graduate');
INSERT INTO vle_courses (dbCourseID,dbCourseName,dbCourseDescription, dbCredits , dbYears, dbDegreeType)
VALUES (1051,'Computer Security', 'The Study of Computer Security, this course provides the fundamental knowledge of computing security. List of subject areas: Secure Applications, Vulnerabilities, Exploits, PenTesting, Ethics and many more.', 120, 3, "Graduate");
INSERT INTO vle_courses (dbCourseID,dbCourseName,dbCourseDescription, dbCredits , dbYears, dbDegreeType)
VALUES (2050,'Bio-Medical Science', 'The Study of Bio-Medical Science, this course provides the fundamental knowledge of Medicine. List of subject areas: Human Anatomy, Cellular Biology, Medicines, Ethics and many more.', 120, 3, "Graduate");
INSERT INTO vle_courses (dbCourseID,dbCourseName,dbCourseDescription, dbCredits , dbYears, dbDegreeType)
VALUES (2052,'Chemistry', 'The Study of Chemistry, this course provides the fundamental knowledge of Chemistry. List of subject areas: Atoms, Molecules and many more.', 120, 3, "Graduate");


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
VALUES (2080,'Functional Programming', 'The functional programming module focuses on practical problem solving methods with the use of functions and how it can be integrated into Object Oriented Programming', 30, 1050);
INSERT INTO vle_modules (dbModuleID,dbModuleTitle,dbModuleDescription,dbCredits,dbCourseID)
VALUES (2090,'Artificial Intelligence', 'This module introduces foundational concepts of AI and knowledge based systems', 30, 1050);
INSERT INTO vle_modules (dbModuleID,dbModuleTitle,dbModuleDescription,dbCredits,dbCourseID)
VALUES (2095,'Web Development and Design', 'This Module focuses on the the fundamentals of Web development such as HTML5, CSS3 and basic JavaScript. Along side learning about information architecture and how people interact with websites.', 30, 1050);
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
dbtablepdf VARCHAR(200),
dbCourseID INT(5) NOT NULL,
PRIMARY KEY (dbTimeTableID)	
);
INSERT INTO vle_timetables(dbTimeTableID, dbtablepdf,dbCourseID)
VALUES (300,'/FinalYearProject/VLE/app/assets/PDF/vle_timetable.pdf',1050);


/*Announcement TABLE*/
CREATE TABLE vle_announcements(
dbAnnouncementID INT(5)  AUTO_INCREMENT,
dbAnnouncementTitle VARCHAR(50),
dbCourseID INT(5),
dbModuleID INT(5),
dbDescription VARCHAR(500),
dbDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (dbAnnouncementID)
);
INSERT INTO vle_announcements(dbAnnouncementID,dbAnnouncementTitle,dbCourseID,dbModuleID,dbDescription,dbDate)
VALUES (105,'Deadline Extensions!', 1050, 2080, 'We will not be permitting any extensions for the up and coming deadline for the Heap Application. For legitimate reasons we are willing to help. Otherwise the deadline remains the same. ~Ben', default);
INSERT INTO vle_announcements(dbAnnouncementID,dbAnnouncementTitle,dbCourseID,dbModuleID,dbDescription,dbDate)
VALUES (106,'Guest Speakers!', 1050, 2080, 'There will be guest lectures for Functional Programming in April during Easter. I employ you to make sure you are available during this time. The speakers present have a lot of real world experience and there have been employment opportunities in the past. See you there. ~Ben', default);
INSERT INTO vle_announcements(dbAnnouncementID,dbAnnouncementTitle,dbCourseID,dbModuleID,dbDescription,dbDate)
VALUES (107,'Coursework Marks Now Up', 1050, 2080, 'I have now uploaded all marks for the Christmas coursework, beware these marks are unmoderated and are subject to change. If you would like some more detailed feedback please email me or visit my office.  ~Ben', default);
INSERT INTO vle_announcements(dbAnnouncementID,dbAnnouncementTitle,dbCourseID,dbModuleID,dbDescription,dbDate)
VALUES (108,'Employer Talks', 1050, NULL, 'There will be several Computer Science Talks being held this week from big Employers for placements. Please come a long and try and talk to the teams. This is essential to secure a placement.  ~Ben', default);
INSERT INTO vle_announcements(dbAnnouncementID,dbAnnouncementTitle,dbCourseID,dbModuleID,dbDescription,dbDate)
VALUES (109,'Security Access', 1050, NULL, 'All Computer Science students must report to security to have access granted to their cards for the new computer labs on floors 10 and 11 of the main computer building. ~Ben', default);
INSERT INTO vle_announcements(dbAnnouncementID,dbAnnouncementTitle,dbCourseID,dbModuleID,dbDescription,dbDate)
VALUES (110,'Database Assignemnt Questions', 1050, 2100, 'I have had an influx of emails regarding the Database Assignment, because of this I will be using next weeks lecture to answer all questions as there are too many people asking the same questions. ~Ben', default);
INSERT INTO vle_announcements(dbAnnouncementID,dbAnnouncementTitle,dbCourseID,dbModuleID,dbDescription,dbDate)
VALUES (111,'Web Development Resources', 1050, 2095, 'Get ahead and enhance your Web Development skills, the university has free on-line resources for HTML5, CSS3 and JavaScript courses. ~Ben', default);
INSERT INTO vle_announcements(dbAnnouncementID,dbAnnouncementTitle,dbCourseID,dbModuleID,dbDescription,dbDate)
VALUES (112,'IBM A.I talk', 1050, 2090, 'IBM will be doing a talk on A.I this weekend in the main Computer Science building please don\'t miss it. This is an ideal time to talk about placements. ~Ben', default);
INSERT INTO vle_announcements(dbAnnouncementID,dbAnnouncementTitle,dbCourseID,dbModuleID,dbDescription,dbDate)
VALUES (113,'Robotics Labs', 1050, 2090, 'There are now more robotics labs on floors 4 and 5. I am hoping we have these till the end of the semester but please use them whilst we have them. ~Ben', default);
INSERT INTO vle_announcements(dbAnnouncementID,dbAnnouncementTitle,dbCourseID,dbModuleID,dbDescription,dbDate)
VALUES (114,'Project Ideas Now Up!', 1050, 2090, 'Project Ideas have now been published. These are on a first come first serve basis and I advise you to present your own project idea if you do not like the look of any that have been uploaded. ~Ben', default);
INSERT INTO vle_announcements(dbAnnouncementID,dbAnnouncementTitle,dbCourseID,dbModuleID,dbDescription,dbDate)
VALUES (115,'Ilness in Staff', 1050, 2095, 'Due to illness in some practical staff, labs next week will not be mandatory but I suggest that you still make use of the free labs with the up and comming assignments. I will be making an effort to be present in my office and near those class rooms for support if needed. ~Ben', default);
INSERT INTO vle_announcements(dbAnnouncementID,dbAnnouncementTitle,dbCourseID,dbModuleID,dbDescription,dbDate)
VALUES (116,'Third Party Software', 1050, 2095, 'I have had more questions about using third party software such as Adobe Muse and DreamWeaver to create the sites for your projects. This is not acceptable and doing so will result in a failure. The brief clearly states to hand code all assignment material. ~Ben', default);
INSERT INTO vle_announcements(dbAnnouncementID,dbAnnouncementTitle,dbCourseID,dbModuleID,dbDescription,dbDate)
VALUES (117,'NoSQL Module final year students', 1050, 2100, 'There will soon be a survey for those who are interested in a NoSQL module next semester. If I receive enough feedback for this I will consider rolling the program and integrating this for final year students. ~Ben', default);
INSERT INTO vle_announcements(dbAnnouncementID,dbAnnouncementTitle,dbCourseID,dbModuleID,dbDescription,dbDate)
VALUES (118,'Course Trip', 1050, NULL, 'For any students interested in a course related trip there will be a Jet setter chance to go to Germany and work with BMW\'s development team. From previous years experience this has lead to possible placement and post grad success. ~Ben', default);


/*Modules TABLE*/
/*CREATE TABLE vle_module_allocation(
dbModuleID INT(5),
dbCourseID INT(5),
PRIMARY KEY (dbModuleID,dbCourseID)

);*/


/*Classes TABLE*/
CREATE TABLE vle_classes(
dbClassID INT(5)  AUTO_INCREMENT,
dbModuleID INT(5),
dbDate datetime,
dbDescAndWeek VARCHAR(50),
PRIMARY KEY (dbClassID)
);

INSERT INTO vle_classes(dbClassID,dbModuleID,dbDate,dbDescAndWeek)
VALUES (20, 2100, '2017-11-15', 'Course Integration');
INSERT INTO vle_classes(dbClassID,dbModuleID,dbDate,dbDescAndWeek)
VALUES (21, 2100, '2017-11-20', 'DB Design pt1');
INSERT INTO vle_classes(dbClassID,dbModuleID,dbDate,dbDescAndWeek)
VALUES (22, 2100, '2017-11-22', 'NoSQL Databases');
INSERT INTO vle_classes(dbClassID,dbModuleID,dbDate,dbDescAndWeek)
VALUES (23, 2100, '2017-11-30', 'Primary and Foreign Keys');
INSERT INTO vle_classes(dbClassID,dbModuleID,dbDate,dbDescAndWeek)
VALUES (24, 2100, '2017-12-5', 'Test');

INSERT INTO vle_classes(dbClassID,dbModuleID,dbDate,dbDescAndWeek)
VALUES (75, 2080, '2018-04-11', 'Functional Programing Practical Data Structures Part1');

INSERT INTO vle_classes(dbClassID,dbModuleID,dbDate,dbDescAndWeek)
VALUES (76, 2080, '2018-04-12', 'Functional Programing Practical Data Structures Part2');

INSERT INTO vle_classes(dbClassID,dbModuleID,dbDate,dbDescAndWeek)
VALUES (77, 2090, '2018-04-11', 'A.I Robots Section 40');

INSERT INTO vle_classes(dbClassID,dbModuleID,dbDate,dbDescAndWeek)
VALUES (78, 2090, '2018-04-13', 'A.I Robots Section 41');

INSERT INTO vle_classes(dbClassID,dbModuleID,dbDate,dbDescAndWeek)
VALUES (79, 2095, '2018-04-14', 'Web Development responsive design pt1 ');

INSERT INTO vle_classes(dbClassID,dbModuleID,dbDate,dbDescAndWeek)
VALUES (80, 2095, '2018-04-15', 'Web Development responsive design pt2 ');

INSERT INTO vle_classes(dbClassID,dbModuleID,dbDate,dbDescAndWeek)
VALUES (81, 2100, '2018-04-13', 'Database Design Section 5');

INSERT INTO vle_classes(dbClassID,dbModuleID,dbDate,dbDescAndWeek)
VALUES (82, 2100, '2018-04-14', 'Table types section 1');

/*Attendance TABLE*/
CREATE TABLE vle_attendance(
dbClassID INT(5),
dbUniqueID INT(9),
dbAttended BOOLEAN,
PRIMARY KEY (dbClassID,dbUniqueID)

);

INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (20, 1027, 0);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (20, 1028, 1);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (20, 1029, 1);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (20, 1030, 0);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (20, 1031, 1);

INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (21, 1027, 1);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (21, 1028, 1);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (21, 1029, 1);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (21, 1030, 1);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (21, 1031, 1);

INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (22, 1027, 1);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (22, 1028, 0);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (22, 1029, 1);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (22, 1030, 0);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (22, 1031, 1);

INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (23, 1027, 1);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (23, 1028, 1);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (23, 1029, 0);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (23, 1030, 1);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (23, 1031, 0);

INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (24, 1027, 1);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (24, 1028, 0);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (24, 1029, 0);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (24, 1030, 1);
INSERT INTO vle_attendance(dbClassID,dbUniqueID,dbAttended)
VALUES (24, 1031, 1);

/*Coursework TABLE*/
CREATE TABLE vle_coursework(
dbCourseWorkID INT(5)  AUTO_INCREMENT,
dbDescription VARCHAR(200),
dbPostDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
dbDeadline TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
dbbrief VARCHAR(200),
dbModuleID INT(5),
PRIMARY KEY (dbCourseWorkID)
);

INSERT INTO vle_coursework(dbCourseWorkID,dbDescription,dbPostDate,dbDeadline,dbbrief,dbModuleID)
VALUES (110, 'Simple pdf Assignment', default, '2018-04-12 23:59:59','/FinalYearProject/VLE/app/assets/PDF/Brief1.pdf', 2080);

INSERT INTO vle_coursework(dbCourseWorkID,dbDescription,dbPostDate,dbDeadline,dbbrief,dbModuleID)
VALUES (111, 'Simple pdf Assignment', default, '2018-04-12 23:59:59','/FinalYearProject/VLE/app/assets/PDF/Brief2.pdf', 2090);

INSERT INTO vle_coursework(dbCourseWorkID,dbDescription,dbPostDate,dbDeadline,dbbrief,dbModuleID)
VALUES (112, 'Simple pdf Assignment', default, '2018-04-12 23:59:59','/FinalYearProject/VLE/app/assets/PDF/Brief3.pdf', 2095);

/*Submissions TABLE*/
CREATE TABLE vle_submissions(
dbSubmissionID INT(5),
dbFeedback VARCHAR(500),
dbDate TIMESTAMP,
dbSubPdf VARCHAR(200),
dbMarked BOOLEAN,
dbUniqueID INT(9),
dbCourseWorkID INT(5),
PRIMARY KEY (dbSubmissionID)
);

INSERT INTO vle_submissions(dbSubmissionID,dbFeedback,dbDate,dbSubPdf,dbMarked, dbUniqueID,dbCourseWorkID)
VALUES (701, '', default, '/FinalYearProject/VLE/app/assets/PDF/Assignment1.pdf', 0,1027, 110);

INSERT INTO vle_submissions(dbSubmissionID,dbFeedback,dbDate,dbSubPdf,dbMarked, dbUniqueID,dbCourseWorkID)
VALUES (703, '', default, '/FinalYearProject/VLE/app/assets/PDF/Assignment2.pdf', 0,1027, 111);

INSERT INTO vle_submissions(dbSubmissionID,dbFeedback,dbDate,dbSubPdf,dbMarked, dbUniqueID,dbCourseWorkID)
VALUES (704, '', default, '/FinalYearProject/VLE/app/assets/PDF/Assignment2.pdf', 0,1027, 112);



CREATE TABLE vle_learning(
dbResID INT(5) AUTO_INCREMENT,
dbPractical BOOLEAN,
dbTheory BOOLEAN,
dbLearningTitle VARCHAR(50),
dbDescription VARCHAR(200),
dbPDF VARCHAR(200),
dbDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
dbModuleID INT(5),
PRIMARY KEY (dbResID)
);



INSERT INTO vle_learning(dbResID,dbPractical,dbTheory,dbLearningTitle,dbDescription,dbPDF,dbDate,dbModuleID)
VALUES (1001, 0, 1, 'Database Design Documents', 'Further reading is recommended. Please understand the core conecpts before moving on.','/FinalYearProject/VLE/app/assets/PDF/LearningMaterial1.pdf', default, 2100);

INSERT INTO vle_learning(dbResID,dbPractical,dbTheory,dbLearningTitle,dbDescription,dbPDF,dbDate,dbModuleID)
VALUES (1002, 0, 1, 'Data Structures Knowledge', 'Key information on how data is stored in a data structure.','/FinalYearProject/VLE/app/assets/PDF/LearningMaterial2.pdf', default, 2080);

INSERT INTO vle_learning(dbResID,dbPractical,dbTheory,dbLearningTitle,dbDescription,dbPDF,dbDate,dbModuleID)
VALUES (1003, 1, 0, 'Creating Tables in MySQL', 'Basic Setup and query on a small database.','/FinalYearProject/VLE/app/assets/PDF/PracticalWork1.pdf', default, 2100);

INSERT INTO vle_learning(dbResID,dbPractical,dbTheory,dbLearningTitle,dbDescription,dbPDF,dbDate,dbModuleID)
VALUES (1004, 1, 0, 'Mat lab Content', 'Carrying on from last week. use the content to help you through this week','/FinalYearProject/VLE/app/assets/PDF/PracticalWork2.pdf', default, 2090);


/* FOREIGN KEYS*/
ALTER TABLE vle_modules ADD FOREIGN KEY (dbCourseID) REFERENCES vle_courses(dbCourseID)  ON DELETE CASCADE;
ALTER TABLE vle_allocation ADD FOREIGN KEY (dbUniqueID) REFERENCES vle_users(dbUniqueID)  ON DELETE CASCADE;
ALTER TABLE vle_allocation ADD FOREIGN KEY (dbCourseID) REFERENCES vle_courses(dbCourseID)  ON DELETE CASCADE;
ALTER TABLE vle_allocation ADD FOREIGN KEY (dbModuleID) REFERENCES vle_modules(dbModuleID)  ON DELETE CASCADE;
ALTER TABLE vle_timetables ADD FOREIGN KEY (dbCourseID) REFERENCES vle_courses(dbCourseID)  ON DELETE CASCADE;
ALTER TABLE vle_coursework ADD FOREIGN KEY (dbModuleID) REFERENCES vle_modules(dbModuleID)  ON DELETE CASCADE;
ALTER TABLE vle_submissions ADD FOREIGN KEY (dbUniqueID) REFERENCES vle_users(dbUniqueID)  ON DELETE CASCADE;
ALTER TABLE vle_submissions ADD FOREIGN KEY (dbCourseWorkID) REFERENCES vle_coursework(dbCourseWorkID)  ON DELETE CASCADE;
ALTER TABLE vle_classes ADD FOREIGN KEY (dbModuleID) REFERENCES vle_modules(dbModuleID)  ON DELETE CASCADE;
ALTER TABLE vle_announcements ADD FOREIGN KEY (dbCourseID) REFERENCES vle_courses(dbCourseID)  ON DELETE CASCADE;
ALTER TABLE vle_announcements ADD FOREIGN KEY (dbModuleID) REFERENCES vle_modules(dbModuleID)  ON DELETE CASCADE;
ALTER TABLE vle_attendance ADD FOREIGN KEY (dbClassID) REFERENCES vle_classes(dbClassID)  ON DELETE CASCADE;
ALTER TABLE vle_attendance ADD FOREIGN KEY (dbUniqueID) REFERENCES vle_users(dbUniqueID)  ON DELETE CASCADE;
ALTER TABLE vle_learning ADD FOREIGN KEY (dbModuleID) REFERENCES vle_modules(dbModuleID)  ON DELETE CASCADE;
