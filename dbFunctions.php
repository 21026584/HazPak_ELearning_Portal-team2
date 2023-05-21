<?php
// Database credentials
$host = "localhost";
$username = "root";
$password = "";
$database = "lp_db1";

// Connect to the database
$link = mysqli_connect($host, $username, $password, $database) or die(mysqli_connect_error());
