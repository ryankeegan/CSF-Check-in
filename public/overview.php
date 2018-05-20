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

    //Overview for meetings (public)
    include_once("../admin/database.php");
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Meetings</title>
	<meta name="viewport" content="width=device-width, initial-scale=.8">
        <link rel="stylesheet" type="text/css" href="./css/main.css">
        <link rel="stylesheet" type="text/css" href="./css/table.css">
    </head>
    <body>
        <div>
            <header>
                <h1 class="header">Meetings Overview</h1>
                <?php nav_bar_public() ?>
            </header>
            <table>
                <tr>
                    <th>Meeting</th>
                    <th>Description</th>
                </tr>
                <?php
                    $result = mysqli_query($databaseConnect, "SELECT date, description FROM meetings");
                    while($row = mysqli_fetch_array($result)) {
                        $date = $row['0'];
                        $description = $row['1'];
                        echo "
                            <tr>
                                <td>" . $date . "</td>
                                <td>" . $description . "</td>
                            </tr>
                        ";
                    }
                ?>
            </table>
        </div>
    </body>
</html>
