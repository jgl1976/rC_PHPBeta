<?php
//comment yeah
session_start();



function show_accounts($instance_url, $access_token) {

//$choice = $_GET['choices'];

$choice = "Contact";

/*if($choice == "Account"){
	echo "You Chose Account";	
}else if($choice == "Opportunity"){
	echo "You Chose Opportunity";
}else if($choice == "Contact"){
	echo "You Chose Contact";
} */ 
if($choice == "Account"){
	$choice1 = "Id";
	$choice2 = "AccountNumber";
	$choice3 = "rC_Bios__Acquired_Date__c";
	echo $choice . " and fields are " . $choice1 . ", " . $choice2 . ", " . $choice3 . ".";
}else if($choice == "Opportunity"){
	$choice1 = "rC_Giving__Source_Code__c";
	$choice2 = "rC_Giving__Current_Giving_Amount__c";
	$choice3 = "rC_Giving__Expected_Giving_Amount__c";	
	echo $choice . " and fields are " . $choice1 . ", " . $choice2 . ", " . $choice3 . ".";
}else if($choice == "Contact"){
	$choice1 = "Id";
	$choice2 = "Birthdate";
	$choice3 = "rC_Giving__Largest_Hard_Credit_Amount__c";
	echo $choice . " and fields are " . $choice1 . ", " . $choice2 . ", " . $choice3 . ".";
}

        $query = "SELECT $choice1, $choice2, $choice3 FROM $choice";
        
        $url = "$instance_url/services/data/v33.0/query?q=" . urlencode($query);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
        array("Authorization: OAuth $access_token"));
        $json_response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($json_response, true);
        $total_size = $response['totalSize'];   
    
    if(isset($_GET['pn'])){
        $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
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
        $offset = $pn * 10 - 10;
        
        $query = "SELECT $choice1, $choice2, $choice3 FROM $choice ORDER BY $choice1 LIMIT 10 OFFSET $offset";
        
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
        $paginationDisplay .=  '<nav><ul class="pagination pagination-lg"><li><a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
		// Render clickable number links that should appear on the left of the target page number
		for($i = $pn-2; $i < $pn; $i++){
			if($i > 0){
		        $paginationDisplay .= '<li><a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a><li>';
			}
	    }
    }
	// Render the target page number, but without it being a link
	$paginationDisplay .= '<li class="active"><span>' . $pn . '</span></li>';
	// Render clickable number links that should appear on the right of the target page number
	for($i = $pn+1; $i <= $lastPage; $i++){
		$paginationDisplay .= '<li><a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp;<li>';
		if($i >= $pn+2){
			break;
		}
	}
     //If we are not on the very last page we can place the Next button*/
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
        $paginationDisplay .=  '<li><a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $nextPage . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li></ul>
</nav>Page <strong>' . $pn . '</strong> of ' . $lastPage . '</div>';
    }// This does the same as above, only checking if we are on the last page, and then generating the "Next"
    if ($pn == $lastPage) {
        //$nextPage = null;
        $paginationDisplay .= '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li></ul>
</nav></div>';
    }
}
//////////////////////////////pagination/////////////////////////////////////////////////////////////////
      
$searchBar = '<form method="get" action="'. $_SERVER['PHP_SELF'] . '" class="navbar-form navbar-left" role="search"> Seach for: <input type="text" name="find" class="form-control" placeholder="Search"/> in  <Select name="choices"><Option value="Opportunity">Opportunity</option><Option value="Contact">Contact</option><Option value="Account">Account</option> </Select><input type="hidden" value="yes" /> <input type="submit"class="btn btn-default" value="Search" /> </form>';
        
        echo $searchBar;
        
        $theDiv = "<br/><div class='container'><div class='table-responsive'><table class='table table-condensed table-hover'>";
        
        foreach ((array) $records as $record) {

        echo $choice1;
		echo $choice2;
		
        $theDiv .= "<tr><td width='25%'>".$record[$choice1]."</td><td width='25%'>".$record[$choice2]."</td><td width='25%'>".$record[$choice3]."</td>
        <td width='25%'><button type='button' class='btn btn-warning'>Edit Record</button></td></tr>";
    }
        
        $theDiv .= "</table></div></div>";
		echo $paginationDisplay;
    }else{
        $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
        $query = "SELECT SELECT $choice1, $choice2, $choice3 FROM $choice ORDER BY $choice1 LIMIT 10 OFFSET 0";
        $pn = 1;//set page number to 1 
        
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
        
        $url = "$instance_url/services/data/v33.0/query?q=" . urlencode($query);
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
  <ul class="pagination pagination-lg"><li><a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
		// Render clickable number links that should appear on the left of the target page number
		for($i = $pn-2; $i < $pn; $i++){
			if($i > 0){
		        $paginationDisplay .= '<li><a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp;</li>';
			}
	    }
    }
	// Render the target page number, but without it being a link
	$paginationDisplay .= '<li class="active"><span>' . $pn . '</span></li>';
	// Render clickable number links that should appear on the right of the target page number
	for($i = $pn+1; $i <= $lastPage; $i++){
		$paginationDisplay .= '<li><a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp;</li>';
		if($i >= $pn+2){
			break;
		}
	}
	
    //If we are not on the very last page we can place the Next button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
        $paginationDisplay .=  '<li><a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $nextPage . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li></ul>
