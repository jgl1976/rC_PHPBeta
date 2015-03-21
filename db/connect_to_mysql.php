<?php
$servername = "ih7lzhkhj9ckxv8y.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "fdo9nglcafpld48u";
$password = "6c3pjezu2eteduv9";
$dbname = "DCoE";

$db_conx = mysqli_connect("ih7lzhkhj9ckxv8y.cbetxkdyhwsb.us-east-1.rds.amazonaws.com", "fdo9nglcafpld48u", "6c3pjezu2eteduv9", "DCoE");
// Evaluate the connection
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
    exit();
} 
?>