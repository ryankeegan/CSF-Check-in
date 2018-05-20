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

    //Enables editing of specific users
    include_once("../admin/database.php");
    loggedIn();
    if(!has_permission()) {
        header("Location: ./users.php");
    }
    if(has_permission() && isset($_POST['submit'])) {
        $checkFields = array('username', 'name', 'accesslevel', 'password');
        if(!array_diff($checkFields, array_keys($_POST))) {
            $editUserUsername = mysqli_real_escape_string($databaseConnect, $_POST['username']);
            $editUserName = mysqli_real_escape_string($databaseConnect, $_POST['name']);
            $editUserAccesslevel = mysqli_real_escape_string($databaseConnect, $_POST['accesslevel']);
            $editUserPassword = mysqli_real_escape_string($databaseConnect, strip_tags($_POST['password']));
            $passwordResult = password_hash($editUserPassword, PASSWORD_BCRYPT, array('cost'=>'13'));
            $statement = $databaseConnect->prepare("INSERT INTO users (username, name, access_level, password) VALUES (?, ?, ?, ?)");
            $statement->bind_param("ssss", $editUserUsername, $editUserName, $editUserAccesslevel, $passwordResult);
            $statement->execute();
            header("Location: ./users.php");
        }
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="./css/main.css">
        <meta charset="utf-8">
        <title>Add User</title>
    </head>
    <body>
        <header>
            <h1>Adding User</h1>
            <?php nav_bar() ?>
        </header>
        <form action="useradd.php" method="post">
            <table>
                <th></th>
                <th></th>
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type='text' name='username' autocomplete='off' size='20px'>
                    </td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td>
                        <input type='password' name='password' autocomplete='off' size='20px'>
                    </td>
                </tr>
                <tr>
                    <td>Name: </td>
                    <td>
                        <input type='text' name='name' autocomplete='off' size='20px'>
                    </td>
                </tr>
                <tr>
                    <td>Accesslevel: </td>
                    <td>
                        <input type='text' name='accesslevel' autocomplete='off' size='20px'>
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