</nav>Page <strong>' . $pn . '</strong> of ' . $lastPage . '</div>';
    }// This does the same as above, only checking if we are on the last page, and then generating the "Next"
    if ($pn == $lastPage) {
        //$nextPage = null;
        $paginationDisplay .= '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li></ul>
</nav></div>';
    }
}
//////////////////////////////pagination/////////////////////////////////////////////////////////////////
$searchBar = '<form method="get" action="'. $_SERVER['PHP_SELF'] . '" class="navbar-form navbar-left" role="search"> Seach for: <input type="text" name="find" class="form-control" placeholder="Search"/> in  <Select name="choices"><Option value="Opportunity">Opportunity</option><Option value="Contact">Contact</option><Option value="Account">Account</option> </Select><input type="hidden" value="yes" /> <input type="submit"class="btn btn-default" value="Search" /> </form>';
    
        echo $searchBar;
        echo $paginationDisplay;
        
        $theDiv = "<div class='container'><div class='table-responsive' style='overflow: hidden;'><table class='table table-condensed table-hover'>";
        
        foreach ((array) $records as $record) {
		
        $theDiv .= "<tr><td width='25%'>".$record['$choice1']."</td><td width='25%'>".$record['$choice2']."</td><td width='25%'>".$record['$choice3']."</td>
        <td width='25%'><button type='button' class='btn btn-warning'>Edit Record</button></td></tr>";
    }   
    $theDiv .= "</table></div></div>";
    }
    echo "<div class='container-fluid'><div class='bg-primary' align='center'><h2>You are in Account | Total Number Of Records: $total_size</h2></div></div><br/><br/>
    <div class='container'><div class='table-responsive' style='overflow: hidden;'><table class='table'><tr><td width='15%'><h3>ID</h3></td><td width='15%'><h3>Name</h3></td><td width='15%'><h3>Giving Primary Giving Level</h3></td>
    <td width='15%'><h3>First Name</h3></td><td width='15%'><h3>Last Name</h3></td><td width='15%'><h3>Edit Record</h3></td></tr></table>"; 
    echo $theDiv;
}
/*function create_account($name, $instance_url, $access_token) {
    $url = "$instance_url/services/data/v20.0/sobjects/Account/";
 
    $content = json_encode(array("Name" => $name));
 
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token",
                "Content-type: application/json"));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
 
    $json_response = curl_exec($curl);
 
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
 
    if ( $status != 201 ) {
        die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }
     
    echo "HTTP status $status creating account<br/><br/>";
 
    curl_close($curl);
 
    $response = json_decode($json_response, true);
 
    $id = $response["id"];
 
    echo "New record id $id<br/><br/>";
 
    return $id;
}
function show_account($id, $instance_url, $access_token) {
    $url = "$instance_url/services/data/v20.0/sobjects/Account/$id";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));
 
    $json_response = curl_exec($curl);
 
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
 
    if ( $status != 200 ) {
        die("Error: call to URL $url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }
 
    echo "HTTP status $status reading account<br/><br/>";
 
    curl_close($curl);
 
    $response = json_decode($json_response, true);
    foreach ((array) $response as $key => $value) {
echo "$key:$value<br/>";
    }
    echo "<br/>";
}
 
function update_account($id, $new_name, $city, $instance_url, $access_token) {
    $url = "$instance_url/services/data/v20.0/sobjects/Account/$id";
 
    $content = json_encode(array("Name" => $new_name, "BillingCity" => $city));
 
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token",
                "Content-type: application/json"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
 
    curl_exec($curl);
 
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
 
    if ( $status != 204 ) {
        die("Error: call to URL $url failed with status $status, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }
 
    echo "HTTP status $status updating account<br/><br/>";
 
    curl_close($curl);
}
 
function delete_account($id, $instance_url, $access_token) {
    $url = "$instance_url/services/data/v20.0/sobjects/Account/$id";
 
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
 
    curl_exec($curl);
 
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
 
    if ( $status != 204 ) {
        die("Error: call to URL $url failed with status $status, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
    }
 
    echo "HTTP status $status deleting account<br/><br/>";
 
    curl_close($curl);
}*/
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

            <?php
            $access_token = $_SESSION['access_token'];
            $instance_url = $_SESSION['instance_url'];
 
            if (!isset($access_token) || $access_token == "") {
                die("Error - access token missing from session!");
            }
 
            if (!isset($instance_url) || $instance_url == "") {
                die("Error - instance URL missing from session!");
            }
 
            show_accounts($instance_url, $access_token);
 
            /*$id = create_account("My New Org", $instance_url, $access_token);
 
            show_account($id, $instance_url, $access_token);
 
            show_accounts($instance_url, $access_token);
 
            update_account($id, "My New Org, Inc", "San Francisco",
                    $instance_url, $access_token);
 
            show_account($id, $instance_url, $access_token);
 
            show_accounts($instance_url, $access_token);
 
            delete_account($id, $instance_url, $access_token);
 
            show_accounts($instance_url, $access_token);*/
            ?>



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