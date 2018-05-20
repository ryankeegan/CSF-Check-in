<?php
/* CSF Check-in - CSF check-in, meeting management, and record keeping site.
Copyright (C) 2017-2018 Ryan Keegan
	
This program is free software; you can redistribute it and/or modify it
under the terms of the GNU General Public License as published by the
Free Software Foundation; either version 3, or (at your option) any
later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; see the file LICENSE.  If not see
<http://www.gnu.org/licenses/>.  */

    //Assists with term migration
    include_once("../admin/database.php");
    loggedIn();
    if(!has_permission()) {
        header("Location: ./meetings.php");
    }

    ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/main.css">
        <meta charset="utf-8">
    </head>
    <body>
        <header>
	    <h1>Term Migration</h1>
	    <?php nav_bar() ?>
	</header>
	<a href="qualify.php">Download</a> qualifying members
	<br>
	<a style="color: grey">Download</a> attendance records for all meetings
	<br>
	<br>
	<input disabled="true" type="button" value="Clear Students" style="color: red"></input>
	<br>
	<input disabled="true" type="button" value="Clear Meetings" style="color: red"></input>
	<br>
	<input disabled="true" type="button" value="Clear Officer Accounts" style="color: red"></input>
	<br>
	<input disabled="true" type="button" value="Clear Attendance Records" style="color: red"></input>
    </body>
</html>
