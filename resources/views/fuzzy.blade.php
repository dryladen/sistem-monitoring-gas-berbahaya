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
                            <span class="font-weight-bold">Amonia : {{ $amonia }}</span>
                            <br>
                            <span class="font-weight-bold">Metana : {{ $metana }}</span>
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
                                            <th>Variabel</th>
                                            <th>a</th>
                                            <th>b</th>
                                            <th>c</th>
                                            <th>d</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data_fuzzy as $item)
                                            <tr>
                                                <td>{{ $item->variabel }}</td>
                                                <td>{{ $item->a }}</td>
                                                <td>{{ $item->b }}</td>
                                                <td>{{ $item->c }}</td>
                                                <td>{{ $item->d }}</td>
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
                                        <tr>
                                            <th>Variabel</th>
                                            <th>Rendah</th>
                                            <th>Normal</th>
                                            <th>Tinggi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Amonia</td>
                                            <td>{{ $fuzzy_mamdani['derajat_keanggotaan']['Amonia']['Normal'] }}</td>
                                            <td>{{ $fuzzy_mamdani['derajat_keanggotaan']['Amonia']['Sedang'] }}</td>
                                            <td>{{ $fuzzy_mamdani['derajat_keanggotaan']['Amonia']['Tinggi'] }}</td>
                                        </tr>
                                        <tr>
                                            <td>Metana</td>
                                            <td>{{ $fuzzy_mamdani['derajat_keanggotaan']['Metana']['Rendah'] }}</td>
                                            <td>{{ $fuzzy_mamdani['derajat_keanggotaan']['Metana']['Normal'] }}</td>
                                            <td>{{ $fuzzy_mamdani['derajat_keanggotaan']['Metana']['Tinggi'] }}</td>
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
                            <h4 class="card-title">Fungsi Implikasi</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>Rules</th>
                                            <th>Variabel 1</th>
                                            <th>Variabel 2</th>
                                            <th>Konklusi</th>
                                            <th>Alpa Predikat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                            $index = 0;
                                        @endphp
                                        @foreach ($aturan_fuzzy as $item)
                                            <tr>
                                                <td>R{{ $no++ }}</td>
                                                <td>{{ $item->variabel1 }}</td>
                                                <td>{{ $item->variabel2 }}</td>
                                                <td>{{ $item->konklusi }}</td>
                                                <td>{{ $fuzzy_mamdani['alpa_predikat'][$index++] }}</td>
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
                            <h4 class="card-title">Nilai Keanggotaan</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>a1</th>
                                            <th>a2</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $fuzzy_mamdani['nilai_keanggotaan']['a1'] }}</td>
                                            <td>{{ $fuzzy_mamdani['nilai_keanggotaan']['a2'] }}</td>
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
                            <h4 class="card-title">Deffuzifikasi</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Output</th>
                                            <th class="text-center">Kesimpulan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">{{ $fuzzy_mamdani['output'][1] }}</td>
                                            <td class="text-center">{{ $fuzzy_mamdani['output'][0] }}</td>
                                        </tr>
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
