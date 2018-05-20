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

    //Export attendance for meetings
    include_once("../admin/database.php");
    loggedIn();
    $editMeetingId = mysqli_real_escape_string($databaseConnect, $_GET['id']);

    $result = $databaseConnect->query("SELECT student_id FROM attendance WHERE meeting_id = $editMeetingId");
    if (!$result) die("Couldn't fetch records");
    $headers = array("Student ID", "Student Name");
    $fp = fopen('php://output', 'w');
    if ($fp && $result) {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="Meeting ' . $editMeetingId . ' Attendance.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');
        fputcsv($fp, $headers);
        while ($row = $result->fetch_array(MYSQLI_NUM)) {
            $studentId = $row['0'];
            $studentName = mysqli_fetch_array(mysqli_query($databaseConnect, "SELECT name FROM students WHERE student_id = $studentId LIMIT 1"));
            array_push($row, $studentName['0']);
            fputcsv($fp, array_values($row));
        }
        die;
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Download CSV</title>
    </head>
</html>
