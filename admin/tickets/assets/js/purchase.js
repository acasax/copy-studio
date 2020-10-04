$(document).ready(function() {

    let dataTable = $('#purchase_data').DataTable({
        "processing":true,
        "serverSide": true,
        "autoWidth": false,
        "searching": false,
        "order": [],
        "ajax": {
            url: "php_assets/user_functions/purchape_featch.php",
            type: "POST"
        },
        "columnDefs": [{
            "orderable": false,
        }, ],
        "lengthMenu": [ 10 ],
        "language": {
            "lengthMenu": "Prikazi maks 10 kupovina po strani",
            "zeroRecords": "zero records",
            "info": "_PAGE_. strana od _PAGES_ strana",
            "infoEmpty": "No records available",
            "infoFiltered": "",
            "loadingRecords": "Loading...",
            "processing": "Loading",
            "search": "",
            "paginate": {
                "first": "First",
                "last": "Last",
                "next": "->",
                "previous": "<-"
            },
        },

    });

    const $purchaseForm = $('#purchase_form')
    let validator = void(0)

    if ($purchaseForm.length) {
        validator = $purchaseForm.validate({
            rules: {
                txt_amount: {
                    required: true,
                },
                txt_description: {
                    required: true
                }
            },
            messages: {
                txt_amount: {
                    required: "Unesite iznos",
                },
                txt_description: {
                    required: "Unesite opis kupovine",
                }
            },
            submitHandler: function submitHandler(form) {
                event.preventDefault();
                $.ajax({
                    url: "php_assets/user_functions/purchapre_func.php",
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
                            $('#purchase_form')[0].reset();
                            $('#exampleModalCenter').modal('hide');
                            window.location.reload();
                            dataTable.ajax.reload();
                        }

                    }
                })
            }
        })
    }

    const ticket_form = $('#ticket_form')

    if (ticket_form.length) {
        validator = ticket_form.validate({
            rules: {
                txt_ticket: {
                    required: true,
                }
            },
            messages: {
                txt_ticket: {
                    required: "Unesite broj vaučera",
                }
            },
            submitHandler: function submitHandler(form) {
                event.preventDefault();
                $.ajax({
                    url: "php_assets/user_functions/ticket_function.php",
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
                            $('#purchase_form')[0].reset();
                            $('#exampleModalCenter').modal('hide');
                            window.location.reload();
                            dataTable.ajax.reload();
                        }

                    }
                })
            }
        })
    }



    $('.modal').on('shown.bs.modal', function() {
        $(this).find('[autofocus]').focus();
    });

});