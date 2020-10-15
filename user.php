<?php
include_once("util/include.php");
include("checkLogin.php");
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
include("header.php"); ?>
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
    } );
</script>
<?php include("navBar.php"); ?>
<main class="container" role="main">
    <?php include("util/displayMessage.php"); ?>
    <div class="row">
        <div class="col-3">
            <div class="btn btn-info btn-lg container-fluid">Ontology User</div>
        </div>
        <div class="col-3">
            <div class="btn btn-info btn-lg container-fluid">Ontology Developer</div>
        </div>
        <div class="col-6">
        </div>
    </div>
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
                        <td></td>
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
</main>
<?php
echo file_get_contents("footer.html");
?>
</body>
</html>
