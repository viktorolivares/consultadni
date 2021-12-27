@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="pb-4 text-primary">Máximo 50 Consultas</h5>
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
       <div class="col-md-10" id="card-table">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-success fa-pull-right" id="btn-excel">
                        <i class="fa fa-file-excel"></i>
                        &nbsp;Excel
                    </button>
                </div>
                <div class="card-body mt-3">
                    <div class="table-responsive-md">
                        <table class="table table-bordered table-hover table-sm table-condensed" id="table-dni">
                            <thead class="thead-light">
                                <tr>
                                    <th>Dni</th>
                                    <th>Nombre</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Código de Verf.</th>
                                    <th>Fecha de Nac.</th>
                                    <th>Edad</th>
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
    </div>
@endsection

@push('scripts')

<script src="js/jquery.table2excel.min.js"></script>

<script>

    $('#card-table').hide()

    $("#btn-dni").on("click", function (e) {

        e.preventDefault()

        $('#card-table').toggle()

        var dni = $("#dni").val().split(/\n/)
        var body = $("#body").empty()

        var btn = $(this)
        btn.prop('disabled', true);

        console.log(dni)

        setTimeout (function ()
        {
            btn.prop ('disabled', false);
        }, 2000);

        if (dni)
        {
            if(dni.length <= 50){
                for (var i=0; i < dni.length; i++)
                {
                    $.get("/dni/" + dni[i], function (data)
                    {
                        var table = '';

                        console.log(data)

                        if (data.error == 404)
                        {
                            $.notify("Ocurrió un error, no xiste coincidencias", "info");
                        }
                        else
                        {
                            if (data.midis.original.vMensajeResponse) {

                                table += '<tr class="table-danger">',
                                table += '<td>' + data.externalApi.original.result.DNI + '</td>',
                                table += '<td>' + data.sunat.original.nombreSoli + '</td>',
                                table += '<td>' + data.sunat.original.apePatSoli + '</td>',
                                table += '<td>' + data.sunat.original.apeMatSoli + '</td>',
                                table += '<td>' + data.codigoV + '</td>',
                                table += '<td>' + data.midis.original.vMensajeResponse + '</td>',
                                table += '<td>' + '-' + '</td>',
                                table += '<td>' + '-' + '</td>',
                                table += '</tr>'

                                $('#body').append(table);

                            }
                            else
                            {
                                var date = $.date(data.midis.original.dtFecNacimiento)
                                var date2 = $.date2(data.midis.original.dtFecNacimiento)

                                var age = calcularAge(date2)

                                if (age < 18) {
                                    table += '<tr class="table-danger">'
                                } else {
                                    table += '<tr>'
                                }

                                table += '<td>' + data.externalApi.original.result.DNI + '</td>',
                                table += '<td>' + data.sunat.original.nombreSoli + '</td>',
                                table += '<td>' + data.sunat.original.apePatSoli + '</td>',
                                table += '<td>' + data.sunat.original.apeMatSoli + '</td>',
                                table += '<td>' + data.codigoV + '</td>',
                                table += '<td>' + date + '</td>',
                                table += '<td>' + calcularAge(date2) + '</td>',
                                table += '<td>' + data.midis.original.vDireccion + '</td>',
                                table += '</tr>'

                                $('#body').append(table);
                            }
                            $('#card-table').show()
                        }
                    });
                }
            } else{
                $.notify("Número máximo de consultas: 50", "error");
                $('#card-table').toggle()
            }
        }
        else
        {
            $.notify("Ingrese un número de DNI", "error");
            table.hide();
            spin.show()
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

    var d = new Date().getTime() ;

    $("#btn-excel").click(function(e) {
        $("#table-dni").table2excel({
            filename: "dni-" + d + ".xls",
            preserveColors: false
        });
    });


</script>

@endpush

