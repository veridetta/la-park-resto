@extends('layouts.my_admin_layout')
@section('title', 'Notifikasi')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Pemberitahuan <i class="fa fa-bell"></i></h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    @include('components.flash-message')
                    <table id="datatable" class="table table-bordered rounded w-100">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Tanggal</th>
                                <th class="text-center">Keterangan</th>
                                <th class="text-center">Pesan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            @foreach ($data as $data)
                                <tr @if($data->is_read == 0) class="bg-light" @endif>
                                    <td class="text-center">{{ $no++ }}</td>
                                    <td class="text-center">{{ $data->created_at }}</td>
                                    <td class="text-center">{{ $data->title }}</td>
                                    <td class="text-center">{{ $data->content }}
                                        @if($data->type == 'raw_material')
                                            <a href="{{ route('manager.raw_material.index', [$data->id]) }}"
                                                class="btn my-bg text-white"><small class="text-white">Lihat</small></a>
                                        @endif
                                    </td>

                                </tr>
                                <?php $no++; ?>
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
