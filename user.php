<?php
include_once("util/include.php");
include("checkLogin.php");

if(isset($_POST['formSubmit'])) {
    $submitPostData = [];
    $submitPostData['fields'] = [];
    $submitPostData['data'] = [];
    foreach ($_POST as $key => $value){
        $submitPostData['fields'][] = $key;
        $submitPostData['data'][] = $value;
    }
    $response = $curl->post(Constants::ONTOLOBRIDGE_URL."user/details",$submitPostData);
    $httpCode = $curl->http_status_code;
    if ($httpCode === 0) {
        $_SESSION['message'] = "backend has went away";
    }
    if ($httpCode === 200) {
        $_SESSION['message'] = "Settings Saved";
        redirect("/");
    }
}

$extraTags = "<link rel=\"stylesheet\" href=\"https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css\">
<style type='text/css'>
    .dataTables_wrapper .dataTables_filter{
         float:left;
         text-align:left
    }
    .dataTables_wrapper .dataTables_length{
         float:right;
         text-align:right
    }
</style>
";
include("header.php");
?>
<body>

<script src="js/bootstrap.bundle.js"></script>
<script src="js/bootstrap.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(function() {
        $('#termTable').DataTable( {
            "dom":"<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    if(column.index() != 1 && column.index() != 3  )
                        return;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo(column.header())
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        } );
        <?php if(in_array("ROLE_CURATOR",$_SESSION['roles'])){ ?>
        $('#maintainerTable').DataTable( {
            "dom":"<'row'<'col-sm-12 col-md-6'f><'col-sm-12 col-md-6'l>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    if(column.index() != 1 && column.index() != 3  )
                        return;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo(column.header())
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }
        } );
        <?php } ?>
        $(document).on('click', '#btnSend', function () {
            $(".field-form").map(function() {
                $("<input />").attr("type", "hidden")
                    .attr("name", $(this).attr("id"))
                    .attr("value", $(this).val())
                    .appendTo("#form");
            })
            $("#form").trigger("submit")
        });
        $(".request_access_button").on("click",
            function() {
                window.location.href = "/requests/"+$(this).attr("data-ontoid");
            }
        )
    } );
