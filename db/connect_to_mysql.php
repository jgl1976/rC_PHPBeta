<?php
$servername = "mysql://This:Text@WillAutomatically.UpdateOnce.DatabaseIsReady:1234/heroku_app_db";
$username = "This";
$password = "Text";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";
?>