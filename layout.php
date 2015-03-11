<?php
//comment
session_start();
 
$paginationDisplay = ""; // Initialize the pagination output variable

function show_accounts($instance_url, $access_token) {
	
		$query = "SELECT Name, Id, AnnualRevenue FROM Account";
		
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
		$offset = $_GET['pn'] * 10 - 10;
		$query = "SELECT Name, Id, AnnualRevenue FROM Account ORDER BY Id LIMIT 10 OFFSET $offset";
		
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
		
		$theDiv = "<div class='container'><div class='table-responsive'><table class='table table-condensed table-hover'>";
		
		foreach ((array) $records as $record) {
		
        $theDiv .= "<tr><td width='33%'>".$record['Id']."</td><td width='33%'>".$record['Name']."</td><td width='33%'>$".$record['AnnualRevenue']."</td></tr>";
    }
		
		$theDiv .= "</table></div></div>";
	}else{
		$pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
    	$query = "SELECT Name, Id, AnnualRevenue FROM Account ORDER BY Id LIMIT 10 OFFSET 0";
		$pn = 1;//set page number to 1 
		
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
		
		$theDiv = "<div class='container'><div class='table-responsive' style='overflow: hidden;'><table class='table table-condensed table-hover'>";
		
		foreach ((array) $records as $record) {
		
        $theDiv .= "<tr><td width='33%'>".$record['Id']."</td><td width='33%'>".$record['Name']."</td><td width='33%'>$".$record['AnnualRevenue']."</td></tr>";
    }	
	$theDiv .= "</table></div></div>";
	}

    echo "<div class='container-fluid'><div class='bg-primary' align='center'><h2>$total_size record(s) returned</h2></div></div><br/><br/>
    <div class='container'><div class='table-responsive' style='overflow: hidden;'><table class='table'><tr><td width='33%'><h3>ID</h3></td><td width='33%'><h3>Name</h3></td><td width='33%'><h3>AnnualRevenue</h3></td></tr></table>";	
	echo $theDiv;
	function returnSize(){
    return $total_size;
	}
    //echo "<br/>";
}
//This is where we set how many database items to show on each page 
$itemsPerPage = 10; 

// Get the value of the last page in the pagination result set
$lastPage = ceil($the_total_size / $itemsPerPage);

// Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
if ($pn < 1) { // If it is less than 1
    $pn = 1; // force if to be 1
} else if ($pn > $lastPage) { // if it is greater than $lastpage
    $pn = $lastPage; // force it to be $lastpage's value
} 
// This creates the numbers to click in between the next and back buttons
// This section is explained well in the video that accompanies this script
$centerPages = "";
$sub1 = $pn - 1;
$sub2 = $pn - 2;
$add1 = $pn + 1;
$add2 = $pn + 2;
if ($pn == 1) {
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
} else if ($pn == $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
} else if ($pn > 2 && $pn < ($lastPage - 1)) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub2 . '">' . $sub2 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add2 . '">' . $add2 . '</a> &nbsp;';
} else if ($pn > 1 && $pn < $lastPage) {
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $sub1 . '">' . $sub1 . '</a> &nbsp;';
    $centerPages .= '&nbsp; <span class="pagNumActive">' . $pn . '</span> &nbsp;';
    $centerPages .= '&nbsp; <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $add1 . '">' . $add1 . '</a> &nbsp;';
}
// This line sets the "LIMIT" range... the 2 values we place to choose a range of rows from database in our query
$limit = 'LIMIT ' .($pn - 1) * $itemsPerPage .',' .$itemsPerPage;
	
//////Adam's Pagination Display Setup /////////////////////////////////////////////////////////////////////
$paginationDisplay = ""; // Initialize the pagination output variable
// This code runs only if the last page variable is ot equal to 1, if it is only 1 page we require no paginated links to display
if ($lastPage != "1"){
    // This shows the user what page they are on, and the total number of pages
    $paginationDisplay .= '<div class="pagination">Page <strong>' . $pn . '</strong> of ' . $lastPage. '&nbsp;  &nbsp;  &nbsp; ';
    // If we are not on page 1 we can place the Back button
    if ($pn != 1) {
        $previous = $pn - 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $previous . '"> Back</a> ';
    } 
    // Lay in the clickable numbers display here between the Back and Next links
    $paginationDisplay .= '<span class="paginationNumbers">' . $centerPages . '</span>';
    // If we are not on the very last page we can place the Next button
    if ($pn != $lastPage) {
        $nextPage = $pn + 1;
        $paginationDisplay .=  '&nbsp;  <a href="' . $_SERVER['PHP_SELF'] . '?pn=' . $nextPage . '"> Next</a></div>';
    } 
}

//////////////////////////////pagination/////////////////////////////////////////////////////////////////

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
<?php echo $paginationDisplay; ?>

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
