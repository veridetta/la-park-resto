@extends('layouts.my_admin_layout')
@section('title', 'Ubah Bahan Baku')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Ubah Bahan Baku</h1>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('manager.raw_material.update', [$data->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold my-text-color">Nama Bahan Baku</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                value="{{ old('name', $data->name) }}" name="name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label fw-bold my-text-color">Harga</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price"
                                value="{{ old('price', $data->price) }}" name="price">
                            @error('price')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="qty" class="form-label fw-bold my-text-color">Stok Awal</label>
                            <input type="number" class="form-control @error('qty') is-invalid @enderror" id="qty"
                                value="{{ old('qty', $data->qty) }}" name="qty">
                            @error('qty')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="unit" class="form-label fw-bold my-text-color">Satuan</label>
                            <input type="text" class="form-control @error('unit') is-invalid @enderror" id="unit"
                                value="{{ old('unit', $data->unit) }}" name="unit">
                            @error('unit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="limit" class="form-label fw-bold my-text-color">Stok Minimum</label>
                            <input type="number" class="form-control @error('limit') is-invalid @enderror" id="limit"
                                value="{{ old('limit', $data->limit) }}" name="limit">
                            @error('limit')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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
