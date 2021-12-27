@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <form method="GET" id="form-dni">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">N° de DNI</label>
                        <input type="text" class="form-control" maxlength="8" id="dni">
                    </div>
                    <div class="form-group float-right">
                        <button class="btn btn-primary" type="submit" id="btn-dni">Apply</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-9" id="card-form">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-dark">
                        <h5 class="card-title text-white">Fuente: Sunat</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" id="nameS">Nombres: <span></span></li>
                        <li class="list-group-item" id="lastname1S">Ap. Paterno: <span></span></li>
                        <li class="list-group-item" id="lastname2S">Ap. Materno: <span></span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-primary">
                        <h5 class="card-title text-white">Fuente: Midis</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" id="nameM">Nombres: <span></span></li>
                        <li class="list-group-item" id="lastname1M">Ap. Paterno: <span></span></li>
                        <li class="list-group-item" id="lastname2M">Ap. Materno: <span></span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-success">
                        <h5 class="card-title text-white">Fuente: Oefa</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" id="nameO">Nombres: <span></span></li>
                        <li class="list-group-item" id="lastname1O">Ap. Paterno: <span></span></li>
                        <li class="list-group-item" id="lastname2O">Ap. Materno: <span></span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header bg-info">
                        <h5 class="card-title text-white">Fuente: External Api</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" id="nameE">Nombres: <span></span></li>
                        <li class="list-group-item" id="lastname1E">Ap. Paterno: <span></span></li>
                        <li class="list-group-item" id="lastname2E">Ap. Materno: <span></span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-12 mt-3">
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
    </div>
</div>
@endsection

@push('scripts')

<script>

    $("#btn-dni").on("click", function (e) {

        e.preventDefault()
        resetData();

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

                    /*Sunat*/
                    if (data.sunat.success == false) {
                        $.notify('Sunat: ' + data.sunat.message, "info");
                    }else{
                        if(data.sunat.original.error){
                            $.notify('Sunat: ' + data.sunat.original.error, "error");
                        } else{
                            $('#nameS span').append(data.sunat.original.nombreSoli)
                            $('#lastname1S span').append(data.sunat.original.apePatSoli)
                            $('#lastname2S span').append(data.sunat.original.apeMatSoli)
                        }
                    }


                    /*Midis*/
                    if (data.midis.error == 404){
                        $.notify("Midis: No se encontró coincidencias", "info");
                    } else{
                        if(!data.midis.original.vMensajeResponse){
                            $('#nameM span').append(data.midis.original.vNombres)
                            $('#lastname1M span').append(data.midis.original.vApePaterno)
                            $('#lastname2M span').append(data.midis.original.vApeMaterno)
                        } else{
                            $.notify('Midis: ' + data.midis.original.vMensajeResponse, "error");
                        }
                    }

                    /*Oefa*/
                    if (data.oefa.error == 404){
                        $.notify("Oefa: No se encontró coincidencias", "info");
                    } else{
                        if(data.oefa.original.esValido == "true"){
                            $('#nameO span').append(data.oefa.original.nombres)
                            $('#lastname1O span').append(data.oefa.original.apellidoPaterno)
                            $('#lastname2O span').append(data.oefa.original.apellidoMaterno)
                        } else{
                            $.notify('Oefa: ' + data.oefa.original.mensaje, "error");
                        }

                    }

                    /*External Api*/
                    if (data.externalApi.error == 404){
                        $.notify("External Api: No se encontró coincidencias", "info");
                    } else{
                        if(data.externalApi.original.result.Nombre != null){
                           $('#nameE span').append(data.externalApi.original.result.Nombre)
                            $('#lastname1E span').append(data.externalApi.original.result.Paterno)
                            $('#lastname2E span').append(data.externalApi.original.result.Materno)
                        } else {
                            $.notify('External Api: ' + 'No se encontró registros', "error");
                        }

                    }


                    /*All*/

                    if (data.midis.original.vMensajeResponse) {

                        $.notify(data.midis.original.vMensajeResponse, "error");

                        $("#name").val(data.sunat.original.nombreSoli)
                        $("#lastname1").val(data.sunat.original.apePatSoli)
                        $("#lastname2").val(data.sunat.original.apeMatSoli)
                        $("#code").val(data.codigoV)

                        }
                        else{

                        date = $.date(data.midis.original.dtFecNacimiento)
                        date2 = $.date2(data.midis.original.dtFecNacimiento)

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
                        } else {
                            $("#sex").val('Mujer')
                        }

                        if (data.oefa.original.estadoCivil == 112) {
                            $("#status").val('Soltero(a)')
                        } else if(data.oefa.original.estadoCivil == 115) {
                            $("#status").val('Divorciado(a)')
                        } else if(data.oefa.original.estadoCivil == 113) {
                            $("#status").val('Casado(a)')
                        } else {
                            $("#status").val('Viudo(a)')
                        }

                        $("#age").val(calcularAge(date2))

                        if (calcularAge(date2) < 18) {
                        $.notify("DNI Corresponde a un menor de edad", "error");
                        }

                        $("#date").val(date);

                    }

                    console.log(data)


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

    function resetData(){
        $('#nameS span').empty()
        $('#lastname1S span').empty()
        $('#lastname2S span').empty()
        $('#nameM span').empty()
        $('#lastname1M span').empty()
        $('#lastname2M span').empty()
        $('#nameO span').empty()
        $('#lastname1O span').empty()
        $('#lastname2O span').empty()
        $('#nameE span').empty()
        $('#lastname1E span').empty()
        $('#lastname2E span').empty()
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

