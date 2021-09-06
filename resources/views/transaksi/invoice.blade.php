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
                        <label class="col-form-label col-md-3" for="kodebarang">Kode Barang</label>
                        <div class="col-md-9">
                            <input {{ $readonly }} type="text" id="kodebarang" name="kodebarang" class="form-control form-control-sm validate">
                            <input {{ $readonly }} type="hidden" id="kodebarang_id" name="kodebarang_id">
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-md-3">Kode Produk</label>
                        <div class="col-md-9 pt-2">
                            <span id="formproduk"></span>
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-md-3" for="jumlah">Jumlah</label>
                        <div class="col-md-9">
                            <input {{ $readonly }} type="text" id="jumlah" name="jumlah" class="number form-control form-control-sm validate">
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-md-3" for="satuan">Satuan</label>
                        <div class="col-md-9">
                        <select class="form-control form-control-sm" id="satuan" name="satuan">
                            @foreach($satuan as $sat)
                            <option value="{{ $sat->id }}">{{ $sat->satuan }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-md-3" for="harga">Harga</label>
                        <div class="col-md-9">
                            <input {{ $readonly }} type="text" id="harga" name="harga" class="number form-control form-control-sm validate">
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-md-3" for="total">Total DPP</label>
                        <div class="col-md-9">
                            <input type="text" readonly id="total" name="total" class="number form-control form-control-sm validate">
                        </div>
                    </div>
                    <div class="form-row mb-1">
                        <label class="col-form-label col-md-3" for="ppn">PPN</label>
                        <div class="col-md-9">
                            <input type="text" readonly id="ppn" name="ppn" class="number form-control form-control-sm validate">
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
                    Form Perekaman Invoice
                </div>
                @can('invoice.transaksi')
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
                                    <label class="col-md-2 col-form-label form-control-sm">No.Inv Jual</label>
                                    <div class="col-sm-4">
                                        <input {{ $readonly }} type="text" class="form-control form-control-sm" name="noinv" value="{{ $header->NO_INV_JUAL }}" id="noinv">
                                    </div>
                                    <label class="col-md-2 col-form-label form-control-sm">Payment</label>
                                    <div class="col-sm-2">
                                        <select {{ $readonly == 'readonly' ? 'disabled' : '' }} type="text" class="form-control form-control-sm" name="payment" value="{{ $header->PAYMENT }}" id="payment">
                                            <option value=""></option>
                                            <option {{ $header->PAYMENT == "C" ? 'selected' : ' '}} value="C">Cash</option>
                                            <option {{ $header->PAYMENT == "30" ? 'selected' : ' '}} value="30">D/A-30</option>
                                            <option {{ $header->PAYMENT == "60" ? 'selected' : ' '}} value="60">D/A-60</option>
                                            <option {{ $header->PAYMENT == "90" ? 'selected' : ' '}} value="90">D/A-90</option>                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row px-2 pb-0 pt-2">
                                    <label class="col-md-2 col-form-label form-control-sm">Tgl Inv Jual</label>
                                    <div class="col-md-3">
                                        <input {{ $readonly }} autocomplete="off" type="text" class="datepicker{{ $readonly == 'readonly' ? '-readonly' : '' }} form-control form-control-sm" name="tgljual" value="{{ $header->TGL_JUAL }}" id="tgljual">
                                    </div>
                                    <label class="col-md-3 text-sm-center col-form-label form-control-sm">Tgl Jth Tempo</label>
                                    <div class="col-md-3">
                                        <input readonly type="text" class="datepicker{{ $readonly == 'readonly' ? '-readonly' : '' }} form-control form-control-sm" name="tgljatuhtempo" id="tgljatuhtempo">
                                    </div>
                                </div>
                                <div class="form-row px-2 pt-2">
                                    <label class="col-form-label col-md-2" for="party">Kode ID</label>
                                    <div class="col-md-2">
                                        <select {{ $readonly == 'readonly' ? 'disabled' : '' }} class="form-control form-control-sm" id="kodeparty" name="kodeparty" value="{{ $header->KODEPARTY_ID }}">
                                            <option value=""></option>
                                            @foreach($kodeparty as $kode)
                                            <option @if($header->KODEPARTY_ID == $kode->KODEPARTY_ID) selected @endif value="{{ $kode->KODEPARTY_ID }}">{{ $kode->URAIAN }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label class="col-md-3 text-sm-center col-form-label form-control-sm">Tgl Lunas</label>
                                    <div class="col-md-3">
                                        <input type="text" class="datepicker{{ $readonly == 'readonly' ? '-readonly' : '' }} form-control form-control-sm" value="{{ $header->TGL_LUNAS }}" name="tgllunas" id="tgllunas">
                                    </div>
                                </div>
                                <div class="form-row px-2">                                    
                                    <label class="col-md-2 col-form-label">Party</label>
                                    <div class="col-md-4">
                                        <select {{ $readonly == 'readonly' ? 'disabled' : '' }} class="form-control form-control-sm" id="party" name="party" value="{{ $header->PEMBELI_ID }}">
                                        </select>
                                    </div>
                                    <label class="col-md-2 col-form-label">No ID</label>
                                    <div class="col-md-3 mt-2">
                                        <span id="no_identitas"></span>
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
                                <h5 class="card-title">Detail Invoice</h5>
                                <div class="form-row">
                                    <div class="col primary-color text-white py-2 px-4">
                                        Detail Invoice
                                    </div>
                                    @can('invoice.transaksi')
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
                                                    <th>Kd Brg</th>
                                                    <th>Produk</th>
                                                    <th>Jumlah</th>
                                                    <th>Satuan</th>
                                                    <th>Harga</th>
                                                    <th>Total DPP</th>
                                                    <th>PPN</th>
                                                    @can('invoice.transaksi')
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
                $('td:eq(2)', row).html(parseFloat(data.JMLSATJUAL).formatMoney(2,"",",","."));
                $('td:eq(4)', row).html(parseFloat(data.HARGA).formatMoney(2,"",",","."));
                $('td:eq(5)', row).html((parseFloat(data.HARGA)*parseFloat(data.JMLSATJUAL)).formatMoney(0,"",",","."));
                $('td:eq(6)', row).html((0.1*parseFloat(data.HARGA)*parseFloat(data.JMLSATJUAL)).formatMoney(0,"",",","."));
                @can('invoice.transaksi')
                $('td:eq(7)', row).html('<a href="#modaldetail" class="edit" data-toggle="modal" id="' + data.ID +
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
                data: "NAMABARANG"
            },
            { target: 1,
                data: "nama"
            },
            { target: 2,
                data: "JMLSATJUAL"
            },
            { target: 3,
                data: "satuan"
            },
            { target: 4,
                data: "HARGA"
            },
            { target: 5,
                data: null
            },
            @can('invoice.transaksi')
            { target: 6,
                data: null
            }
            @endcan
            ],
        })
        @can('invoice.transaksi')
        $("body").on("change","#kodebarang", function(){
            var kodebarang = $(this).val().trim();
            $.ajax({
                method: "GET",
                url: "/transaksi/searchproduk",
                data: {kode: kodebarang},
                success: function(response){
                    if (typeof response.error == 'undefined'){
                        $("#formproduk").html(response.nama);
                        $("#kodebarang_id").val(response.ID);
                    }
                    else {
                        $("#modal .modal-body").html(response.error);
                        $("#formproduk").html("");
                        $("#kodebarang_id").val("");
                        $("#modal").modal("show");
                        setTimeout(function(){
                            $("#modal").modal("hide");
                        }, 5000);
                    }
                }
            })
        })
        $('#modaldetail').on('shown.bs.modal', function () {
            $('#kodebarang').focus();
        })
        $("#harga,#jumlah").on("change", function(){
            var harga = parseFloat($("#harga").inputmask("unmaskedvalue"));
            var jumlah = parseFloat($("#jumlah").inputmask("unmaskedvalue"));
            var total = (harga*jumlah).toFixed(2);
            var ppn = (harga*jumlah*0.1).toFixed(2);
            $("#total").val(total);
            $("#ppn").val(ppn);
        })
        $("#payment, #tgljual").on("change", function(){
            var payment = $("#payment").val();
            var tgljual = $("#tgljual").val();
            if (payment != "" & tgljual != ""){
                if (payment == "C"){
                    tgljatuhtempo = tgljual
                }
                else {
                    var orig = $('#tgljual').datepicker('getDate'); 
                    orig.setDate(orig.getDate()+parseInt(payment)); 
                    $('#tgljatuhtempo').datepicker('setDate', orig);
                }
            }
            else {
                $("#tgljatuhtempo").val("");
            }
        })
        $("#savedetail").on("click", function(){
            var kodebarang = $("#kodebarang").val();
            var kodebarang_id = $("#kodebarang_id").val();
            var produk = $("#formproduk").html();
            var satuan_id = $("#satuan option:selected").val();
            var satuan = $("#satuan option:selected").html();
            if (!satuan){
                satuan = "";
                satuan_id = "";
            }
            var jumlah = $("#jumlah").inputmask('unmaskedvalue');
            var harga = $("#harga").inputmask('unmaskedvalue');
            var act = $("#form").attr("act");

            if (act == "add"){
                tabel.row.add({KODEBARANG: kodebarang_id, NAMABARANG: kodebarang, nama: produk, JMLSATJUAL: jumlah, SATJUAL: satuan_id, satuan: satuan, HARGA: harga}).draw();
                $("#formproduk").html("");
                $("#kodebarang").val("");
                $("#kodebarang_id").val("");
                $("#harga").val("");
                $("#jumlah").val("");
                $("#total").val("");
                $("#ppn").val("");
                $("#satuan").val("");
                $("#kodebarang").focus();
            }
            else if (act == "edit"){
                var id = $("#iddetail").val();
                var idx = $("#idxdetail").val();
                tabel.row(idx).data({ID: id, KODEBARANG: kodebarang_id, NAMABARANG: kodebarang, nama: produk, JMLSATJUAL: jumlah, SATJUAL: satuan_id, satuan: satuan, HARGA: harga}).draw();
                $("#modaldetail").modal("hide");
            }
        });

        $("#adddetail").on("click", function(){
            $("#formproduk").html("");
            $("#kodebarang").val("");
            $("#kodebarang_id").val("");
            $("#harga").val("");
            $("#jumlah").val("");
            $("#total").val("");
            $("#ppn").val("");
            $("#satuan").val("");
            $("#kodebarang").focus();
            $("#modaldetail .modal-title").html("Tambah ");
            $("#form").attr("act","add");
        })
        $("body").on("click", ".edit", function(){
            var row = $(this).closest("tr");
            var index = tabel.row(row).index();
            var row = tabel.rows(index).data();
            $("#formproduk").html(row[0].nama);
            $("#kodebarang").val(row[0].NAMABARANG);
            $("#kodebarang_id").val(row[0].KODEBARANG);
            $("#satuan").val(row[0].SATJUAL);
            $("#harga").val(row[0].HARGA);
            $("#jumlah").val(row[0].JMLSATJUAL);
            $("#total").val(row[0].HARGA*row[0].JMLSATJUAL);
            $("#ppn").val(row[0].HARGA*row[0].JMLSATUAN*0.1);
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
                    data: {_token: "{{ csrf_token() }}", type: "invoice", header: $("#transaksi").serialize(), detail: detail},
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
                    data: {_token: "{{ csrf_token() }}", type: "invoice", delete: "{{ $header->ID}}"},
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
                            window.location.href = "/transaksi/invoice";
                        }
                    }
                })
            });
            $("#modal").modal("show");
        });                
        @endif     
        $("#party").on("change", function(){
            var selected = $(this).find("option:selected");
            if ($(selected).val() == ""){
                $("#no_identitas").html("");
            }
            else {
                $("#no_identitas").html($(selected).attr("no_id"));
            }
        })
        @endcan
        $("#kodeparty").on("change", function(){
            var value = $(this).val();            
            if (value == ""){
                $("#party").html('<option value=""></option>');
                $("#no_identitas").html("");
            }
            else {
                var party = dataparty[value];
                var html = '<option value=""></option>';
                for(var i in party){
                    html += '<option no_id="' + party[i].NO_IDENTITAS + '" value="' + party[i].PARTY_ID + '">' + party[i].NAMA + '</option>';
                }
                $("#party").html(html);
                $("#no_identitas").html("");
            }
        })
        $("#kodeparty").trigger("change");
        $("#party").val("{{ $header->PEMBELI_ID }}");
        $("#no_identitas").html("{{ $header->NO_IDENTITAS }}");
        $("#nopen").inputmask({"mask": "999999","removeMaskOnSubmit": true});      
        $("#payment").trigger("change");
    })
</script>
@endpush
