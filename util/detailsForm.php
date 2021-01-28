<?php
foreach($detailsForm['data'] as $detail){
    $currentDetail= "";
    if($userDetails != null && array_key_exists($detail['field'],$userDetails)) //if the field is already set then populate the field.
        $currentDetail= $userDetails[$detail['field']];
    ?>
    <div class="row">
        <div class="col-2"> </div>
        <div class="col-3"><?php echo $detail['pretty_name'];?> <?php echo $detail['required']==1?"*":"";?>:</div>
        <div class="col-3">
            <?php if ($detail['field_type'] == "text"){ ?>
                <input class ="container-fluid field-form" type="text" id="<?php echo $detail['field'];?>" value="<?php echo $currentDetail;?>">
            <?php }else if ($detail['field_type'] == "list") { ?>
                <select class ="container-fluid field-form" id="<?php echo $detail['field'];?>" value="<?php echo $currentDetail;?>">
                    <?php foreach($detail['allowed_values'] as $aValue){ ?>
                        <option <?php echo $aValue==$currentDetail?"selected":""; ?>value="<?php echo $aValue; ?>"><?php echo $aValue; ?> </option>
                    <?php }?>
                </select>
            <?php } ?>
        </div>
        <div class="col-4"> </div>
    </div>
    <?php
}
?>
