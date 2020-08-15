<?php
/**
 * Created by PhpStorm.
 * User: comp
 * Date: 3/15/2020
 * Time: 1:32 PM
 */
session_set_cookie_params(0);
session_start();
include('./db.php');
require_once './Admin.php';
$user_home = new Admin();



if (!isset($_SESSION['userSession'])) {
    $user_home->logout();
    $user_home->redirect('../prijava');
}

if (!$user_home->is_logged_in()) {
    $user_home->redirect('../prijava');
}

$account_id = $_SESSION['userSession'];

$role = $user_home->get_type_of_account($account_id);

if ($role !== "admin") {
    $user_home->redirect('../prijava');
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Copy Studio | Newsletter </title>
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="../img/logo-short.ico">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap4.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css">
    <!-- Sweetalert style -->
    <link rel="stylesheet" href="../plugins/swall/sweetalert.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/style.css?asdasd121">
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/card.css?2134">
    <link rel="stylesheet" href="../dist/css/loginArea.css?A21312S" type="text/css" />
    <!-- DataTable responsive style -->
    <link rel="stylesheet" href="../plugins/dataTable/css/responsive.dataTables.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- Theme style -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">


    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
    <script src="https://cdn.tiny.cloud/1/zlpdloait50k23c2fecpmres1458xo3gzbg68ub2rem0vk05/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <!-- jQuery -->
    <script src="../plugins/jquery/jquery-3.2.1.min.js"></script>
    <link
            rel="stylesheet"
            href="../plugins/dropzone/dropzone.css">
    <!-- jQuery -->


    <script>tinymce.init({
            selector:'textarea#mail_message',
            menu: {
                file: { title: 'File', items: 'preview | print ' },
                edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall | searchreplace' },
                insert: { title: 'Insert', items: 'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime' },
                format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align | forecolor backcolor | removeformat' },
            },
            toolbar: 'undo redo | formatselect | formatfonts |' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ',
            statusbar: false,
            height : "480",
            weight : "100%"
        });
    </script>
    <link type="text/css" href="../plugins/dataTable/css/dataTables.checkboxes.css" rel="stylesheet" />
    <meta name="csrf-token" content="XYZ123">
</head>

<body class="hold-transition sidebar-collapse user-select-none h-100-vh">
<div class="wrapper  d-flex flex-column justify-content-between">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item">
                    <a class="nav-link" title="Odjava" href="./logout.php">
                        <i class="fas fa-power-off"></i>
                    </a>
                </li>
            </ul>
        </nav>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper flex-2 z-index-1">
            <!-- Content Header (Page header) -->
            <section class="content-header">

            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Newsletter</h3>
                                <div class=" select-article-state">
                                    <div class="row">
                                        <div class="">
                                            <label class="float-right" style="padding: 8px 4px;text-align:center;">Status newsletter</label></div>
                                        <div class="">
                                            <select class="form-control" name="selectStateOfNewsletter" id="selectStateOfNewsletter">
                                                <option value="A">Aktivni</option>
                                                <option value="N">Neaktivni</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 pt-3 d-flex">
                                <button type="button" id="add_button" data-toggle="modal" data-target="#sendMessage" class="btn btn-primary copy_studio_button">Nova poruka</button>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body default-card-body">
                                <form id="newsletter-form"  method="POST">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-6 col-md-6 col-lg-6 col-xs-12 col-sm-8">
                                            <table id="newsletter_data" class="table  table-striped responsive nowrap" width="100%" cellspacing="0">
                                                <thead class="">
                                                <tr>
                                                    <th style="width: 60%;">Email</th>
                                                    <th style="width: 10%;">Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                </form>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer z-index-1">
            <div class="footer-div">
                <strong>Copyright &copy;2020 <a href="http://copystudio.rs/">Copy Studio 88</a>.</strong> Sva prava su zadržana
            </div>
            <div class="float-right d-none d-sm-inline-block">
               Created by <a href="http://resivoje.com">Rešivoje Team</a>
            </div>
        </footer>

        <div id="sendMessage" class="modal fade" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-lg" style="width:80%;">
                <form id="sendMessageForm">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Prosledi poruke</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="container">
                                    <div class="col-md-12 d-flex justify-content-end row pb-2">
                                        <div class="col-md-2 form-group image_preview">
                                            <img>
                                        </div>
                                        <div class="col-md-3 form-group">
                                            <label for="product_image">Slika</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" onblur="$(this).valid()" id="image" name="image" class="custom-file-input" data-buttonText="Ubaci"/>
                                                    <label class="custom-file-label" for="exampleInputFile">Slika</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <textarea id="mail_message" name="mail_message"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" name="action_invoice" id="action_invoice" class="btn btn-primary copy_studio_button action-invoice" value="Pošalji"/>
                            <button type="button" class="btn  btn-default silver_gradient_button" id="modal_close" data-dismiss="modal">Nazad</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <div class="loading-area">
        <div class="loadingio-spinner-spinner-xkd27nljhuk"><div class="ldio-9r3gjr71qx5">
                <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
            </div></div>
    </div>


    </div>
</body>





<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap4.js"></script>
<script type="text/javascript" src="../plugins/dataTable/js/dataTables.checkboxes.min.js"></script>
<!-- SlimScroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<script src="../dist/js/adminlte.min.js"></script>
<script src="../dist/js/demo.js"></script>
<!-- Sweetalert js -->
<script src="../plugins/swall/sweetalert.js"></script>
<!-- DataTable responsive js -->
<script src="../plugins/dataTable/js/dataTables.responsive.min.js"></script>
<!-- page script -->
<script src="../plugins/form-validation/jquery.form.js"></script>
<script src="../plugins/form-validation/jquery.validate.min.js"></script>

<script src="ajax/JS/newsletter.js?!1321#" charset="UTF-8"></script>
<script src="./ajax/JS/gloabl.js"></script>
</html>
