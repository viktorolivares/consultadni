@extends('layouts.app')

@section('content')
<div class="row mb-2">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <h5 class="pb-4 text-primary">Máximo 500 Consultas</h5>
                <form method="GET" id="form-dni">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">N° de DNI</label>
                        <textarea class="form-control" id="dni" rows="15"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" type="submit" id="btn-dni">Apply</button>
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
                            <button class="btn btn-success btn-sm" id="btn-excel">
                                <i class="fa fa-file-excel"></i> &nbsp;
                                Proceso finalizado | Exportar en Excel
                            </button>
                        </div>
                        <div class="table-responsive-md">
                            <table class="table table-bordered table-hover table-sm table-condensed" id="table-dni"
                                style="font-size: 13px">
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
                                        <th>Mensaje</th>
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
                        <div class="progress my-4">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
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

        setTimeout(function () {
            btn.prop('disabled', false);
        }, 5000);


        // $(".progress-bar").css("width", 0 + "%")
        //     .attr("aria-valuenow", 0)
        //     .text(0 + "%");

        // $('#progress').toggle();


        if (dni) {
            if (dni.length <= 500) {
                for (var i = 0; i < dni.length; i++) {
                    $.ajax({
                        type: 'GET',
                        url: "/dni/" + dni[i],
                        data: {},
                        beforeSend: function () {
                            $("div.loading").show();
                        },
                        success: function (data) {

                            console.log(data);

                            var table = '';

                            if (data.error == 404) {
                                $.notify("Ocurrió un error, no xiste coincidencias", "info");
                            }
                            else {
                                if (data.oefa.original.fechaNacimiento != null) {
                                    var birthday = data.oefa.original.fechaNacimiento
                                    y = birthday.substr(0, 4);
                                    m = birthday.substr(4, 2);
                                    d = birthday.substr(6, 2);

                                    var date = d + '/' + m + '/' + y
                                    var date2 = y + '/' + m + '/' + d

                                }

                                var age = calcularAge(date2)

                                if (age < 18) {
                                    table += '<tr class="table-danger">',
                                    table += '<td>' + data.jne.original.dni + '</td>',
                                    table += '<td>' + data.sunat.original.nombreSoli + '</td>',
                                    table += '<td>' + data.sunat.original.apePatSoli + '</td>',
                                    table += '<td>' + data.sunat.original.apeMatSoli + '</td>',
                                    table += '<td>' + data.codigoV + '</td>',
                                    table += '<td>' + date + '</td>',
                                    table += '<td>' + calcularAge(date2) + '</td>'

                                    if (data.oefa.original.genero == 117) {
                                        table += '<td>' + 'H' + '</td>'
                                    } else {
                                        table += '<td>' + 'M' + '</td>'
                                    }

                                    table += '<td>' + data.oefa.original.direccion + '</td>',
                                    table += '<td>' + data.apiExterna.original.statusMessage + '</td>',
                                    table += '</tr>'

                                    $('#body').append(table);
                                }
                            }

                            progressed = Math.floor((++i / dni.length * 100) / 2)

                            $(".progress-bar").css("width", progressed + "%")
                                .attr("aria-valuenow", progressed)
                                .text(progressed + "%");

                            if (progressed == 100) {
                                $("div.loading").hide();
                                $('#card-table').show();
                            }

                            if (data.error == 404) {
                                $.notify("Ocurrió un error, no xiste coincidencias", "info");
                            }
                            else {
                                if (data.oefa.original.esValido == "false") {

                                    table += '<tr class="table-danger">',
                                        table += '<td>' + data.jne.original.dni + '</td>',
                                        table += '<td>' + ((data.sunat.original.error) ? '-' : data.sunat.original.nombreSoli) + '</td>',
                                        table += '<td>' + ((data.sunat.original.error) ? '-' : data.sunat.original.apePatSoli) + '</td>',
                                        table += '<td>' + ((data.sunat.original.error) ? '-' : data.sunat.original.apeMatSoli) + '</td>',
                                        table += '<td>' + ((data.sunat.original.error) ? '-' : data.codigoV) + '</td>',
                                        table += '<td>' + '-' + '</td>',
                                        table += '<td>' + '-' + '</td>',
                                        table += '<td>' + '-' + '</td>',
                                        table += '<td>' + '-' + '</td>',
                                        table += '<td>' + data.oefa.original.mensaje + '</td>',
                                        table += '</tr>'

                                    $('#body').append(table);

                                }
                                else {
                                    if (data.oefa.original.fechaNacimiento != null) {
                                        var birthday = data.oefa.original.fechaNacimiento
                                        y = birthday.substr(0, 4);
                                        m = birthday.substr(4, 2);
                                        d = birthday.substr(6, 2);

                                        var date = d + '/' + m + '/' + y
                                        var date2 = y + '/' + m + '/' + d

                                    }

                                    var age = calcularAge(date2)

                                    if (age < 18) {
                                        table += '<tr class="table-danger">'
                                    } else {
                                        table += '<tr>'
                                    }

                                    table += '<td>' + data.jne.original.dni + '</td>',
                                        table += '<td>' + data.sunat.original.nombreSoli + '</td>',
                                        table += '<td>' + data.sunat.original.apePatSoli + '</td>',
                                        table += '<td>' + data.sunat.original.apeMatSoli + '</td>',
                                        table += '<td>' + data.codigoV + '</td>',
                                        table += '<td>' + date + '</td>',
                                        table += '<td>' + calcularAge(date2) + '</td>'

                                    if (data.oefa.original.genero == 117) {
                                        table += '<td>' + 'H' + '</td>'
                                    } else {
                                        table += '<td>' + 'M' + '</td>'
                                    }
                                    table += '<td>' + data.oefa.original.direccion + '</td>',
                                        table += '<td>' + data.apiExterna.original.statusMessage + '</td>',
                                        table += '</tr>'

                                    $('#body').append(table);
                                }
                            }



                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {

                            $.notify("Status: Error en servidor externo | " + textStatus, 'error');
                            $.notify("Error: " + errorThrown, 'error');

                            progressed = Math.floor((++i / dni.length * 100) / 2)
                            console.log(dni[i])

                            $(".progress-bar").css("width", progressed + "%")
                                .attr("aria-valuenow", progressed)
                                .text(progressed + "%");

                            if (progressed == 100) {
                                $("div.loading").hide();
                                $('#card-table').show();
                            }
                        }
                    });
                }
            } else {
                $.notify("Número máximo de consultas: 500", "error");
            }
        }
        else {
            $.notify("Ingrese un número de DNI", "error");
        }
    });

    $.date = function (dateObject) {
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

    $.date2 = function (dateObject) {
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

    var excel_name = new Date().getTime();

    $("#btn-excel").click(function (e) {
        $("#table-dni").table2excel({
            filename: "dni-" + excel_name + ".xls",
            preserveColors: false
        });
    });

</script>

@endpush
