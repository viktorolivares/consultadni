@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body mt-3">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Events</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    <div class="card">
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

<script>

queryJson();

function queryJson(){
    $.ajax({
        url: "{{ route('queryodds') }}",
        type: "GET",
        dataType: "JSON",
        success: function(response){

            var data = JSON.stringify(response.data.events);

            $("#events").text(data)

            for (i = 0; i < response.data.sports.length; i++){
                $("#body").append(
                    '<tr>'+
                    '<td>' + response.data.sports[i].id + '</td>'+
                    '<td>' + response.data.sports[i].name + '</td>'+
                    '<td>' + response.data.sports[i].events + '</td>'+
                    '</tr>'
                );
            }
        }
    });
}

</script>

@endpush

