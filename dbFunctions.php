<?php
//Database credentials
 $host = "localhost";
 $username = "root";
 $password = "";
 $database = "lp_db1";

/* $host = "localhost";
$username = "u439252487_fypteam2";
$password = "t?3RSg=&4B";
$database = "u439252487_hazpak2"; */

// Connect to the database
$link = mysqli_connect($host, $username, $password, $database) or die(mysqli_connect_error());
