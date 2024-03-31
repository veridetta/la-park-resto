<div class="card">
    <div class="card-body">
        <p class="h3 font-weight-bold fw-bold text-center text-capitalize">Hasil Prediksi Penjualan</p>
        <table id="datatable" class="table table-bordered rounded w-100">
            <thead>
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Menu</th>
                    <th class="text-center">Harga</th>
                    <th class="text-center">Hasil</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach($sales as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->date }}</td>
                    <?php
                    $input = $item->input;
                    $input = json_decode($input);
                    $menu = App\Models\Menu::find($input[0]);
                    ?>
                    <td>{{ $menu->name }}</td>
                    <td>{{ 'Rp. ' . number_format($input[1], 0, ',', '.') }}</td>
                    <td>{{ 'Rp. ' . number_format($menu->price, 0, ',', '.') }}</td>
                    <td>{{ $item->output }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <hr>
    </div>
</div>
