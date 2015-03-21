<?php
//comment yeah
session_start();

include_once ("db/connect_to_mysql.php");

/*$choice = "";
$pn = "";

if(!isset($_GET['objectChosen'])){
	$choice = "rC_Opportunity";
	$pn = 1;
}else{
	$choice = $_GET['objectChosen'];	
}*/
$choice = "rC_Opportunity";
if($choice == "rC_Account"){
	$choice1 = "sF_Id";
	$choice2 = "sF_Phone";
	$choice3 = "sF_Name";
    $choice4 = "sF_rC_Bios__Acquired_Date__c";
    $choice5 = "sF_rC_Giving__Lifetime_Hard_Credit_Amount__c";
    $choice6 = "sF_rC_Giving__Lifetime_Soft_Credit_Amount__c";
}else if($choice == "rC_Opportunity"){
	$choice1 = "sF_Id";
	$choice2 = "sF_rC_Giving__Giving_Type__c";
	$choice3 = "sF_rC_Giving__Calculated_Giving_Type__c";	
    $choice4 = "sF_rC_Giving__Affiliation__c";
    $choice5 = "sF_rC_Giving__Giving_Type_Engine__c";
    $choice6 = "sF_rC_Giving__Close_Date_Time__c";
}else if($choice == "rC_Contact"){
    $choice1 = "sF_rC_Id";
    $choice2 = "sF_Birthdate";
    $choice3 = "sF_rC_Giving__Largest_Hard_Credit_Amount__c";
    $choice4 = "sF_rC_Bios__Age__c";
    $choice5 = "sF_rC_Bios__Birth_Year__c";
    $choice6 = "sF_rC_Bios__Gender__c";
}

//echo $choice1 . ', ' . $choice2 . ', ' . $choice3 . ', ' . $choice4 . ', ' . $choice5 . ', ' . $choice6;

        //$query = "SELECT $choice1, $choice2, $choice3, $choice4, $choice5, $choice6 FROM $choice";
        
        /*$url = "$instance_url/services/data/v33.0/query?q=" . urlencode($sqlCommand);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
        array("Authorization: OAuth $access_token"));
        $json_response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($json_response, true);
        $total_size = $response['totalSize'];*/
    
