@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <form method="GET" id="form-dni">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">N° de DNI</label>
                        <input type="number" class="form-control" id="dni">
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
            <div class="card-body mt-3">
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="name">Nombre</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="lastname1">Apellido Paterno</label>
                            <input type="text" class="form-control" id="lastname1">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="lastname2">Apellido Materno</label>
                            <input type="text" class="form-control" id="lastname2">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="address">Dirección</label>
                            <input type="text" class="form-control" id="address">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="date">Fecha de Nac.</label>
                            <input type="text" class="form-control" id="date">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="age">Edad</label>
                            <input type="number" class="form-control" id="age" disabled>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="code">Código de Verf.</label>
                            <input type="number" class="form-control" id="code" disabled>
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
                            $("#age").val(calcularAge(date2))

                            if (calcularAge(date2) < 18) {
                            $.notify("DNI Corresponde a un menor de edad", "error");
                            }

                            $("#date").val(date);
                        }

                        $.notify("Consulta cargada exitosamente", "success");

                        console.log(data)

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
    }

</script>

@endpush

