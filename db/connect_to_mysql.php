<?php
$servername = "ih7lzhkhj9ckxv8y.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "fdo9nglcafpld48u";
$password = "6c3pjezu2eteduv9";
$dbname = "DCoE";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>