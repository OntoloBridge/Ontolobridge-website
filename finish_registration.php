<?php
include_once("util/include.php");
include("checkLogin.php");
//we have a login requests
//check if we have all the required details set before you can use the website.

$response = $curl->get(Constants::ONTOLOBRIDGE_URL."auth/getAllDetails");
$httpCode = $curl->http_status_code;
if ($httpCode === 0) {
    $_SESSION['message'] = "backend has went away";
}
$detailsForm = json_decode($response, true); //get the details to fill out
$detailFields = [];
foreach ($detailsForm['data'] as $detail){
    $detailFields[]=$detail['field'];
}
if(isset($_POST['formSubmit'])) {
    $submitPostData = [];
    $submitPostData['fields'] = [];
    $submitPostData['data'] = [];
    foreach ($_POST as $key => $value){
        if(!in_array($key,$detailFields))
            continue;
        $submitPostData['fields'][] = $key;
        $submitPostData['data'][] = $value;
    }
    $response = $curl->post(Constants::ONTOLOBRIDGE_URL."user/details",$submitPostData);
    $httpCode = $curl->http_status_code;
    if ($httpCode === 0) {
        $_SESSION['message'] = "backend has went away";
    }
    if ($httpCode === 200) {
        $_SESSION['message'] = "Settings Saved";
        redirect("/");
    }
}
$response = $curl->get(Constants::ONTOLOBRIDGE_URL."user/details");
$httpCode = $curl->http_status_code;
if ($httpCode === 0) {
    $_SESSION['message'] = "backend has went away";
}
$data = json_decode($response, true); //get current user details if available
$userDetails = $data['details'];
?>
<?php include("header.php"); ?>
<body xmlns="http://www.w3.org/1999/html">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/bootstrap.js"></script>
    <script type="text/javascript">
        $(function() {
            $(document).on('click', '#btnSend', function () {
                $(".field-form").map(function() {
                    $("<input />").attr("type", "hidden")
                        .attr("name", $(this).attr("id"))
                        .attr("value", $(this).val())
                        .appendTo("#form");
                })
                $("#form").trigger("submit")
            });
        });
    </script>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal">Ontolobridge</h5>
    </div>

    <div class="container d-flex h-100">
        <div class="row align-self-center w-100">
            <div class="row">
                <div class="col-4"> </div>
                <div class="col text-center">Finish Registration</div>
                <div class="col-4"> </div>
            </div>
            <?php include("util/detailsForm.php"); ?>
            <div class="row text-center">
                <form action="/finish_registration" method="post" id="form" name="form">
                    <input type="hidden" name="formSubmit" value="1">
                </form>
                <div class="col"><div  class="btn btn-secondary btn-lg" id="btnSend">Finish Registration</div></div>
            </div>
        </div>
    </div>
    <?php
    echo file_get_contents("footer.html");
    ?>
</body>
</html>