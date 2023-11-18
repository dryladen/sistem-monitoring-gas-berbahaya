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
            <div class="container-fluid pt-0">
                <div class="card d-none d-sm-block">
                    <div class="card-body">
                        <h4 class="card-title">Data Gas Amonia dan Gas Metana</h4>
                        <canvas height="75" id="myChart"></canvas>
                    </div>
                </div>
                <div class="row m-sm-2 m-lg-0 m-1">
                    <div class="col-sm col-md-4">
                        <div class="card card-widget">
                            <div class="card-body bg-blue p-md-3">
                                <div class="media d-flex justify-content-center align-items-center">
                                    <span class="card-widget__icon"><i class="icon-fire"></i></span>
                                    <div class="media-body">
                                        <h2 id="nilai_amonia" class="card-widget__title">0 PPM</h2>
                                        <h5 class="card-widget__subtitle">Gas Amonia</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm col-md-4">
                        <div class="card card-widget">
                            <div class="card-body bg-orange p-md-3">
                                <div class="media d-flex justify-content-center align-items-center">
                                    <span class="card-widget__icon "><i class="icon-fire"></i></span>
                                    <div class="media-body">
                                        <h2 id="nilai_metana" class="card-widget__title">0 PPM</h2>
                                        <h5 class="card-widget__subtitle">Gas Metana</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm col-md-4">
                        <div class="card card-widget">
                            <div id="card-kondisi" class="card-body bg-red p-md-3">
                                <div class="media d-flex justify-content-center align-items-center">
                                    <span class="card-widget__icon"><i class="icon-home"></i></span>
                                    <div class="media-body">
                                        <h2 id="nilai_kondisi" class="card-widget__title">Aman</h2>
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
@section('scripts')
    @parent

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
    <script>
        var ctx = document.getElementById("myChart");
        var nilai_amonia = document.getElementById("nilai_amonia");
        var nilai_metana = document.getElementById("nilai_metana");
        var nilai_kondisi = document.getElementById("nilai_kondisi");
        var card_kondisi = document.getElementById("card-kondisi");
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Amonia',
                    data: [],
                    borderColor: '#36A2EB',
                    backgroundColor: '#2F64FD10',
                    borderWidth: 2,

                }, {
                    label: 'Metana',
                    data: [],
                    borderColor: '#FF6384',
                    backgroundColor: '#eb862810',
                    borderWidth: 2,
                }]
            },
            options: {
                scales: {
                    xAxes: [],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
        var updateChart = function() {
            $.ajax({
                url: "{{ route('dataGas') }}",
                type: 'GET',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    // update data chart
                    console.log(data)
                    myChart.data.labels = data.labels;
                    myChart.data.datasets[0].data = data.amonia;
                    myChart.data.datasets[1].data = data.metana;
                    myChart.update();
                    // update data dibawah chart
                    nilai_metana.innerHTML = data.nilai_last_metana + " PPM";
                    nilai_amonia.innerHTML = data.nilai_last_amonia + " PPM";
                    nilai_kondisi.innerHTML = data.nilai_kondisi['output'][0];
                    if (data.nilai_kondisi['output'][0] == "Aman") {
                        card_kondisi.style.backgroundColor = "#32CD32"
                    } else if (data.nilai_kondisi['output'][0] == "Waspada") {
                        card_kondisi.style.backgroundColor = "#FFC300"
                    } else if (data.nilai_kondisi['output'][0] == "Bahaya") {
                        card_kondisi.style.backgroundColor = "#FF0000"
                    }
                },
                error: function(data) {
                    console.log('Data tidak terkirim')
                }
            });
        }

        updateChart();
        setInterval(() => {
            updateChart();
        }, 10000);
    </script>
    <script>
        // mengubah warna background sesuai kondisi
        var nilai_kondisi = document.getElementById("nilai_kondisi");
    </script>
@endsection
