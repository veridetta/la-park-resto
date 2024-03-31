@extends('layouts.my_admin_layout')
@section('title', 'Dashboard')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">

            <h1 class="mb-4 fw-bold my-text-color">Selamat Datang, {{ Auth::user()->name }}</h1>
            <div class="card">
                <div class="card-body">
                    <p class="h3 font-weight-bold fw-bold text-center text-capitalize">Grafik Penjualan</p>
                    <div class="chart">
                        <canvas id="myChart" width="400" height="100"></canvas>
                    </div>
                </div>
            </div>
            @include('owner.dashboard.in')
            @include('owner.dashboard.out')
            @include('owner.dashboard.sales')
            @include('owner.dashboard.profit')

        </div>
    </main>

@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();

            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($data_penjualan['labels']) !!},
                    datasets: [{
                        label: 'Penjualan',
                        data: {!! json_encode($data_penjualan['data']) !!},
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        fill: false,
                        tension: 0.1
                    }, {
                        label: 'Pendapatan',
                        data: {!! json_encode($data_pendapatan['data']) !!},
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        fill: false,
                        tension: 0.1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        });

    </script>
@endsection
