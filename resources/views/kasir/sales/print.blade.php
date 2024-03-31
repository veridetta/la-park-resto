<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Penjualan</title>
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
        <h3 style=" line-height: 0.5;">{{ get_my_app_config('nama_web') }}</h3>
        <h4 style=" line-height: 0.5;">Nota Penjualan</h4>
        <p style="text-align: left; line-height: 0.5;">No Penjualan : {{ $data->sales_no }}</p>
        <p style="text-align: left; line-height: 0.5;">Tanggal : {{ $data->date }}</p>
        <p style="text-align: left; line-height: 0.5;">Kasir : {{ $data->user->name }}</p>
        <p style="text-align: left; line-height: 0.5;">Pelanggan : {{ $data->customer }}</p>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Menu</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach ($data->salesDetails as $order)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $order->menu->name }}</td>
                        <td>Rp. {{ number_format($order->price, 0, ',', '.') }}</td>
                        <td>{{ $order->qty }}</td>
                        <td>Rp. {{ number_format($order->qty*$order->price, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="4">Total</td>
                    <td>Rp. {{ number_format($data->total, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
        <h5>Terima kasih atas kunjungan Anda</h5>

    </div>
    <script>
        window.print();
    </script>
</body>
</html>
