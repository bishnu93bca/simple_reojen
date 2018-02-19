<?php
	date_default_timezone_set("Asia/Kolkata");
    $connection =new mysqli("localhost", "manoj255", "]@[RTep4#$#X", "codebeginer_reojen"); // Establishing Connection with Server
    $db = mysqli_select_db($connection, "clientsv_reojen");
    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
