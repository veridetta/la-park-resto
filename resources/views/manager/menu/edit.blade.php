@extends('layouts.my_admin_layout')
@section('title', 'Ubah Menu')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Ubah Menu</h1>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('manager.menu.update', [$data->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold my-text-color">Nama Menu</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                value="{{ old('name', $data->name) }}" name="name">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label fw-bold my-text-color">Kategori</label>
                            <select name="category" id="category"
                                class="form-select @error('category') is-invalid @enderror">
                                <option value="">Pilih Kategori</option>
                                <option value="makanan" {{ old('category', $data->category) == 'makanan' ? 'selected' : '' }}>
                                    Makanan</option>
                                <option value="minuman" {{ old('category', $data->category) == 'minuman' ? 'selected' : '' }}>
                            </select>
                            @error('category')
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
                            <img src="{{ url('storage/menu/' . $data->image) }}" alt="{{ $data->name }}"
                                class="img-fluid" style="width: 100px">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label fw-bold my-text-color">Gambar <span class="text-muted text-small">- Biarkan kosong jika tidak ingin mengubah gambar</span></label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image">
                            @error('image')
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
