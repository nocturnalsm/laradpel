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
                        <label class="col-form-label col-md-3" for="nominal">Nominal</label>
                        <div class="col-md-9">
                            <input {{ $readonly }} type="text" id="nominal" name="nominal" class="number form-control form-control-sm validate">
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-md-3" for="total">Debet / Kredit</label>
                        <div class="col-md-9 mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" checked type="radio" name="dk" id="dk" value="D">
                                <label class="form-check-label" for="dk">Debet</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="dk" id="dk" value="K">
                                <label class="form-check-label" for="dk">Kredit</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-md-3" for="kodetransaksi">Kode Acc</label>
                        <div class="col-md-9">
                        <select class="form-control form-control-sm" id="kodeacc" name="kodeacc">
                            <option value=""></option>
                            @foreach($kodeacc as $kode)
                            <option value="{{ $kode->KODEACC_ID }}">{{ $kode->URAIAN }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-md-3" for="party">Kode Party</label>
                        <div class="col-md-9">
                        <select class="form-control form-control-sm" id="kodeparty" name="kodeparty">
                            <option value=""></option>
                            @foreach($kodeparty as $kode)
                            <option value="{{ $kode->KODEPARTY_ID }}">{{ $kode->URAIAN }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-md-3" for="party">Party</label>
                        <div class="col-md-9">
                        <select class="form-control form-control-sm" id="party" name="party">
                            <option value=""></option>
                        </select>
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-md-3">No Dok</label>
                        <div class="col-md-9 pt-2">
                            <input {{ $readonly }} type="text" id="nodok" name="nodok" class="form-control form-control-sm validate">
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-md-3">Tgl Dok</label>
                        <div class="col-md-9 pt-2">
                            <input {{ $readonly }} type="text" id="tgldok" name="tgldok" class="datepicker form-control form-control-sm validate">
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-md-3">Remarks</label>
                        <div class="col-md-9 pt-2">
                            <textarea {{ $readonly }} rows="4" type="text" id="remarks" name="remarks" class="form-control form-control-sm validate">
                            </textarea>
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
                    Form Mutasi Kas
                </div>
                @can('mutasikas.transaksi')
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
                                    <label class="col-md-3 col-form-label form-control-sm">Tanggal</label>
                                    <div class="col-md-3">
                                        <input {{ $readonly }} autocomplete="off" type="text" class="datepicker{{ $readonly == 'readonly' ? '-readonly' : '' }} form-control form-control-sm" name="tanggal" value="{{ $header->TANGGAL }}" id="tanggal">
                                    </div>
                                </div>
                                <div class="form-row px-2">
                                    <label class="col-md-3 col-form-label form-control-sm">Importir</label>
                                    <div class="col-md-6">
                                        <select {{ $readonly == 'readonly' ? 'disabled' : '' }} class="form-control form-control-sm" id="importir" name="importir" value="{{ $header->IMPORTIR_ID }}">
                                            <option value=""></option>
                                            @foreach($importir as $imp)
                                            <option @if($header->IMPORTIR_ID == $imp->IMPORTIR_ID) selected @endif value="{{ $imp->IMPORTIR_ID }}">{{ $imp->NAMA }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row px-2">
                                    <label class="col-md-3 col-form-label form-control-sm">Rekening</label>
                                    <div class="col-md-6">
                                        <select {{ $readonly == 'readonly' ? 'disabled' : '' }} class="form-control form-control-sm" id="rekening" name="rekening" value="{{ $header->REKENING_ID }}">
                                            <option value=""></option>
                                            @foreach($rekening as $rek)
                                            <option @if($header->REKENING_ID == $rek->REKENING_ID) selected @endif value="{{ $rek->REKENING_ID }}">{{ $rek->NAMA }} - {{ $rek->NO_REKENING }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row px-2">
                                    <label class="col-md-3 col-form-label form-control-sm">Total Debet</label>
                                    <div class="col-md-3">
                                        <input type="text" id="totaldebet" name="totaldebet" class="number form-control form-control-sm" readonly value="{{ $header->TOTAL_DEBET }}">
                                    </div>
                                </div>
                                <div class="form-row px-2">
                                    <label class="col-md-3 col-form-label form-control-sm">Total Kredit</label>
                                    <div class="col-md-3">
                                        <input type="text" id="totalkredit" name="totalkredit" class="number form-control form-control-sm" readonly value="{{ $header->TOTAL_KREDIT }}">
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
                                <div class="form-row">
                                    <div class="col primary-color text-white py-2 px-4">
                                        Detail Pembayaran
                                    </div>
                                    @can('mutasikas.transaksi')
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
                                                    <th>Nominal</th>
                                                    <th>D/K</th>
                                                    <th>Kode Acc</th>
                                                    <th>Kode Party</th>
                                                    <th>Party</th>
                                                    <th>No Dok</th>
                                                    <th>Tgl Dok</th>
                                                    <th>Remarks</th>
                                                    <th>Upload</th>
                                                    @can('mutasikas.transaksi')
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
    var party = @json($party);
    dataparty = JSON.parse(party);
    console.log(dataparty);
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
                $('td:eq(0)', row).html(parseFloat(data.NOMINAL).formatMoney(2,"",",","."));
                $('td:eq(0)', row).html();
                @can('mutasikas.transaksi')
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
                data: "NOMINAL"
            },
            { target: 1,
                data: "DK"
            },
            { target: 2,
                data: "KODE_ACC"
            },
            { target: 3,
                data: "KODE_PARTY"
            },
            { target: 4,
                data: "PARTY"
            },
            { target: 5,
                data: "NO_DOK"
            },
            { target: 6,
                data: "TGL_DOK"
            },
            { target: 7,
                data: "REMARKS"
            },
            { target: 8,
                data: null
            },
            @can('mutasikas.transaksi')
            { target: 9,
                data: null
            }
            @endcan
            ],
        })
        @can('mutasikas.transaksi')
        function count_total(){
          var totaldebet = 0;
          var totalkredit = 0;
          $("#griddetail tbody tr").each(function(index,elem){
              var dk = $(elem).find("td:eq(1)").html().trim();
              var nominal = $(elem).find("td:eq(0)").html().trim();
              if (dk == "D"){
                  totaldebet += nominal == "" ? 0 : parseFloat(nominal.replace(/,/g,""));
              }
              else if (dk == "K"){
                  totalkredit += nominal == "" ? 0 : parseFloat(nominal.replace(/,/g,""))
              }
          });
          $("#totaldebet").val(totaldebet);
          $("#totalkredit").val(totalkredit);
        }
        $('#modaldetail').on('shown.bs.modal', function () {
            $('#nominal').focus();
        })
        $("#savedetail").on("click", function(){
            var kodeacc_id = $("#kodeacc option:selected").val();
            var kodeacc = $("#kodeacc option:selected").html();
            var kodeparty_id = $("#kodeparty option:selected").val();
            var kodeparty = $("#kodeparty option:selected").html();
            var party_id = $("#party option:selected").val();
            var party = $("#party option:selected").html();
            var nodok = $("#nodok").val();
            var tgldok = $("#tgldok").val();
            var remarks = $("#remarks").val();
            var nominal = $("#nominal").inputmask('unmaskedvalue');
            var dk = $("input[name='dk']:checked").val();
            var act = $("#form").attr("act");

            if (act == "add"){
                tabel.row.add({KODEACC_ID: kodeacc_id, KODE_ACC: kodeacc, KODE_PARTY: kodeparty, KODEPARTY_ID: kodeparty_id, NO_DOK: nodok, TGL_DOK: tgldok, REMARKS: remarks, NOMINAL: nominal, PARTY_ID: party_id, PARTY: party, DK: dk}).draw();
                $("#nodok").val("");
                $("#kodeacc").val("");
                $("#kodeparty").val("");
                $("#party").val("");
                $("#nominal").val("");
                $("#tgldok").val("");
                $("#remarks").val("");
                $("#nominal").focus();
            }
            else if (act == "edit"){
                var id = $("#iddetail").val();
                var idx = $("#idxdetail").val();
                tabel.row(idx).data({ID: id, KODEACC_ID: kodeacc_id, KODE_PARTY: kodeparty, KODEPARTY_ID: kodeparty_id, KODE_ACC: kodeacc, NO_DOK: nodok, TGL_DOK: tgldok, REMARKS: remarks, NOMINAL: nominal, PARTY_ID: party_id, PARTY: party, DK: dk}).draw();
                $("#modaldetail").modal("hide");
            }
            count_total();
        });

        $("#adddetail").on("click", function(){
            $("#nodok").val("");
            $("#kodeacc").val("");
            $("#kodeparty").val("");
            $("#party").val("");
            $("#nominal").val("");
            $("#tgldok").val("");
            $("#remarks").val("");
            $("input[name='dk'][value='D']").prop("checked", true);
            $("#modaldetail .modal-title").html("Tambah ");
            $("#nominal").focus();
            $("#form").attr("act","add");
        })
        $("body").on("click", ".edit", function(){
            var row = $(this).closest("tr");
            var index = tabel.row(row).index();
            var row = tabel.rows(index).data();
            $("#nodok").val(row[0].NO_DOK);
            $("#tgldok").val(row[0].TGL_DOK);
            $("#kodeacc").val(row[0].KODEACC_ID);
            $("#kodeparty").val(row[0].KODEPARTY_ID);
            $("#kodeparty").trigger("change");
            $("#party").val(row[0].PARTY_ID);
            $("#nominal").val(row[0].NOMINAL);
            $("#remarks").val(row[0].REMARKS);
            $("input[name='dk'][value='" + row[0].DK + "']").prop("checked", true);
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
            count_total();
        })
        $("#kodeparty").on("change", function(){
            var value = $(this).val();            
            if (value == ""){
                $("#party").html('<option value=""></option>');
            }
            else {
                var party = dataparty[value];
                var html = '<option value=""></option>';
                for(var i in party){
                    html += '<option value="' + party[i].PARTY_ID + '">' + party[i].NAMA + '</option>';
                }
                $("#party").html(html);
            }
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
                    data: {_token: "{{ csrf_token() }}", type: "mutasikas", header: $("#transaksi").serialize(), detail: detail},
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
                    data: {_token: "{{ csrf_token() }}", type: "mutasikas", delete: "{{ $header->ID}}"},
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
                            window.location.href = "/transaksi/mutasikas";
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
