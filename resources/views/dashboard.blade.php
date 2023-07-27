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
        <div class="row">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Data Gas Amonia dan Gas Metana</h4>
                        <canvas id="sales-chart" width="500" height="250"></canvas>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-3">
                        <div class="card card-widget">
                            <div class="card-body gradient-9">
                                <div class="media">
                                    <span class="card-widget__icon"><i class="icon-fire"></i></span>
                                    <div class="media-body">
                                        <h2 class="card-widget__title">15 PPM</h2>
                                        <h5 class="card-widget__subtitle">Gas Amonia</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="card card-widget">
                            <div class="card-body gradient-5">
                                <div class="media">
                                    <span class="card-widget__icon"><i class="icon-fire"></i></span>
                                    <div class="media-body">
                                        <h2 class="card-widget__title">100 PPM</h2>
                                        <h5 class="card-widget__subtitle">Gas Metana</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card card-widget">
                            <div class="card-body gradient-4">
                                <div class="media">
                                    <span class="card-widget__icon"><i class="icon-home"></i></span>
                                    <div class="media-body">
                                        <h2 class="card-widget__title">Aman</h2>
                                        <h5 class="card-widget__subtitle">Kondisi Kandang</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
