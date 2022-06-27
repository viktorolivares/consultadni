@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <form method="GET" id="form-ruc">
                    <div class="form-group">
                        <label for="exampleFormControlInput1">N° de RUC</label>
                        <input type="text" class="form-control" maxlength="11" id="ruc">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" type="submit" id="btn-ruc">Apply</button>
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
                        <div class="form-group col-md-6">
                            <label for="razon-social">Razon Social</label>
                            <input type="text" class="form-control" id="razon-social" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nombre-comercial">Nombre Comercial</label>
                            <input type="text" class="form-control" id="nombre-comercial" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="act-economica">Act. Económica</label>
                            <input type="text" class="form-control" id="act-economica" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" id="direccion" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="ubigeo">Ubigeo</label>
                            <input type="text" class="form-control" id="ubigeo" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tipo">Tipo</label>
                            <input type="text" class="form-control" id="tipo" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="estado">Estado</label>
                            <input type="text" class="form-control" id="estado" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="condicion">Condición</label>
                            <input type="text" class="form-control" id="condicion" readonly>
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

    $("#btn-ruc").on("click", function (e) {

        e.preventDefault()
        resetForm();
        $("#alert").hide()

        var ruc = $("#ruc").val()
        var btn = $(this)
        btn.prop('disabled', true);

        setTimeout(function () {
            btn.prop('disabled', false);
        }, 5000);

        if (ruc) {
            $.ajax({
                type: 'GET',
                url: "/ruc/" + ruc,
                success: function (data) {

                    console.log(data.ruc);

                    if (data.ruc.original) {
                        $("#razon-social").val(data.ruc.original.razonSocial);
                        $("#nombre-comercial").val(data.ruc.original.nombreComercial);
                        $("#act-economica").val(data.ruc.original.actEconomicas[0]);
                        if (data.ruc.original.departamento != null) {
                            $("#ubigeo").val(data.ruc.original.departamento + '/' + data.ruc.original.provincia + '/' + data.ruc.original.distrito);
                        } else {
                            $("#ubigeo").val('-');
                        }
                        $("#direccion").val(data.ruc.original.direccion);
                        $("#estado").val(data.ruc.original.estado);
                        $("#condicion").val(data.ruc.original.condicion);
                        $("#tipo").val(data.ruc.original.tipo);

                        $.notify('Registro encontrado', "success");
                    } else {
                        $.notify('Ocurrió un problema', "error");
                    }


                }
            });
        }
        else {
            $.notify("Ingrese un número de ruc", "error", { position: "top center" });
        }
    });

    function resetForm() {
        $("#razon-social").val('');
        $("#nombre-comercial").val('');
        $("#act-economica").val('');
        $("#ubigeo").val('');
        $("#direccion").val('');
        $("#estado").val('');
        $("#condicion").val('');
        $("#tipo").val('');
    }

</script>

@endpush
