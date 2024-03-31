@extends('layouts.my_admin_layout')
@section('title', 'Laporan')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Laporan</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('manager.report.filter') }}" method="POST">
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
                            <button type="submit" class="ms-2 btn my-bg text-white p-2 px-4"><i class="fa fa-search fa-fw"></i></button>
                            <a href="{{ route('manager.report.print', ['month' => $month, 'year' => $year]) }}" target="_blank"
                                class="btn btn-success ms-2 text-white p-2 px-4"><i class="fa fa-print fa-fw"></i></a>
                        </div>
                    </form>
                    @include('components.flash-message')
                    <h3 class="text-center">{{ get_my_app_config('nama_web') }}</h3>
                    <h4 class="text-center">Laporan Keuangan</h4>
                    <h5 class="text-center">Bulan {{ getIndonesiaMonth($month) }} {{ $year }}</h5>

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
                    "orderable": false,
                    "targets": 2
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
