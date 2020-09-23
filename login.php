<?php
require_once("util/include.php");

if(isset($_SESSION['username']) && isset($_GET['logout'])){
    destroy_sessions();
    redirect("/index.php");
    die();
}

//we have a login requests
if(isset($_POST['username']) &&isset($_POST['password'])) {

    $curl->setHeader('Accept', 'application/json');
    $postData =[];

    // assign username and password to psot data
    $postData['email'] = $_POST['username'];
    $postData['password'] = $_POST['password'];

    //post to login requests
    $response = $curl->post(Constants::ONTOLOBRIDGE_URL."auth/login",$postData);
    $httpCode = $curl->http_status_code;
    $data = json_decode($response, true);

    //if we had a code of 0 something went wrong or timed out
    if ($httpCode === 0) {
        $_SESSION['message'] = "backend has went away";
        redirect("/login");
    }
    //code not 200 means we should have an error back
    //TODO: Check if Missing user role and redirect to complete registration
    if ($httpCode !== 200) {
        $_SESSION['message'] = $data['message'];
        redirect("/login");
    }
    $data = json_decode($response, true);
    $_SESSION['username'] = $data['username'];
    $_SESSION['token'] = $data['accessToken'];

    //check if we have all the required details set before you can use the website.
    $response = $curl->get(Constants::ONTOLOBRIDGE_URL."auth/checkDetails");
    $httpCode = $curl->http_status_code;
    if ($httpCode === 0) {
        destroy_sessions();
        $_SESSION['message'] = "backend has went away";
        redirect("/login");
    }
    if ($httpCode !== 200) {
        destroy_sessions();
        $_SESSION['message'] = $data['message'];
        redirect("/login");
    }
    $data = json_decode($response, true);
    $data['count'] = 0;
    //if we have all the required data then send to front page, otherwise request the details
    if($data['count'] == 0) {
        $_SESSION['message'] = "Login Success";
        $_SESSION['message_type']="success";
        redirect("/index.php");
    }else {
        redirect("/finish_registration");
    }
}
?>
<?php include("header.php"); ?>
<body>

    <script type="text/javascript">
        $(function() {
            $(document).on('click', '#btnSend', function () {
                $("<input />").attr("type", "hidden")
                    .attr("name", "username")
                    .attr("value", $("#username").val())
                    .appendTo("#form");
                $("<input />").attr("type", "hidden")
                    .attr("name", "password")
                    .attr("value", $("#password").val())
                    .appendTo("#form");
                $("#form").trigger("submit");
            });
        });
    </script>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal">Ontolobridge</h5>
    </div>

    <div class="container d-flex h-100">
        <div class="row align-self-center w-100">
            <div class="col-6 mx-auto">
                <div class="jumbotron">
                    <div class="row text-center">
                        <div class="col text-center font-weight-bold">
                            Log in
                        </div>
                    </div>
                    <?php include("util/displayMessage.php"); ?>
                    <div class="row">
                        <div class="col">Username:</div>
                    </div>
                    <div class="row">
                        <div class="col"><input class ="container-fluid" type="text" id="username"></div>
                    </div>
                    <div class="row">
                        <div class="col">Password:</div>
                    </div>
                    <div class="row">
                        <div class="col"><input class ="container-fluid" type="password" id="password"></div>
                    </div>
                    <div class="row text-center">
                        <form action="/login" method="post" id="form" name="form"></form>
                        <div class="col"><div  class="btn btn-primary btn-lg" id="btnSend">Log In</div></div>
                    </div>
                    <hr>
                    <div class="row text-center">
                        <div class="col"><a href="/register"><div  class="btn btn-secondary btn-lg">Register</div></a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        echo file_get_contents("footer.html");
    ?>
</body>
</html>