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
                            <h4 class="card-title">Derajat Keanggotaan</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr><th>Variabel</th>
                                            <th>Rendah</th>
                                            <th>Normal</th>
                                            <th>Tinggi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                                <td>Amonia</td>
                                                <td>{{ $derajat_keanggotaan["Amonia"]["Rendah"] }}</td>
                                                <td>{{ $derajat_keanggotaan["Amonia"]["Normal"] }}</td>
                                                <td>{{ $derajat_keanggotaan["Amonia"]["Tinggi"] }}</td>
                                            </tr>
                                            <tr>
                                                <td>Metana</td>
                                                <td>{{ $derajat_keanggotaan["Metana"]["Rendah"] }}</td>
                                                <td>{{ $derajat_keanggotaan["Metana"]["Normal"] }}</td>
                                                <td>{{ $derajat_keanggotaan["Metana"]["Tinggi"] }}</td>
                                            </tr>
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
                            <h4 class="card-title">Derajat Keanggotaan</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr><th>Rules</th>
                                            <th>Variabel 1</th>
                                            <th>Variabel 2</th>
                                            <th>Konklusi</th>
                                            <th>Alpa Predikat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                            $index = 0
                                        @endphp
                                        @foreach ($aturan_fuzzy as $item)
                                            <tr>
                                                <td>R{{$no++}}</td>
                                                <td>{{$item->variabel1}}</td>
                                                <td>{{$item->variabel2}}</td>
                                                <td>{{$item->konklusi}}</td>
                                                <td>{{$alpa_predikat[$index++]}}</td>
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
