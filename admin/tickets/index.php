<?php include "connection.php" ?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <title>CopyStudio</title>
    <!--Stylesheet -->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" />
    <!--Stylesheet -->
    <link rel="stylesheet" type="text/css" href="assets/vendor/swall/sweetalert.css">

</head>
<body>
<div class="back">
    <a href="../welcome.php" class="m-3" title="Nazad"><i class="fas fa-long-arrow-alt-left"></i></a>
</div>
<div class="w-100 h-100 users-div" style="background: black">
    <div class="container-fluid">
        <button type="button" id="add_button" class="btn btn-primary m-4" data-toggle="modal" data-target="#exampleModalCenter">
            Dodaj novog korisnika
        </button>
        <br>
        <table id="user_data" class="table table-striped table-bordered" style="width:100%">
            <thead class="thead-dark">
            <tr>
                <th>Broj kupona</th>
                <th>Slika</th>
                <th>Ime</th>
                <th>Prezime</th>
                <th>Telefon</th>
                <th>E-mail</th>
                <th>Ustanova</th>
                <th>Trenutni broj poena</th>
                <th style="width: 5%"></th>
                <th style="width: 5%"></th>
                <th style="width: 5%"></th>
            </tr>
            </thead>
        </table>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Novi kupac</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" id="user_form" enctype="multipart/form-data">
                    <label class="control-label">Izaberi sliku</label>
                    <div class="custom-file">
                        <input type="file" onblur="$(this).valid()" id="image" name="image" class="custom-file-input" data-buttonText="Ubaci" autofocus/>
                        <label class="custom-file-label" for="image" id="imageLabel"></label>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Unesi broj kupona</label>
                        <input type="text" name="txt_ticket_number" id="txt_ticket_number"  onblur="$(this).valid()" class="form-control" placeholder="" required >
                    </div>
                    <div class="form-group">
                        <label class="control-label">Unesi ime</label>
                        <input type="text" name="txt_name" id="txt_name"  onblur="$(this).valid()" class="form-control" placeholder="" required >
                    </div>
                    <div class="form-group">
                        <label class="control-label">Unesi prezime</label>
                        <input type="text" name="txt_last_name" id="txt_last_name"  onblur="$(this).valid()" class="form-control" placeholder="" required>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Unesi broj telefona</label>
                        <input type="text" name="txt_phone" id="txt_phone"   onblur="$(this).valid()" class="form-control" placeholder="" required>
                        <p class="blockquote-footer">(xxx)xxx-xxx</p>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Unesi e-mail</label>
                        <input type="text" name="txt_email" id="txt_email"  onblur="$(this).valid()" class="form-control" placeholder="" >
                        <p class="blockquote-footer">xxxxxx@xxxx.xxx</p>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Unesi naziv institucije</label>
                        <input type="text" name="txt_institution" id="txt_institution"  onblur="$(this).valid()" class="form-control" placeholder="" >
                    </div>

            </div>
            <div class="modal-footer">
                <input type="hidden" name="user_id" id="user_id" />
                <input type="hidden" name="operation" id="operation" />
                <input type="submit" name="action" id="action" class="btn btn-primary" value="Dodaj" />
                <button type="button" class="btn btn-secondary" id="dismiss-modal" data-dismiss="modal">Odustani</button>
            </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>

    <script>
        $('#image').on('change',function(e){
            //get the file name
            var fileName = e.target.files[0].name;
            //replace the "Choose a file" label
            $('#imageLabel').text(fileName);
        })
    </script>


    <script type="text/javascript" language="javascript" src="assets/js/user.js" ></script>
    <script type="text/javascript" language="javascript" src="assets/vendor/swall/sweetalert.js" ></script>
    <script type="text/javascript" language="JavaScript" src="../../js/pagination.js"></script>

    <script src="assets/vendor/form-validation/jquery.form.js"></script>
    <script src="assets/vendor/form-validation/jquery.validate.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/77c0d793ed.js" crossorigin="anonymous"></script>
    <!--Bootstrap Scripts-->
    <script src="https://kit.fontawesome.com/77c0d793ed.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>