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

    //Specific meeting information (public)
    include_once("../admin/database.php");
    loggedIn();
    if(!has_permission()) {
        header("Location: ./meetings.php");
    }
    if(has_permission() && isset($_POST['submit'])) {
        $checkFields = array('date', 'description');
        if(!array_diff($checkFields, array_keys($_POST))) {
            $editMeetingDate = mysqli_real_escape_string($databaseConnect, $_POST['date']);
            $editMeetingDescription = mysqli_real_escape_string($databaseConnect, $_POST['description']);
            $statement = $databaseConnect->prepare("INSERT INTO meetings (date, description) VALUES (?, ?)");
            $statement->bind_param('ss', $editMeetingDate, $editMeetingDescription);
            $statement->execute();
            header("Location: meetings.php");
        }
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Meeting Details</title>
        <link rel="stylesheet" type="text/css" href="./css/main.css">
        <link rel="stylesheet" type="text/css" href="./css/table.css">
    </head>
    <body>
        <div>
            <header>
                <h1>Meeting Details</h1>
                <?php nav_bar() ?>
            </header>
            <body>
                <form action="meetingadd.php" method="post">
                    <input type="text" name="date" style="font-size: 24px" placeholder="MONTH DAY, YEAR">
                    <textarea type="text" name="description" placeholder="Description"></textarea>
                    <input type="submit" name="submit" value="Submit">
                </form>
            </body>
        </div>
    </body>
</html>
