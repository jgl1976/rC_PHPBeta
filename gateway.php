<?php
session_start();

include_once ("functions.php");

$access_token = $_SESSION['access_token'];
$instance_url = $_SESSION['instance_url'];


if (!isset($access_token) || $access_token == "") {
    flash('error', 'Access Token Missing Login Below!' );
    header('Location: https://fathomless-fjord-6605.herokuapp.com');
}
 
if (!isset($instance_url) || $instance_url == "") {
    flash('error', 'Instance Url missing' );
    header('Location: https://fathomless-fjord-6605.herokuapp.com');
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
        <div class="col-md-4"></div>
            <div class="col-md-4">
            <div class="panel panel-primary">
    <div class="panel-heading"> <p class="text-center"><h1>rC-DMCS</h1></p></div>
     <div class="panel-body">roundCorner Data Migration Calculator System</div>
     <div class="panel-footer">Version 0.5.3</div>
</div>
                
            </div><div class="col-md-4"></div>
            <div class="col-md-12 well">
                        <p class="text-center">Welcome to the rC-DMCS. Please give us a second to change.</p> 
            </div>
            <div class="col-md-12">
            <div class="col-md-3"></div>
            <div class="col-md-3">
                <p class="text-center"><a href="layout.php">Data Migration</a></p>
            </div>
            <div class="col-md-3">
            <p class="text-center"> <a href="#">Calculator</a></p>
            </div>
            <div class="col-md-3"></div>
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