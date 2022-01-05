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
    <div class="col-md-9" id="card-form" style="font-size: 14px">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-info">
                        <h5 class="card-title text-white">Fuente: Sunat</h5>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" id="nameS">Nombres: <span></span></li>
                        <li class="list-group-item" id="lastname1S">Ap. Paterno: <span></span></li>
                        <li class="list-group-item" id="lastname2S">Ap. Materno: <span></span></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
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
            <div class="col-md-4">
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

