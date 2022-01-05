@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <form method="GET" id="form-dni">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">N° de DNI</label>
                        <input type="text" class="form-control"  maxlength="8"  id="dni">
                    </div>
                    <div class="form-group float-right">
                        <button class="btn btn-primary" type="submit" id="btn-dni">Apply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-9" id="card-form">
        <div class="card">
            <div class="card-header bg-transparent">
                <strong>Consultas Combinadas</strong>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="lastname1">Apellido Paterno</label>
                            <input type="text" class="form-control" id="lastname1" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="lastname2">Apellido Materno</label>
                            <input type="text" class="form-control" id="lastname2" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="status">Estado Civil</label>
                            <input type="text" class="form-control" id="status" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="sex">Genero</label>
                            <input type="text" class="form-control" id="sex" readonly>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="age">Edad</label>
                            <input type="text" class="form-control" id="age" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="code">Código de Verf.</label>
                            <input type="text" class="form-control" id="code" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="date">Fecha Nac.</label>
                            <input type="text" class="form-control" id="date" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="address">Dirección</label>
                            <input type="text" class="form-control" id="address" readonly>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="ubigeo">Ubigeo</label>
                            <input type="text" class="form-control" id="ubigeo" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="department">Departamento</label>
                            <input type="text" class="form-control" id="department" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="province">Provincia</label>
                            <input type="text" class="form-control" id="province" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="district">Distrito</label>
                            <input type="text" class="form-control" id="district" readonly>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>

    $("#btn-dni").on("click", function (e) {

        e.preventDefault()
        resetForm();
        $("#alert").hide()

        var dni = $("#dni").val()
        var btn = $(this)
        btn.prop('disabled', true);

        setTimeout (function ()
        {
            btn.prop ('disabled', false);
        }, 2000);

        if (dni)
        {
            $.ajax({
                type: 'GET',
                url: "/dni/" + dni,
                success: function (data) {
                    if (data.error == 404)
                    {
                        $.notify("No se encontró coincidencias", "info");
                    }
                    else
                    {

                        if (data.midis.original.vMensajeResponse) {
                            $.notify(data.midis.original.vMensajeResponse, "error");
                            $("#name").val(((data.sunat.original.error)  ? '' : data.sunat.original.nombreSoli))
                            $("#lastname1").val(((data.sunat.original.error)  ? '' : data.sunat.original.apePatSoli))
                            $("#lastname2").val(((data.sunat.original.error)  ? '' : data.sunat.original.apeMatSoli))
                            $("#code").val(((data.sunat.original.error)  ? '' : data.codigoV))
                        }
                        else{
                            if (data.oefa.original.fechaNacimiento != null) {
                                var birthday = data.oefa.original.fechaNacimiento
                                y = birthday.substr(0,4);
                                m = birthday.substr(4,2);
                                d = birthday.substr(6,2);

                                var date = d + '/' + m + '/' + y
                                var date2 = y + '/' + m + '/' + d


                            }
                            else {
                                var date = $.date(data.midis.original.dtFecNacimiento)
                                var date2 = $.date2(data.midis.original.dtFecNacimiento)
                            }

                            $("#name").val(data.sunat.original.nombreSoli)
                            $("#lastname1").val(data.sunat.original.apePatSoli)
                            $("#lastname2").val(data.sunat.original.apeMatSoli)
                            $("#code").val(data.codigoV)
                            $("#address").val(data.midis.original.vDireccion)
                            $("#ubigeo").val(data.oefa.original.ubigeo)

                            var ubigeo = data.oefa.original.ubigeo

                            $.ajax({
                                type: "GET",
                                dataType: "json",
                                url: "js/ubigeo.json",
                                success: function (data) {
                                    $.each(data, function(i, v) {
                                        if (v.inei_district == ubigeo) {
                                            $("#department").val(v.departamento)
                                            $("#province").val(v.provincia)
                                            $("#district").val(v.distrito)
                                            return false;
                                        }
                                    });
                                }
                            })

                            if (data.oefa.original.genero == 117) {
                                $("#sex").val('Hombre')
                            } else if(data.oefa.original.genero == 118) {
                                $("#sex").val('Mujer')
                            } else {
                                $("#sex").val('-')
                            }

                            if (data.oefa.original.estadoCivil == 112) {
                                $("#status").val('Soltero(a)')
                            } else if(data.oefa.original.estadoCivil == 115) {
                                $("#status").val('Divorciado(a)')
                            } else if(data.oefa.original.estadoCivil == 113) {
                                $("#status").val('Casado(a)')
                            } else {
                                $("#status").val('-')
                            }

                            $("#age").val(calcularAge(date2))

                            if (calcularAge(date2) < 18) {
                                $.notify("DNI Corresponde a un menor de edad", "error");
                            }

                            $("#date").val(date);

                            }

                        $.notify("Consulta cargada exitosamente", "success");
                    }
                }
            });
        }
        else
        {
            $.notify("Ingrese un número de DNI", "error", { position:"top center" });
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

    function resetForm(){
        $("#name").val('')
        $("#lastname1").val('')
        $("#lastname2").val('')
        $("#code").val('')
        $("#address").val('')
        $("#date").val('');
        $("#age").val('');
        $("#status").val('');
        $("#sex").val('');
        $("#ubigeo").val('');
        $("#department").val('');
        $("#province").val('');
        $("#district").val('');
    }

</script>

@endpush

