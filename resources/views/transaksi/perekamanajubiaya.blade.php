@extends('layouts.base')
@section('main')
<div class="card">
    <div class="card-header">
        Browse Pengajuan Biaya
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <form id="form" method="POST" action="/transaksi/ajubiaya?filter=1&export=1">
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
                                @foreach($datakategori as $kat)
                                <option value="{{ $kat }}">{{ $kat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="px-sm-3 col-sm-1">Periode</label>
                        <div class="col-md-5">
                            <input autocomplete="off" type="text" id="dari1" name="dari1" class="datepicker form-control d-inline form-control-sm" style="width: 120px">
                            &nbsp;&nbsp;sampai&nbsp;&nbsp;
                            <input autocomplete="off" type="text" id="sampai1" name="sampai1" class="datepicker form-control d-inline form-control-sm" style="width: 120px">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Kategori
                        </div>
                        <div class="col-md-3">
                            <select class="form-control form-control-sm" id="kategori2" name="kategori2">
                                <option value=""></option>
                                @foreach($datakategori as $kat)
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
                        <th>Tgl Rekam</th>
                        <th>Tgl Aju By</th>
                        <th>Importir</th>
                        <th>Tgl Vrf By</th>
                        <th>Tgl Byr By</th>
                        <th>TTl By</th>
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
        var columns = [{target: 0, data: null, orderable : false},
        {target: 1, data: "TGL_REKAM"},
        {target: 2, data: "TGL_AJU_BY"}, {target: 3, data: "NAMAIMPORTIR"},
        {target: 4, data: "TGL_VRF_BY"}, {target: 5, data: "TGL_BYR_BY"}, {target: 6, data: "TOTAL_BIAYA"}
        ];

        function format(d) {
            // `d` is the original data object for the row            
            let detail = '<table width="100%" class="row-detail">' +
                '<thead>' +
                    '<tr>' +
                        '<th width="15%">Jenis Dok<br>Nomor</th>' +
                        '<th width="20%">Customer</th>' +
                        '<th width="15%">No Aju<br>Nopen</th>' +
                        '<th width="10%">Tgl Nopen</th>' +
                        '<th width="10%">Party</th>' +
                        '<th width="10%">No Inv By<br>Tgl Inv By</th>' +
                        '<th width="10%">DPP</th>' +
                        '<th width="10%">PPN</th>' +
                    '</tr>' + 
                '</thead>' +
                '<tbody>';
                    $(d.details).map(function(key, item){                                                   
                        detail += '<tr>' +
                                    '<td width="15%">' + (item.JENIS_DOKUMEN || '') +'<br>' + (item["NO_" +item.JENIS_DOKUMEN] || '')+ '</td>' +
                                    '<td width="20%">' + item.NAMACUSTOMER + '</td>' +
                                    '<td width="15%">' + item.NOAJU + '<br>' + item.NOPEN +'</td>' +
                                    '<td width="10%">' + item.TGLNOPEN + '</td>' +
                                    '<td width="10%">' + item.JUMLAH_KEMASAN + '</td>' +
                                    '<td width="10%">' + item.NO_INV_BY + '<br>' + item.TGL_INV_BY + '</td>' +
                                    '<td width="10%">' + parseFloat(item.DPP).formatMoney(2,"",",",".") + '</td>' +
                                    '<td width="10%">' + parseFloat(item.PPN).formatMoney(2,"",",",".") + '</td>' +
                                   '</tr>';

                    });                        
                detail += '</tbody></table>';
                return detail;
        }

        var grid = $("#grid").DataTable({responsive: true,
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
                $(row).find("td").css("background", "#dddddd");
                $('td:eq(0)', row).html('<a title="Edit" href="/transaksi/pengajuanbiaya/' + data.ID + '"><i class="fa fa-edit"></i></a>');
                $('td:eq(6)', row).html(parseFloat(data.TOTAL_BIAYA).formatMoney(0,"",",","."));
            }
        }).on('draw.dt', function () {
            grid.rows().every(function () {
                this.child(format(this.data())).show();
                this.nodes().to$().addClass('shown');
                this.child().find('td:first-of-type').addClass('child-container')
            });
        });        
        
        $("#preview").on("click", function(){
            $.ajax({
            method: "POST",
            url: "/transaksi/ajubiaya?filter=1",
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
    })
</script>
@endpush
