@extends('layouts.my_admin_layout')
@section('title', 'Ubah Transaksi')
@section('content')
    <main class="content">
        <div class="container p-0">
            <h1 class="mb-3 fw-bold my-text-color">Ubah Transaksi</h1>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('manager.cash.update', [$data->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="type" class="form-label">Jenis Transaksi</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="in" {{ old('type', $data->type) == 'in' ? 'selected' : '' }}>Pemasukan</option>
                                <option value="out" {{ old('type', $data->type) == 'out' ? 'selected' : '' }}>Pengeluaran</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="amount" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="amount" name="amount" value="{{ old('amount', $data->amount) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="description" name="description" required>{{ old('description', $data->description) }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="date" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $data->date) }}" required>
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
