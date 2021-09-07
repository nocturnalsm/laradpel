@extends('layouts.base')
@section('main')
<style>
    .error {display:none;font-size: 0.75rem;color: red};
</style>
<div class="modal fade" id="modaldetail" tabindex="-1" role="dialog" aria-labelledby="modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h4 class="modal-title w-100 font-weight-bold"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-3">
                <form id="form" act="">
                    @csrf
                    <input {{ $readonly }} type="hidden" name="idxdetail" id="idxdetail">
                    <input {{ $readonly }} type="hidden" name="iddetail" id="iddetail">
                    <div class="form-row mb-1">
                        <label class="col-form-label col-form-label-sm col-md-4" for="nobl">No BL</label>
                        <div class="col-md-8">
                            <input {{ $readonly }} type="text" id="nobl" name="nobl" class="form-control form-control-sm validate">
                            <input {{ $readonly }} type="hidden" id="nobl_id" name="nobl_id">
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-form-label-sm col-md-4">No Aju</label>
                        <div class="col-md-8">
                            <span id="formnoaju" class="form-control-sm"></span>
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-form-label-sm col-md-4">Nopen</label>
                        <div class="col-md-8">
                            <span id="formnopen" class="form-control-sm"></span>
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-form-label-sm col-md-4">Tgl Nopen</label>
                        <div class="col-md-8">
                            <span id="formtglnopen" class="form-control-sm"></span>
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-form-label-sm col-md-4" for="noinvbiaya">No Inv Biaya</label>
                        <div class="col-md-8">
                            <input {{ $readonly }} type="text" id="noinvbiaya" name="noinvbiaya" class="form-control form-control-sm validate">
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-form-label-sm col-md-4" for="tglinvbiaya">Tgl Inv Biaya</label>
                        <div class="col-md-8">
                            <input type="text" id="tglinvbiaya" name="tglinvbiaya" class="datepicker{{ $readonly == 'readonly' ? '-readonly' : '' }} form-control form-control-sm validate">
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-form-label-sm col-md-4" for="nofakturbiaya">No Faktur Biaya</label>
                        <div class="col-md-8">
                            <input {{ $readonly }} type="text" id="nofakturbiaya" name="nofakturbiaya" class="form-control form-control-sm validate">
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-form-label-sm col-md-4" for="tglinvbiaya">Tgl Faktur Biaya</label>
                        <div class="col-md-8">
                            <input type="text" id="tglfakturbiaya" name="tglfakturbiaya" class="datepicker{{ $readonly == 'readonly' ? '-readonly' : '' }} form-control form-control-sm validate">
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-form-label-sm col-md-4" for="dpp">DPP</label>
                        <div class="col-md-8">
                            <input {{ $readonly }} type="text" id="dpp" name="dpp" class="number form-control form-control-sm validate">
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-form-label-sm col-md-4" for="ppn">PPN</label>
                        <div class="col-md-8">
                            <input {{ $readonly }} type="text" id="ppn" name="ppn" class="number form-control form-control-sm validate">
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-form-label-sm col-md-4" for="total">Subtotal</label>
                        <div class="col-md-8">
                            <input type="text" readonly id="total" name="total" class="number form-control form-control-sm validate">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <a id="savedetail" class="btn btn-primary">Simpan</a>
                <a class="btn btn-danger" data-dismiss="modal">Batal</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="card col-md-12 p-0">
        <div class="card-header font-weight-bold">
            <div class="row">
                <div class="col-md-4 py-0 pl-4 mt-1">
                    Form Pengajuan Biaya
                </div>
                @can('ajubiaya.transaksi')
                <div class="col-md-8 py-0 pr-4 text-right">
                    <button type="button" id="btnsimpan" class="btn btn-primary btn-sm m-0">Simpan</button>&nbsp;
                    <a href="/" class="btn btn-default btn-sm m-0">Batal</a>&nbsp;
                    @if(isset($header->ID) && $header->ID != null)
                    <a id="deletetransaksi" class="btn btn-warning btn-sm m-0" data-dismiss="modal">Hapus</a>
                    @endif
                </div>
                @endcan
            </div>
        </div>
        <form id="transaksi" autocomplete="off">
        <div class="card-body">
            <input {{ $readonly }} type="hidden" value="{{ $header->ID }}" id="idtransaksi" name="idtransaksi">
            <div class="row px-2">
                <div class="col-md-6 pt-0 col-sm-12">
                    <div class="row">
                        <div class="card col-md-12 p-0 mb-2">
                            <div class="card-body p-3">
                                <div class="form-row px-2 pb-0">
                                    <label class="col-md-2 col-form-label form-control-sm">Tgl Rekam</label>
                                    <div class="col-sm-4">
                                        <input autocomplete="off" type="text" class="datepicker{{ $readonly == 'readonly' ? '-readonly' : '' }} form-control form-control-sm" name="tglrekam" value="{{ $header->TGL_REKAM }}" id="tglrekam">
                                    </div>
                                </div>
                                <div class="form-row px-2 pb-0 pt-2">
                                    <label class="col-md-2 col-form-label form-control-sm">Tgl Aju Biaya</label>
                                    <div class="col-sm-4">
                                        <input autocomplete="off" type="text" class="datepicker{{ $readonly == 'readonly' ? '-readonly' : '' }} form-control form-control-sm" name="tglajubiaya" value="{{ $header->TGL_AJU_BY }}" id="tglajubiaya">
                                    </div>
                                </div>
                                <div class="form-row px-2 pt-2">
                                    <label class="col-form-label col-form-label-sm col-md-2" for="importir">Importir</label>
                                    <div class="col-md-8">
                                        <select {{ $readonly == 'readonly' ? 'disabled' : '' }} class="form-control form-control-sm" id="importir" name="importir" value="{{ $header->IMPORTIR }}">
                                            <option value=""></option>
                                            @foreach($importir as $imp)
                                            <option @if($header->IMPORTIR == $imp->IMPORTIR_ID) selected @endif value="{{ $imp->IMPORTIR_ID }}">{{ $imp->NAMA }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row px-2 pb-0 pt-2">
                                    <label class="col-md-2 col-form-label form-control-sm">Tgl Vrf Biaya</label>
                                    <div class="col-md-3">
                                        <input autocomplete="off" type="text" class="datepicker{{ $readonly == 'readonly' ? '-readonly' : '' }} form-control form-control-sm" name="tglvrfbiaya" value="{{ $header->TGL_VRF_BY }}" id="tglvrfbiaya">
                                    </div>
                                </div>
                                <div class="form-row px-2 pb-0 pt-2">
                                    <label class="col-md-2 col-form-label form-control-sm">Tgl Byr Biaya</label>
                                    <div class="col-md-3">
                                        <input type="text" class="datepicker{{ $readonly == 'readonly' ? '-readonly' : '' }} form-control form-control-sm" name="tglbyrbiaya" id="tglbyrbiaya" value="{{ $header->TGL_BYR_BY }}">
                                    </div>
                                </div>
                                <div class="form-row px-2 pb-0 pt-2">
                                    <label class="col-md-2 col-form-label form-control-sm">Total Biaya</label>
                                    <div class="col-md-3">
                                        <input readonly type="text" class="number form-control form-control-sm" name="totalbiaya" id="totalbiaya" value="{{ $header->TOTAL_BIAYA }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row px-2">
                <div class="col-md-12">
                    <div class="row mb-2">
                        <div class="card col-md-12 p-0">
                            <div class="card-body p-3">
                                <h5 class="card-title">Detail Aju Biaya</h5>
                                <div class="form-row">
                                    <div class="col primary-color text-white py-2 px-4">
                                        Detail Aju Biaya
                                    </div>
                                    @can('ajubiaya.transaksi')
                                    <div class="col primary-color text-white text-right p-2" style="text-decoration:underline">
                                        <a href="#modaldetail" data-toggle="modal" class="text-white" id="adddetail">Tambah Detail</a>
                                    </div>
                                    @endcan
                                </div>
                                <div class="form-row">
                                    <div class="col mt-2">
                                        <table width="100%" id="griddetail" class="table">
                                            <thead>
                                                <tr>
                                                    <th>No BL</th>
                                                    <th>No Aju</th>
                                                    <th>Nopen<br>Tgl Nopen</th>
                                                    <th>No Inv By<br>Tgl Inv By</th>
                                                    <th>No Faktur By<br>Tgl Faktur By</th>
                                                    <th>DPP</th>
                                                    <th>PPN</th>
                                                    <th>Sub Ttl By</th>
                                                    <th>Upload</th>
                                                    @can('ajubiaya.transaksi')
                                                    <th>Opsi</th>
                                                    @endcan
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection
@push('stylesheets_end')
    <link href="{{ asset('jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
@endpush
@push('scripts_end')
<script type="text/javascript" src="{{ asset('js/jquery.inputmask.bundle.js') }}"></script>
<script type="text/javascript" src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
<script>
    var detail = @json($detail);
    datadetail = JSON.parse(detail);

    $(function(){

        Number.prototype.formatMoney = function(places, symbol, thousand, decimal) {
            places = !isNaN(places = Math.abs(places)) ? places : 2;
            symbol = symbol !== undefined ? symbol : "";
            thousand = thousand || ",";
            decimal = decimal || ".";
            var number = this,
                    negative = number < 0 ? "-" : "",
                    i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
                    j = (j = i.length) > 3 ? j % 3 : 0;
            return symbol + negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
        };
        $(".datepicker").datepicker({dateFormat: "dd-mm-yy"});
        $(".number").inputmask("numeric", {
            radixPoint: ".",
            groupSeparator: ",",
            digits: 2,
            autoGroup: true,
            rightAlign: false,
            removeMaskOnSubmit: true,
        });
        var tabel = $("#griddetail").DataTable({
            processing: false,
            serverSide: false,
            data: datadetail,
            dom: "t",
            rowCallback: function(row, data)
            {
                $(row).attr("id-transaksi", data.ID);
                $('td:eq(2)', row).html(data.NOPEN + '<BR>' + data.TGLNOPEN);
                $('td:eq(3)', row).html(data.NO_INV_BY + '<BR>' + data.TGL_INV_BY);
                $('td:eq(4)', row).html(data.NO_FAKTUR_BY + '<BR>' + data.TGL_FAKTUR_BY);
                $('td:eq(5)', row).html(parseFloat(data.DPP).formatMoney(2,"",",","."));
                $('td:eq(6)', row).html(parseFloat(data.PPN).formatMoney(2,"",",","."));
                $('td:eq(7)', row).html((parseFloat(data.DPP) + parseFloat(data.PPN)).formatMoney(0,"",",","."));
                @can('ajubiaya.transaksi')
                $('td:eq(9)', row).html('<a href="#modaldetail" class="edit" data-toggle="modal" id="' + data.ID +
                                        '"><i class="fa fa-edit"></i></a>' +
                                        '&nbsp;&nbsp;<a class="del" id="' + data.ID + '"><i class="fa fa-trash"></i></a>'
                                        );
                @endcan
            },
            select: 'single',     // enable single row selection
            responsive: false,     // enable responsiveness,
            rowId: 0,
            columns: [{
                target: 0,
                data: "NOBL"
            },
            { target: 1,
                data: "NOAJU"
            },
            { target: 2,
                data: "NOPEN"
            },
            { target: 3,
                data: "NO_INV_BY"
            },
            { target: 4,
                data: "NO_FAKTUR_BY"
            },
            { target: 5,
                data: "DPP"
            },
            { target: 6,
                data: "PPN"
            },
            { target: 7,
                data: null
            },
            { target: 8,
                data: null
            },
            @can('ajubiaya.transaksi')
            { target: 9,
                data: null
            }
            @endcan
            ],
        })
        @can('ajubiaya.transaksi')
        $("body").on("change","#nobl", function(){
            var nobl = $(this).val().trim();
            $.ajax({
                method: "GET",
                url: "/transaksi/searchbl",
                data: {kode: nobl},
                success: function(response){
                    if (typeof response.error == 'undefined'){
                        $("#formnopen").html(response.NOPEN);
                        $("#formnoaju").html(response.NOAJU);
                        $("#formtglnopen").html(response.TGLNOPEN);
                        $("#nobl_id").val(response.ID);
                    }
                    else {
                        $("#modal .modal-body").html(response.error);
                        $("#formnopen").html("");
                        $("#formnoaju").html("");
                        $("#formtglnopen").html("");
                        $("#nobl_id").val("");
                        $("#modal").modal("show");
                        setTimeout(function(){
                            $("#modal").modal("hide");
                        }, 5000);
                    }
                }
            })
        })
        $('#modaldetail').on('shown.bs.modal', function () {
            $('#nobl').focus();
        })
        $("#dpp,#ppn").on("change", function(){
            var dpp = parseFloat($("#dpp").inputmask("unmaskedvalue"));
            var ppn = parseFloat($("#ppn").inputmask("unmaskedvalue"));
            var total = (dpp+ppn).toFixed(2);
            $("#total").val(total);
        })
        $("#savedetail").on("click", function(){
            var nobl = $("#nobl").val();
            var nobl_id = $("#nobl_id").val();
            var nopen = $("#formnopen").html();
            var noaju = $("#formnoaju").html();
            var tglnopen = $("#formtglnopen").html();
            var noinvbiaya = $("#noinvbiaya").val();
            var nofakturbiaya = $("#nofakturbiaya").val();
            var tglinvbiaya = $("#tglinvbiaya").val();
            var tglfakturbiaya = $("#tglfakturbiaya").val();
            var dpp = $("#dpp").inputmask('unmaskedvalue');
            var ppn = $("#ppn").inputmask('unmaskedvalue');
            var act = $("#form").attr("act");

            if (act == "add"){
                tabel.row.add({NO_BL: nobl_id, NOBL: nobl, NOPEN: nopen,
                               DPP: dpp, PPN: ppn, NOAJU: noaju, TGLNOPEN: tglnopen,
                               TGL_INV_BY: tglinvbiaya, TGL_FAKTUR_BY: tglfakturbiaya,
                               NO_FAKTUR_BY: nofakturbiaya, NO_INV_BY: noinvbiaya
                            }).draw();
                $("#formnopen").html("");
                $("#formnoaju").html("");
                $("#formtglnopen").html("")
                $("#nobl").val("");
                $("#nobl_id").val("");
                $("#noinvbiaya").val("");
                $("#tglinvbiaya").val("");
                $("#nofakturbiaya").val("");
                $("#tglfakturbiaya").val("");
                $("#dpp").val("");
                $("#ppn").val("");
                $("#total").val("");
                $("#nobl").focus();
            }
            else if (act == "edit"){
                var id = $("#iddetail").val();
                var idx = $("#idxdetail").val();
                tabel.row(idx).data({ID: id, NO_BL: nobl_id, NOBL: nobl, NOPEN: nopen,
                                    DPP: dpp, PPN: ppn, NOAJU: noaju, TGLNOPEN: tglnopen,
                                    TGL_INV_BY: tglinvbiaya, TGL_FAKTUR_BY: tglfakturbiaya,
                                    NO_FAKTUR_BY: nofakturbiaya, NO_INV_BY: noinvbiaya}).draw();
                $("#modaldetail").modal("hide");
            }
            var rows = tabel.rows().data();
            var total = 0;
            $(rows).each(function(index,elem){
                total = total + parseFloat(elem.DPP) + parseFloat(elem.PPN);
            })
            $("#totalbiaya").val(total);
        });

        $("#adddetail").on("click", function(){
            $("#formnopen").html("");
            $("#formnoaju").html("");
            $("#formtglnopen").html("")
            $("#nobl").val("");
            $("#nobl_id").val("");
            $("#noinvbiaya").val("");
            $("#tglinvbiaya").val("");
            $("#nofakturbiaya").val("");
            $("#tglfakturbiaya").val("");
            $("#dpp").val("");
            $("#ppn").val("");
            $("#total").val("");
            $("#kodebarang").focus();
            $("#modaldetail .modal-title").html("Tambah ");
            $("#form").attr("act","add");
        })
        $("body").on("click", ".edit", function(){
            var row = $(this).closest("tr");
            var index = tabel.row(row).index();
            var row = tabel.rows(index).data();
            $("#formnopen").html(row[0].NOPEN);
            $("#formtglnopen").html(row[0].TGLNOPEN);
            $("#formnoaju").html(row[0].NOAJU);
            $("#nobl").val(row[0].NOBL);
            $("#nobl_id").val(row[0].NO_BL);
            $("#noinvbiaya").val(row[0].NO_INV_BY);
            $("#nofakturbiaya").val(row[0].NO_FAKTUR_BY);
            $("#tglinvbiaya").val(row[0].TGL_INV_BY);
            $("#tglfakturbiaya").val(row[0].TGL_FAKTUR_BY);
            $("#dpp").val(row[0].DPP);
            $("#ppn").val(row[0].PPN);
            $("#total").val(row[0].DPP + row[0].PPN);
            $("#idxdetail").val(index);
            $("#iddetail").val(row[0].ID);
            $("#modaldetail .modal-title").html("Edit ");
            $("#form").attr("act","edit");
        })
        $("body").on("click", ".del", function(){
            var row = $(this).closest("tr");
            var id = tabel.row(row).data().ID;
            if (typeof id != 'undefined'){
                $("input[name='deletedetail'").val($("input[name='deletedetail'").val() + id + ";");
            }
            var index = tabel.row(row).remove().draw();
        })
        $("#btnsimpan").on("click", function(){

                //if (validate()){
                var detail = [];
                var rows = tabel.rows().data();
                var total = 0;
                $(rows).each(function(index,elem){
                    detail.push(elem);
                })
                $(this).prop("disabled", true);
                $(".loader").show()
                $.ajax({
                    url: "/transaksi/crud",
                    data: {_token: "{{ csrf_token() }}", type: "ajubiaya", header: $("#transaksi").serialize(), detail: detail},
                    type: "POST",
                    cache: false,
                    success: function(msg) {
                        if (typeof msg.error != 'undefined'){
                            $("#modal .modal-body").html(msg.error);
                            $("#modal").modal("show");
                            setTimeout(function(){
                                $("#modal").modal("hide");
                            }, 5000);
                        }
                        else {
                            $("#modal .modal-body").html("Penyimpanan berhasil");
                            $("#modal").on("hidden.bs.modal", function(){
                                window.location.reload();
                            });
                            $("#modal").modal("show");
                            setTimeout(function(){
                                $("#modal").modal("hide");
                            }, 5000);
                        }
                    },
                    complete: function(){
                        $("#btnsimpan").prop("disabled", false);
                        $(".loader").hide();
                    }
                })
            /*}
            else {
                return false;
            }*/
        })
        @if(isset($header) && $header->ID != null)
        $("a#deletetransaksi").on("click", function(){
            $("#modal .btn-ok").removeClass("d-none");
            $("#modal .btn-close").html("Batal");
            $("#modal .modal-body").html("Apakah Anda ingin menghapus data ini?");
            $("#modal .btn-ok").html("Ya").on("click", function(){
                $.ajax({
                    url: "/transaksi/crud",
                    data: {_token: "{{ csrf_token() }}", type: "ajubiaya", delete: "{{ $header->ID}}"},
                    type: "POST",
                    success: function(msg){
                        $("#modal .btn-ok").addClass("d-none");
                        if (typeof msg.error != 'undefined'){
                            $("#modal .modal-body").html(msg.error);
                            $("#modal").modal("show");
                            setTimeout(function(){
                                $("#modal").modal("hide");
                            }, 5000);
                        }
                        else {
                            $("#modal .modal-body").html("Data berhasil dihapus");
                            $("#modal").modal("show");
                            setTimeout(function(){
                                $("#modal").modal("hide");
                            }, 10000);
                            window.location.href = "/transaksi/ajubiaya";
                        }
                    }
                })
            });
            $("#modal").modal("show");
        });
        @endif
        @endcan
    })
</script>
@endpush
