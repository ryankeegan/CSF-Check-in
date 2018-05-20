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
    if($_SESSION['id'] != $_GET['id'] && !has_permission()) {
        header("Location: ./users.php");
    }
    $editUserId = mysqli_real_escape_string($databaseConnect, $_GET['id']);
    
    $statement = $databaseConnect->prepare("SELECT username, name, access_level, id FROM users WHERE id=?");
    $statement->bind_param("s", $editUserId);
    $statement->execute();
    $row = $statement->get_result()->fetch_assoc();
    
    $editUserUsername = $row['username'];
    $editUserName = $row['name'];
    $editUserAccesslevel = $row['access_level'];
    if(($_SESSION['id'] == $editUserId || has_permission()) && isset($_POST['submit'])) {
        $checkFields = array('username', 'name');
        if(!array_diff($checkFields, array_keys($_POST))) {
            $editUserUsername = mysqli_real_escape_string($databaseConnect, $_POST['username']);
            $editUserName = mysqli_real_escape_string($databaseConnect, $_POST['name']);
            if(has_permission() && $_POST['password'] != "") {
	        $editUserAccesslevel = mysqli_real_escape_string($databaseConnect, $_POST['access_level']);
                $editUserPassword = mysqli_real_escape_string($databaseConnect, $_POST['password']);
                $passwordResult = password_hash($editUserPassword, PASSWORD_BCRYPT, array('cost'=>'13'));
                $statement = $databaseConnect->prepare("UPDATE users SET username=?, name=?, access_level=?, password=? WHERE id=?");
                $statement->bind_param("sssss", $editUserUsername, $editUserName, $editUserAccesslevel, $passwordResult, $editUserId);
                $statement->execute();
            } elseif(has_permission()) {
	        $editUserAccesslevel = mysqli_real_escape_string($databaseConnect, $_POST['access_level']);
                $statement = $databaseConnect->prepare("UPDATE users SET username=?, name=?, access_level=? WHERE id=?");
                $statement->bind_param("ssss", $editUserUsername, $editUserName, $editUserAccesslevel, $editUserId);
                $statement->execute();
            } elseif(!has_permission() && $_POST['password'] != "") {
                $editUserPassword = mysqli_real_escape_string($databaseConnect, $_POST['password']);
                $passwordResult = password_hash($editUserPassword, PASSWORD_BCRYPT, array('cost'=>'13'));      
	        $statement = $databaseConnect->prepare("UPDATE users SET username=?, name=?, password=? WHERE id=?");
                $statement->bind_param("ssss", $editUserUsername, $editUserName, $passwordResult, $editUserId);
                $statement->execute();
            } else {
                $statement = $databaseConnect->prepare("UPDATE users SET username=?, name=? WHERE id=?");
                $statement->bind_param("sss", $editUserUsername, $editUserName, $editUserId);
                $statement->execute();
            }
            header("Location: ./users.php");
        }
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="./css/main.css">
        <meta charset="utf-8">
        <title>Edit User</title>
    </head>
    <body>
        <header>
            <h1>Editing User: <?php echo $editUserUsername ?></h1>
            <?php nav_bar() ?>
        </header>
        <form action="useredit.php?id=<?php echo $editUserId ?>" method="post">
            <table>
                <th></th>
                <th></th>
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type='text' name='username' autocomplete='off' value='<?php echo $editUserUsername ?>' size='20px'>
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
                        <input type='text' name='name' autocomplete='off' value='<?php echo $editUserName ?>' size='20px'>
                    </td>
                </tr>
                <tr>
                    <td>Accesslevel: </td>
                    <td>
                        <input type='text' <?php if($_SESSION['id'] == $editUserId && !has_permission()): ?>disabled<?php endif; ?> name='access_level' autocomplete='off' value='<?php echo $editUserAccesslevel ?>' size='20px'>
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
