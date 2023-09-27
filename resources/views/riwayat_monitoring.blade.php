@extends('layout.layout')
@section('content')
    <div class="content-body">

        <div class="row page-titles mx-0">
            <div class="col p-md-0">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Data</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Riwayat Monitoring</a></li>
                </ol>
            </div>
        </div>
        <div class="container-fluid pt-0">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Riwayat Monitoring</h4>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered zero-configuration">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Waktu</th>
                                            <th>Gas Amonia</th>
                                            <th>Gas Metana</th>
                                            <th>Kondisi Kandang</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($data_gas as $item)
                                            <tr>
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $item->created_at }}</td>
                                                <td>{{ $item->gas_amonia }}</td>
                                                <td>{{ $item->gas_metana }}</td>
                                                <td>{{ $item->kondisi }}</td>
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
@section('scripts')
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script>
        var updateData = function() {
            $.ajax({
                url: "{{ route('dataGas') }}",
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {

                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        updateData();
        setInterval(() => {
            updateData();
        }, 10000);
    </script>
@endsection
