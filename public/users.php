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

    //Overview for Users
    include_once("../admin/database.php");
    loggedIn();
    ?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="./css/main.css">
        <link rel="stylesheet" href="./css/table.css">
        <meta charset="utf-8">
        <title>Users</title>
    </head>
    <body>
        <header>
            <h1>Users Overview</h1>
            <?php nav_bar() ?>
        </header>
        <table align='center'>
            <tr align='center'>
                <th>User Name</th>
                <th>Name</th>
                <th>Access Level</th>
                <th></th>
            </tr>
            <?php
                $result = mysqli_query($databaseConnect, "SELECT username, name, access_level, id FROM users ORDER BY name ASC");
                while($row = mysqli_fetch_array($result)) {
                    $username = $row['0'];
                    $name = $row['1'];
                    $accesslevel = $row['2'];
                    $id = $row['3'];
                    echo "
                        <tr>
                            <td>" . $username . "</td>
                            <td>" . $name . "</td>
                            <td>" . $accesslevel . "</td>";
                            if($_SESSION['id'] == $id || has_permission()) {
                                echo "<td><a href='useredit.php?id=" . $id . "'>Edit</a></td>";
                            } else {
			        echo "<td></td>";
                            }
                            echo "
                        </tr>
                        ";
                }
                ?>
        </table>
        <div align="center">
            <br>
            <?php if(has_permission()) : ?>
                <a href="useradd.php">Add User</a>
            <?php endif; ?>
        </div>
    </body>
</html>