/*if(isset($_GET['pn']) || ($pn = 1) && ($choice)){
$pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
//This is where we set how many database items to show on each page 
$itemsPerPage = 10; 
// Get the value of the last page in the pagination result set
$lastPage = ceil($total_size / $itemsPerPage);
// Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
}else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
} 
        $offset = $pn * 10 - 10;
        
        $sqlCommand = "SELECT $choice1, $choice2, $choice3, $choice4, $choice5, $choice6 FROM $choice ORDER BY id LIMIT 10 OFFSET $offset";
		
	$query = mysql_query($sqlCommand) or die (mysql_error());
	$num_rows = mysql_num_rows($query);
	
	if ($num_rows > 0) {
		$theDiv = "<br/><div class='container'><div class='table-responsive'><table class='table table-condensed table-hover'>";
		// get all the video details
		while($row = mysql_fetch_array($query)){ 
			 $choice1 = $row['$choice1'];
			 $choice2 = $row['$choice2'];
			 $choice3 = $row['$choice3'];
			 $choice4 = $row['$choice4'];
			 $choice5 = $row['$choice5'];
			 $choice6 = $row['$choice6'];		 
         }
		 
		 echo $choice1 . '<br/>';
		 echo "wtf";
		  /*$theDiv .= "<tr><td width='14%'>".$choice1."</td><td width='14%'>".$choice2."</td><td width='14%'>".$choice3."</td>
        <td width='14%'>".$choice4."</td><td width='14%'>".$choice5."</td><td width='14%'>".$choice6."</td>
        <td width='14%'>
        <form name='editRecord' method='post' action='editRecord.php' class='navbar-form navbar-left'><input type='hidden' name='rId' value='$choice1' /><input type='hidden' name='choice2' value='$choice2' /><input type='hidden' name='choice3' value='$choice3' />
        <input type='hidden' name='choice4' value='$choice4' /><input type='hidden' name='choice5' value='$choice5' /><input type='hidden' name='choice6' value='$choice6' />
		<input type='hidden' name='fieldName1' value='$choice1' />
		<input type='hidden' name='fieldName2' value='$choice2' />
		<input type='hidden' name='fieldName3' value='$choice3' />
		<input type='hidden' name='fieldName4' value='$choice4' />
		<input type='hidden' name='fieldName5' value='$choice5' />
		<input type='hidden' name='fieldName6' value='$choice6' />
		<input type='hidden' name='tblName' value='$choice' />
        <input type='submit' class='btn btn-warning' value='Edit Record' /></form></td></tr>";
        
        $theDiv .= "</table></div></div>";
	}
        
        $url = "$instance_url/services/data/v33.0/query?q=" . urlencode($query);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
        array("Authorization: OAuth $access_token"));
        $json_response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($json_response, true);
    
        $records = $response['records'];
		        
//////Adam's Pagination Display Setup /////////////////////////////////////////////////////////////////////
$paginationDisplay = ""; // Initialize the pagination output variable
// This code runs only if the last page variable is not equal to 1, if it is only 1 page we require no paginated links to display
if ($lastPage != "1"){
    // This shows the user what page they are on, and the total number of pages
    $paginationDisplay .= '<div class="pagination" style="text-align: center;">';
  //If we are on page one, generate disabled previous arrow
  if($pn == 1){
		$paginationDisplay .= '<nav><ul class="pagination pagination-lg"><li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
  }
    // If we are not on page 1 we can place the Back button
    if ($pn > 1) {
        $previous = $pn - 1;
        $paginationDisplay .=  '<nav><ul class="pagination pagination-lg"><li><a href="' . $_SERVER['PHP_SELF'] . '?objectChosen='.$choice.'&pn=' . $previous . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
		// Render clickable number links that should appear on the left of the target page number
		for($i = $pn-2; $i < $pn; $i++){
			if($i > 0){
		        $paginationDisplay .= '<li><a href="'.$_SERVER['PHP_SELF'].'?objectChosen='.$choice.'&pn='.$i.'">'.$i.'</a><li>';
			}
	    }
    }
	// Render the target page number, but without it being a link
	$paginationDisplay .= '<li class="active"><span>' . $pn . '</span></li>';
	// Render clickable number links that should appear on the right of the target page number
	for($i = $pn+1; $i <= $lastPage; $i++){
		$paginationDisplay .= '<li><a href="'.$_SERVER['PHP_SELF'].'?objectChosen='.$choice.'&pn='.$i.'">'.$i.'</a> &nbsp;<li>';
		if($i >= $pn+2){
			break;
		}
	}
     //If we are not on the very last page we can place the Next button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
        $paginationDisplay .=  '<li><a href="' . $_SERVER['PHP_SELF'] . '?objectChosen='.$choice.'&pn=' . $nextPage . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li></ul>
</nav>Page <strong>' . $pn . '</strong> of ' . $lastPage . '</div>';
    }// This does the same as above, only checking if we are on the last page, and then generating the "Next"
    if ($pn == $lastPage) {
        //$nextPage = null;
        $paginationDisplay .= '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li></ul>
</nav></div>';
    }
}
//////////////////////////////pagination/////////////////////////////////////////////////////////////////
      
$searchBar = '<form method="get" action="'. $_SERVER['PHP_SELF'] . '" class="navbar-form navbar-left" role="search">Seach for: <input type="text" name="find" class="form-control" placeholder="Search"/> in  <Select name="objectChosen"><Option value="Opportunity">Opportunity</option><Option value="Contact">Contact</option><Option value="Account">Account</option> </Select><input type="hidden" value="yes" /><input type="hidden" name="pn" value="1" /><input type="submit" class="btn btn-default" value="Search" /></form>';
        
        echo $searchBar;
		echo $paginationDisplay;
/////////////////////////////else if pn is not set/////////////////////////////////////////////////
    }else{*/
        //$pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
        //$pn = 1;//set page number to 1
		
	$sql = "SELECT id FROM $choice";	
	
	
	if($result = $query = mysqli_query($db_conx, $sql)){
		// Return the number of rows in result set
  $rowcount = mysqli_num_rows($result);
  printf("Result set has %d rows.\n",$rowcount);
  if($rowcount < 0){
	  while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
		  $firstEntry = $row[$choice1];
	  }
	  echo $firstEntry;
  }
  // Free result set
  mysqli_free_result($result);
	}
	
	/*if ($num_rows > 0) {
		$theDiv = "<br/><div class='container'><div class='table-responsive'><table class='table table-condensed table-hover'>";
		// get all the video details
		while($row = mysql_fetch_array($query)){ 
			 $choice1 = $row['sF_Id'];
			 //$choice2 = $row[$choice2];
			 //$choice3 = $row[$choice3];
			 //$choice4 = $row[$choice4];
			 //$choice5 = $row[$choice5];
			 //$choice6 = $row[$choice6];		 
         }
		 
		 echo $choice1 . '<br/>';
		 echo "wtf";
		 
		  $theDiv .= "<tr><td width='14%'>".$choice1."</td><td width='14%'>".$choice2."</td><td width='14%'>".$choice3."</td>
        <td width='14%'>".$choice4."</td><td width='14%'>".$choice5."</td><td width='14%'>".$choice6."</td>
        <td width='14%'>
        <form name='editRecord' method='post' action='editRecord.php' class='navbar-form navbar-left'><input type='hidden' name='rId' value='$choice1' /><input type='hidden' name='choice2' value='$choice2' /><input type='hidden' name='choice3' value='$choice3' />
        <input type='hidden' name='choice4' value='$choice4' /><input type='hidden' name='choice5' value='$choice5' /><input type='hidden' name='choice6' value='$choice6' />
		<input type='hidden' name='fieldName1' value='$choice1' />
		<input type='hidden' name='fieldName2' value='$choice2' />
		<input type='hidden' name='fieldName3' value='$choice3' />
		<input type='hidden' name='fieldName4' value='$choice4' />
		<input type='hidden' name='fieldName5' value='$choice5' />
		<input type='hidden' name='fieldName6' value='$choice6' />
		<input type='hidden' name='tblName' value='$choice' />
        <input type='submit' class='btn btn-warning' value='Edit Record' /></form></td></tr>";
        
        $theDiv .= "</table></div></div>";
	}
        
//This is where we set how many database items to show on each page 
$itemsPerPage = 10; 
// Get the value of the last page in the pagination result set
$lastPage = ceil($total_size / $itemsPerPage);
// Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
} else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
} 
        
        /*$url = "$instance_url/services/data/v33.0/query?q=" . urlencode($sqlCommand);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
        array("Authorization: OAuth $access_token"));
        $json_response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($json_response, true);
        //$total_size = $response['totalSize'];   
        $records = $response['records'];
        
        //////Adam's Pagination Display Setup /////////////////////////////////////////////////////////////////////
$paginationDisplay = ""; // Initialize the pagination output variable
// This code runs only if the last page variable is ot equal to 1, if it is only 1 page we require no paginated links to display
if ($lastPage != "1"){
    // This shows the user what page they are on, and the total number of pages
    $paginationDisplay .= '<div class="pagination" style="text-align: center;">';
	//If we're on page one but no pn var is set put the disabled arrow
	$paginationDisplay .= '<nav><ul class="pagination pagination-lg"><li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
    // If we are not on page 1 we can place the Back button
    if ($pn > 1) {
        $previous = $pn - 1;
        $paginationDisplay .=  '<nav>
  <ul class="pagination pagination-lg"><li><a href="' . $_SERVER['PHP_SELF'] . '?objectChosen='.$choice.'&pn=' . $previous . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
		// Render clickable number links that should appear on the left of the target page number
		for($i = $pn-2; $i < $pn; $i++){
			if($i > 0){
		        $paginationDisplay .= '<li><a href="'.$_SERVER['PHP_SELF'].'?objectChosen='.$choice.'&pn='.$i.'">'.$i.'</a> &nbsp;</li>';
			}
	    }
    }
	// Render the target page number, but without it being a link
	$paginationDisplay .= '<li class="active"><span>' . $pn . '</span></li>';
	// Render clickable number links that should appear on the right of the target page number
	for($i = $pn+1; $i <= $lastPage; $i++){
		$paginationDisplay .= '<li><a href="'.$_SERVER['PHP_SELF'].'?objectChosen='.$choice.'&pn='.$i.'">'.$i.'</a> &nbsp;</li>';
		if($i >= $pn+2){
			break;
		}
	}
	
    //If we are not on the very last page we can place the Next button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
        $paginationDisplay .=  '<li><a href="' . $_SERVER['PHP_SELF'] . '?objectChosen='.$choice.'&pn=' . $nextPage . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li></ul>
</nav>Page <strong>' . $pn . '</strong> of ' . $lastPage . '</div>';
    }// This does the same as above, only checking if we are on the last page, and then generating the "Next"
    if ($pn == $lastPage) {
        //$nextPage = null;
        $paginationDisplay .= '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li></ul>
</nav></div>';
    }
}*/
//////////////////////////////pagination/////////////////////////////////////////////////////////////////
/*$searchBar = '<form method="get" action="'. $_SERVER['PHP_SELF'] . '" class="navbar-form navbar-left" role="search">Seach for: <input type="text" name="find" class="form-control" placeholder="Search"/> in <Select name="objectChosen"><Option value="Opportunity">Opportunity</option><Option value="Contact">Contact</option><Option value="Account">Account</option> </Select><input type="hidden" value="yes" /><input type="hidden" name="pn" value="1" /><input type="submit"class="btn btn-default" value="Search" /></form>';
    
        echo $searchBar;
        echo $paginationDisplay;

    
    echo "<div class='container-fluid'><div class='bg-primary' align='center'><h2>You are in $choice | Total Number Of Records: $total_size</h2></div></div><br/><br/>
    <div class='container'><div class='table-responsive' style='overflow: hidden;'><table class='table'><tr><td width='14%'><h3>$choice1</h3></td><td width='14%'><h3>$choice2</h3></td>
    <td width='14%'><h3>$choice3</h3></td><td width='14%'><h3>$choice4</h3></td><td width='14%'><h3>$choice5</h3></td>
    <td width='14%'><h3>$choice6</h3></td><td width='14%'><h3>Edit Record</h3></td></tr></table>"; 
    //echo $theDiv;*/

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

           <?php //echo $theDiv; ?>



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