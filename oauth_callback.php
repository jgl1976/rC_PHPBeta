<?php
02
require_once 'config.php';
03
 
04
session_start();
05
 
06
$token_url = LOGIN_URI . "/services/oauth2/token";
07
 
08
$code = $_GET['code'];
09
 
10
if (!isset($code) || $code == "") {
11
    die("Error - code parameter missing from request!");
12
}
13
 
14
$params = "code=" . $code
15
    . "&grant_type=authorization_code"
16
    . "&client_id=" . CLIENT_ID
17
    . "&client_secret=" . CLIENT_SECRET
18
    . "&redirect_uri=" . urlencode(REDIRECT_URI);
19
 
20
$curl = curl_init($token_url);
21
curl_setopt($curl, CURLOPT_HEADER, false);
22
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
23
curl_setopt($curl, CURLOPT_POST, true);
24
curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
25
 
26
$json_response = curl_exec($curl);
27
 
28
$status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
29
 
30
if ( $status != 200 ) {
31
    die("Error: call to token URL $token_url failed with status $status, response $json_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
32
}
33
 
34
curl_close($curl);
35
 
36
$response = json_decode($json_response, true);
37
 
38
$access_token = $response['access_token'];
39
$instance_url = $response['instance_url'];
40
 
41
if (!isset($access_token) || $access_token == "") {
42
    die("Error - access token missing from response!");
43
}
44
 
45
if (!isset($instance_url) || $instance_url == "") {
46
    die("Error - instance URL missing from response!");
47
}
48
 
49
$_SESSION['access_token'] = $access_token;
50
$_SESSION['instance_url'] = $instance_url;
51
 
52
header( 'Location: demo_rest.php' ) ;
53
?>