<?php
session_start();
include_once ("functions.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>rC-DMCS</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    </head>
<body>
<div class="container">
<div class="row">
<div class="col-md-4"></div>
<div class="col-md-4"><p class="text-center"><h1>rC-DMCS</h1></p>
<img src="img/beta.png" alt="Beta" class="img-rounded"><br>
<h3>roundCorner Data Migration Calculator System</h3>
<h4>Log into SalesForce to gain access to the rC-DMCS Gateway</h4>
<?php flash('error'); ?>



<script type="text/javascript" language="javascript">
    if (location.protocol != "https:") {
        document.write("OAuth will not work correctly from plain http. "+ "Please use an https URL.");
    } else {
        document.write("<a href=\"oauth.php\" class=\"btn btn-primary btn-lg\">Sign In</a>");
    }
</script></div>
<div class="col-md-4"></div>

</div>
    </div> <!-- /container -->
</body>

</html>
