<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

session_start();

$access_token = $_SESSION['access_token'];
$instance_url = $_SESSION['instance_url'];


if (!isset($_GET['objectChosen'])) {
    $object = "Opportunity";
    $pn     = 1;
} else {
    $object = $_GET['objectChosen'];
}
 
if (!isset($access_token) || $access_token == "") {
    header('Location: https://php-restbeta.herokuapp.com');
    die("Error - access token missing from session!");
}
 
if (!isset($instance_url) || $instance_url == "") {
    header('Location: https://php-restbeta.herokuapp.com');
    die("Error - instance URL missing from session!");
}

function curlRequest($query, $instance_url, $access_token)
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
    $pn = "";
    
    $object = "Opportunity";
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

    $response = curlRequest($query, $instance_url, $access_token);
    
    $total_size = $response['totalSize'];
    
        $pn = preg_replace('#[^0-9]#i', '', $_GET['pn']); // filter everything but numbers for security(new)
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
        $offset = $pn * $itemsPerPage - $itemsPerPage;
        
        $query = "SELECT $field1, $field2, $field3, $field4, $field5, $field6 FROM $object ORDER BY $field1 LIMIT $itemsPerPage OFFSET $offset";
        
        $response = curlRequest($query, $instance_url, $access_token);
        

        $records = $response['records'];
        
        /* Pagination Display Setup */

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
                        
        $theDiv = "<br/><div class='container'><div class='table-responsive'><table class='table table-condensed table-hover'>";
        
        foreach ((array) $records as $record) {
            
            if ($record[$field1] === null) {
                $record[$field1] = "null";
            }
            if ($record[$field2] === null) {
                $record[$field2] = "null";
            }
            if ($record[$field3] === null) {
                $record[$field3] = "null";
            }
            if ($record[$field4] === null) {
                $record[$field4] = "null";
            }
            if ($record[$field5] === null) {
                $record[$field5] = "null";
            }
            if ($record[$field6] === null) {
                $record[$field6] = "null";
            }
            
            $theDiv .= "<tr>
            <td width='14%'>" . $record[$field1] . "</td>
            <td width='14%'>" . $record[$field2] . "</td>
            <td width='14%'>" . $record[$field3] . "</td>
            <td width='14%'>" . $record[$field4] . "</td>
            <td width='14%'>" . $record[$field5] . "</td>
            <td width='14%'>" . $record[$field6] . "</td>
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
            <input type='submit' class='btn btn-warning' value='Edit Record' /></form>
            </td>
            </tr>";
        }
        
        $theDiv .= "</table></div></div>";
        echo $paginationDisplay;
   
    echo "
    <div class='container-fluid'>
    <div class='bg-primary' align='center'><h2>You are in $object | Total Number Of Records: $total_size</h2></div></div><br/><br/>
    <div class='container'><div class='table-responsive' style='overflow: hidden;'><table class='table'><tr><td width='14%'><h3>$field1</h3></td><td width='14%'><h3>$field2</h3></td>
    <td width='14%'><h3>$field3</h3></td><td width='14%'><h3>$field4</h3></td><td width='14%'><h3>$field5</h3></td>
    <td width='14%'><h3>$field6</h3></td><td width='14%'><h3>Edit Record</h3></td></tr></table>";
    echo $theDiv;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>rC PHP DMA</title>
    <style>
        @import url(http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css);
        body{margin-top:20px;}
        .fa-fw {width: 2em;}
    </style>
    </head>
    <body>
   <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <ul class="nav nav-pills nav-stacked">
                    <li class="active"><a href="#"><i class="fa fa-home fa-fw"></i>Opportunity</a></li>
                    <li><a href=""><i class="fa fa-file-o fa-fw"></i>Contact</a></li>
                    <li><a href=""><i class="fa fa-bar-chart-o fa-fw"></i>Account</a></li>
                    <li><a href=""><i class="fa fa-table fa-fw"></i>Logout</a></li>
                </ul>
            </div>
            <div class="col-md-9 well">
                <form method="get" action="' . $_SERVER['PHP_SELF'] . '" class="navbar-form navbar-left" role="search">
                    Seach for: <input type="text" name="find" class="form-control" placeholder="Search"/>
                    <input type="hidden" name="pn" value="1" />
                    <input type="submit" class="btn btn-default" value="Search" />
                </form>            
            </div>
            <div class="col-md-9 well">
                <?php show_accounts($instance_url, $access_token); ?>
            </div>
        </div>
    </div>

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