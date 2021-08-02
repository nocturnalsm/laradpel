@extends('layouts.master')
@push('formbody')
<form id="form">
    <input type="hidden" id="input-id" name="input-id">
    <input type="hidden" id="input-action" name="input-action">
    <div class="mb-1">
        <label for="input-kodeparty">Kode Party</label>
        <select id="input-kodeparty" name="input-kodeparty" class="form-control">
          <option value=""></option>
          @foreach($kodeParty as $kode)
          <option value="{{ $kode->KODEPARTY_ID }}">{{ $kode->URAIAN }}</option>
          @endforeach
        </select>
    </div>
    <div class="mb-1">
        <label for="input-noid">No Identitas</label>
        <input type="text" id="input-noid" name="input-noid" class="form-control">
    </div>
    <div class="mb-1">
        <label for="input-nama">Nama</label>
        <input type="text" id="input-nama" name="input-nama" class="form-control">
    </div>
    <div class="mb-1">
        <label for="input-alamat">Alamat</label>
        <textarea id="input-alamat" name="input-alamat" class="form-control"></textarea>
    </div>
</form>
@endpush
@push('scripts_end')
    <script>
        $(function(){
            var table = $("#grid").DataTable({
                "processing": false,
                "serverSide": true,
                "ajax": "/master/getdata_party",
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
                        "data": "URAIAN"
                    }, {
                        "target": 1,
                        "data": "NO_IDENTITAS"
                    }, {
                        "target": 2,
                        "data": "NAMA"
                    }, {
                        "target": 3,
                        "data": "ALAMAT"
                    }
                ],
                rowCallback: function(row, data)
                {
                    $(row).attr("row-id", data.PARTY_ID);
                },
                buttons: [{
                text: 'Tambah',
                name: 'add',        // DO NOT change name,
                action: function () {
                    $("#modalform .modal-title").html("Tambah Data");
                    $("#input-kodeparty").val("");
                    $("#input-noid").val("");
                    $("#input-nama").val("");
                    $("#input-alamat").val("");
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
                    $("#input-kodeparty").val(row[0].KODE_PARTY);
                    $("#input-noid").val(row[0].NO_IDENTITAS);
                    $("#input-nama").val(row[0].NAMA);
                    $("#input-alamat").val(row[0].ALAMAT);
                    $("#input-action").val("edit");
                    $("#input-id").val(row[0].PARTY_ID);
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
                            data: {_token: "{{ csrf_token() }}", action: "party", input: $.param({"input-action": "delete", "id": row[0].PARTY_ID})},
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
                $('#input-kodeparty').focus();
            })
            $("#saveform").on("click", function(){
                $(this).addClass("disabled");
                $(".loader").show()
                $.ajax({
                    url: "/master/crud",
                    data: {_token: "{{ csrf_token() }}", action: "party", input: $("#form").serialize()},
                    type: "POST",
                    success: function(msg) {
                        if (typeof msg.error != 'undefined'){
                            $("#modal .modal-body").html(msg.error);
                            $("#modal").modal("show");
                            setTimeout(function(){
                                $("#modal").modal("hide");
                            }, 1000);
                            return false;
                        }
                        else {
                            if ($("#input-action").val() != "add"){
                                $("#modalform").modal("hide");
                            }
                            else {
                                $("#input-kodeparty").val("");
                                $("#input-noid").val("");
                                $("#input-nama").val("");
                                $("#input-alamat").val("");
                                $("#input-kodeparty").focus();
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
        })
    </script>
@endpush
