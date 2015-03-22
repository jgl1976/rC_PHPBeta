<?php
session_start();
include_once ("functions.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>rC PHP DMA</title>

</head>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

    <head>
    <title>rC PHP DMA</title>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    </head>
<body>
<div class="container">

<h1>DMA PHP App</h1>
<img src="img/beta.png" alt="Beta" class="img-rounded"><br>
<h2>Please sign into Salesforce</h2>
<?php flash('error'); ?>



<script type="text/javascript" language="javascript">
    if (location.protocol != "https:") {
        document.write("OAuth will not work correctly from plain http. "+ "Please use an https URL.");
    } else {
        document.write("<a href=\"oauth.php\" class=\"btn btn-primary btn-lg\">Sign In</a>");
    }
</script>



    </div> <!-- /container -->
</body>

</html>
