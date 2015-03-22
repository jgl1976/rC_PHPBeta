<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

//comment yeah
session_start();

function curlResponse($query)
{
    $url  = "$instance_url/services/data/v33.0/query?q=" . urlencode($query);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array(
        "Authorization: OAuth $access_token"
    ));
    $json_response = curl_exec($curl);
    curl_close($curl);
    return json_decode($json_response, true);
}

function show_accounts($instance_url, $access_token)
{
    
    $object = "";
    $pn     = "";
    
    if (!isset($_GET['objectChosen'])) {
        $object = "Opportunity";
        $pn     = 1;
    } else {
        $object = $_GET['objectChosen'];
    }
    
    /*if($object == "Account"){
    echo "You Chose Account";   
    }else if($object == "Opportunity"){
    echo "You Chose Opportunity";
    }else if($object == "Contact"){
    echo "You Chose Contact";
    } */
    $object = "Opportunity"
    $field1 = "Id";
    $field2 = "rC_Giving__Giving_Type__c";
    $field3 = "rC_Giving__Calculated_Giving_Type__c";
    $field4 = "rC_Giving__Affiliation__c";
    $field5 = "rC_Giving__Giving_Type_Engine__c";
    $field6 = "rC_Giving__Close_Date_Time__c";
    

    /*if ($object == "Account") {
        $field1 = "Id";
        $field2 = "Phone";
        $field3 = "Name";
        $field4 = "rC_Bios__Acquired_Date__c";
        $field5 = "rC_Giving__Lifetime_Hard_Credit_Amount__c";
        $field6 = "rC_Giving__Lifetime_Soft_Credit_Amount__c";
    } else if ($object == "Opportunity") {
        $field1 = "Id";
        $field2 = "rC_Giving__Giving_Type__c";
        $field3 = "rC_Giving__Calculated_Giving_Type__c";
        $field4 = "rC_Giving__Affiliation__c";
        $field5 = "rC_Giving__Giving_Type_Engine__c";
        $field6 = "rC_Giving__Close_Date_Time__c";
    } else if ($object == "Contact") {
        $field1 = "Id";
        $field2 = "Birthdate";
        $field3 = "rC_Giving__Largest_Hard_Credit_Amount__c";
        $field4 = "rC_Bios__Age__c";
        $field5 = "rC_Bios__Birth_Year__c";
        $field6 = "rC_Bios__Gender__c";
    }*/
    
    $query = "SELECT $field1, $field2, $field3, $field4, $field5, $field6 FROM $object";
        exit();

    $response = curlResponse($query);
    
    print_r($response);

    $total_size = $response['totalSize'];
    
        $pn           = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
        //This is where we set how many database items to show on each page 
        $itemsPerPage = 20;
        // Get the value of the last page in the pagination result set
        $lastPage     = ceil($total_size / $itemsPerPage);
        // Be sure URL variable $pn(page number) is no lower than page 1 and no higher than $lastpage
        if ($pn < 1) { // If it is less than 1
            $pn = 1; // force if to be 1
        } else if ($pn > $lastPage) { // if it is greater than $lastpage
            $pn = $lastPage; // force it to be $lastpage's value
        }
        $offset = $pn * 10 - 10;
        
        $query = "SELECT $field1, $field2, $field3, $field4, $field5, $field6 FROM $object ORDER BY $field1 LIMIT $itemsPerPage OFFSET $offset";
        
        $response = curlResponse($query); ////use curl function
        

        $records = $response['records'];
        
        //////Adam's Pagination Display Setup /////////////////////////////////////////////////////////////////////
        $paginationDisplay = ""; // Initialize the pagination output variable
        // This code runs only if the last page variable is not equal to 1, if it is only 1 page we require no paginated links to display
        if ($lastPage != "1") {
            // This shows the user what page they are on, and the total number of pages
            $paginationDisplay .= '<div class="pagination" style="text-align: center;">';
            //If we are on page one, generate disabled previous arrow
            if ($pn == 1) {
                $paginationDisplay .= '<nav><ul class="pagination pagination-lg"><li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
            }
            // If we are not on page 1 we can place the Back button
            if ($pn > 1) {
                $previous = $pn - 1;
                $paginationDisplay .= '<nav><ul class="pagination pagination-lg"><li><a href="' . $_SERVER['PHP_SELF'] . '?objectChosen=' . $object . '&pn=' . $previous . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
                // Render clickable number links that should appear on the left of the target page number
                for ($i = $pn - 2; $i < $pn; $i++) {
                    if ($i > 0) {
                        $paginationDisplay .= '<li><a href="' . $_SERVER['PHP_SELF'] . '?objectChosen=' . $object . '&pn=' . $i . '">' . $i . '</a><li>';
                    }
                }
            }
            // Render the target page number, but without it being a link
            $paginationDisplay .= '<li class="active"><span>' . $pn . '</span></li>';
            // Render clickable number links that should appear on the right of the target page number
            for ($i = $pn + 1; $i <= $lastPage; $i++) {
                $paginationDisplay .= '<li><a href="' . $_SERVER['PHP_SELF'] . '?objectChosen=' . $object . '&pn=' . $i . '">' . $i . '</a> &nbsp;<li>';
                if ($i >= $pn + 2) {
                    break;
                }
            }
            //If we are not on the very last page we can place the Next button*/
            if ($pn != $lastPage) {
                $nextPage = $pn + 1;
                $paginationDisplay .= '<li><a href="' . $_SERVER['PHP_SELF'] . '?objectChosen=' . $object . '&pn=' . $nextPage . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li></ul>
</nav>Page <strong>' . $pn . '</strong> of ' . $lastPage . '</div>';
            } // This does the same as above, only checking if we are on the last page, and then generating the "Next"
            if ($pn == $lastPage) {
                //$nextPage = null;
                $paginationDisplay .= '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li></ul>
</nav></div>';
            }
        }
        //////////////////////////////pagination/////////////////////////////////////////////////////////////////
        
        $searchBar = '<form method="get" action="' . $_SERVER['PHP_SELF'] . '" class="navbar-form navbar-left" role="search">Seach for: <input type="text" name="find" class="form-control" placeholder="Search"/> in  <Select name="objectChosen"><Option value="Opportunity">Opportunity</option><Option value="Contact">Contact</option><Option value="Account">Account</option> </Select><input type="hidden" value="yes" /><input type="hidden" name="pn" value="1" /><input type="submit" class="btn btn-default" value="Search" /></form>';
        
        echo $searchBar;
        
        $theDiv = "<br/><div class='container'><div class='table-responsive'><table class='table table-condensed table-hover'>";
        
        foreach ((array) $records as $record) {
            
            if ($record[$field1] == is_null) {
                $record[$field1] = "nothin";
            }
            if ($record[$field2] == is_null) {
                $record[$field2] = "nothin";
            }
            if ($record[$field3] == is_null) {
                $record[$field3] = "nothin";
            }
            if ($record[$field4] == is_null) {
                $record[$field4] = "nothin";
            }
            if ($record[$field5] == is_null) {
                $record[$field5] = "nothin";
            }
            if ($record[$field6] == is_null) {
                $record[$field6] = "nothin";
            }
            
            $theDiv .= "<tr><td width='14%'>" . $record[$field1] . "</td><td width='14%'>" . $record[$field2] . "</td><td width='14%'>" . $record[$field3] . "</td>
        <td width='14%'>" . $record[$field4] . "</td><td width='14%'>" . $record[$field5] . "</td><td width='14%'>" . $record[$field6] . "</td>
        <td width='14%'>
        <form name='editRecord' method='post' action='editRecord.php' class='navbar-form navbar-left'>
        <input type='hidden' name='rId' value='$record[$field1]' />
        <input type='hidden' name='field2' value='$record[$field2]' />
        <input type='hidden' name='field3' value='$record[$field3]' />
        <input type='hidden' name='field4' value='$record[$field4]' />
        <input type='hidden' name='field5' value='$record[$field5]' />
        <input type='hidden' name='field6' value='$record[$field6]' />
        <input type='hidden' name='fieldName1' value='$field1' />
        <input type='hidden' name='fieldName2' value='$field2' />
        <input type='hidden' name='fieldName3' value='$field3' />
        <input type='hidden' name='fieldName4' value='$field4' />
        <input type='hidden' name='fieldName5' value='$field5' />
        <input type='hidden' name='fieldName6' value='$field6' />
        <input type='hidden' name='tblName' value='$object' />
        <input type='submit' class='btn btn-warning' value='Edit Record' /></form></td></tr>";
        }
        
        $theDiv .= "</table></div></div>";
        echo $paginationDisplay;
   
    echo "<div class='container-fluid'><div class='bg-primary' align='center'><h2>You are in $object | Total Number Of Records: $total_size</h2></div></div><br/><br/>
    <div class='container'><div class='table-responsive' style='overflow: hidden;'><table class='table'><tr><td width='14%'><h3>$field1</h3></td><td width='14%'><h3>$field2</h3></td>
    <td width='14%'><h3>$field3</h3></td><td width='14%'><h3>$field4</h3></td><td width='14%'><h3>$field5</h3></td>
    <td width='14%'><h3>$field6</h3></td><td width='14%'><h3>Edit Record</h3></td></tr></table>";
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