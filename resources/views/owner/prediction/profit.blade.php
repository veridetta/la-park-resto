@extends('layouts.my_admin_layout')
@section('title', 'Prediksi Profit')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Prediksi Profit</h1>
            @include('components.flash-message')
            {{-- {{dd(session('message'))}} --}}
            @if(!empty($message))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <p class="h3 font-weight-bold fw-bold text-center text-capitalize">Data Profit Selama Tahun {{$tahun}}</p>
                    <table id="datatable" class="table table-bordered rounded w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Bulan </th>
                                <th class="text-center">Periode (X)</th>
                                <th class="text-center">Profit (Y)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach($data as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item['bulan']  }}</td>
                                <td>{{ $item['x']  }}</td>
                                <td>{{ 'Rp. ' . number_format($item['y'], 0, ',', '.') }}</td>



                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <form action="{{ route('owner.prediction.profit.start') }}" method="POST">
                        @csrf
                        <div class="col-12 row">
                            <p class="h3 font-weight-bold fw-bold text-center text-capitalize">Prediksi Profit</p>
                            <div class="mb-3">
                                <label for="bulan" class="form-label font-weight-bold fw-bold">Masukkan Bulan Untuk Prediksi Profit</label>
                                <select name="bulan" id="bulan" class="form-select" required>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                                </select>
                            </div>
                            <div class="mb-3 mt-2">
                                <label for="tahun" class="form-label font-weight-bold fw-bold">Masukkan Tahun Untuk Prediksi Profit</label>
                                <input type="number" class="form-control" id="tahun" name="tahun" required>
                            </div>
                            <button type="submit" class="btn my-bg text-white">Prediksi</button>
                        </div>
                    </form>
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
