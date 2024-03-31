@extends('layouts.my_admin_layout')
@section('title', 'Tambah Bahan Baku - {{$data->name}} ')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Tambah Bahan Baku - {{$data->name}} </h1>
            @include('components.flash-message')
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('manager.menu.storeRequirement', [$data->id]) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="ingredient" class="form-label">Bahan Baku</label>
                            <select class="form-select" id="raw_material_id" name="raw_material_id" required>
                                <option value="">Pilih Bahan Baku</option>
                                @foreach ($raw as $ingredient)
                                    <option value="{{ $ingredient->id }}">{{ $ingredient->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="qty" class="form-label">Qty</label>
                            <input type="number" class="form-control" id="qty" name="qty" required>
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
