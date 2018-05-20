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

    //Enables students to see their attendance and membership record
    include_once("../admin/database.php");
    ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="../css/main.css">
        <link rel="stylesheet" href="../css/table.css">
        <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=.8, user-scalable=no">
        <title>CSF Lookup</title>
    </head>
    <body>
        <header>
            <h1>CSF Membership Lookup</h1>
            <?php nav_bar_public() ?>
        </header>
        <form action="attendance.php" method="post" style="margin-bottom: 1em">
            <div>
                Student ID: <input type="text" name="query" size="20px">
                <input type="submit" name="submit" value="Search">
            </div>
        </form>
        <?php
            if(isset($_POST['submit']) && $_POST['query'] != "") {
              $query = strip_tags($_POST['query']);
              $query = mysqli_real_escape_string($databaseConnect, $query);

              $statement = $databaseConnect->prepare("SELECT id, student_id, name, grade, terms FROM students WHERE student_id = ? LIMIT 1");
              $statement->bind_param("s", $query);
              $statement->execute();
              if(sizeof($row = $statement->get_result()->fetch_assoc())) {
                $studentId = $row['id'];
                $studentStudentId = $row['student_id'];
                $studentName = $row['name'];
                $studentGrade = $row['grade'];
                $studentTerms = $row['terms'];
                echo "
                    <table align='center' style='width: 100%'>
                        <tr align='center'>
                            <th>Student ID</th>
                            <th>Grade</th>
                            <th>Terms</th>
                            <th>Meetings</th>
                        </tr>
                        <tr id='mobile'>
                            <td>" . $_POST['query'] . "</td>
                            <td>" . $studentGrade . "</td>
                            <td>" . $studentTerms . "</td>
                            <td>";

                            //For each Meeting
                            $result = mysqli_query($databaseConnect, "SELECT id, date FROM meetings");
                            while($row = mysqli_fetch_array($result)) {
                                $attendance = attendanceStudent($studentStudentId, $row['0'], $databaseConnect);
                                echo "<a href='meeting.php?id=" . $row['0'] . "' style='padding-right: 10px; color:" . $attendance . "'>" . $row['1'] . "</a> <br>";
                            }
                            echo "
                            </td>
                        </tr>
                    </table>
                    ";
                } else {
                  echo "<div>Student not found in database.</div>";
                }
            }
            ?>
    </body>
</html>
