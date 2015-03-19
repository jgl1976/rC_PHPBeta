<?php
$servername = "ih7lzhkhj9ckxv8y.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "fdo9nglcafpld48u";
$password = "6c3pjezu2eteduv9";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully to rC custom dataMigration DataBase!  ";

$sql = "CREATE DATABASE DCoE";

if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();

?>