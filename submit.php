<?php
require_once("util/include.php");
include("checkLogin.php");
$step1 = "submitSteps";
$step2 = "submitSteps";
$step3 = "submitSteps";
$submitted = false;
if(isset($_GET['step'])) {
    if(isset($_POST['csrf'])) { //Look at possibly making the greater if statement require this
        if ($_GET['step'] == 2) {
            if (isset($_POST['ontology']))
                $_SESSION['ontology']['ontology'] = $_POST['ontology'];
        }
        if ($_GET['step'] == 3) {
            if (!isset($_SESSION['ontology']['superclass']) && isset($_POST['superclass']))
                $_SESSION['ontology']['superclass'] = $_POST['superclass'];
            if (isset($_POST['ontology'])) {
                $response = $curl->post(Constants::ONTOLOBRIDGE_URL . "requests/RequestTerm",$_POST);
                if ($httpCode === 0) {
                    $_SESSION['message'] = "backend has went away";
                    redirect("/");
                }else if ($httpCode !== 200) {
                    $_SESSION['message'] = $data['message'];
                    redirect("/");
                }else {
                    $submitted = true;
                }
            }
        }

    }
    $_SESSION['step'] = $_GET['step'];
}

//check if we have needed items for step 3 or not default to step 2
if(isset($_SESSION['step']) && $_SESSION['step'] == 3) {
    if (!isset($_SESSION['ontology']) || !isset($_POST['superclass']))
        $_SESSION['step'] = 2;
    else {
        if(!isset($_SESSION['ontology']['superclass']) && isset($_POST['superclass']))
            $_SESSION['ontology']['superclass'] =$_POST['superclass'];
        $step3 .= " activeStep";
    }
}
//check if we have needed items for step 2 or default to step 1
if(isset($_SESSION['step']) && $_SESSION['step'] == 2) {
    if (!$_SESSION['ontology'])
        $_SESSION['step'] = 1;
    else {
        $step2 .= " activeStep";
        if(!isset($_SESSION['ontology']))
            $_SESSION['ontology'] = [];
    }
}
if(!isset($_SESSION['step']) || $_SESSION['step'] == 1) {
    $step1 .= " activeStep";
    unset ($_SESSION['ontology']);
}

$extraTags = '<link rel="stylesheet" href="css/jquery-ui.min.css">';
?>

