<?php
require_once ("util/include.php");
if(isset($_GET['verify'])) {
    $response = $curl->get(Constants::ONTOLOBRIDGE_URL . "auth/verify?verify=" . $_GET['verify']);
    $httpCode = $curl->http_status_code;

    $data = json_decode($response, true);

//if we had a code of 0 something went wrong or timed out
    if ($httpCode === 0) {
        $_SESSION['message'] = "backend has went away";
        redirect("/index");
    } else {
        if ($httpCode !== 200) {
            $_SESSION['message'] = "Email Successfully Verified";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = $data['message']; //defaults to warning message
        }
        redirect("/index");
    }
}