@extends('layouts.my_admin_layout')
@section('title', 'Riwayat Stok Bahan Baku')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Riwayat Stok Bahan Baku</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-end">
                        <a href="{{ route('manager.raw_material.addStock', [$id]) }}"
                            class="btn my-bg text-white"><i class="fa fa-plus"></i> Tambah Stok</a>
                        <a href="{{ route('manager.raw_material.index') }}" class="btn btn-secondary ms-2"><i
                                class="fa fa-arrow-left"></i> Kembali</a>
                    </div>
                    <table id="datatable" class="table table-bordered rounded w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">In</th>
                                <th class="text-center">Out</th>
                                <th class="text-center">Satuan</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Stok Akhir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($data as $data)
                                <tr>
                                    <td class="text-center"></td>
                                    <td class="text-center">{{ $data->created_at }}</td>
                                    <td class="text-center">{{ $data->rawMaterial->name }}</td>
                                    <td class="text-center">{{ $data->in }}</td>
                                    <td class="text-center">{{ $data->out }}</td>
                                    <td class="text-center">{{ $data->rawMaterial->unit }}</td>
                                    <td class="text-center">
                                        @if($data->in)
                                            <span class="badge bg-success">{{ $data->description }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $data->description }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {!! stockColor($data->balance, $data->rawMaterial->limit) !!}
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
                //kolom pertama sebagai nomor
                columnDefs: [
                    { type: 'date', 'targets': [1] },
                ],
                order: [[ 1, 'desc' ]],
                "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td:eq(0)', nRow).html(iDisplayIndexFull +1);
                }
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
