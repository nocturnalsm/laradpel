@extends('layouts.master')
@push('formbody')
<form id="form">
    <input type="hidden" id="input-id" name="input-id">
    <input type="hidden" id="input-action" name="input-action">
    <div class="mb-1">                        
        <label for="input-npwp">NPWP</label>
        <input type="text" id="input-npwp" name="input-npwp" class="form-control validate">                        
    </div>
    <div class="mb-1">                        
        <label for="input-nama">Nama</label>
        <input type="text" id="input-nama" name="input-nama" class="form-control validate">                        
    </div>
    <div class="mb-1">                        
        <label for="input-alamat">Alamat</label>
        <input type="text" id="input-alamat" name="input-alamat" class="form-control validate">                        
    </div>
    <div class="mb-1">                        
        <label for="input-telepon">Telepon</label>
        <input type="text" id="input-telepon" name="input-telepon" class="form-control validate">                        
    </div>
    <div class="mb-1">                        
        <label for="input-email">Email</label>
        <input type="email" id="input-email" name="input-email" class="form-control validate">                        
    </div>
</form>
@endpush
@push('scripts_end')
    <script src="{{ asset('js/jquery.inputmask.bundle.js') }}" type="text/javascript"></script>
    <script>
        $(function(){
            var table = $("#grid").DataTable({
            "processing": false,
            "serverSide": true,
            "ajax": "/master/getdata_importir",
            "paging": false,
            dom: 'Bfrtip',        // element order: NEEDS BUTTON CONTAINER (B) ****
            select: 'single',     // enable single row selection
            responsive: true,     // enable responsiveness,
            rowId: 0,
            "language": 
                {
                    "lengthMenu": "Menampilkan _MENU_ record per halaman",
                    "info": "",
                    "infoEmpty": "Data tidak ada",
                    "infoFiltered": "",
                    "search":         "Cari:",
                    "zeroRecords":    "Tidak ada data yang sesuai pencarian",
                    "paginate": {
                        "next":       ">>",
                        "previous":   "<<"
                    }
                },
            columns: [
                {
                    "target": 0,
                    "data": "npwp"
                }, {
                    "target": 1,
                    "data": "nama"
                }, {
                    "target": 2,
                    "data": "alamat"
                }, {
                    "target": 3,
                    "data": "telepon"
                }, {
                    "target": 1,
                    "data": "email"
                }],
            rowCallback: function(row, data)
            {
                $(row).attr("row-id", data.importir_id);
            },
            buttons: [{
            text: 'Tambah',
            name: 'add',        // DO NOT change name,
            action: function () {
                $("#modalform .modal-title").html("Tambah Data");
                $("#input-npwp").val("");
                $("#input-nama").val("");
                $("#input-alamat").val("");
                $("#input-telepon").val("");
                $("#input-email").val("");
                $("#input-action").val("add");
                $("#modalform").modal("show");
                $("#modalform input").eq(0).focus();
            }
            },
            {
            extend: 'selected', // Bind to Selected row
            text: 'Edit',
            name: 'edit',        // DO NOT change name
            action: function (e, dt) {
                var row = dt.rows( { selected: true } ).data();           
                $("#modalform .modal-title").html("Edit Data");
                $("#input-npwp").val(row[0].npwp);
                $("#input-nama").val(row[0].nama);
                $("#input-alamat").val(row[0].alamat);
                $("#input-telepon").val(row[0].telepon);
                $("#input-email").val(row[0].email);
                $("#input-action").val("edit");
                $("#input-id").val(row[0].importir_id);
                $("#modalform").modal("show");
            }
            },
            {
            extend: 'selected', // Bind to Selected row
            text: 'Hapus',
            name: 'delete',      // DO NOT change name
            action: function (e, dt){
                $("#modal .btn-ok").removeClass("d-none");
                $("#modal .btn-close").html("Batal");
                $("#modal .modal-body").html("Apakah Anda ingin menghapus data ini?");        
                $("#modal .btn-ok").html("Ya").on("click", function(){
                    var row = dt.rows( { selected: true } ).data();
                    $.ajax({
                        url: "/master/crud",
                        data: {_token: "{{ csrf_token() }}", action: "importir", input: $.param({"input-action": "delete", "id": row[0].importir_id})},
                        type: "POST",
                        success: function(msg) {
                            $("#modal .btn-ok").addClass("d-none");
                            if (typeof msg.error != 'undefined'){
                                $("#modal .modal-body").html(msg.error);
                            }
                            else {
                                table.ajax.reload();
                                $("#modal .modal-body").html("Penghapusan berhasil");
                            }
                            setTimeout(function(){
                                $("#modal").modal("hide");
                            }, 5000);  
                        }
                    })
                });                        
                $("#modal").modal("show").on("hidden.bs.modal", function(){
                    $("#modal .btn-ok").off("click");            
                    $("#modal .btn-close").html("Tutup");
                })
            }
        }]
        })
        $('#modalform').on('shown.bs.modal', function () {
            $('#input-npwp').focus();
        })
        $("#saveform").on("click", function(){    
            $(this).addClass("disabled");
            $(".loader").show()
            $.ajax({
                url: "/master/crud",
                data: {_token: "{{ csrf_token() }}", action: "importir", input: $("#form").serialize()},
                type: "POST",
                success: function(msg) {
                    if (typeof msg.error != 'undefined'){
                        $("#modal .modal-body").html(msg.error);
                        $("#modal").modal("show");
                        setTimeout(function(){
                            $("#modal").modal("hide");
                        }, 1000);
                    }
                    else {
                        if ($("#input-action").val() != "add"){
                            $("#modalform").modal("hide");
                        }            
                        else {
                            $("#input-npwp").val("");
                            $("#input-nama").val("");
                            $("#input-alamat").val("");
                            $("#input-telepon").val("");
                            $("#input-email").val("");
                            $("#input-npwp").focus();
                        }
                        table.ajax.reload();
                        $("#modal .modal-body").html("Data tersimpan");
                        $("#modal").modal("show");
                        setTimeout(function(){
                            $("#modal").modal("hide");
                        }, 1000);
                    }              
                },
                complete: function(){
                    $("#saveform").removeClass("disabled");
                    $(".loader").hide();
                }
            });
        });
        $("#input-npwp").inputmask("99.999.999.9-999.999");
    })
    </script>
@endpush