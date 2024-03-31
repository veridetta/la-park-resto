<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h3, h4, h5 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .cogs {
            font-size: 18px;
        }

        .cogs:hover {
            color: blue;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3>{{ get_my_app_config('nama_web') }}</h3>
        <h4>Laporan Keuangan</h4>
        <h5>Bulan {{ getIndonesiaMonth($month) }} {{ $year }}</h5>

        <table id="datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>No Penjualan</th>
                    <th>Pelanggan</th>
                    <th>Pesanan</th>
                    <th>Total</th>
                    <th>Kasir</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach ($data as $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $data->date }}</td>
                        <td>{{ $data->sales_no }}</td>
                        <td>{{ $data->customer }}</td>
                        <td>
                            @foreach ($data->salesDetails as $order)
                                <span>{{ $order->menu->name }} x({{ $order->qty }}) = Rp. {{ number_format($order->qty*$order->price, 0, ',', '.') }}</span><br>
                            @endforeach
                        </td>
                        <td>Rp. {{ number_format($data->total, 0, ',', '.') }}</td>
                        <td>{{ $data->user->name }}</td>
                    </tr>
                    <?php $no++; ?>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        window.print();
    </script>
</body>
</html>
