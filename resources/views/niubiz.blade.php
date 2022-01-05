@extends('layouts.app')

@section('content')
<div class="row">

</div>
@endsection

@push('scripts')
<script>
    const data = null;
    const xhr = new XMLHttpRequest();
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === this.DONE) {
            console.log(this.responseText);
        }
    });
    xhr.open("GET", "https://apisandbox.vnforappstest.com/api.authorization/v3/retrieve/external/341198210/3ac183ca-06a6-4438-80ad-aa82e88c14697");
    xhr.setRequestHeader("Authorization", "eyJhbGciOiJSUzI1NiIsInR5cCIgOiAiSldUIiwia2lkIiA6ICIwTWR3R0R6RjQ1YS1SbWs3bkhwc2lNYUJweFJQRjNzekEtNW1HWFllMThvIn0.eyJleHAiOjE2NDEzMjkxOTQsImlhdCI6MTY0MTMyNTU5NCwianRpIjoiM2M0MmYyNTgtOGE2NS00YmQ2LWIwYzQtYmM1YWIwMzM5ODE3IiwiaXNzIjoiaHR0cHM6Ly9hY2Nlc3MuaW50dm50LmNvbS9hdXRoL3JlYWxtcy9vbmxpbmUtYXBpcyIsInN1YiI6IjQyNjg5NzZlLWVhOWEtNDI0Yi04YWEwLTY5ZWYwMjA5NTJkZSIsInR5cCI6IkJlYXJlciIsImF6cCI6ImFwcC1tdWx0aXJlZ2lvbiIsInNlc3Npb25fc3RhdGUiOiIxODE4MjFlZS01YWUyLTQxYTctYTRhZC1mNzMzYjUzODcxYWQiLCJhY3IiOiIxIiwic2NvcGUiOiJhd3MuY29nbml0by5zaWduaW4udXNlci5hZG1pbiIsImdyb3VwcyI6W10sInVzZXJuYW1lIjoiaW50ZWdyYWNpb25lc0BuaXViaXouY29tLnBlIn0.dTpRS4t21BBPxLpGX1enaRe6Er1PQdjIbP9fPpKFyZs492TzRxTjJdewzRkX4Yzh8yjG5MI4y-XQojRuf9xY41x9UEWoZKor3w8AovH20Tcc519uUEb00W8vxxHbSTOu5z85lh-gr-y0iHsoXaHWsAJREaO61E2XObhGox8QlPhIlUW1UbG1v8ebS-SFstvvpkXIMNgwleeOIvZb2Nv6jSLjRxjj98_nVenCJw9DT4llQ0i5KbrYMlzX9ja4k9lLToO8fJ9Z7YTSIdFLRgmqsDCofjh9hRAX-6bWFcmeLJWobNCcpRym3gzrNhSEjLmQCsjmkltMc8cGcSD6j90LmA");
    xhr.setRequestHeader("accept", "application/json");
    xhr.setRequestHeader("content-type", "application/json");
    xhr.send(data);
    console.log(data)
</script>
@endpush

