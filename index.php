<?php
include_once("util/include.php");
?>
<?php include("header.php"); ?>
<body>

<script src="js/bootstrap.bundle.js"></script>
<script src="js/bootstrap.js"></script>
<?php include("navBar.php"); ?>
<main class="container" role="main">
    <?php include("util/displayMessage.php"); ?>
    <div class="row">
        <div class="col">
            <img class="img-fluid" src="img/Workflow.png" />
        </div>
    </div>
    <div class="row">
        <div class="col-5"> </div>
        <div class="col-2 text-center">
            <a class="btn btn-danger btn-lg container-fluid" href="submit">Start</a>
        </div>
        <div class="col-5"> </div>
    </div>
</main>
<?php
    echo file_get_contents("footer.html");
?>
</body>
</html>