<?php
include_once("util/include.php");
include("checkLogin.php");
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
                    .attr("name", "username")
                    .attr("value", $("#username").val())
                    .appendTo("#form");
                $("<input />").attr("type", "hidden")
                    .attr("name", "password")
                    .attr("value", $("#password").val())
                    .appendTo("#form");
                $("#form").submit();
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
            <div class="row">
                <div class="col-4"> </div>
                <div class="col">First Name:</div>
                <div class="col"><input class ="container-fluid" type="text" id="fname"></div>
                <div class="col-4"> </div>
            </div>
            <div class="row">
                <div class="col-4"> </div>
                <div class="col">Last Name:</div>
                <div class="col"><input class ="container-fluid" type="password" id="lname"></div>
                <div class="col-4"> </div>
            </div>
            <div class="row">
                <div class="col-4"> </div>
                <div class="col">Current Role in Company/University:</div>
                <div class="col"><input class ="container-fluid" type="password" id="role"></div>
                <div class="col-4"> </div>
            </div>
            <div class="row">
                <div class="col-4"> </div>
                <div class="col">Company/University</div>
                <div class="col"><input class ="container-fluid" type="password" id="employer"></div>
                <div class="col-4"> </div>
            </div>
            <div class="row text-center">
                <form action="/register" method="post" id="form" name="form"></form>
                <div class="col"><a href="register"></a><div  class="btn btn-secondary btn-lg">Finish Registration</div></a></div>
            </div>
        </div>
    </div>
    <?php
    echo file_get_contents("footer.html");
    ?>
</body>
</html>