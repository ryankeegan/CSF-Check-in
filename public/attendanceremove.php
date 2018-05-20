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

    //Overview for meetings
    include_once("../admin/database.php");
    loggedIn();
    $attendanceId = mysqli_real_escape_string($databaseConnect, $_GET['id']);
    if(has_permission() && isset($attendanceId)) {
        $statement = $databaseConnect->prepare("SELECT meeting_id FROM attendance WHERE id = ? LIMIT 1");
        $statement->bind_param('s', $attendanceId);
        $statement->execute();
        $row = $statement->get_result()->fetch_assoc();
        $editMeetingId = $row['meeting_id'];
        $statement = $databaseConnect->prepare("DELETE FROM attendance WHERE id=?");
        $statement-> bind_param("s", $attendanceId);
        $statement->execute();
        header("Location: meetingedit.php?id=$editMeetingId");
    }
    header("Location: meetings.php");
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Attendance Remove</title>
    </head>
    <body>
        <p>
            <a href='meetings.php' target="_top">Click here</a> if you are not automatically redirected.
        </p>
    </body>
</html>