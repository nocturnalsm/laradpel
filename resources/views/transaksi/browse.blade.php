@extends('layouts.base')
@section('main')
<div class="card">
    <div class="card-header">
        Browse Transaksi
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-8">
                <form id="form" method="POST" action="/transaksi/filter?export=1">
                    @csrf
                    <div class="row">
                        <label class="col-md-2">Kantor</label>
                        <div class="col-md-5 col-sm-6">
                            <select class="form-control form-control-sm" id="kantor" name="kantor">
                                <option value="">Semua</option>
                                @foreach($datakantor as $ktr)
                                <option value="{{ $ktr->KANTOR_ID }}">{{ $ktr->URAIAN }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @can('customer.view')
                    <div class="row">
                        <label class="col-md-2">Customer</label>
                        <div class="col-md-8">
                            <select class="form-control form-control-sm" id="customer" name="customer">
                                <option value="">Semua</option>
                                @foreach($datacustomer as $cust)
                                <option value="{{ $cust->id_customer }}">{{ $cust->nama_customer }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endcan
                    <div class="row">
                        <label class="col-md-2">Importir</label>
                        <div class="col-md-8">
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
                        <label class="px-sm-3">Periode</label>
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
                        <label class="px-sm-3">Periode</label>
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
                        <th>Kd Ktr</th>
                        <th>No. Inv</th>
                        <th>No. BL</th>
                        <th>Jml Kmsn</th>
                        <th>Customer</th>
                        <th>Importir</th>
                        <th>Tgl Tiba</th>
                        <th>Tgl SPPB</th>
                        <th>Tgl Keluar</th>
                        <th>Tgl Masuk</th>
                        <th>No Aju</th>
                        <th>Nopen</th>
                        <th>Tgl Nopen</th>
                        <!--
                        <th>No. PO</th>
                        <th>No. SC</th>
                        -->
                        <th>Jml Kontainer</th>
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
<script type="text/javascript" src="{{ asset('js/jquery.inputmask.bundle.js') }}"></script>
<script type="text/javascript" src="{{ asset('jquery-ui/jquery-ui.min.js') }}"></script>
<script>
$(function(){
    $(".datepicker").datepicker({dateFormat: "dd-mm-yy"});
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
            columns: [{target: 0, data: "KODEKANTOR"}, {target: 1, data: "NO_INV"},
                {target: 2, data: "NO_BL"},
                {target: 3, data: "JUMLAH_KEMASAN"},
                {target: 4, data: "NAMA"@cannot('customer.view') , visible: false @endcannot}, {target: 5, data: "IMPORTIR"},
                {target: 6, data: "TGLTIBA"}, {target: 7, data: "TGLSPPB"}, {target: 8, data: "TGLKELUAR"},
                {target: 9, data: "TGLMASUK"},
                {target: 10, data: "NOAJU"},
                {target: 11, data: "NOPEN"},{target: 12, data: "TGLNOPEN"},
                /*
                {target: 9, data: "NO_PO"},
                {target: 10, data: "NO_SC"},
                */
                {target: 13, data: "JUMLAH_KONTAINER"}
                ],
        }
    );
    $("#preview").on("click", function(){
        $.ajax({
        method: "POST",
        url: "/transaksi/filter",
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
