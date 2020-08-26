@extends('layouts.app')

@section('navbar-mid')
<div class="row">
    <div class="col-6 col-md-9">
        <label for="rpi-location" class="d-none">Current selection</label>
        <input id="rpi-location" class="form-control" type="text" value="{{$rpi->location}}" readonly>
    </div>
    <div class="col-6 col-md-3">
        <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#rpiModal">
            Filter
        </button>
    </div></div>

@endsection

@section('content')
<div class="container">
    <div class="justify-content-center">
        @isset($tempChart)
        <div class="card">
            <div class="card-header">
                <span class="font-weight-bold">Temperature</span>
                <span class="float-right">{{ !empty($rpi->temperature->last()) ? $rpi->temperature->last()->degree . ' °C' : 'No Data' }}</span>
            </div>
            <div class="card-body">
                {!! $tempChart->container() !!}
            </div>
        </div>
        <br>
        @endisset
        @isset($tempChart)
        <div class="card">
            <div class="card-header">
                <span class="font-weight-bold">Humidity</span>
                <span class="float-right">{{ !empty($rpi->humidity->last()) ? $rpi->humidity->last()->percentage . ' %' : 'No Data' }}</span>
            </div>
            <div class="card-body">
                {!! $humChart->container() !!}
            </div>
        </div>
        <br>
        @endisset
        @isset($lightChart)
        <div class="card">
            <div class="card-header">
                <span class="font-weight-bold">Light</span>
                <span class="float-right">{{ !empty($rpi->light->last()) ? $rpi->light->last()->lux . ' lx' : 'No Data' }}</span>
            </div>
            <div class="card-body">
                {!! $lightChart->container() !!}
            </div>
        </div>
        <br>
        @endisset
        @isset($pressureChart)
        <div class="card">
            <div class="card-header">
                <span class="font-weight-bold">Pressure</span>
                <span class="float-right">{{ !empty($rpi->pressure->last()) ? $rpi->pressure->last()->hpa . ' hPa' : 'No Data' }}</span>
            </div>
            <div class="card-body">
                {!! $pressureChart->container() !!}
            </div>
        </div>
        @endisset
    </div>
</div>


<div class="modal fade" id="rpiModal" tabindex="-1" role="dialog" aria-labelledby="rpiModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('dashboard') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filters</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rpi_select">Location</label>
                        <select class="custom-select" id="rpi_select" name="rpi_id">
                        @foreach($rpis as $pi)
                            <option @if($pi->id == $rpi->id) selected @endif value="{{$pi->id}}">{{$pi->location}}</option>
                        @endforeach
                        </select>
                    <div class="form-group">
                    </div>
                        <label for="interval">Time interval (hours)</label>
                        <input class="form-control" @isset($interval) value="{{$interval}}" @endisset type="number" step="1" min="0" name="interval" id="interval">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/frappe-charts@1.1.0/dist/frappe-charts.min.iife.js"></script>

@isset($tempChart)
    {!! $tempChart->script() !!}
@endisset
@isset($humChart)
    {!! $humChart->script() !!}
@endisset
@isset($lightChart)
    {!! $lightChart->script() !!}
@endisset
@isset($pressureChart)
    {!! $pressureChart->script() !!}
@endisset
@endsection
