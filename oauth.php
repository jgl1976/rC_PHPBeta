<?php
2
require_once 'config.php';
3
 
4
$auth_url = LOGIN_URI
5
        . "/services/oauth2/authorize?response_type=code&client_id="
6
        . CLIENT_ID . "&redirect_uri=" . urlencode(REDIRECT_URI);
7
 
8
header('Location: ' . $auth_url);
9
?>
