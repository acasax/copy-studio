$(document).ready(function() {
    $('#add_button').click(function() {
        $('#user_form')[0].reset();
        $('.modal-title').text("Unos");
        $('#image').val("");
        $('#imagelabel').text("");
        $('#action').val("Dodaj");
        $('#operation').val("Dodaj");
    });

    let dataTable = $('#user_data').DataTable({
        "processing":true,
        "serverSide": true,
        "autoWidth": false,
        "order": [],
        "ajax": {
            url: "php_assets/user_functions/user_function.php",
            type: "POST"
        },
        "columnDefs": [{
            "targets": [0, 3, 4],
            "orderable": false,
        }, ],
        "lengthMenu": [ 5 ],
        "language": {
            "lengthMenu": "Prikazi maks 5 korisnika po strani",
            "zeroRecords": "zero records",
            "info": "Show page _PAGE_ od _PAGES_",
            "infoEmpty": "No records available",
            "infoFiltered": "(Show _MAX_ of all image)",
            "loadingRecords": "Loading...",
            "processing": "Loading",
            "search": "Search:",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "->",
                "previous": "<-"
            },
        },

    });

    const $userForm = $('#user_form')
    let validator = void(0)

    if ($userForm.length) {
        validator = $userForm.validate({
            rules: {
                txt_ticket_number: {
                    required: true,
                },
                txt_name: {
                    required: true
                },
                txt_last_name: {
                    required: true,
                },
                txt_phone: {
                    required: true
                },
                txt_email: {
                    required: true
                },
                txt_institution: {
                    required: true,
                }
            },
            messages: {
                txt_ticket_number: {
                    required: "Unesite broj kupona",
                },
                txt_name: {
                    required: "Unesite ime korisnika",
                },
                txt_last_name: {
                    required: "Unesite prezime korisnika",
                },
                txt_phone: {
                    required: "Unesite broj korisnika",
                },
                txt_email: {
                    required: "Unesite email korisnika",
                },
                txt_institution: {
                    required: "Unesite instituciju",
                }
            },
            submitHandler: function submitHandler(form) {
                event.preventDefault();
                $.ajax({
                    url: "php_assets/user_functions/user_func.php",
                    method: 'POST',
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    cache: false,
                    xhrFields: {
                        withCredentials: true
                    },
                    crossDomain: true,
                    success: function(data) {
                        let objResp = JSON.parse(data);
                        let str = objResp.type;

                        if (str === 'ERROR') {
                            str = objResp.data;
                            swal({
                                title: "Error",
                                text: str,
                                timer: 3000,
                                showCancelButton: false,
                                showConfirmButton: false,
                                type: "error"
                            });
                            $('#user_form')[0].reset();
                            return;
                        }

                        if (str === 'OK') {
                            str = objResp.data;
                            swal({
                                title: "Success",
                                text: str,
                                timer: 1000,
                                showCancelButton: false,
                                showConfirmButton: false,
                                type: "success"
                            });
                            $('#user_form')[0].reset();
                            $('#exampleModalCenter').modal('hide');
                            dataTable.ajax.reload();
                        }

                    }
                })
            }
        })
    }

    $(document).on('click', '#dismiss-modal, button[data-dismiss="modal"]', function() {
        validator.resetForm();
    })


    $(document).on('click', '.update', function() {
        let user_id = $(this).attr("id");
        $.ajax({
            url: "php_assets/user_functions/user_fetch_single.php",
            method: "POST",
            data: { user_id: user_id },
            dataType: "json",
            success: function(data) {
                $('#user_form')[0].reset();
                $('#exampleModalCenter').modal('show');
                $('#txt_ticket_number').val(data.tNumber);
                $('#txt_name').val(data.name);
                $('#txt_last_name').val(data.lName);
                $('#txt_phone').val(data.phone);
                $('#txt_email').val(data.email);
                $('#txt_institution').val(data.institution);
                $('.custom-file-label').text(data.picture);
                $('.modal-title').text("Promeni");
                $('#id').val(user_id);
                $('#action').val("Promeni");
                $('#operation').val("Promeni");
            }
        })
    });



    $(document).on('click', '.delete', function() {
        let user_id = $(this).attr("id");
        swal({
            title: "Da li ste sigurni da želite da obrišete ovog korisnika?",
            type: "error",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Da",
            cancelButtonText: "Ne",
            closeOnConfirm: false
        }, function(isConfirm) {
            if (!isConfirm) return;
            $.ajax({
                url: "php_assets/user_functions/user_delete.php",
                method: "POST",
                data: { user_id: user_id },
                success: function(data) {
                    let objResp = JSON.parse(data);
                    let str = objResp.type;
                    if (str === 'OK') {
                        swal({
                            title: "Success",
                            text: str,
                            timer: 1000,
                            showCancelButton: false,
                            showConfirmButton: false,
                            type: "success"
                        });
                        dataTable.ajax.reload();
                    }
                }
            })

        })
    });

    $('.modal').on('shown.bs.modal', function() {
        $(this).find('[autofocus]').focus();
    });

});