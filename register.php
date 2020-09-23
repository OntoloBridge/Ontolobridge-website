<?php
include_once("util/include.php");

if(isset($_POST['email']) &&isset($_POST['password'])) {
    $curl->setHeader('Accept', 'application/json');
    $postData = [];

// assign username and password to psot data
    $postData['email'] = $_POST['email'];
    $postData['name'] = $_POST['email'];
    $postData['password'] = $_POST['password'];
    $postData['anon'] = $_POST['anon']==="on";

//post to register requests
    $response = $curl->post(Constants::ONTOLOBRIDGE_URL . "auth/register", $postData);
    $httpCode = $curl->http_status_code;
    $data = json_decode($response, true);

//if we had a code of 0 something went wrong or timed out
    if ($httpCode === 0) {
        $_SESSION['message'] = "backend has went away";
        redirect("/index");
    }else if ($httpCode === 200) {
        $_SESSION['message'] = "Register Successfully, Please check your email for verification link";
        $_SESSION['message_type'] = "success";
    }else{
        $_SESSION['message'] = $data['message'];
    }
}
?>

<?php include("header.php"); ?>
<body>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
    <script src="js/bootstrap.js"></script>
    <script type="text/javascript">
        $(function() {
            $(document).on('click', '#btnSend', function () {
                $("<input />").attr("type", "hidden")
                    .attr("name", "email")
                    .attr("value", $("#email").val())
                    .appendTo("#form");
                $("<input />").attr("type", "hidden")
                    .attr("name", "name")
                    .attr("value", "")
                    .appendTo("#form");
                $("<input />").attr("type", "hidden")
                    .attr("name", "password")
                    .attr("value", $("#password").val())
                    .appendTo("#form");
                $("<input />").attr("type", "hidden")
                    .attr("name", "anon")
                    .attr("value", $("#anon").val())
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
            <div class="row">
                <div class="col-4"> </div>
                <div class="col text-center">User Registration</div>
                <div class="col-4"> </div>
            </div>
            <?php include("util/displayMessage.php"); ?>
            <div class="row">
                <div class="col-4"> </div>
                <div class="col">Email:</div>
                <div class="col"><input class ="container-fluid" type="text" id="email"></div>
                <div class="col-4"> </div>
            </div>
            <div class="row">
                <div class="col-4"> </div>
                <div class="col">Password:</div>
                <div class="col"><input class ="container-fluid" type="password" id="password"></div>
                <div class="col-4"> </div>
            </div>
            <div class="row">
                <div class="col-4"> </div>
                <div class="col">Anonymize Email?</div>
                <div class="col"><input class ="container-fluid" type="checkbox" id="anon"></div>
                <div class="col-4"> </div>
            </div>
            <div class="row text-center">
                <form action="/register" method="post" id="form" name="form" ></form>
                <div class="col"><div  class="btn btn-secondary btn-lg" id="btnSend">Register</div></div>
            </div>
        </div>
    </div>
    <?php
        echo file_get_contents("footer.html");
    ?>
</body>
</html>