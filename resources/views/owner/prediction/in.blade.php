@extends('layouts.my_admin_layout')
@section('title', 'Prediksi Kas Masuk')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Prediksi Kas Masuk</h1>
            @include('components.flash-message')
            {{-- {{dd(session('message'))}} --}}
            @if(!empty($message))
                <div class="alert alert-success">
                    {{ $message }}
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <p class="h3 font-weight-bold fw-bold text-center text-capitalize">Data Kas Masuk dari Penjualan {{$menu->name}}</p>
                    <form action="{{ route('owner.prediction.in.filter') }}" method="POST">
                        @csrf
                        <div class="d-flex mb-4 justify-content-end">
                            <select name="menu_id" id="menu_id" class="form-select ms-2">
                                @foreach ($menus as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $menu_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn my-bg text-white p-2 px-4 ms-2"><i class="fa fa-search fa-fw"></i></button>
                        </div>
                    </form>
                    <table id="datatable" class="table table-bordered rounded w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Penjualan (X)</th>
                                <th class="text-center">Kas Masuk (Y)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach($data as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item['x']  }}</td>
                                <td>{{ 'Rp. ' . number_format($item['y'], 0, ',', '.') }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <form action="{{ route('owner.prediction.in.start', $menu_id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="x" class="form-label font-weight-bold fw-bold">Masukkan Penjualan Untuk Prediksi Kas Masuk</label>
                            <input type="number" class="form-control" id="x" name="x" required>
                        </div>
                        <button type="submit" class="btn my-bg text-white">Prediksi</button>
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
