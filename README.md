# Virtual Learning Environment

Computer Science Development Final Year Project:

This is a Secure Web Application developed on my own during my final year of university. It uses the Slim 3 Micro Framework for the back end and Twig templates for the front end. Additionally, the user of the [Respect Validation](https://github.com/Respect/Validation) Library is used within the middle ware of the application.

The current implementation holds a fully functioning virtual learning environment for 4 different users of the system:

* Students
* Teachers
* Administrators
* Super Administrators 

Each Actor has its own unique home screen after logging in with respective login details.

---

## List of Use Cases:

### All Users

* Login
* Logout
* Update Details
* Reset Password

---

### Students

* View Timetables
* View Attendance
* Read Coursework
* Submit Coursework
* View Announcements
* View Learning Materials
* Upload/Download Documents

---

### Teachers

* View Classes
* Record Attendance
* Reset Attendance
* Post/Remove/Edit Announcements
* Post/Remove/Edit/Mark Coursework
* Post/Remove/Edit Learning Materials
* Upload/Download Documents

---

### Administrator

* Create/Remove/Edit/View Users
* Create/Remove/Edit/View Classes
* Create/Remove/Edit/View Timetables
* Create/Remove/Edit/View Courses
* Create/Remove/Edit/View Modules
* Create/Remove/Edit/View User Education Allocation

---

### Super Administrator 

* Can do all Administrator roles
* Create/Remove/Edit/View Administrators

---

