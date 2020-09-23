<?php
session_start();
if(!isset($_SESSION['username'])){
    $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
    $_SESSION['message'] = "You must be logged in to access this";
    header('Location: /login',303);
    die();
}