$(function () {


    let stateNewsletter = $('#selectStateOfNewsletter').val();

    var dataTable = void(0);

    LOAD_DATA_TABLE = function (stateArticle) {
        if(dataTable){
            dataTable.destroy();
            $('#newsletter_data tbody').empty();
        }

        dataTable = $('#newsletter_data').DataTable({
            "processing":true,
            "serverSide":true,
            responsive: true,
            "Paginate": true,
            "pager":{
                container:"paging_here", // the container to place the pager controls into
                lenght:100, // the number of records per a page
                start:0   // the number of pages in the pager
            },
            "order":[],
            "ajax":{
                url:"ajax/newsletter/fetch.php",
                type:"POST",
                data:{
                    stateNewsletter:stateNewsletter
                }
            },
            "columnDefs": [],
            "language": {
                "decimal":        "",
                "emptyTable":     "Niste ubacili ",
                "info":           "Prikaz _START_ - _END_ od _TOTAL_",
                "infoEmpty":      "Prikaz 0 - 0 od 0 ",
                "infoFiltered":   "(prikaz _MAX_ )",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "Prikaz _MENU_ ",
                "loadingRecords": "Učitavanje...",
                "processing":     "Obrada...",
                "search":         "Pretraži:",
                "zeroRecords":    "Nisu pronađeni odgovarajući ",
                "paginate": {
                    "first":      "Prvi",
                    "last":       "Poslednji",
                    "next":       ">",
                    "previous":   "<"
                },
                "aria": {
                    "sortAscending":  ": Sortiranje uzlazno",
                    "sortDescending": ": Sortiranje silazno"
                }
            }
        });
    }

    LOAD_DATA_TABLE(stateNewsletter);

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.image_preview img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image").change(function() {
        readURL(this);
        $('.image_preview').css('display','block');
    });


    // Handle click on checkbox to set state of "Select all" control





    /*$("div#my-dropzone").dropzone({
        url: "ajax/newsletter/dropzone_process.php",
        previewTemplate: document.querySelector('#preview-template').innerHTML,
        parallelUploads: 2,
        thumbnailHeight: 120,
        thumbnailWidth: 120,
        maxFilesize: 3,
        filesizeBase: 1000,
        thumbnail: function (file, dataUrl) {
            if (file.previewElement) {
                file.previewElement.classList.remove("dz-file-preview");
                var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
                for (var i = 0; i < images.length; i++) {
                    var thumbnailElement = images[i];
                    thumbnailElement.alt = file.name;
                    thumbnailElement.src = dataUrl;
                }
                setTimeout(function () {
                    file.previewElement.classList.add("dz-image-preview");
                }, 1);
            }
        }
    });*/

    function page_loader() {
        $('.loading-area').fadeOut(2000)
        setTimeout(()=>{
            $('.loading-area').css('display','none')
        },1500)
    };
    page_loader()

    $(document).on('submit','#sendMessageForm',function(e){
        e.preventDefault();
        $('.loading-area').css('display','block')
        $.ajax({
            url:"ajax/newsletter/send_message.php",
            method:'POST',
            data:new FormData(this),
            contentType:false,
            processData:false,
            success:function(data)
            {

                var objResp = JSON.parse(data.toString('utf8'));
                var str=objResp.type;
                if(str==='ERROR') {
                    str=objResp.data;
                    swal("Greška!", str, "error");
                    return;
                }
                if(str==='OK') {
                    str=objResp.data;
                    swal("Uspešno!", str, "success");
                    $('#sendMessageForm')[0].reset()
                    $('#sendMessage').modal('hide')
                    return
                }

            },
            complete: function () {
                $('.loading-area').fadeOut(2000)
                $('.loading-area').css('display','none')
            }

        });

    });
})
