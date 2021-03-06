{% extends "base.html.twig" %}
{% block body %}
<div class="card">
    <div class="card-header">
        Browse SPTNP
    </div>
    <div class="card-body">
        <div class="row">            
            <div class="col-md-10">
                <form id="form" method="POST" action="/transaksi/browsesptnp?filter=1&export=1">
                    <div class="row">
                        <label class="col-md-2">Kantor</label>
                        <div class="col-md-3 col-sm-6">
                            <select class="form-control form-control-sm" id="kantor" name="kantor">
                                <option value="">Semua</option>
                                {% for ktr in datakantor %}
                                <option {{ ktr.KANTOR_ID == filters.kantor ? 'selected' : '' }} value="{{ ktr.KANTOR_ID }}">{{ ktr.URAIAN }}</option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>           
                    <div class="row">
                        <label class="col-md-2">Importir</label>
                        <div class="col-md-3">
                            <select class="form-control form-control-sm" id="importir" name="importir">
                                {% if dataimportir|length != 1 %}
                                <option value="">Semua</option>
                                {% endif %}
                                {% for imp in dataimportir %}
                                <option value="{{ imp.IMPORTIR_ID }}">{{ imp.NAMA }}</option>
                                {% endfor %}
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
                                {% for kat in datakategori1 %}
                                <option {% if kategori1 == kat %}selected{% endif %} value="{{ kat }}">{{ kat }}</option>
                                {% endfor %}
                            </select>
                        </div>
                        <label class="px-sm-3 col-sm-1">Nilai</label>
                        <div class="col-md-5">
                            <input type="text" id="isikategori1_text" name="isikategori1" class="form-control form-control-sm" style="display:inline;width: 120px">
                            <select disabled id="isikategori1_select" name="isikategori1" class="form-control form-control-sm" style="display:none;width:120px">
                                <option value=""></option>
                                <option value="NP">NP</option>
                                <option value="NP+FORM">NP+FORM Inspect</option>
                                <option value="FORM">FORM</option>
                                <option value="BMT">BMT</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            Kategori
                        </div>
                        <div class="col-md-3">
                            <select class="form-control form-control-sm" id="kategori2" name="kategori2" value="{{ kategori2 }}">
                                <option value=""></option>
                                {% for kat in datakategori2 %}
                                <option {% if kategori2 == kat %}selected{% endif %} value="{{ kat }}">{{ kat }}</option>
                                {% endfor %}
                            </select>
                        </div>
                        <label class="px-sm-3 col-sm-1">Periode</label>
                        <div class="col-md-5">
                            <input autocomplete="off" type="text" id="dari2" name="dari2" value="{{ dari2 }}" class="datepicker form-control d-inline form-control-sm" style="width: 120px">
                            &nbsp;&nbsp;sampai&nbsp;&nbsp;
                            <input autocomplete="off" type="text" id="sampai2" value="{{ sampai2 }}" name="sampai2" class="datepicker form-control d-inline form-control-sm" style="width: 120px">
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
                        <th>Customer</th>                        
                        <th>No Aju</th>
                        <th>Nopen</th>
                        <th>Tgl Nopen</th>
                        <th>No SPTNP</th>
                        <th>Tgl SPTNP</th>
                        <th>Tgl Jth Tempo</th>
                        <th>Tgl Lunas</th>
                        <th>Tgl BRT</th>
                        <th>Hasil BRT</th>
                        <th>Denda TB</th>
                        <th>Total TB</th>
                        <th>Jenis SPTNP</th>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>      
    </div>
</div>  
{% endblock %}
{% block scripts %}
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

var columns = [{target: 0, data: null}, {target: 1, data: "IMPORTIR"}, {target: 2, data: "CUSTOMER"}, {target: 3, data: "NOAJU"},  
{target: 4, data: "NOPEN"}, {target: 5, data: "TGLNOPEN"}, {target: 6, data: "NO_SPTNP"},
{target: 7, data: "TGLSPTNP"}, {target: 8, data: "TGLJTHTEMPOSPTNP"}, {target: 9, data: "TGLLUNAS"}, {target: 10, data: "TGLBRT"},
{target: 11, data: "HSL_BRT"}, 
{target: 12, data: "DENDA_TB"},
{target: 13, data: "TOTAL_TB"},
{target: 14, data: "JENIS_SPTNP"}
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
        $('td:eq(0)', row).html('<a title="Edit" href="/transaksi/' + data.ID + '"><i class="fa fa-edit"></i></a>');
        $('td:eq(12)', row).html(parseFloat(data.DENDA_TB).formatMoney(2,"",",","."));
        $('td:eq(13)', row).html(parseFloat(data.TOTAL_TB).formatMoney(2,"",",","."));
    },
    columnDefs: [
        { "orderable": false, "targets": 0 }
    ]
}); 
$("#kategori1").on("change", function(){
    var value = $(this).val();
    if (value == "Status VO"){
        $("#isikategori1_text").css("display","none");
        $("#isikategori1_text").prop("disabled", true);
        $("#isikategori1_select").css("display","inline");
        $("#isikategori1_select").prop("disabled", false);
    }
    else {
        $("#isikategori1_text").css("display","inline");
        $("#isikategori1_select").css("display","none");
        $("#isikategori1_select").prop("disabled", true);
        $("#isikategori1_text").prop("disabled", false);
    }
})
$("#preview").on("click", function(){
    $.ajax({
       method: "POST",
       url: "/transaksi/browsesptnp?filter=1",
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
{% endblock %}