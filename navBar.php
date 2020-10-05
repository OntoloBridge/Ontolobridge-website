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