@extends('layouts.base')
@section('main')
<div class="card">
    <div class="card-header">
        Browse Invoice
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="form" method="POST" action="/transaksi/browseinvoice?filter=1&export=1">
                    @csrf
                    <div class="row">
                        <label class="col-md-2">Importir</label>
                        <div class="col-md-3">
                            <select class="form-control form-control-sm" id="importir" name="importir">
                                @if(count($dataimportir) != 1)
                                <option value="">Semua</option>
                                @endif
                                @foreach($dataimportir as $imp)
                                <option value="{{ $imp->IMPORTIR_ID }}">{{ $imp->NAMA }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Kategori
                        </div>
                        <div class="col-md-3">
                            <select class="form-control form-control-sm" id="kategori1" name="kategori1">
                                <option value=""></option>
                                @foreach($datakategori1 as $kat)
                                <option value="{{ $kat }}">{{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="px-sm-3 col-2 col-sm-1">Nilai</label>
                        <div class="col-md-4">
                            <input type="text" id="isikategori1_text" name="isikategori1" class="form-control form-control-sm" style="display:inline;width: 120px">
                            <select disabled id="isikategori1_select_payment" name="isikategori1" class="form-control form-control-sm" style="display:none;width:120px">
                                <option value=""></option>
                                <option value="C">Cash</option>
                                <option value="30">D/A-30</option>
                                <option value="60">D/A-60</option>
                                <option value="90">D/A-90</option>
                            </select>
                            <select disabled id="isikategori1_select_kodeid" name="isikategori1" class="form-control form-control-sm" style="display:none;width:120px">
                                <option value=""></option>
                                @foreach($kodeparty as $kode)
                                <option value="{{ $kode->KODEPARTY_ID }}">{{ $kode->URAIAN }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Kategori
                        </div>
                        <div class="col-md-3">
                            <select class="form-control form-control-sm" id="kategori2" name="kategori2">
                                <option value=""></option>
                                @foreach($datakategori2 as $kat)
                                <option value="{{ $kat }}">{{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="px-sm-3 col-sm-1">Periode</label>
                        <div class="col-md-5">
                            <input autocomplete="off" type="text" id="dari2" name="dari2" class="datepicker form-control d-inline form-control-sm" style="width: 120px">
                            &nbsp;&nbsp;sampai&nbsp;&nbsp;
                            <input autocomplete="off" type="text" id="sampai2" name="sampai2" class="datepicker form-control d-inline form-control-sm" style="width: 120px">
                        </div>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 px-sm-2 pt-2">
                <a id="preview" class="btn btn-primary">Filter</a>
                <a id="export" class="btn btn-primary disabled">Export</a>
            </div>
        </div>
        </form>
        <div class="row mt-4 pt-4">
            <div class="col" id="divtable">
                <table width="100%" id="grid" class="table">
                    <thead>
                        <th>Opsi</th>
                        <th>Importir</th>
                        <th>No Inv Jual<br>Tgl Inv Jual</th>
                        <th>No Faktur<br>Tgl Faktur</th>
                        <th>Kode ID<br>Party</th>
                        <th>Payment</th>
                        <th>Jth Tempo</th>
                        <th>Tgl Lunas</th>
                        <th>PPN</th>
                        <th>Total</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('stylesheets_end')
    <link href="{{ asset('jquery-ui/jquery-ui.min.css') }}" rel="stylesheet">
@endpush
@push('scripts_end')
<script type="text/javascript" src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
<script>
    $(function(){
        $(".datepicker").datepicker({dateFormat: "dd-mm-yy"});

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
        var columns = [{target: 0, data: null},
        {target: 1, data: "NAMAIMPORTIR"}, {target: 2, data: "NO_INV_JUAL"},
        {target: 3, data: "NO_FAKTUR"}, {target: 4, data: "PARTY"},
        {target: 5, data: "PAYMENT"}, {target: 6, data: "TGL_JATUH_TEMPO"}, {target: 7, data: "TGL_LUNAS"},
        {target: 8, data: "TOTAL_PPN"}, {target: 9, data: "TOTAL_INV"}
        ];

        var grid = $("#grid").DataTable({responsive: false,
            dom: "rtip",
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
            order: [[1, 'asc']],
            columns: columns,
            rowCallback: function(row, data)
            {
                $(row).attr("id-transaksi", data[0]);
                @can('invoice.transaksi')
                $('td:eq(0)', row).html('<a title="Edit" href="/transaksi/invoice/' +data.ID + '">' +
                                        '<i class="fa fa-cog"></i></a>');
                @endcan
                $('td:eq(2)', row).html(data.NO_INV_JUAL + '<BR>' + data.TGL_INV_JUAL);
                $('td:eq(3)', row).html(data.NO_FAKTUR + '<BR>' + data.TGL_FAKTUR);
                $('td:eq(4)', row).html(data.KODE_ID + '<BR>' + data.PARTY);
                $('td:eq(5)', row).html((data.PAYMENT != '' ? (data.PAYMENT == 'C' ? 'Cash' : 'D/A-' +data.PAYMENT) : ''));
                $('td:eq(8)', row).html(parseFloat(data.TOTAL_PPN).formatMoney(2,"",",","."));
                $('td:eq(9)', row).html(parseFloat(data.TOTAL_INV).formatMoney(2,"",",","."));
            }
        });
        $("#preview").on("click", function(){
            $.ajax({
            method: "POST",
            url: "/transaksi/browseinvoice?filter=1",
            data: $("#form").serialize(),
            success: function(msg){
                    grid.clear().rows.add(msg);
                    grid.columns.adjust().draw();
                    if (msg.length == 0){
                        $("#export").addClass("disabled");
                    }
                    else {
                        $("#export").removeClass("disabled");
                    }
            }
            });
        })
        $("#form input, select").on("change", function(){
            $("#export").addClass("disabled");
        })
        $("#export").on("click", function(){
            $("#form").submit();
        })
        $("#kategori1").on("change", function(){
            var value = $(this).val();
            if (value == "Kode ID"){
                $("#isikategori1_text").css("display","none");
                $("#isikategori1_text").prop("disabled", true);
                $("#isikategori1_select_payment").css("display","none");
                $("#isikategori1_select_payment").prop("disabled", true);
                $("#isikategori1_select_kodeid").css("display","inline");
                $("#isikategori1_select_kodeid").prop("disabled", false);
            }
            else if (value == "Payment"){
                $("#isikategori1_text").css("display","none");
                $("#isikategori1_text").prop("disabled", true);
                $("#isikategori1_select_payment").css("display","inline");
                $("#isikategori1_select_payment").prop("disabled", false);
                $("#isikategori1_select_kodeid").css("display","none");
                $("#isikategori1_select_kodeid").prop("disabled", true);
            }
            else {
                $("#isikategori1_text").css("display","inline");
                $("#isikategori1_text").prop("disabled", false);
                $("#isikategori1_select_kodeid").css("display","none");
                $("#isikategori1_select_kodeid").prop("disabled", true);    
                $("#isikategori1_select_payment").css("display","none");
                $("#isikategori1_select_payment").prop("disabled", true);            
            }
        })
    })
</script>
@endpush
