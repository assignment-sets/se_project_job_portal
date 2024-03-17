<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "db_job_portal";
    $con = mysqli_connect($server, $username, $password, $database);
    if(!$con){
        die("Connection failed: " . mysqli_connect_error());
    }
?>