<?php include("header.php"); ?>
<body>
<?php include("navBar.php"); ?>
<script src="js/jquery-ui.js"></script>
<main class="container" role="main">
    <?php include("util/displayMessage.php"); ?>

    <div class="row">
    <div class="col-2"></div>
    <div class="col-2">
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
    </div>
    <div class="col-8">
        <div class="d-inline">
            <?php if($submitted) {?>
                <div class="row">
                    <div class="col-2"> </div>
                    <div class="col-8 text-center">Requests Submitted</div>
                    <div class="col-2"> </div>
                </div>

            <?php }else if(!isset($_SESSION['step']) || $_SESSION['step'] == 1) { ?>
                <script>
                    $(function() {
                        $( "#ontologies" ).autocomplete({
                            source: "ontologies",
                            minLength: 2,
                            select: function( event, ui ) {
                                $("body").append('<form id="ontology-form" action="?step=2" method="post"></form>');
                                $("<input />").attr("type", "hidden")
                                    .attr("name", "ontology")
                                    .attr("value", ui.item.value)
                                    .appendTo("#ontology-form");
                                $("<input />").attr("type", "hidden")
                                    .attr("name", "csrf")
                                    .attr("value", 1)
                                    .appendTo("#ontology-form");
                                $("#ontology-form").trigger("submit")
                            }
                        });
                    } );
                </script>
                <input id="ontologies">
            <?php } else if($_SESSION['step'] == 2) { ?>
                <div id="dialog-confirm" title="Confirm Parent Class">
                    <p id ="parent-confirm"><span  class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>Do you want to</p>
                </div>
                <link rel="stylesheet" type="text/css" href="http://bioportal.bioontology.org/widgets/minified/jquery.ncbo.tree.min.css">
                <script src="/widgets/jquery.ncbo.tree-2.0.2.js"></script>
                <div id="widget_tree"></div>
                <script src="http://bioportal.bioontology.org/widgets/minified/jquery.ncbo.tree-2.0.2.min.js "></script>
                <script>
                        var widget_tree = $("#widget_tree").NCBOTree({
                            apikey: "f44ba7ce-84c7-45de-8ff9-c0d3f604b719",
                            ontology: "<?php echo $_SESSION['ontology']['ontology'] ?>",
                            afterSelect: function(event, classId, prefLabel, selectedNode){
                                $("#parent-confirm").text("Do you want to select "+classId+"("+event+") as the parent for your requests")
                                $( "#dialog-confirm" ).dialog({
                                    resizable: false,
                                    height: "auto",
                                    width: 400,
                                    modal: true,
                                    buttons: {
                                        "Select Class": function() {
                                            $("body").append('<form id="ontology-form" action="?step=3" method="post"></form>');
                                            $("<input />").attr("type", "hidden")
                                                .attr("name", "superclass")
                                                .attr("value", event)
                                                .appendTo("#ontology-form");
                                            $("<input />").attr("type", "hidden")
                                                .attr("name", "csrf")
                                                .attr("value", 1)
                                                .appendTo("#ontology-form");
                                            $("#ontology-form").trigger("submit")
                                        },
                                        Cancel: function() {
                                            $( this ).dialog( "close" );
                                        }
                                    }
                                });
                            }
                        });
                </script>
            <?php }
            else if($_SESSION['step'] == 3) { ?>
                <script type="text/javascript">
                    $(function() {
                        $(document).on('click', '#btnSend', function () {
                            $(".field-form").map(function() {
                                $("<input />").attr("type", "hidden")
                                    .attr("name", $(this).attr("id"))
                                    .attr("value", $(this).val())
                                    .appendTo("#form");
                            })
                            $("<input />").attr("type", "hidden")
                                .attr("name", "csrf")
                                .attr("value", 1)
                                .appendTo("#form");
                            $("#form").trigger("submit")
                        });
                    });
                </script>
              <form action="" id="form" method="post">
                  <div class="row">
                      <div class="col-2"> </div>
                      <div class="col-8 text-center">Ontology Submission Form</div>
                      <div class="col-2"> </div>
                  </div>
                  <div class="row">
                      <div class="col-2"> </div>
                      <div class="col-2">Ontology:</div>
                      <div class="col-6"><input class ="container-fluid field-form" type="text" id="ontology" value="<?php echo $_SESSION['ontology']['ontology']; ?>"></div>
                      <div class="col-2"> </div>
                  </div>
                  <div class="row">
                      <div class="col-2"> </div>
                      <div class="col-2">Superclass:</div>
                      <div class="col-6"><input class ="container-fluid field-form" type="text" id="superclass" value="<?php echo $_SESSION['ontology']['superclass']; ?>"></div>
                      <div class="col-2"> </div>
                  </div>
                  <div class="row">
                      <div class="col-2"> </div>
                      <div class="col-2">Label:</div>
                      <div class="col-6"><input class ="container-fluid field-form" type="text" id="label"></div>
                      <div class="col-2"> </div>
                  </div>
                  <div class="row">
                      <div class="col-2"> </div>
                      <div class="col-2">Description:</div>
                      <div class="col-6"><textarea class ="container-fluid field-form" id="description"></textarea></div>
                      <div class="col-2"> </div>
                  </div>
                  <div class="row">
                      <div class="col-2"> </div>
                      <div class="col-2">Justification:</div>
                      <div class="col-6"><textarea class ="container-fluid field-form" id="justification"></textarea></div>
                      <div class="col-2"> </div>
                  </div>
                  <div class="row">
                      <div class="col-2"> </div>
                      <div class="col-2">References:</div>
                      <div class="col-6"><textarea class ="container-fluid field-form" id="references"></textarea></div>
                      <div class="col-2"> </div>
                  </div>
                  <div class="row">
                      <div class="col-6"> </div>
                      <div class="col">
                          <div  class="btn btn-secondary btn-lg" id="btnSend">Submit</div>
                      </div>
                      <div class="col-4"> </div>
                  </div>
              </form>
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