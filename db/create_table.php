<?php
$servername = "ih7lzhkhj9ckxv8y.cbetxkdyhwsb.us-east-1.rds.amazonaws.com";
$username = "fdo9nglcafpld48u";
$password = "6c3pjezu2eteduv9";
$db_name = "DCoE";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully to rC custom dataMigration DataBase!  ";

// sql to create table
$sql = "CREATE TABLE IF NOT EXISTS rC_Opportunity (
id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
sF_id VARCHAR(255) NOT NULL,
sF_rC_Giving__Giving_Type__c VARCHAR(255) NOT NULL,
sF_rC_Giving__Calculated_Giving_Type__c VARCHAR(255),
sF_rC_Giving__Affiliation__c VARCHAR(255),
sF_rC_Giving__Giving_Type_Engine__c VARCHAR(255),
sF_rC_Giving__Close_Date_Time__c VARCHAR(255)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table rC_Opportunity created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();

?>