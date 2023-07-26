@extends('layout.layout')
@section('content')
    <div class="content-body">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col">
                    <div class="card card-widget">
                        <div class="card-body gradient-3">
                            <div class="media">
                                <span class="card-widget__icon"><i class="icon-user"></i></span>
                                <div class="media-body">
                                    <h2 class="card-widget__title"></h2>
                                    <h5 class="card-widget__subtitle">Data User</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card card-widget">
                        <div class="card-body gradient-4">
                            <div class="media">
                                <span class="card-widget__icon"><i class="icon-paper-clip"></i></span>
                                <div class="media-body">
                                    <h2 class="card-widget__title"></h2>
                                    <h5 class="card-widget__subtitle">Data Barang</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card card-widget">
                        <div class="card-body gradient-4">
                            <div class="media">
                                <span class="card-widget__icon"><i class="icon-social-dropbox"></i></span>
                                <div class="media-body">
                                    <h2 class="card-widget__title"></h2>
                                    <h5 class="card-widget__subtitle">Data Jenis Barang</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- #/ container -->
    </div>
@endsection
