@extends('layouts.my_admin_layout')
@section('title', 'Kelola Penjualan')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Kelola Penjualan</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-end">
                        <a href="{{ route('kasir.sales.create') }}" class="btn my-bg text-white p-2 px-4"><i
                                class="fa fa-plus fa-fw"></i>
                            Tambah Transaksi</a>
                    </div>
                    <div class="d-flex mb-4 justify-content-end">
                        <h3 class="text-center">Penjualan Harian : Rp. {{ number_format($saldo, 0, ',', '.') }}</h3>
                    </div>
                    <form action="{{ route('kasir.sales.filter') }}" method="POST">
                        <div class="d-flex mb-4 justify-content-end">
                            @csrf
                            <p class="text-center me-2 text-nowrap my-auto">Filter Tanggal</p>
                            <?php $formattedDate = date("Y-m-d", strtotime($tanggal));?>
                            <input type="date" name="date" class="ms-3 form-control" value="{{ $formattedDate }}">
                            <button type="submit" class="btn my-bg text-white p-2 px-4 ms-2"><i class="fa fa-search fa-fw"></i></button>
                        </div>
                    </form>
                    <table id="datatable" class="table table-bordered rounded w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">No Penjualan</th>
                                <th class="text-center">Pelanggan</th>
                                <th class="text-center">Pesanan</th>
                                <th class="text-center">Total</th>
                                <th class="text-center">Kasir</th>
                                <th class="text-center"><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($data as $data)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td class="text-center">{{ $data->date }}</td>
                                    <td class="text-center">{{ $data->sales_no }}</td>
                                    <td class="text-center">{{ $data->customer }}</td>
                                    <td class="text-center">
                                        @foreach ($data->salesDetails as $order)
                                            <span>{{ $order->menu->name }} x({{ $order->qty }}) = Rp.
                                                {{ number_format($order->qty*$order->price, 0, ',', '.') }}</span><br>
                                        @endforeach
                                    </td>
                                    <td class="text-center">Rp. {{ number_format($data->total, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $data->user->name }}</td>

                                    <td class="text-center">
                                        <a href="{{ route('kasir.sales.print', [$data->id]) }}" target="_blank"
                                            class="btn my-bg text-white"><i class="fa fa-print"></i></a>
                                        <form action="{{ route('kasir.sales.destroy', [$data->id]) }}"
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
