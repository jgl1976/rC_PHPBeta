<?php
//comment
session_start();

 

function show_accounts($instance_url, $access_token) {

    $query = "SELECT Name, Id from Account LIMIT 100";

    $url = "$instance_url/services/data/v20.0/query?q=" . urlencode($query);

 

    $curl = curl_init($url);

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

        echo $record['Id'] . ", " . $record['Name'] . "<br/>";

    }

    echo "<br/>";

}

 

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
