<?php
require_once("util/include.php");

//we have a login requests
if(isset($_POST['email'])) {

    $curl->setHeader('Accept', 'application/json');
    $postData =[];

    // assign username and password to psot data
    $postData['email'] = $_POST['email'];

    //post to login requests
    $response = $curl->post(Constants::ONTOLOBRIDGE_URL."user/request_reset_password",$postData);
    $httpCode = $curl->http_status_code;
    $data = json_decode($response, true);

    //if we had a code of 0 something went wrong or timed out
    if ($httpCode === 0) {
        $_SESSION['message'] = "backend has went away";
        redirect("/reset_password");
    }
    //code not 200 means we should have an error back
    //TODO: Check if Missing user role and redirect to complete registration
    if ($httpCode !== 200) {
        $_SESSION['message'] = $data['message'];
        redirect("/reset_password");
    }
    $_SESSION['message'] = "If a user is associated with this email a reset should have been sent";
}
if(isset($_POST['token'])) {

    $curl->setHeader('Accept', 'application/json');
    $postData =[];

    // assign username and password to psot data
    $postData['token'] = $_POST['token'];
    $postData['password'] = $_POST['password'];

    //post to login requests
    $response = $curl->get(Constants::ONTOLOBRIDGE_URL."user/reset_password",$postData);
    $httpCode = $curl->http_status_code;
    $data = json_decode($response, true);

    //if we had a code of 0 something went wrong or timed out
    if ($httpCode === 0) {
        $_SESSION['message'] = "backend has went away";
        redirect("/reset_password");
    }
    //code not 200 means we should have an error back
    //TODO: Check if Missing user role and redirect to complete registration
    if ($httpCode !== 200) {
        $_SESSION['message'] = $data['message'];
        redirect("/reset_password");
    }
    $_SESSION['message'] = "If a user is associated with this email a reset should have been sent";
}
?>
<?php include("header.php"); ?>
<script type="text/javascript">
    $(function() {
        $(document).on('click', '#btnSend', function () {
            <?php if(!isset($_GET['token'])) { ?>
                $("<input />").attr("type", "hidden")
                    .attr("name", "email")
                    .attr("value", $("#email").val())
                    .appendTo("#form");
            <?php }else{ ?>
                $("<input />").attr("type", "hidden")
                    .attr("name", "token")
                    .attr("value", "<?php echo $_GET['token'] ?>")
                    .appendTo("#form");
                $("<input />").attr("type", "hidden")
                    .attr("name", "password")
                    .attr("value", $("#password1").val())
                    .appendTo("#form");
            <?php } ?>
            $("#form").trigger("submit");
        });
        $(document).on('keydown',function(e) {
            if ((e.key === 'Enter' || e.keyCode === 13)
                && $("#email").val()){
                $('#btnSend').trigger('click')
            }
        });
    });
</script>
<body>
<?php include("navBar.php"); ?>
<main class="container" role="main">
    <?php include("util/displayMessage.php"); ?>
    <div class="container d-flex h-100">
        <div class="row align-self-center w-100">
            <div class="col-6 mx-auto">
                <?php if(!isset($_GET['token'])) { ?>
                    <div class="jumbotron">
                        <div class="row text-center">
                            <div class="col text-center font-weight-bold">
                                Reset Password
                            </div>
                        </div>
                        <?php include("util/displayMessage.php"); ?>
                        <div class="row">
                            <div class="col">Email:</div>
                        </div>
                        <div class="row">
                            <div class="col"><input class ="container-fluid" type="text" id="email"></div>
                        </div>
                        <hr>
                        <div class="row text-center">
                            <form action="/reset_password" method="post" id="form" name="form"></form>
                            <div class="col"><div  class="btn btn-primary btn-lg" id="btnSend">Request Reset</div></div>
                        </div>
                    </div>
                <?php }else{ ?>
                    <div class="jumbotron">
                        <div class="row text-center">
                            <div class="col text-center font-weight-bold">
                                Reset Password
                            </div>
                        </div>
                        <?php include("util/displayMessage.php"); ?>
                        <div class="row">
                            <div class="col">Password:</div>
                        </div>
                        <div class="row">
                            <div class="col"><input class ="container-fluid" type="text" id="password1"></div>
                        </div>
                        <div class="row">
                            <div class="col">Password Confirm:</div>
                        </div>
                        <div class="row">
                            <div class="col"><input class ="container-fluid" type="text" id="password2"></div>
                        </div>
                        <hr>
                        <div class="row text-center">
                            <form action="/reset_password" method="post" id="form" name="form"></form>
                            <div class="col"><div  class="btn btn-primary btn-lg" id="btnSend">Change Password</div></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
    <?php
        echo file_get_contents("footer.html");
    ?>
</body>
</html>