@extends('layouts.sidebar')
@extends('layouts.app')
@section('content')
    <!-- <div class="container-xxl">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">{{ __('Dashboard') }}</div>

                                <div class="card-body">
                                    @if (session('status'))
    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
    @endif

                                    {{ __('Welcome to COLOASIA Invoice Module') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
@endsection

@section('maincontent')
    <div class="fs-4 fw-bold text-info" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
        </ol>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div>
                <div>
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <script type="text/javascript">
                        google.charts.load("current", {
                            packages: ["corechart"]
                        });
                        google.charts.setOnLoadCallback(drawChart);

                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                                ['Concern', 'MRC'],
                                ['Coloasia MRC', {{ $coloasiaMRC }}],
                                ['MCloud MRC', {{ $mcloudMRCMRC }}],
                                ['Bogra POI MRC', {{ $bograMRC }}],
                                ['Sylhet POI MRC', {{ $sylhetMRC }}],
                                ['SMS MRC', {{ $smsMRC }}]
                            ]);

                            var options = {
                                title: 'Pie chart of Monthly Recurring Charge',
                                is3D: true,
                            };

                            var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                            chart.draw(data, options);
                        }
                    </script>
                </div>
                <div>
                    <div id="piechart_3d" style="width: 500; height: 400px;"></div>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            {{-- <div class="" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"> --}}
            <div class="" style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">
                <div class="">
                    <div class=" shadow-lg">
                        <div class="card-header fw-bold text-white" style="background-color: #131d36">
                            Client summary
                        </div>
                        <div class="card-body">
                                <h5 class="card-title">Total number of clients: <span
                                        class="fw-bolder">{{ $totalClientCount }}</span>
                                </h5>
                                <h5 class="card-title">Active clients: <span
                                        class="fw-bolder">{{ $totalActiveClientCount }}</span></h5>
                                <h5 class="card-title">Inactive clients: <span
                                        class="fw-bolder">{{ $totalInactiveClientCount }}</span>
                                </h5>
                                <h5 class="card-title">Coloasia total clients: <span
                                    class="fw-bolder">{{ $totalColoasiaClientCount }}</span>
                            </h5>
                            <h5 class="card-title">MCloud total clients: <span
                                class="fw-bolder">{{ $totalMcloudClientCount }}</span>
                        </h5>
                        <h5 class="card-title">Bogra total clients: <span
                            class="fw-bolder">{{ $totalBograClientCount }}</span>
                    </h5>
                                <a href="{{ url('client-list') }}" class="btn btn-info">view client list</a>
                      
                        </div>
                    </div>
                </div> <br>
                <div class="">
                    <div class="shadow-lg">
                        <div class="card-header fw-bold text-white" style="background-color: #131d36">
                            Service summary
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Total number of services: <span
                                    class="fw-bolder">{{ $totalServiceCount }}</span></h5>
                            <a href="{{ url('service-name') }}" class="btn btn-info">view services</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
