$(document).ready(function() {
    $('#add_button').click(function() {
        $('#gallery_form')[0].reset();
        $('.modal-title').text("Insert");
        $('#image').val("");
        $('#imagelabel').text("");
        $('#action').val("Dodaj");
        $('#operation').val("Dodaj");
    });

    let dataTable = $('#gallery_data').DataTable({
        "processing":true,
        "serverSide": true,
        "autoWidth": false,
        "order": [],
        "ajax": {
            url: "php_assets/gallery_function/gallery_function.php",
            type: "POST"
        },
        "columnDefs": [{
        "targets": [0, 3, 4],
        "orderable": false,
        }, ],
        "lengthMenu": [ 5 ],
        "language": {
        "lengthMenu": "Show max 5 image on page",
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

    const $galleryForm = $('#gallery_form')
    let validator = void(0)

    if ($galleryForm.length) {
        validator = $galleryForm.validate({
            rules: {
                txt_title: {
                    required: true,
                },
                image: {
                    required: true
                }

            },
            messages: {
                txt_title: {
                    required: 'Insert title',
                },
                image: {
                    required: "Chose file"
                }
            },
            submitHandler: function submitHandler(form) {
                event.preventDefault();
                $.ajax({
                    url: "php_assets/gallery_function/gallery_func.php",
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
                            $('#gallery_form')[0].reset();
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
                            $('#gallery_form')[0].reset();
                            $('#exampleModalCenter').modal('hide');
                            dataTable.ajax.reload();
                        }

                    }
                })
            }
        })
    }


    NUMBER_CONTROL_INPUT = function(e) {
        let value = e.value
        if (!value) return;
        const globalRegex = RegExp('^[0-9]+$', 'g');
        if (!globalRegex.test(value)) {
            e.value = ''
            return
        }
        $(e).valid()
    }



    $(document).on('click', '#dismiss-modal, button[data-dismiss="modal"]', function() {
        validator.resetForm();
    })


    $(document).on('click', '.update', function() {
        let gallery_id = $(this).attr("id");
        $.ajax({
            url: "php_assets/gallery_function/gallery_fetch_single.php",
            method: "POST",
            data: { gallery_id: gallery_id },
            dataType: "json",
            success: function(data) {
                $('#gallery_form')[0].reset();
                $('#exampleModalCenter').modal('show');
                $('#txt_title').val(data.title);
                $('.custom-file-label').text(data.name);
                $('.modal-title').text("Change");
                $('#image').val(data.name);
                $('#id').val(gallery_id);
                $('#action').val("Promeni");
                $('#operation').val("Promeni");
            }
        })
    });



    $(document).on('click', '.delete', function() {
        let gallery_id = $(this).attr("id");
        swal({
            title: "Are you sure you want to delete this image?",
            type: "error",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false
        }, function(isConfirm) {
            if (!isConfirm) return;
            $.ajax({
                url: "php_assets/gallery_function/gallery_delete.php",
                method: "POST",
                data: { gallery_id: gallery_id },
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