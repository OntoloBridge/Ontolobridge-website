<div class="row">
    <div id="messageBox" class="col text-center fade show alert-dismissible alert alert-<?php echo $message_type." ".(empty($message)?"invisible":"") ?>">
        <?php echo $message; ?>
        <button type="button" class="close align-self-end" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        <br>
        <span style="background-color: lightgrey"><?php echo (!empty($message)?"This box will close in 5 seconds":""); ?></span>

    </div>
</div>
<script type="text/javascript">
    $(function() {
        const mBox = $("#messageBox");
        if(!mBox.hasClass("invisible")){
                setTimeout(function()
                {
                    mBox.alert("close");
                }, 5000);
        }
    })
</script>
<?php $message  = ""; ?>