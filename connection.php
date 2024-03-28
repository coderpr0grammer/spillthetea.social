<?php

    $link = mysqli_connect("localhost", "my_user", "my_pass", "my_db");

    if ( mysqli_connect_error()) {

        die ("There was an error connecting to the database");

    }

?>
