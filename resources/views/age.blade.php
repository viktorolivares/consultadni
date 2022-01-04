@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="pb-4 text-primary">Máximo 1000 Consultas</h5>
                    <form method="GET" id="form-dni">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">N° de DNI</label>
                            <textarea class="form-control" id="dni" rows="15"></textarea>
                        </div>
                        <div class="form-group float-right">
                            <button class="btn btn-primary" type="submit" id="btn-dni">Apply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-12 mb-3" id="card-table">
                    <div class="card">
                        <div class="card-body mb-2">
                            <div class="my-3">
                                <button class="btn btn-success" id="btn-excel">
                                    <i class="fa fa-file-excel"></i> &nbsp;
                                    Proceso finalizado |  Exportar en Excel
                                </button>
                            </div>
                            <div class="table-responsive-md">
                                <table class="table table-bordered table-hover table-sm table-condensed" id="table-dni" style="font-size: 13px">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>DNI</th>
                                            <th>Nombre</th>
                                            <th>Apellido Paterno</th>
                                            <th>Apellido Materno</th>
                                            <th>Código de Verf.</th>
                                            <th>Fecha de Nac.</th>
                                            <th>Edad</th>
                                            <th>Genero</th>
                                            <th>Dirección</th>
                                        </tr>
                                    </thead>
                                    <tbody id="body">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" id="progress">
                    <div class="card">
                        <div class="card-body">
                            <div class="progress my-4" style="height: 30px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

<script src="js/jquery.table2excel.min.js"></script>

<script>

    $('#card-table').hide()
    $('#progress').hide()

    $("#btn-dni").on("click", function (e) {

        e.preventDefault()

        $('#card-table').hide();

        var dni = $("#dni").val().split(/\n/)
        var body = $("#body").empty()
        var btn = $(this)

        btn.prop('disabled', true);

        setTimeout (function ()
        {
            btn.prop ('disabled', false);
        }, 2000);


        $(".progress-bar").css("width", 0 + "%")
                          .attr("aria-valuenow", 0)
                          .text(0 + "%");

        $('#progress').toggle();


        if (dni)
        {
            if(dni.length <= 1000){
                for (var i=0; i < dni.length; i++)
                {
                    $.ajax({
                        type: 'GET',
                        url: "/dni/" +  dni[i],
                        data: {},
                        success: function(data){
                            var table = '';

                            progressed = Math.floor( (++i / dni.length * 100) / 2)

                            $(".progress-bar").css("width", progressed + "%")
                                            .attr("aria-valuenow", progressed)
                                            .text(progressed + "%");

                            if (progressed == 100) {
                                $('#card-table').show()
                                $('#progress').hide()
                            }

                            if (data.error == 404)
                            {
                                $.notify("Ocurrió un error, no xiste coincidencias", "info");
                            }
                            else
                            {
                                if (data.oefa.original.fechaNacimiento != null) {
                                    var birthday = data.oefa.original.fechaNacimiento
                                    y = birthday.substr(0,4);
                                    m = birthday.substr(4,2);
                                    d = birthday.substr(6,2);

                                    var date = d + '/' + m + '/' + y
                                    var date2 = y + '/' + m + '/' + d
                                }
                                else
                                {
                                    var date = $.date(data.midis.original.dtFecNacimiento)
                                    var date2 = $.date2(data.midis.original.dtFecNacimiento)
                                }

                                var age = calcularAge(date2)

                                if (age < 18 || data.midis.original.vMensajeResponse) {
                                    if (data.midis.original.vMensajeResponse) {
                                        table += '<tr>',
                                        table += '<td>' + data.midis.original.vNroDocumento + '</td>',
                                        table += '<td>' + data.sunat.original.nombreSoli + '</td>',
                                        table += '<td>' + data.sunat.original.apePatSoli + '</td>',
                                        table += '<td>' + data.sunat.original.apeMatSoli + '</td>',
                                        table += '<td>' + data.codigoV + '</td>',
                                        table += '<td>' + data.midis.original.vMensajeResponse + '</td>',
                                        table += '<td>' + '-' + '</td>',
                                        table += '<td>' + '-' + '</td>',
                                        table += '<td>' + '-' + '</td>',
                                        table += '</tr>'
                                        $('#body').append(table);
                                    }
                                    else
                                    {
                                        table += '<tr>',
                                        table += '<td>' + data.midis.original.vNroDocumento + '</td>',
                                        table += '<td>' + data.sunat.original.nombreSoli + '</td>',
                                        table += '<td>' + data.sunat.original.apePatSoli + '</td>',
                                        table += '<td>' + data.sunat.original.apeMatSoli + '</td>',
                                        table += '<td>' + data.codigoV + '</td>',
                                        table += '<td>' + date + '</td>',
                                        table += '<td>' + age + '</td>'

                                        if (data.oefa.original.genero == 117) {
                                            table += '<td>' + 'H' + '</td>'
                                        } else {
                                            table += '<td>' + 'M' + '</td>'
                                        }
                                        table += '<td>' + data.midis.original.vDireccion + '</td>',
                                        table += '</tr>'
                                        $('#body').append(table);
                                    }
                                }
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            console.log("Status: " + textStatus);
                            console.log("Error: " + errorThrown);
                            progressed = Math.floor( (++i / dni.length * 100) / 2)

                            $(".progress-bar").css("width", progressed + "%")
                                            .attr("aria-valuenow", progressed)
                                            .text(progressed + "%");

                            if (progressed == 100) {
                                $('#card-table').show()
                                $('#progress').hide()
                            }
                        }
                    });
                }
            } else{
                $.notify("Número máximo de consultas: 1000", "error");
            }
        }
        else
        {
            $.notify("Ingrese un número de DNI", "error");
        }
    });

    $.date = function(dateObject) {
        var d = new Date(dateObject);
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        var date = day + "/" + month + "/" + year;

        return date;
    };

    $.date2 = function(dateObject) {
        var d = new Date(dateObject);
        var day = d.getDate();
        var month = d.getMonth() + 1;
        var year = d.getFullYear();
        if (day < 10) {
            day = "0" + day;
        }
        if (month < 10) {
            month = "0" + month;
        }
        var date = year + "/" + month + "/" + day;
        return date;
    };

    function calcularAge(date) {
        var today = new Date();
        var birthday = new Date(date);
        var age = today.getFullYear() - birthday.getFullYear();
        var m = today.getMonth() - birthday.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < birthday.getDate())) {
            age--;
        }

        return age;
    }

    var excel_name = new Date().getTime() ;

    $("#btn-excel").click(function(e) {
        $("#table-dni").table2excel({
            filename: "dni-" + excel_name + ".xls",
            preserveColors: false
        });
    });

</script>

@endpush

