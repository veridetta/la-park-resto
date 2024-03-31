@extends('layouts.my_admin_layout')
@section('title', 'Tambah Bahan Baku')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Tambah Bahan Baku</h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('manager.raw_material.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Harga</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="qty" class="form-label">Stok Awal</label>
                            <input type="number" class="form-control" id="qty" name="qty" required>
                        </div>
                        <div class="mb-3">
                            <label for="unit" class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="unit" name="unit" required>
                        </div>
                        <div class="mb-3">
                            <label for="limit" class="form-label">Stok Minimum</label>
                            <input type="number" class="form-control" id="limit" name="limit" required>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn my-bg text-white p-2 px-4"><i class="fa fa-save fa-fw"></i>
                                Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')

@endsection
