<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "new2";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "INSERT INTO users(first_name,last_name,email,password,is_active,language)VALUES ('sdfgs',1)";
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully" . '<br>';
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
