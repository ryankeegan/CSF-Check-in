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

    //Enables editing of specific students
    include_once("../admin/database.php");
    loggedIn();
    if(!has_permission()) {
        header("Location: ./meetings.php");
    }
    if(has_permission() && isset($_POST['submit'])) {
        $checkFields = array('name', 'student_id', 'grade', 'terms');
        if(!array_diff($checkFields, array_keys($_POST))) {
            $editStudentName = mysqli_real_escape_string($databaseConnect, $_POST['name']);
            $editStudentStudentId = mysqli_real_escape_string($databaseConnect, $_POST['student_id']);
            $editStudentGrade = mysqli_real_escape_string($databaseConnect, $_POST['grade']);
            $editStudentTerms = mysqli_real_escape_string($databaseConnect, $_POST['terms']);
            
            $statement = $databaseConnect->prepare("INSERT INTO students (name, student_id, grade, terms) VALUES (?, ?, ?, ?)");
            $statement->bind_param("ssss", $editStudentName, $editStudentStudentId, $editStudentGrade, $editStudentTerms);
            $statement->execute();
            
            header("Location: ./students.php");
        }
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="./css/main.css">
        <meta charset="utf-8">
        <title>Add Student</title>
    </head>
    <body>
        <header>
            <h1>Adding Student</h1>
            <?php nav_bar() ?>
        </header>
        <form action="studentadd.php" method="post">
            <table>
                <th></th>
                <th></th>
                <tr>
                    <td>Name: </td>
                    <td>
                        <input type='text' name='name' autocomplete='off' size='20px'>
                    </td>
                </tr>
                <tr>
                    <td>Student ID: </td>
                    <td>
                        <input type='text' name='student_id' autocomplete='off' size='20px'>
                    </td>
                </tr>
                <tr>
                    <td>Grade: </td>
                    <td>
                        <input type='text' name='grade' autocomplete='off' size='20px'>
                    </td>
                </tr>
                <tr>
                    <td>Terms: </td>
                    <td>
                        <input type='text' name='terms' autocomplete='off' size='20px'>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="submit" name="submit" value="Submit">
                    </td>
                </tr>
            </table>
            </form>
    </body>
</html>