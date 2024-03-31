@extends('layouts.my_admin_layout')
@section('title', 'Kelola Bahan Baku')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Kelola Bahan Baku</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <div class="d-flex mb-4 justify-content-end">
                        <a href="{{ route('manager.raw_material.create') }}" class="btn my-bg text-white p-2 px-4"><i
                                class="fa fa-plus fa-fw"></i>
                            Tambah Bahan Baku</a>
                    </div>

                    <table id="datatable" class="table table-bordered rounded w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Stok</th>
                                <th class="text-center">Satuan</th>
                                <th class="text-center">Stok Minimum</th>
                                <th class="text-center">Status</th>
                                <th class="text-center"><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($data as $data)
                                <tr>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td class="text-center">{{ $data->name }}</td>
                                    <td class="text-center">{{ 'Rp. ' . number_format($data->price, 0, ',', '.') }}</td>
                                    <td class="text-center">{{ $data->qty }}</td>
                                    <td class="text-center">{{ $data->unit }}</td>
                                    <td class="text-center">{{ $data->limit }}</td>
                                    <td class="text-center">{!! stockStatus($data->qty, $data->limit) !!}</td>

                                    <td class="text-center">
                                        <a href="{{ route('manager.raw_material.history', [$data->id]) }}"
                                            class="btn my-bg text-white"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('manager.raw_material.edit', [$data->id]) }}"
                                            class="btn my-bg text-white"><i class="fa fa-edit"></i></a>
                                        <form action="{{ route('manager.raw_material.destroy', [$data->id]) }}"
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
