@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="pb-4">Inputs</h6>
                    <form method="GET" id="form-dni">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Query DNI</label>
                            <input type="number" class="form-control" id="dni">
                        </div>
                        <div class="form-group float-right">
                            <button class="btn btn-primary" type="submit" id="btn-dni">Apply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8" id="card-form">
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
                            <div class="form-group col-md-6">
                                <label for="address">Dirección</label>
                                <input type="text" class="form-control" id="address">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="date">Fecha de Nac.</label>
                                <input type="text" class="form-control" id="date">
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
            $.get("/dni/" + dni, function (data)
            {
                if (data.error == 404)
                {
                    $.notify("No se encontró coincidencias || Dni debe tener 8 dígitos", "info");
                }
                else
                {
                    $("#name").val(data.query1.nombres)
                    $("#lastname1").val(data.query1.apellidoPaterno)
                    $("#lastname2").val(data.query1.apellidoMaterno)
                    $("#code").val(data.query1.codVerifica)
                    $("#address").val(data.query2.vDireccion)
                    $("#date").val(data.query2.dtFecNacimiento)


                    if (data.query2.vMensajeResponse) {
                        $.notify(data.query2.vMensajeResponse, "error");
                    }

                    $.notify("Consulta cargada exitosamente", "success");

                    console.log(data)

                }
            });
        }
        else
        {
            $.notify("Ingrese un número de DNI", "error", { position:"top center" });
        }
    });

</script>

@endpush

