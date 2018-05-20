# CSF Check-in

Designed for the MVHS California Scholarship Federation (CSF) chapter #1399. CSF Check-in allows for a streamlined check-in process 
with barcode scanners (setup to work with 9-digit student IDs) or manual input. Furthermore it allows 
officers to easily manage meeting plans/information. Members without officer access can use their ID to check their
attendance/term membership records and view meeting info.

## Usage

CSF Check-in tracks students using their district issued 9-digit student ID. Before each meeting each student's ID is scanned into an 
attendance page which records their attendance for that specific meeting. If a student wishes to view their 
attendance or term membership records they can do so semi-anonymously by using their student ID. Officers can view all students 
and see their attendance and term membership records. Officers are free to add, edit, or remove meetings/meeting info. Students can view 
meeting info on a public facing meetings overview page.

## Site Index

**attendance.php** - *Public;* Enables student-ID lookup (returns attendance/term membership records and meeting dates).

**attendanceadd.php** - *Private;* Adds a student to the attendance records for a specific meeting.

**attendanceremove.php** - *Private, tiered, redirect;* Removes a student from attendance records for a specific meeting.

**database.php** - *Private, include;* Resides outside of the root directory of the webserver. Contains database connection 
variable and various functions that are shared amongst pages.

**index.php** - *Public, redirect;* Redirects to either attendance.php (default) or login.php (if user is already logged in).

**login.php** - *Public;* Login page for officers.

**logout.php** - *Public, redirect;* Destroys session (only matters if you're logged in).

**meeting.php** - *Public;* Meeting info for a specific meeting.

**meetingadd.php** - *Private, tiered;* Adds a meeting.

**meetingedit.php** - *Private, semi-tiered;* Allows officers to edit the date/description of a meeting, view student attendance records for that meeting, links to student check-in, and enables removal of students from meeting attendance records for that meeting (tiered).

**meetingremove.php** - *Private, tiered, redirect;* Deletes a meeting.

**meetings.php** - *Private, semi-tiered;* Meetings overview for officers (landing page). Links to meeting edit pages, meeting removal pages (tiered), and meeting addition page (tiered).

**overview.php** - *Public;* Meeting overview for students.

**studentadd.php** - *Private, tiered;* Adds a student.

**studentedit.php** - *Private, tiered;* Edits a student.

**studentremove.php** - *Private, tiered, redirect;* Removes a student.

**students.php** - *Private, semi-tiered;* Students overview for officers. Displays meeting attendance, term membership (tiered), grade level, name, student-ID, and links to add/edit/remove pages (tiered).

**useradd.php** - *Private, tiered;* Adds a user.

**useredit.php** - *Private, tiered;* Edits a user.

**userremove.php** - *Private, tiered, redirect;* Removes a user.

**users.php** - *Private, semi-tiered;* Users overview. Displays name, username, access level, and links to add/edit/remove pages (tiered).

## Table Structure

### Attendance
| id       | meeting_id                     | student_id          | timestamp            |
| :------- |:------------------------------ | :------------------ | :------------------- |
| Auto-Inc | Points to row in Meeting Table | 9-Digit Student ID  | Created on insertion |

### Meetings
| id       | date                        | description |
| :------- |:--------------------------- | :---------- |
| Auto-Inc | String formatted MM DD, YY  | String      |

### Students
| id       | name   | student_id          | grade       | terms                            |
| :------- |:------ | :------------------ | :---------- | :------------------------------- |
| Auto-Inc | String | 9-Digit Student ID  | Grade Level | Number of terms as a full member |

### Users
| id       | username   | password             | name   | access_level             |
| :------- |:---------- | :------------------- | :----- | :----------------------- |
| Auto-Inc | String     | String; uses bcrypt  | String | String, permission level |

## Access Levels
Currently those with access levels "developer" or "advisor" have access to all resources. Resources that require specific privileges
make a call to the has_permissions(); function which resides in admin/database.php. If a specific resource needs to allow for another
access level simply add it to an array then pass it into the has_permissions(); method. 
