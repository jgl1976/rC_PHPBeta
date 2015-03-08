<?php
session_start();
 
function show_accounts($instance_url, $access_token) {
    $sqlCommand = "SELECT Id, Name, AnnualRevenue, Industry from Opportunities LIMIT 100";
    $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);
$allInfo = "";

$query = mysql_query($sqlCommand) or die (mysql_error());
$rows = mysql_fetch_row($query); 
	
	if ($num_rows > 0) {
		$allInfo = '<div class="allInfo">';

		// get all the video details
		while($row = mysql_fetch_array($sql2)){ 
			 $id = $row["Id"];
			 $name = $row["Name"];
			 $annualRevenue = $row["AnnualRevenue"];
			 $industry = $row["Industry"];
			 
			 
			 //echo $id, $name, $annualRevenue, $industry;		 
         }
		 $allInfo .="</div>";
	}
}
    /*$curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Authorization: OAuth $access_token"));
 
    $json_response = curl_exec($curl);
    curl_close($curl);
 
    $response = json_decode($json_response, true);
 
    $total_size = $response['totalSize'];
 
    echo "$total_size record(s) returned<br/><br/>";
    foreach ((array) $response['records'] as $record) {
        $allInfo .= $record['Id'] . ", " . $record['Name'] . ", " . $record['AnnualRevenue'] . ", " . $record['Industry'] . "<br/>";
    }
	echo $allInfo . "<br/>";
}*/
 
function create_account($name, $instance_url, $access_token) {
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
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>roundCorner Data Migration</title>
    </head>
    <body>
        <tt>
            <?php
            /*$access_token = $_SESSION['access_token'];
            $instance_url = $_SESSION['instance_url'];
 
            if (!isset($access_token) || $access_token == "") {
                die("Error - access token missing from session!");
            }
 
            if (!isset($instance_url) || $instance_url == "") {
                die("Error - instance URL missing from session!");
            }
            show_accounts($instance_url, $access_token);
            $id = create_account("My New Org", $instance_url, $access_token);
            show_account($id, $instance_url, $access_token);
            show_accounts($instance_url, $access_token);
            update_account($id, "My New Org, Inc", "San Francisco",
                    $instance_url, $access_token);
            show_account($id, $instance_url, $access_token);
            show_accounts($instance_url, $access_token);
            delete_account($id, $instance_url, $access_token);
            show_accounts($instance_url, $access_token);*/
            ?>
        </tt>
<table id="events-id2" class="table table-bordered" data-url="data1.json" data-height="299" data-search="true">
    <thead>
    <tr>
        <th data-field="state" data-checkbox="true"></th>
        <th data-field="id" data-sortable="true">Item ID</th>
        <th data-field="name" data-sortable="true">Item Name</th>
        <th data-field="price" data-sortable="true">Item Price</th>
        <th data-field="operate" data-formatter="operateFormatter" data-events="operateEvents">Item Operate</th>
    </tr>
    </thead>
</table>
<script>
    function operateFormatter(value, row, index) {
        return [
            '<a class="like" href="javascript:void(0)" title="Like">',
                '<i class="glyphicon glyphicon-heart"></i>',
            '</a>',
            '<a class="edit ml10" href="javascript:void(0)" title="Edit">',
                '<i class="glyphicon glyphicon-edit"></i>',
            '</a>',
            '<a class="remove ml10" href="javascript:void(0)" title="Remove">',
                '<i class="glyphicon glyphicon-remove"></i>',
            '</a>'
        ].join('');
    }
    window.operateEvents = {
        'click .like': function (e, value, row, index) {
            alert('You click like icon, row: ' + JSON.stringify(row));
            console.log(value, row, index);
        },
        'click .edit': function (e, value, row, index) {
            alert('You click edit icon, row: ' + JSON.stringify(row));
            console.log(value, row, index);
        },
        'click .remove': function (e, value, row, index) {
            alert('You click remove icon, row: ' + JSON.stringify(row));
            console.log(value, row, index);
        }
    };
</script>
<script src="js/bootstrap.min.js" type="text/javascript"></script>
<?php echo $allInfo; ?>
    </body>
</html>
