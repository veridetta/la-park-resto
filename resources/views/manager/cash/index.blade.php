@extends('layouts.my_admin_layout')
@section('title', 'Kelola Kas')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Kelola Kas</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-end">
                        <a href="{{ route('manager.cash.create') }}" class="btn my-bg text-white p-2 px-4"><i
                                class="fa fa-plus fa-fw"></i>
                            Tambah Transaksi</a>
                    </div>
                    <div class="d-flex mb-4 justify-content-end">
                        <h3 class="text-center">Saldo : Rp. {{ number_format($saldo, 0, ',', '.') }}</h3>
                    </div>
                    <form action="{{ route('manager.cash.filter') }}" method="POST">
                        <div class="d-flex mb-4 justify-content-end">
                            <select name="month" id="month" class="form-select">
                                <option value="01" {{ $month == 1 ? 'selected' : '' }}>Januari</option>
                                <option value="02" {{ $month == 2 ? 'selected' : '' }}>Februari</option>
                                <option value="03" {{ $month == 3 ? 'selected' : '' }}>Maret</option>
                                <option value="04" {{ $month == 4 ? 'selected' : '' }}>April</option>
                                <option value="05" {{ $month == 5 ? 'selected' : '' }}>Mei</option>
                                <option value="06" {{ $month == 6 ? 'selected' : '' }}>Juni</option>
                                <option value="07" {{ $month == 7 ? 'selected' : '' }}>Juli</option>
                                <option value="08" {{ $month == 8 ? 'selected' : '' }}>Agustus</option>
                                <option value="09" {{ $month == 9 ? 'selected' : '' }}>September</option>
                                <option value="10" {{ $month == 10 ? 'selected' : '' }}>Oktober</option>
                                <option value="11" {{ $month == 11 ? 'selected' : '' }}>November</option>
                                <option value="12" {{ $month == 12 ? 'selected' : '' }}>Desember</option>
                            </select>
                            <select name="year" id="year" class="form-select ms-2">
                                @for ($i = 2021; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            <button type="submit" class="btn my-bg text-white p-2 px-4 ms-2"><i class="fa fa-search fa-fw"></i></button>
                        </div>
                    </form>
                    <table id="datatable" class="table table-bordered rounded w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">No Penjualan</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Masuk</th>
                                <th class="text-center">Keluar</th>
                                <th class="text-center"><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($data as $data)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td class="text-center">{{ $data->date }}</td>
                                    <?php
                                    //gunakan model sales untuk mengambil data penjualan
                                    $sales = App\Models\Sales::where('sales_no', $data->sales_no)->first();
                                    $sale_no = $sales ? $sales->sales_no : '-';

                                    ?>
                                    <td class="text-center">{{ $sale_no }}</td>
                                    <td class="text-center">{{ $data->description }}</td>
                                    <td class="text-center">{{ 'Rp. ' . number_format($data->in, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">{{ 'Rp. ' . number_format($data->out, 0, ',', '.') }}
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('manager.cash.edit', [$data->id]) }}"
                                            class="btn my-bg text-white"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('manager.cash.destroy', [$data->id]) }}"
                                            class="d-inline-block delete-btn" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
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

            const deleleBtn = document.querySelectorAll('.delete-btn')
            deleleBtn.forEach(el => {
                console.log(el)
                el.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Apakah anda yakin?',
                        text: "Ingin menghapus data ini",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit()
                        }
                    })
                })
            })
        })
    </script>
@endsection
