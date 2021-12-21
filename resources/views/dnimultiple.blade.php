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
                            <textarea class="form-control" id="dni" rows="5"></textarea>
                        </div>
                        <div class="form-group float-right">
                            <button class="btn btn-primary" type="submit" id="btn-dni">Apply</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8" id="card-table">
            <div class="card">
                <div class="card-body mt-3">
                    <div class="fa-2x text-center" id="spin">
                        <i class="fas fa-spinner fa-spin"></i>
                    </div>
                    <table class="table table-bordered table-hover table-sm" id="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>Dni</th>
                                <th>Nombres</th>
                                <th>Ap. Paterno</th>
                                <th>Ap. Materno</th>
                                <th>Cod. Verif.</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

<script>


    var table = $("#card-table")
    var spin = $("#spin")

    table.hide();
    spin.hide()

    $("#btn-dni").on("click", function (e) {

        e.preventDefault()

        var dni = $("#dni").val().split(/\n/)
        var tbody = $('#table tbody')

        var btn = $(this)
        btn.prop('disabled', true);

        tbody.empty()
        table.hide()
        spin.hide()

        setTimeout (function ()
        {
            btn.prop ('disabled', false);
        }, 2000);

        if (dni)
        {
            for (var i=0; i < dni.length; i++)
            {
                $.get("/dni/" + dni[i], function (data)
                {
                    if (data.query1.error == 404)
                    {
                        $.notify("No se encontró coincidencias || Dni debe tener 8 dígitos", "info");
                        spin.show()
                    }
                    else
                    {
                        console.log(data.query1)

                        var tr = $('<tr>');
                        var props = ["dni", "nombres", "apellidoPaterno", "apellidoMaterno", "codVerifica"];

                        $.each(props, function(i, prop) {
                            $('<td>').html(data.query1[prop]).appendTo(tr);
                        });
                        tbody.append(tr);
                        table.show()
                        spin.hide()
                    }
                });
            }
        }
        else
        {
            $.notify("Ingrese un número de DNI", "error");
            table.hide();
            spin.show()
        }
    });

</script>

@endpush

