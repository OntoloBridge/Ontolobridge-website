<?php
include_once("util/include.php");
include("checkLogin.php");
include("header.php"); ?>
<body>

<script src="js/bootstrap.bundle.js"></script>
<script src="js/bootstrap.js"></script>
<?php include("navBar.php"); ?>
<main class="container" role="main">
    <?php include("util/displayMessage.php"); ?>
    <?php
        $getData['requestID'] = $_GET['q'];
        $response = $curl->get(Constants::ONTOLOBRIDGE_URL . "user/RequestStatus",$getData);
        $httpCode = $curl->http_status_code;
        if ($httpCode !== 200) {
            echo "<tr><td colspan='5'>Error Loading Requests</td></tr>";
        }else {
            $data = json_decode($response, true); //get current user details if available
?>
    <div class="row">
        <div class="col">
            <div class="row">
                <div class="col-2"> </div>
                <div class="col-2">Label:</div>
                <div class="col-6"><div class="d-inline"><?php echo $data['label'] ?></div><input class ="container-fluid field-form hidden" type="text" id="Label"></div>
                <div class="col-2"> </div>
            </div>
            <div class="row">
                <div class="col-2"> </div>
                <div class="col-2">Ontology:</div>
                <div class="col-6"><div class="d-inline"><?php echo $data['ontology'] ?></div><input class ="container-fluid field-form hidden" type="text" id="ontology" value="Ontology"></div>
                <div class="col-2"> </div>
            </div>
            <div class="row">
                <div class="col-2"> </div>
                <div class="col-2">Superclass:</div>
                <div class="col-6"><div class="d-inline"><?php echo $data['superclass_ontology'].":".$data['superclass_id'] ?></div><input class ="container-fluid field-form hidden" type="text" id="superclass" value="test"></div>
                <div class="col-2"> </div>
            </div>
            <div class="row">
                <div class="col-2"> </div>
                <div class="col-2">Description:</div>
                <div class="col-6"><div class="d-inline"><?php echo $data['description'] ?></div><textarea class ="container-fluid field-form hidden" id="description"></textarea></div>
                <div class="col-2"> </div>
            </div>
            <div class="row">
                <div class="col-2"> </div>
                <div class="col-2">Justification:</div>
                <div class="col-6"><div class="d-inline"><?php echo $data['justification'] ?></div><textarea class ="container-fluid field-form hidden" id="justification"></textarea></div>
                <div class="col-2"> </div>
            </div>
            <div class="row">
                <div class="col-2"> </div>
                <div class="col-2">References:</div>
                <div class="col-6"><div class="d-inline"><?php echo $data['references'] ?></div><textarea class ="container-fluid field-form hidden" id="references"></textarea></div>
                <div class="col-2"> </div>
            </div>
            <div class="row">
                <div class="col-2"> </div>
                <div class="col-2">Change Reason:</div>
                <div class="col-6"><select class="hidden">
                        <?php if(in_array("ROLE_CURATOR",$_SESSION['roles'])){ ?>
                            <option value="accept">Accept as is</option>
                            <option value="accept">Requests Response</option>
                            <option value="accept">Reject</option>
                        <?php } else { ?>
                            <option value="accept">Cancel</option>
                        <?php } ?>
                        <option value="comment">Add comment</option>
                    </select></div>
                <div class="col-2"> </div>
            </div>
            <div class="row">
                <div class="col-2"> </div>
                <div class="col-6"><div class="d-inline"></div><textarea class ="container-fluid field-form hidden" id="Comment"></textarea></div>
                <div class="col-4"><div  class="btn btn-secondary btn-lg hidden" id="btnSend">Submit</div></div>
            </div>
        </div>
        <div class="col">
            <div class="text-center">Term History</div>
            <?php
            $getData['requestID'] = $_GET['q'];
            $response = $curl->get(Constants::ONTOLOBRIDGE_URL . "user/RequestHistory",$getData);
            $httpCode = $curl->http_status_code;
            if ($httpCode !== 200) {
                echo "<tr><td colspan='5'>Error Loading Requests</td></tr>";
            }else {
                $historyData = json_decode($response, true); //get current user details if available
            ?>
            <div class="row">
                <table id="historyTable">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action Owner</th>
                        <th>Comment</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody><?php
                    foreach ($historyData as $value){
                        echo "
                            <tr>
                                <td>".$value['current_status']."</td>
                                <td>".date('m/d/Y', $value['timestamp'])."</td>
                                <td>".($data['user_id'] == $value['user_id']?"User":"Maintainer")."</td>
                                <td>".$value['message']."</td>
                            </tr>";
                        }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php }?>
        </div>
    </div>
            <?php
            }
    ?>
</main>
<?php
    echo file_get_contents("footer.html");
?>
</body>
</html>