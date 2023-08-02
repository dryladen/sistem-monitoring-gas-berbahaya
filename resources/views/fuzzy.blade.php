@extends('layout.layout')
@section('content')
    <div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Data</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Himpunan Fuzzy</a></li>
                </ol>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Himpunan Fuzzy</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>Variabel</th>
                                            <th>a</th>
                                            <th>b</th>
                                            <th>c</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_fuzzy as $item)
                                            <tr>
                                                <td>{{ $item->variabel }}</td>
                                                <td>{{ $item->a }}</td>
                                                <td>{{ $item->b }}</td>
                                                <td>{{ $item->c }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Himpunan Fuzzy</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>Rendah</th>
                                            <th>Normal</th>
                                            <th>Tinggi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($derajat_keanggotaan as $item)
                                            <tr>
                                                {{ var_dump($derajat_keanggotaan)}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
