<?php
function redirect($url){
    if(!headers_sent())
        header($url,303);
    echo "<script type='text/javascript'>window.onload =function() {window.location.replace('$url');};</script>";
    die();
}

/**
 * @param OntolobridgeCurl $curl
 */
function checkRefreshToken($curl){
    //if we have a token set and the url contains the ontolobridge url, add the authorization header
    if(isset($curl->response_headers['jwtToken']) && isset($_SESSION['token']))
        $_SESSION['token'] = $curl->response_headers['jwtToken'];
}
/**
 * @param OntolobridgeCurl $curl
 */
function addToken($curl){
    //if we have a token set and the url contains the ontolobridge url, add the authorization header
    if(isset($_SESSION['token'])&& strpos($curl->url, Constants::ONTOLOBRIDGE_URL) !== false )
        $curl->setHeader("authorization","Bearer ".$_SESSION['token']);
}

function destroy_sessions(){
    if(session_status() != PHP_SESSION_NONE)
        session_destroy();
}