<?php

if(isset($_POST['rId'])){
	$id = $_POST['rId'];
	$choice2 = $_POST['choice2'];
	$choice3 = $_POST['choice3'];
    $choice4 = $_POST['choice4'];
    $choice5 = $_POST['choice5'];
    $choice6 = $_POST['choice6'];
}else{
	header("location: layout.php");
}

echo "<br><br><div class='container-fluid'><div class='bg-primary' align='center'><h2>Data Here</h2></div></div><br/>
<div class='container'><div class='row'><div class='col-md-4'>
<button onclick='goBack()' type='button' class='btn btn-success btn-lg'>Go Back</button>
<script>
function goBack() {
    window.history.back()
}
</script>
</div>
<div class='col-md-4'><form name='theRecord' id='theRecord' action='insertRecord.php' method='post'>
<div class='form-group'><label for='field1'>$id</label><input type='text' class='form-control' id='field1' placeholder='$id' name='id' value='$id'></div>
<div class='form-group'><label for='field2'>$choice2</label><input type='text' class='form-control' id='$choice2' placeholder='$choice2' name='choice2' value='$choice2'></div>
<div class='form-group'><label for='field3'>$choice3</label><input type='text' class='form-control' id='$choice3' placeholder='$choice3' name='choice3' value='$choice3'></div>
<div class='form-group'><label for='field4'>$choice4</label><input type='text' class='form-control' id='$choice4' placeholder='$choice4' name='choice4' value='$choice4'></div>
<div class='form-group'><label for='field5'>$choice5</label><input type='text' class='form-control' id='$choice5' placeholder='$choice5' name='choice5' value='$choice5'></div>
<div class='form-group'><label for='field6'>$choice6</label><input type='text' class='form-control' id='$choice6' placeholder='$choice6' name='choice6' value='$choice6'></div>
<input type='submit' class='btn btn-default' value='Submit' /></form></div><div class='col-md-4'></div></div></div>";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>rC PHP DMA</title>
    </head>
    <body>

 <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>