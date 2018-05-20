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

    //Check-in students for meeting attendance
    include_once("../admin/database.php");
    loggedIn();
    $meetingId = mysqli_real_escape_string($databaseConnect, $_GET['id']);
    $statement = $databaseConnect->prepare("SELECT date FROM meetings WHERE id = ?");
    $statement->bind_param('s', $meetingId);
    $statement->execute();
    $meetingDate = $statement->get_result()->fetch_assoc();

    if(isset($_POST['student_id'])) {
        $studentStudentId = mysqli_real_escape_string($databaseConnect, strip_tags($_POST['student_id']));
        $statement = $databaseConnect->prepare("SELECT id FROM attendance WHERE student_id = ? AND meeting_id = ?");
        $statement->bind_param('ss', $studentStudentId, $meetingId);
        $statement->execute();
        $duplicate = $statement->get_result()->fetch_array();
        
        $statement = $databaseConnect->prepare("SELECT id FROM students WHERE student_id = ?");
        $statement->bind_param('s', $studentStudentId);
        $statement->execute();
        $studentExists = $statement->get_result()->fetch_array();
        
        if(empty($duplicate) && !empty($studentExists)) {
            $statement = $databaseConnect->prepare("INSERT INTO attendance (meeting_id, student_id) VALUES (?, ?)");
            $statement->bind_param("ss", $meetingId, $studentStudentId);
            $statement->execute();
            echo $studentStudentId . " attended";
        } else {
          echo "<div style='color: red'>Entry already exists or Student ID is not in DB</div>";
        }
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="./css/main.css">
        <link rel="stylesheet" href="./css/table.css">
        <meta charset="utf-8">
        <title>Meeting Check-In</title>
        <script type="text/javascript">
            window.onload=function() {
                var select = document.getElementById('student_id');
                select.focus();
                select.select();
            };
        </script>
    </head>
    <body>
        <header>
            <h1>Check-In for <?php echo $meetingDate['date'] ?></h1>
            <?php nav_bar() ?>
        </header>
        <form action="attendanceadd.php?id=<?php echo $meetingId ?>" method="post" name="student_post" style="margin-bottom: 1em">
            <div>
                Student ID: <input type="text" name="student_id" id="student_id" size="20px" onFocus="this.select()">
                <input type="submit" name="add" value="Add">
            </div>
        </form>
    </body>
</html>
