<?php
session_start();

if(!isset($_SESSION['username'])){
    $_SESSION['redirect'] = $_SERVER['REQUEST_URI'];
    $_SESSION['message'] = "You must be logged in to access this";
    header('Location: /login',303);
    die();
}else{
    $response = $curl->get(Constants::ONTOLOBRIDGE_URL . "auth/checkToken");
    $httpCode = $curl->http_status_code;
    if ($httpCode === 0) {
        destroy_sessions();
        $_SESSION['message'] = "backend has went away";
        redirect("/login");
    }
    if ($httpCode !== 200) {
        destroy_sessions();
        session_start();
        $_SESSION['message'] = "Session has expired, please login again";
        redirect("/login");
    }
}