<div class="card">
    <div class="card-body">
        <p class="h3 font-weight-bold fw-bold text-center text-capitalize">Hasil Prediksi Penjualan</p>
        <table id="datatable" class="table table-bordered rounded w-100">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Bulan</th>
                    <th class="text-center">Tahun</th>
                    <th class="text-center">Hasil</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach($profit as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->date }}</td>
                    <?php
                    $input = $item->input;
                    $input = json_decode($input);

                    ?>
                    <td>{{ getIndonesiaMonth($input[0]) }}</td>
                    <td>{{ $input[1] }}</td>
                    <td>{{ 'Rp. ' . number_format($item->result, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
    </div>
</div>
