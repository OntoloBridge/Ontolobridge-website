<?php
session_start();
include_once("curl.php");
include_once("constants.php");
include_once("utils.php");
$curl = new OntolobridgeCurl();
$curl->beforeSend("addToken");
$curl->complete("curlComplete");

//Allow changing of color of message box on pages
$message_type = "warning";
$message = "";
//if we have a status message set the global variable so it can be displayed
if(session_status() != PHP_SESSION_NONE){
    if(isset($_SESSION['message_type'])) {
        $message_type = $_SESSION['message_type'];
        unset( $_SESSION['message_type']);
    }
    if(isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        unset( $_SESSION['message']);
    }
}