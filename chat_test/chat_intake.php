<?php
session_start();
$text = "";
if(isset($_POST['text']) && isset($_SESSION['uname'])) {
    $text = $_SESSION['uname']." said: ".$_POST['text']."\n";
    $handle = fopen("chat.txt", "a");
    fwrite($handle, $text);
    fclose($handle);
    exit();
}
if(isset($_POST['uname'])) {
    $_SESSION['uname'] = $_POST['uname'];
    echo "success";
    exit();
}
?>