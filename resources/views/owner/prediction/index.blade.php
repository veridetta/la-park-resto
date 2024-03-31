@extends('layouts.my_admin_layout')
@section('title', 'Prediksi Penjualan')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Prediksi Penjualan</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <p class="h3 font-weight-bold fw-bold text-center">Data Penjualan</p>
                    <table id="datatable" class="table table-bordered rounded w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Bulan</th>
                                <th class="text-center">Makanan</th>
                                <th class="text-center">Minuman</th>
                                <th class="text-center">Total Penjualan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach($data_sales as $bulan => $nilai)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $bulan }}</td>
                                <td>{{ $nilai['total_makanan'] }}</td>
                                <td>{{ $nilai['total_minuman'] }}</td>
                                <td>{{ $nilai['total_penjualan'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <p class="h3 font-weight-bold fw-bold text-center">Data Cash Flow</p>
                    <table id="datatable" class="table table-bordered rounded w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Bulan</th>
                                <th class="text-center">Biaya Produksi</th>
                                <th class="text-center">Pendapatan</th>
                                <th class="text-center">Biaya Lainnya</th>
                                <th class="text-center">Profit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach($data as $bulan => $nilai)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $bulan }}</td>
                                <td>{{ 'Rp. ' . number_format($nilai['biaya_produksi'], 0, ',', '.') }}</td>
                                <td>{{ 'Rp. ' . number_format($nilai['pendapatan'], 0, ',', '.') }}</td>
                                <td>{{ 'Rp. ' . number_format($nilai['biaya_lainnya'], 0, ',', '.') }}</td>
                                <td>{{ 'Rp. ' . number_format($nilai['profit'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            new DataTable('#datatable', {
                "columnDefs": [{
                    // "orderable": false,
                    // "targets": 2
                }]
            });


        })
    </script>
@endsection
