<?php
require_once("util/include.php");
include("checkLogin.php");
$step1 = "submitSteps";
$step2 = "submitSteps";
$step3 = "submitSteps";

//check if we have needed items for step 3 or not default to step 2
if(isset($_SESSION['step']) && $_SESSION['step'] == 2) {
    if (!isset($_SESSION['newRequests']) || !isset($_SESSION['newRequests']['superClass']))
        $_SESSION['step'] = 2;
    else
        $step3 .= " activeStep";
}
//check if we have needed items for step 2 or default to step 1
if(isset($_SESSION['step']) && $_SESSION['step'] == 2) {
    if (!isset($_SESSION['newRequests']) || !isset($_SESSION['newRequests']['ontology']))
        $_SESSION['step'] = 1;
    else
        $step2 .= " activeStep";
}
if(!isset($_SESSION['step']) || $_SESSION['step'] == 1) {
    $_SESSION['step'] = 1;
    $step1 .= " activeStep";
}


?>

<?php include("header.php"); ?>

<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">Ontolobridge</h5>
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

<div class="container">
    <div class="d-inline-block alert alert-secondary">
       <div class="stepTitle">
           Request A New Term
       </div><br>
       <div class="<?php echo $step1; ?> text-center">
           <span>Step 1: </span><br>
           Find An ontology
       </div><br>
       <div class="<?php echo $step2; ?> text-center">
           <span>Step 2: </span><br>
           Find term in hierarchy
       </div><br>
       <div class="<?php echo $step3; ?> text-center">
           <span>Step 3: </span><br>
           Describe Term
       </div>
    </div>
    <div class="d-inline">
    </div>
</div>
<?php
    echo file_get_contents("footer.html");
?>
</body>
</html>