@extends('layout.layout')
@section('content')
    <div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Monitoring</a></li>
                </ol>
            </div>
        </div>
        <!-- row -->

        <div class="container-fluid">
            <!-- /# row -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Data Gas Amonia dan Gas Metana</h4>
                    <canvas id="sales-chart" width="500" height="250"></canvas>
                </div>
            </div>
        </div>
        <!-- #/ container -->
    </div>
@endsection
