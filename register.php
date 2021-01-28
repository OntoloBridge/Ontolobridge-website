<?php
include_once("util/include.php");
 include("header.php"); ?>
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

<?php include("navBar.php"); ?>
<main class="container" role="main">
    <?php include("util/displayMessage.php"); ?>
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
</main>
    <?php
        echo file_get_contents("footer.html");
    ?>
</body>
</html>