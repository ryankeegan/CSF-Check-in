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

    session_start();
    include_once("../admin/database.php");
    $wrongpassword = "";
    if(isset($_POST['username'], $_POST['login'])) {
        $username = strip_tags($_POST['username']);
        $password = strip_tags($_POST['password']);
        $username = mysqli_real_escape_string($databaseConnect, $username);
        $password = mysqli_real_escape_string($databaseConnect, $password);
        
        $statement = $databaseConnect->prepare("SELECT id, username, password, name, access_level FROM users WHERE username = ? LIMIT 1");
        $statement->bind_param("s", $username);
        $statement->execute();
        $row = $statement->get_result()->fetch_assoc();
        if($username == $row['username'] && password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['id'] = $row['id'];
            $_SESSION['access-level'] = $row['access_level'];
            $_SESSION['name'] = $row['name'];
            header("Location: ./meetings.php");
        } else {
            $wrongpassword = "The password or username entered was incorrect.";
        }
    }
    ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>CSF Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=.8, user-scalable=no">
        <link rel="stylesheet" type="text/css" href="./css/main.css">
    </head>
    <body>
        <header>
            <h1>CSF Login</h1>
            <hr>
        </header>
        <form action="login.php" method="post" enctype="multipart/form-data" target="_top">
            <table>
                <th></th>
                <th></th>
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" spellcheck="false">
                    </td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td>
                        <input type="password" name="password">
                    </td>
                </tr>
                <div style="color: red">
                    <?php echo $wrongpassword; ?>
                </div>
                <tr>
                    <td>
                        <input type="submit" value="Login" name="login">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
