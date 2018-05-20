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
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Meetings</title>
        <link rel="stylesheet" type="text/css" href="./css/main.css">
        <link rel="stylesheet" type="text/css" href="./css/table.css">
        <style>
            .header-textField {
                color: #5E6C7F;
                font-size: 24pt;
                padding: .25em;
                border: 1px solid #5E6C7F;
                background: white;
            }
            .header-textField:hover {
                background: #F2F2F2;
            }
            .header-button {
                color: white;
                font-size: 14pt;
                padding: .25em;
                border: 0px;
                background: #5E6C7F;
            }
            .header-button:hover {
                background: #6C7C91;
            }
        </style>
    </head>
    <body>
        <div>
            <header>
                <h1 class="header">Meetings Overview</h1>
                <?php nav_bar() ?>
            </header>
            <table>
                <tr>
                    <th>Meeting</th> <!--Add attended/absent to overview?-->
                    <th>Description</th>
                    <th></th>
                    <?php if(has_permission()) : ?>
                        <th></th>
                    <?php endif; ?>
                </tr>
                <?php
                    $result = mysqli_query($databaseConnect, "SELECT date, description, id FROM meetings");
                    while($row = mysqli_fetch_array($result)) {
                        $date = $row['0'];
                        $description = $row['1'];
                        $id = $row['2'];
                        echo "
                            <tr>
                                <td>" . $date . "</td>
                                <td>" . $description . "</td>
                                <td><a href='meetingedit.php?id=" . $id . "'>Details</a></td>";
                                
                                if(has_permission()) {
                                    echo "<td><a href='meetingremove.php?id=" . $id . "'>Remove</a></td>";
                                }
                                echo "
                            </tr>
                        ";
                    }
                ?>
            </table>
        </div>
        <div align="center">
            <br>
            <?php if(has_permission()) : ?>
                <a href="meetingadd.php">Add Meeting</a>
            <?php endif; ?>
        </div>
    </body>
</html>
