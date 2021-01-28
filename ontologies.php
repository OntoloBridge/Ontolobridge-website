<?php
include_once("util/curl.php");
include_once("util/utils.php");
include_once("util/constants.php");
$curl = new OntolobridgeCurl();
$curl->beforeSend("addToken");
$response = $curl->get(Constants::ONTOLOBRIDGE_URL . "retrieve/ontologies");
$httpCode = $curl->http_status_code;
$response = json_decode($response,true);
if ($httpCode !== 200) {
    json_encode(['Error'=>$httpCode,'response'=>$response]);
}else{
    $output = [];
    foreach($response as $ontology){
        $output[]=['value'=>$ontology['ontology_short'],'label'=>$ontology['name']];
    }
    echo json_encode($output);
}