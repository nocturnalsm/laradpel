@extends('layouts.base')
@section('main')
<div class="card">
    <div class="card-header">
        Browse Mutasi Kas
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="form" method="POST" action="/transaksi/browsemutasikas?filter=1&export=1">
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
                            <select class="kategori form-control form-control-sm" id="kategori1" name="kategori1">
                                <option value=""></option>
                                @foreach($datakategori1 as $kat)
                                <option value="{{ $kat }}">{{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="px-sm-3 col-sm-1">Nilai</label>
                        <div class="col-md-5">
                            <select class="kategori_value form-control form-control-sm" id="isikategori1_text" name="isikategori1">                                
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Kategori
                        </div>
                        <div class="col-md-3">
                            <select class="kategori form-control form-control-sm" id="kategori2" name="kategori2">
                                <option value=""></option>
                                @foreach($datakategori1 as $kat)
                                <option value="{{ $kat }}">{{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="px-sm-3 col-sm-1">Nilai</label>
                        <div class="col-md-5">
                            <select class="kategori_value form-control form-control-sm" id="isikategori2_text" name="isikategori2">                                
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Kategori
                        </div>
                        <div class="col-md-3">
                            <select class="form-control form-control-sm" id="kategori3" name="kategori3">
                                <option value=""></option>
                                @foreach($datakategori2 as $kat)
                                <option value="{{ $kat }}">{{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="px-sm-3 col-sm-1">Periode</label>
                        <div class="col-md-5">
                            <input autocomplete="off" type="text" id="dari3" name="dari3" class="datepicker form-control d-inline form-control-sm" style="width: 120px">
                            &nbsp;&nbsp;sampai&nbsp;&nbsp;
                            <input autocomplete="off" type="text" id="sampai3" name="sampai3" class="datepicker form-control d-inline form-control-sm" style="width: 120px">
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
                        <th>Tanggal</th>
                        <th>Importir</th>
                        <th>Rekening</th>
                        <th>Nominal</th>
                        <th>D/K</th>
                        <th>Kd Acc</th>
                        <th>Kd ID</th>
                        <th>Party</th>
                        <th>No Dok</th>
                        <th>Tgl Dok</th>
                        <th>Remarks</th>
                        <th>Upload</th>
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
        var columns = [{target: 0, data: null, orderable: false @cannot('mutasikas.transaksi') , visible: false @endcannot }, {target: 1, data: "TANGGAL"},
        {target: 2, data: "IMPORTIR"}, {target: 3, data: "NO_REKENING"},
        {target: 4, data: "NOMINAL"},
        {target: 5, data: "DK"},
        {target: 6, data: "KODE_ACC"},
        {target: 7, data: "KODE_PARTY"},
        {target: 8, data: "PARTY"},
        {target: 9, data: "NO_DOK"},
        {target: 10, data: "TGL_DOK"},
        {target: 11, data: "REMARKS"}, {target: 12, data: null}
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
            order: [[0, 'asc']],
            columns: columns,
            rowCallback: function(row, data)
            {
                $(row).attr("id-transaksi", data[0]);
                var nominal_col = 3
                @can('mutasikas.transaksi')                
                $('td:eq(0)', row).html('<a title="Edit" href="/transaksi/mutasikas/' + data.ID + '"><i class="fa fa-edit"></i></a>');
                nominal_col = 4;
                @endcannot
                $("td:eq(" + nominal_col +")", row).html(parseFloat(data.NOMINAL).formatMoney(2));
            },
            columnDefs: [
                { "orderable": false, "targets": 0 }
            ]
        });
        $("#preview").on("click", function(){
            $.ajax({
            method: "POST",
            url: "/transaksi/browsemutasikas?filter=1",
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
        $(".kategori").on("change", function(){
            var select = $(this).find("option:selected");
            var value = "";
            if ($(select).length > 0){
                value = $(select).val();
            }
            var select_values = $(select).closest(".row").find(".kategori_value");
            var options_html = "";
            if (value == "Kode Acc"){                
                var source = @json($kodeacc);
                options = JSON.parse(source);                
                for(var i in options){
                    options_html += '<option value="' + options[i].KODEACC_ID +'">' + options[i].URAIAN +'</option>';
                }                
            }
            else if (value == "Kode ID"){                
                var source = @json($kodeparty);
                options = JSON.parse(source);                
                for(var i in options){
                    options_html += '<option value="' + options[i].KODEPARTY_ID +'">' + options[i].KODE +'</option>';
                }                
            }
            else if (value == "No Rekening"){                
                var source = @json($rekening);
                options = JSON.parse(source);                
                for(var i in options){
                    options_html += '<option value="' + options[i].REKENING_ID +'">' 
                                 + options[i].BANK + ' - '  + options[i].NO_REKENING +'</option>';
                }                
            }
            else if (value == "D/K"){
                options_html = '<option value="D">D</option>' +
                               '<option value="K">K</option>';
            }
            $(select_values).html(options_html);
        })
    })
</script>
@endpush
