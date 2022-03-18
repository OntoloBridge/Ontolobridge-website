<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Ontolobridge - About</title>
    <!-- Bootstrap CSS file -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/bootstrap-grid.css">
    <link rel="stylesheet" href="css/bootstrap-reboot.css">
    <link rel="stylesheet" href="css/bootstrap-utilities.css">
    <link rel="stylesheet" href="css/footer.css">

</head>
<body>

<script src="js/bootstrap.bundle.js"></script>
<script src="js/bootstrap.js"></script>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal">Ontolobridge</h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="/api/">API</a>
        <a class="p-2 text-dark">About</a>
        <a class="p-2 text-dark" href="#">Help</a>
    </nav>
    <a class="btn btn-primary" href="#">Sign up</a>
</div>

<main class="container" role="main">
    <?php include("util/displayMessage.php"); ?>
    <div class="row">
        <div class="col">
<div><b>About this grant</b></div>

<div>The U01 grant supports collaborative substantial programmatic development between NIH and awarded institutes. Award Number 1U01LM012630-01 from National Center for Advancing Translational Sciences as described on NIH Reporter supports this project. The content is so$

<div><b>About CDD</b></div>

<div>CDD’s flagship product, CDD Vault®, is a modern web application for your chemical registration, assay data management and SAR analysis. CDD Vault® is a hosted database solution for secure management and sharing of biological and chemical data. It lets you intuitivel$

<div><b>About Schürer Lab at the University of Miami</b></div>

<div>The Schürer lab operates at the Department of Pharmacology in the Miller School of Medicine and the Center for Computational Science (http://ccs.miami.edu/focus-area/drug-discovery/) at the University of Miami. The core research theme at the Schürer group is systems$

<div><b>About Stanford University’s Center for Biomedical Informatics Research</b></div>

<div>The Stanford Center for Biomedical Informatics Research (BMIR) studies the development and evaluation of advanced computational methods to enhance biomedicine. BMIR is home to the Center for Expanded Data Annotation and Retrieval (CEDAR), which offers modular, REST-$
<br>
        </div>
    </div>
</main>

<?php
    echo file_get_contents("footer.html")
?>
</body>
</html>
