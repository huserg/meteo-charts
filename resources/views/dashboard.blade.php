@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="alert alert-dark">
                <h3>Select Location</h3>
            </div>
        </div>
        <div class="col-md-6">

            <div class="card">
                <h5 class="card-header">Temperature</h5>
                <div class="card-body">
                    <p class="card-text">°C graph</p>
                </div>
            </div>
            <br>
            <div class="card">
                <h5 class="card-header">Humidity</h5>
                <div class="card-body">
                    <p class="card-text">% graph</p>
                </div>
            </div>

        </div>
        <div class="col-md-6">

            <div class="card">
                <h5 class="card-header">Pressure</h5>
                <div class="card-body">
                    <p class="card-text">HPa graph</p>
                </div>
            </div>
            <br>
            <div class="card">
                <h5 class="card-header">Light</h5>
                <div class="card-body">
                    <p class="card-text">Lux graph</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
