<div class="card">
    <div class="card-body">
        <p class="h3 font-weight-bold fw-bold text-center text-capitalize">Hasil Prediksi Kas Keluar</p>
        <table id="datatable" class="table table-bordered rounded w-100">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Penjualan</th>
                    <th class="text-center">Hasil</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach($out as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->input }}</td>
                    <td>{{ 'Rp. ' . number_format($item->result, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
    </div>
</div>
