@extends('layouts.dashboard')

@section('title', 'Home')

@section('header', 'Home')

@section('page-title')
    <div class="page-header">
        <div class="page-header-content header-elements-md-inline">
            <div class="page-title d-flex">
                <h2 class="font-weight-semibold">Dashboard</h2>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
    </div>
@stop

@section('custom-scripts')
    <script>
        $('#dashboard').addClass('active')
    </script>
@stop
