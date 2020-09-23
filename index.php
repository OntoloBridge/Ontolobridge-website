<?php
include_once("util/include.php");
?>
<?php include("header.php"); ?>
<body>

<script src="js/bootstrap.bundle.js"></script>
<script src="js/bootstrap.js"></script>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">Ontolobridge</h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="/api/">API</a>
        <a class="p-2 text-dark" href="about.php">About</a>
        <a class="p-2 text-dark" href="#">Help</a>
    </nav>
    <?php
    if(!isset($_SESSION['username'])){
    ?>
    <a class="btn btn-primary" href="login">Sign up</a>
    <?php
    }else{
        ?>
    <div>
        <div class="row">
        <?php echo $_SESSION['username'];?>
        </div>
        <div class="row">
            <a href="/login?logout">sign out</a>
        </div>
    </div>
    <?php
    }
    ?>
</div>
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