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
	$fieldName1 =  $_POST['fieldName1'];
	$fieldName2 =  $_POST['fieldName2'];
	$fieldName3 =  $_POST['fieldName3'];
	$fieldName4 =  $_POST['fieldName4'];
	$fieldName5 =  $_POST['fieldName5'];
	$fieldName6 =  $_POST['fieldName6'];
	$tblName = 'rC_' . $_POST['tblName'];
	
	//cho $dbname;
	
	//echo $id . ', '. $choice2 . ', ' . $choice3 . ', ' . $choice4 . ', ' . $choice5 . ', ' . $choice6 . '<br/>';
	//echo $fieldName1 . ', '. $fieldName2 . ', ' . $fieldName3 . ', ' . $fieldName4 . ', ' . $fieldName5 . ', ' . $fieldName6;
	

$sql = "INSERT INTO $tblName ($fieldName1,$fieldName2,$fieldName3,$fieldName4,$fieldName5,$fieldName6) VALUES ('$id','$choice2','$choice3','$choice4','$choice5','$choice6')";

if ($conn->query($sql) === TRUE) {
    $msg = "New record created in the DCoE Database successfully! <a href='adminer123.php' class='btn btn-info'>View and Edit Record Here</a> or <a href='layout.php' class='btn btn-info'>Click Here</a> to go back";
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
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
<title>Insert Record</title>
</head>

<body>
<?php echo $msg; ?>
</body>
</html>