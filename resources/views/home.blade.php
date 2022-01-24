@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-7 col-md-8 col-sm-8 mb-2">
            <div class="card">
                <div class="card-header text-primary">
                    Equipo de Prevención de Fraude - Online
                </div>
                <div class="card-body  text-center">
                    <img src="{{asset('img/logo_at.png')}}" alt="apuestatotal" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-4 col-sm-4">
            <div class="card">
                <div class="card-header text-primary">
                    Información Digitos DNI
                </div>
                <div class="card-body" style="font-size: 12px">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <i class="fa fa-check"></i>&nbsp;
                            Las personas que tenían mayoría de edad y libreta electoral antes de que se creara el DNI, en 1996, migraron con el mismo número
                            al obtener el nuevo documento. Algunos empiezan con 0, 1 y 2.
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-check"></i>&nbsp;
                            Las personas que cumplían 18 años a partir de 1996, cuando se empezó a utilizar el DNI, se les asignó, en la mayoría de casos, la serie 4.
                        </li>
                        <li class="list-group-item text-primary">
                            <i class="fa fa-check"></i>&nbsp;
                            Desde 2006, cuando se empezó a emitir el DNI amarillo para los menores de edad, se asignaron las series de inicio 6 y 7, de acuerdo con el
                            número de acta de nacimiento.
                        </li>
                        <li class="list-group-item">
                            <i class="fa fa-check"></i>&nbsp;
                            A las personas indocumentadas se les asignó 8 y 9 como número de inicio, durante las campañas que hizo el Estado. Estos ciudadanos podían
                            haber tenido o no libreta electoral o partida de nacimiento.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

