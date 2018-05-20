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

    //Specific meeting information (public)
    include_once("../admin/database.php");
    $editMeetingId = mysqli_real_escape_string($databaseConnect, $_GET['id']);
    $statement = $databaseConnect->prepare("SELECT date, description FROM meetings WHERE id = ?");
    $statement->bind_param('s', $editMeetingId);
    $statement->execute();
    $row = $statement->get_result()->fetch_assoc();
    $editMeetingDate = $row['date'];
    $editMeetingDescription = $row['description'];
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Meeting Details</title>
	<meta name="viewport" content="width=device-width, initial-scale=.8">
        <link rel="stylesheet" type="text/css" href="./css/main.css">
        <link rel="stylesheet" type="text/css" href="./css/table.css">
    </head>
    <body>
        <div>
            <header>
                <h1><?php echo $editMeetingDate ?></h1>
                <?php nav_bar_public() ?>
            </header>
            <p><?php echo $editMeetingDescription ?></p>
        </div>
    </body>
</html>
