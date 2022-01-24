@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body mt-3">
                    <table class="table table-bordered table-hover table-sm" id="table">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody id="body">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <form>
                <div class="form-group">
                    <input type="number" id="event" class="form-control" placeholder="Ingresa Número de evento">
                </div>
                <button class="btn btn-primary" id="btn-event">Apply</button>
            </form>
            <div class="card" id="events">
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

<script>

queryJson();

var events = $('#events')
var table = $('#table')

events.hide()
table.hide()

function queryJson(){
    $.ajax({
        url: "{{ route('queryodds') }}",
        type: "GET",
        dataType: "JSON",
        success: function(response){

            table.show()

            for (i = 0; i < response.data.sports.length; i++){
                $("#body").append(
                    '<tr>'+
                    '<td>' + response.data.sports[i].id + '</td>'+
                    '<td>' + response.data.sports[i].name + '</td>'+
                    '</tr>'
                );
            }
        }
    })
};

$("#btn-event").on("click", function (e) {
    e.preventDefault()
    var id = $('#event').val()
    $.ajax({
        url: "{{ route('queryodds') }}",
        type: "GET",
        dataType: "JSON",
        success: function(response){
            var event = response.data.events[id]
            console.log(event)
        }
    })
});

</script>

@endpush