</script>
<?php include("navBar.php"); ?>
<main class="container" role="main">
    <?php include("util/displayMessage.php"); ?>
    <div class="row">
        <ul class="nav nav-tabs" id="userTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#user" role="tab" aria-controls="user"
                   aria-selected="true">Ontology User</a>
            </li>
            <?php if(in_array("ROLE_CURATOR",$_SESSION['roles'])){ ?>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#developer" role="tab" aria-controls="developer"
                   aria-selected="false">Ontology Developer</a>
            </li>
            <?php } ?>
            <li class="nav-item">
                <a class="nav-link" id="contact-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                   aria-selected="false">Profile</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="user" role="tabpanel" aria-labelledby="user-tab">
                <div class="row">
                    <div class="col-4"> </div>
                    <div class="col-4 text-center">
                        Previously Requested Terms
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row">
                    <div class="col-1"> </div>
                    <div class="col-10 text-center">
                        <table id="termTable">
                            <thead>
                            <tr>
                                <th>Term</th>
                                <th>Ontology</th>
                                <th>Data Submitted</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $response = $curl->get(Constants::ONTOLOBRIDGE_URL . "user/requests");
                            $httpCode = $curl->http_status_code;
                            if ($httpCode !== 200) {
                                echo "<tr><td colspan='5'>Error Loading Requests</td></tr>";
                            }else{
                                $data = json_decode($response, true); //get current user details if available
                                foreach ($data as $value){
                                    echo "
                    <tr>
                        <td>".$value['label']."</td>
                        <td>".$value['superclass_ontology']."</td>
                        <td>".$value['datetime']."</td>
                        <td>".$value['status']."</td>
                        <td><button type=\"button\" class='request_access_button' data-ontoid='".$value['request_id']."'>View Request</button></td>
                    </tr>";
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-1"> </div>
                </div>
                <div class="row last-row">
                    <div class="col-4"> </div>
                    <div class="col-4 text-center">
                        <a class="btn btn-danger btn-lg container-fluid" href="submit">Requests New Term</a>
                    </div>
                    <div class="col-4"> </div>
                </div>
            </div>
            <?php if(in_array("ROLE_CURATOR",$_SESSION['roles'])){ ?>
            <div class="tab-pane fade" id="developer" role="tabpanel" aria-labelledby="developer-tab">
                <div class="row">
                    <div class="col-4"> </div>
                    <div class="col-4 text-center">
                        Terms Waiting
                    </div>
                    <div class="col-4"> </div>
                </div>
                <div class="row">
                    <div class="col-1"> </div>
                    <div class="col-10 text-center">
                        <table id="maintainerTable">
                            <thead>
                            <tr>
                                <th>Term</th>
                                <th>Ontology</th>
                                <th>Data Submitted</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $response = $curl->get(Constants::ONTOLOBRIDGE_URL . "user/maintainer_requests");
                            $httpCode = $curl->http_status_code;
                            if ($httpCode !== 200) {
                                echo "<tr><td colspan='5'>Error Loading Requests</td></tr>";
                            }else{
                                $data = json_decode($response, true); //get current user details if available
                                foreach ($data as $value){
                                    echo "
                    <tr>
                        <td>".$value['label']."</td>
                        <td>".$value['superclass_ontology']."</td>
                        <td>".$value['datetime']."</td>
                        <td>".$value['submitter_email']."</td>
                        <td>".$value['status']."</td>
                        <td><button type=\"button\" class='request_access_button' data-ontoid='".$value['request_id']."'>View Request</button></td>
                    </tr>";
                                }
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-1"> </div>
                </div>
                <div class="row last-row">
                    <div class="col-4"> </div>
                    <div class="col-4 text-center">
                        <a class="btn btn-danger btn-lg container-fluid" href="submit">Requests New Term</a>
                    </div>
                    <div class="col-4"> </div>
                </div>
            </div>
            <?php }?>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <?php
                $response = $curl->get(Constants::ONTOLOBRIDGE_URL."auth/getAllDetails");
                $httpCode = $curl->http_status_code;
                if ($httpCode === 0) {
                    $_SESSION['message'] = "backend has went away";
                }
                $detailsForm = json_decode($response, true); //get the details to fill out
                $detailFields = [];
                foreach ($detailsForm['data'] as $detail){
                    $detailFields[]=$detail['field'];
                }
                $response = $curl->get(Constants::ONTOLOBRIDGE_URL."user/details");
                $httpCode = $curl->http_status_code;
                if ($httpCode === 0) {
                    $_SESSION['message'] = "backend has went away";
                }
                $data = json_decode($response, true); //get current user details if available
                $userDetails = $data['details'];
                ?>
                <div class="row">
                    <div class="col-2"> </div>
                    <div class="col-3">Name:</div>
                    <div class="col-3"><input class ="container-fluid field-form" type="text" id="name" value="<? echo $data['name']?>"></div>
                    <div class="col-4"> </div>
                </div>
                <div class="row">
                    <div class="col-2"> </div>
                    <div class="col-3">Email:</div>
                    <div class="col-3"><input class ="container-fluid field-form" type="text" id="email" value="<? echo $data['email']?>"></div>
                    <div class="col-4"> </div>

                </div>
                <div class="row">
                    <div class="col-2"> </div>
                    <div class="col-3">Password:</div>
                    <div class="col-3"><input class ="container-fluid field-form" type="text" id="pass" ></div>
                    <div class="col-4"> </div>

                </div>
                <div class="row">
                    <div class="col-2"> </div>
                    <div class="col-3">Password Confirm:</div>
                    <div class="col-3"><input class ="container-fluid field-form" type="text" id="pass2"></div>
                    <div class="col-4"> </div>

                </div>
                <?php include("util/detailsForm.php"); ?>
                <div class="row text-center">
                    <form action="" method="post" id="form" name="form">
                        <input type="hidden" name="formSubmit" value="1">
                    </form>
                    <div class="col"><div  class="btn btn-secondary btn-lg" id="btnSend">Save</div></div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
echo file_get_contents("footer.html");
?>
</body>
</html>
