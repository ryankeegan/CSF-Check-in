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

    $editMeetingId = mysqli_real_escape_string($databaseConnect, $_GET['id']);
    $statement = $databaseConnect->prepare("SELECT date, description FROM meetings WHERE id = ?");
    $statement->bind_param('s', $editMeetingId);
    $statement->execute();
    $row = $statement->get_result()->fetch_assoc();
    $editMeetingDate = $row['date'];
    $editMeetingDescription = $row['description'];
    
    if(isset($_POST['submit'])) {
        $checkFields = array('date', 'description');
        if(!array_diff($checkFields, array_keys($_POST))) {
            $date = mysqli_real_escape_string($databaseConnect, $_POST['date']);
            $description = $_POST['description'];
            $statement = $databaseConnect->prepare("UPDATE meetings SET date=?, description=? WHERE id=?");
            $statement-> bind_param("sss", $date, $description, $editMeetingId);
            $statement->execute();
	    header("Location: meetingedit.php?id=" . $editMeetingId);
        }
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Meeting Details</title>
        <link rel="stylesheet" type="text/css" href="./css/main.css">
        <link rel="stylesheet" type="text/css" href="./css/table.css">
        <style>
            .textField-header {
                color: #5E6C7F;
                font-size: 24pt;
                padding: .25em;
                border: 1px solid #5E6C7F;
                background: white;
            }
            .textField-header:hover {
                background: #F2F2F2;
            }
            .button-header {
                color: white;
                font-size: 14pt;
                padding: .25em;
                border: 0px;
                background: #5E6C7F;
            }
            .button-header:hover {
                background: #6C7C91;
            }
            #button-checkin {
                color: white;
                font-size: 14pt;
                padding: .25em;
                border: 0px;
                background: #5E6C7F;
            }
            #button-checkin:hover {
                background: #6C7C91;
            }
        </style>
    </head>
    <body>
        <div>
            <header>
                <form action="attendanceadd.php?id=<?php echo $editMeetingId ?>" method="post" style="display: inline; float: right; margin-top: -5px; margin-bottom: 2px">
                    <input name="submit" id="button-checkin" type="submit" value="Check In">
                </form>
                <form action="meetingedit.php?id=<?php echo $editMeetingId ?>" method="post">
                    <input name="date" class="textField-header" placeholder="MONTH DAY, YEAR" value="<?php echo $editMeetingDate ?>">
                    <div style="display: inline; float: right; clear: right; margin-bottom: 5px">
                        <input name="submit" class="button-header" type="submit" value="Save Changes">
                    </div>
                    <textarea type="text" name="description" placeholder="Description"><?php echo $editMeetingDescription  ?></textarea>
                </form>
                <?php nav_bar() ?>
            </header>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Student ID</th>
                    <th>Timestamp</th>
                    <?php if(has_permission()) : ?>
                        <th></th>
                        <th></th>
                    <?php endif; ?>
                </tr>
                <?php
                    $statement = $databaseConnect->prepare("SELECT student_id, timestamp FROM attendance WHERE meeting_id = ? ORDER BY timestamp ASC");
                    $statement->bind_param('s', $editMeetingId);
                    $statement->execute();
                    $result = $statement->get_result();
                    while($row = $result->fetch_array()) {
                        $studentStudentId = $row['student_id'];
                        $studentInfo = mysqli_fetch_array(mysqli_query($databaseConnect, "SELECT id, name FROM students WHERE student_id = $studentStudentId LIMIT 1"));
                        $studentId = $studentInfo['0'];
                        $name = $studentInfo['1'];
                        $studentTimestamp = $row['timestamp'];
                        $attendanceInfo = mysqli_fetch_array(mysqli_query($databaseConnect, "SELECT id FROM attendance WHERE student_id = $studentStudentId AND meeting_id = $editMeetingId LIMIT 1"));
                        $attendanceId = $attendanceInfo['0'];
                        echo "
                            <tr>
                                <td>" . $name . "</td>
                                <td>" . $studentStudentId . "</td>
                                <td>" . $studentTimestamp . "</td>";
                                if(has_permission()) {
                                echo "
                                    <td><a href='studentedit.php?id=" . $studentId . "'>Details</a></td>
                                    <td><a href='attendanceremove.php?id=" . $attendanceId . "'>Remove</a></td>";
                                }
                                echo "
                            </tr>
                        ";
                    }
                    ?>
            </table>
	    <div align="center" style="padding-bottom: 5px"><a href="download?id=<?php echo $editMeetingId ?>" target="_blank">Download</a></div>
        </div>
    </body>
</html>
