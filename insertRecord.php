<?php

include_once ("db/connect_to_mysql.php");

$msg = "";

if(isset($_POST['id'])){
	$id = $_POST['id'];
	$choice2 = $_POST['choice2'];
	$choice3 = $_POST['choice3'];
    $choice4 = $_POST['choice4'];
    $choice5 = $_POST['choice5'];
    $choice6 = $_POST['choice6'];
	$fieldName1 = 'sF_' . $_POST['fieldName1'];
	$fieldName2 = 'sF_' . $_POST['fieldName2'];
	$fieldName3 = 'sF_' . $_POST['fieldName3'];
	$fieldName4 = 'sF_' . $_POST['fieldName4'];
	$fieldName5 = 'sF_' . $_POST['fieldName5'];
	$fieldName6 = 'sF_' . $_POST['fieldName6'];
	
	//echo $id . ', '. $choice2 . ', ' . $choice3 . ', ' . $choice4 . ', ' . $choice5 . ', ' . $choice6 . '<br/>';
	//echo $fieldName1 . ', '. $fieldName2 . ', ' . $fieldName3 . ', ' . $fieldName4 . ', ' . $fieldName5 . ', ' . $fieldName6;
	

$sql = "INSERT INTO $dbname ($fieldName1,$fieldName2,$fieldName3,$fieldName4,$fieldName5,$fieldName6) VALUES ('$id','$choice2','$choice3','$choice4','$choice5','$choice6') LIMIT 1";

if ($conn->query($sql) === TRUE) {
    $msg = "New record created successfully";
} else {
    $msg = "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Insert Record</title>
</head>

<body>
<?php echo $msg; ?>
</body>
</html>