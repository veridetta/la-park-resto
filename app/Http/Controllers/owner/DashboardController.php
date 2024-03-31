<?php

namespace App\Http\Controllers\owner;

use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use App\Models\Dataset;
use App\Models\Menu;
use App\Models\Prediction;
use App\Models\ProductStock;
use App\Models\Sales;
use App\Models\SalesDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $in = Prediction::where('category','Kas Masuk')->get();
        $out = Prediction::where('category','Kas Keluar')->get();
        $sales = Prediction::where('category','Penjualan')->get();
        $profit = Prediction::where('category','Profit')->get();
        $bulan = [
            'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];
        //data penjualan untuk chartjs
        $data_penjualan = [];
        $data_penjualan['labels'] = [];
        $data_penjualan['data'] = [];
        $data_pendapatan = [];
        $data_pendapatan['labels'] = [];
        $data_pendapatan['data'] = [];

        $salesx = Sales::whereYear('date', Carbon::now()->format('Y'))->get();
        foreach ($bulan as $index => $nama_bulan) {
            $total_penjualan = 0;
            $total_pendapatans = 0;
            foreach ($salesx as $sale) {
                if (Carbon::parse($sale->date)->format('m') == $index + 1) {
                    foreach ($sale->salesDetails as $detail) {
                        $total_penjualan += $detail->qty;
                    }
                    $total_pendapatans += $sale->total;
                }
            }
            $data_penjualan['labels'][] = $nama_bulan;
            $data_pendapatan['labels'][] = $nama_bulan;
            $data_penjualan['data'][] = $total_penjualan;
            $data_pendapatan['data'][] = $total_pendapatans;
        }



        return view('owner.dashboard', compact('in', 'out', 'sales', 'profit', 'data_penjualan', 'data_pendapatan'));
    }

    public function prediction()
    {
        // $bulan = Carbon::now()->format('m');
        $tahun = Carbon::now()->format('Y');
        $bulan = [
            'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];

        $data = [];
        $data_sales = [];
        foreach ($bulan as $index => $nama_bulan) {
            $biaya_produksi = CashFlow::whereYear('date', $tahun)
                                        ->whereMonth('date', $index + 1)
                                        ->where('category', 'Biaya Produksi')
                                        ->sum('out');

            $pendapatan = CashFlow::whereYear('date', $tahun)
                                    ->whereMonth('date', $index + 1)
                                    ->where('category', 'Pendapatan')
                                    ->sum('in');

            $biaya_lainnya = CashFlow::whereYear('date', $tahun)
                                        ->whereMonth('date', $index + 1)
                                        ->where('category', 'Biaya Lainnya')
                                        ->sum('out');

            $profit = $pendapatan - ($biaya_produksi + $biaya_lainnya);

            $data[$nama_bulan] = [
                'bulan' => $nama_bulan,
                'biaya_produksi' => $biaya_produksi,
                'pendapatan' => $pendapatan,
                'biaya_lainnya' => $biaya_lainnya,
                'profit' => $profit
            ];
            $data_sales[$nama_bulan] = [
                'total_penjualan' => 0,
                'total_makanan' => 0,
                'total_minuman' => 0
            ];
            $data_penjualan = Sales::whereYear('date', $tahun)->whereMonth('date', $index + 1)->get();
            foreach ($data_penjualan as $penjualan) {
                foreach ($penjualan->salesDetails as $detail) {
                    $data_sales[$nama_bulan]['total_penjualan'] += $detail->qty;
                    if($detail->menu->category == 'makanan') {
                        $data_sales[$nama_bulan]['total_makanan'] += $detail->qty;
                    }else{
                        $data_sales[$nama_bulan]['total_minuman'] += $detail->qty;
                    }
                }
            }
        }
        return view('owner.prediction.index', compact('data', 'data_sales'));
    }

    public function sales_prediction(){
        //ambil first
        $menu_id = Menu::first()->id;
        $menu = Menu::find($menu_id);
        $menus = Menu::all();
        //select dari sales_detail where menu_id = menu_id
        $sales_details = SalesDetail::select('price', DB::raw('SUM(qty) as total_qty'))
        ->where('menu_id', $menu_id)
        ->groupBy('price')
        ->get();
        $data = [];
        //INI YANG NANTI DIPAKAI
        //masukkan harga dan sales ke dalam array
        foreach($sales_details as $sales_detail){
            $data[] = [
                'harga' => $sales_detail->price,
                'sales' => $sales_detail->total_qty
            ];
        }
        //INI YANG DIGANTI
        // $harga = [50000,60000,70000,80000,90000];
        // $sales = [120,130,140,150,160];
        // for($i = 0; $i < count($harga); $i++){
        //     $data[$i] = [
        //         'harga' => $harga[$i],
        //         'sales' => $sales[$i]
        //     ];
        // }
        //SAMPAI SINI
        return view('owner.prediction.sales', compact('menus', 'menu','menu_id', 'data'));
    }

    public function sales_prediction_filter(Request $request){
        //ambil first
        $menu_id = $request->menu_id;
        $menu = Menu::find($menu_id);
        $menus = Menu::all();

        $sales_details = SalesDetail::select('price', DB::raw('SUM(qty) as total_qty'))
        ->where('menu_id', $menu_id)
        ->groupBy('price')
        ->get();
        $data = [];
        //INI YANG NANTI DIPAKAI
        //masukkan harga dan sales ke dalam array
        foreach($sales_details as $sales_detail){
            $data[] = [
                'harga' => $sales_detail->price,
                'sales' => $sales_detail->total_qty
            ];
        }
        // $harga = [50000,60000,70000,80000,90000];
        // $sales = [120,130,140,150,160];
        // for($i = 0; $i < count($harga); $i++){
        //     $data[$i] = [
        //         'harga' => $harga[$i],
        //         'sales' => $sales[$i]
        //     ];
        // }
        return view('owner.prediction.sales', compact('menus', 'menu','menu_id', 'data'));
    }

    public function start_sales(Request $request,$menu_id){
        $harga_x = $request->harga;
        $menu = Menu::find($menu_id);
        $menus = Menu::all();
        $data = [];
        // $harga = [50000,60000,70000,80000,90000];
        // $sales = [120,130,140,150,160];
        // for($i = 0; $i < count($harga); $i++){
        //     $data[$i] = [
        //         'harga' => $harga[$i],
        //         'sales' => $sales[$i]
        //     ];
        // }
        $sales_details = SalesDetail::select('price', DB::raw('SUM(qty) as total_qty'))
        ->where('menu_id', $menu_id)
        ->groupBy('price')
        ->get();
        $data = [];
        //INI YANG NANTI DIPAKAI
        //masukkan harga dan sales ke dalam array
        $harga=[];
        $sales=[];
        foreach($sales_details as $sales_detail){
            $data[] = [
                'harga' => $sales_detail->price,
                'sales' => $sales_detail->total_qty
            ];
            $harga[] = $sales_detail->price;
            $sales[] = $sales_detail->total_qty;
        }

        $rata_rata_harga = array_sum($harga) / count($harga);
        $rata_rata_sales = array_sum($sales) / count($sales);

        $koeffisien_regresi = 0;
        $koeffisien_pembagi = 0;
        $rata_rata_harga_no_ribuan = $rata_rata_harga / 1000;

        for($i = 0; $i < count($harga); $i++){
            //ribuan dari harga tidak diambil
            $harga_no_ribuan = $harga[$i] / 1000;
            $koefisien_regresi = ($harga_no_ribuan - $rata_rata_harga_no_ribuan) * ($sales[$i] - $rata_rata_sales);
            $koeffisien_regresi += $koefisien_regresi;
            $koeffisien_pembagi += pow($harga_no_ribuan - $rata_rata_harga_no_ribuan, 2);

        }
        //menghindari devision zero
        if($koeffisien_pembagi == 0){
            $koeffisien_pembagi = 1;
        }
        $koefisien_regresi_final = $koeffisien_regresi / $koeffisien_pembagi;
        $konstanta_regresi = $rata_rata_sales - ($koefisien_regresi_final * $rata_rata_harga_no_ribuan);

        $prediksi = $koefisien_regresi_final * ($harga_x / 1000) + $konstanta_regresi;

        //insert ke table prediction
        $array_input = [$menu_id, $harga_x];
        $prediction = new Prediction();
        $prediction->date = Carbon::now();
        $prediction->input = json_encode($array_input);
        $prediction->result = $prediksi;
        $prediction->category = 'Penjualan';
        $prediction->save();

        return view('owner.prediction.sales', compact('menus', 'menu', 'menu_id', 'data'))
        ->with('message','Prediksi penjualan berhasil dengan harga Rp. '.number_format($harga_x,0,',','.').' sebanyak '.round($prediksi,2).' porsi');
    }



    public function in_prediction(){
        //ambil first
        $menu_id = Menu::first()->id;
        $menu = Menu::find($menu_id);
        $menus = Menu::all();
        //INI YANG DIGANTI
        $data = [];
        $bulan = [
            'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];
        $sales = Sales::whereYear('date', Carbon::now()->format('Y'))->get();
        $x = [];
        $y = [];
        foreach($bulan as $index => $nama_bulan){
            $total = 0;
            $price = 0;
            foreach($sales as $sale){
                if(Carbon::parse($sale->date)->format('m') == $index + 1){
                    //loop sales detail ambil sesuai menu_id
                    foreach($sale->salesDetails as $detail){
                        if($detail->menu_id == $menu_id){
                            $total += $detail->qty;
                            $price += ($detail->price*$detail->qty);
                        }
                    }
                }
            }
            $x[] = $total;
            $y[] = $price;
        }

        // $x = [10,15,20,25,30]; //jumlah penjualan
        // $y = [150000,200000,250000,300000,350000]; //kas masuk
        for($i = 0; $i < count($x); $i++){
            $data[$i] = [
                'x' => $x[$i],
                'y' => $y[$i]
            ];
        }
        //SAMPAI SINI
        return view('owner.prediction.in', compact('menus', 'menu','menu_id', 'data'));
    }

    public function in_prediction_filter(Request $request){
        //ambil first
        $menu_id = $request->menu_id;
        $menu = Menu::find($menu_id);
        $menus = Menu::all();
        //INI YANG DIGANTI
        $data = [];
        $bulan = [
            'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];
        $sales = Sales::whereYear('date', Carbon::now()->format('Y'))->get();
        $x = [];
        $y = [];
        foreach($bulan as $index => $nama_bulan){
            $total = 0;
            $price = 0;
            foreach($sales as $sale){
                if(Carbon::parse($sale->date)->format('m') == $index + 1){
                    //loop sales detail ambil sesuai menu_id
                    foreach($sale->salesDetails as $detail){
                        if($detail->menu_id == $menu_id){
                            $total += $detail->qty;
                            $price += ($detail->price*$detail->qty);
                        }
                    }
                }
            }
            $x[] = $total;
            $y[] = $price;
        }
        // $x = [10,15,20,25,30]; //jumlah penjualan
        // $y = [150000,200000,250000,300000,350000]; //kas masuk
        for($i = 0; $i < count($x); $i++){
            $data[$i] = [
                'x' => $x[$i],
                'y' => $y[$i]
            ];
        }
        //SAMPAI SINI
        return view('owner.prediction.in', compact('menus', 'menu','menu_id', 'data'));
    }

    public function start_in(Request $request,$menu_id){
        $x_x = $request->x;
        $menu = Menu::find($menu_id);
        $menus = Menu::all();
        $data = [];
        $bulan = [
            'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];
        $sales = Sales::whereYear('date', Carbon::now()->format('Y'))->get();
        $x = [];
        $y = [];
        foreach($bulan as $index => $nama_bulan){
            $total = 0;
            $price = 0;
            foreach($sales as $sale){
                if(Carbon::parse($sale->date)->format('m') == $index + 1){
                    //loop sales detail ambil sesuai menu_id
                    foreach($sale->salesDetails as $detail){
                        if($detail->menu_id == $menu_id){
                            $total += $detail->qty;
                            $price += ($detail->price*$detail->qty);
                        }
                    }
                }
            }
            $x[] = $total;
            $y[] = $price;
        }
        // $x = [10,15,20,25,30]; //jumlah penjualan
        // $y = [150000,200000,250000,300000,350000]; //kas masuk
        for($i = 0; $i < count($x); $i++){
            $data[$i] = [
                'x' => $x[$i],
                'y' => $y[$i]
            ];
        }
        $rata_rata_x = array_sum($x) / count($x);
        $rata_rata_y = array_sum($y) / count($y);
        $koeffisien_regresi = 0;
        $koeffisien_pembagi = 0;
        $rata_rata_x_no_ribuan = $rata_rata_x;
        $rata_rata_y_no_ribuan = $rata_rata_y;
        for($i = 0; $i < count($x); $i++){
            //ribuan dari harga tidak diambil
            $x_no_ribuan = $x[$i];
            $koefisien_regresi = ($x_no_ribuan - $rata_rata_x_no_ribuan) * ($y[$i] - $rata_rata_y_no_ribuan);
            $koeffisien_regresi += $koefisien_regresi;
            $koeffisien_pembagi += pow($x_no_ribuan - $rata_rata_x_no_ribuan,2);
        }
        if($koeffisien_pembagi == 0){
            $koeffisien_pembagi = 1;
        }
        $koefisien_regresi_final = $koeffisien_regresi / $koeffisien_pembagi;
        $konstanta_regresi = $rata_rata_y_no_ribuan - ($koefisien_regresi_final * $rata_rata_x_no_ribuan);

        $prediksi = $koefisien_regresi_final * ($x_x) + $konstanta_regresi;

        //insert ke table prediction
        $prediction = new Prediction();
        $prediction->date = Carbon::now();
        $prediction->input = $x_x;
        $prediction->result = $prediksi;
        $prediction->category = 'Kas Masuk';
        $prediction->save();

        return view('owner.prediction.in', compact('menus', 'menu', 'menu_id', 'data'))
        ->with('message','Prediksi kas masuk berhasil dengan jumlah penjualan '.number_format($x_x,0,',','.').' sebanyak Rp. '.number_format(round($prediksi,2),0,',','.'));
    }

    public function out_prediction(){
        //ambil first
        $menu_id = Menu::first()->id;
        $menu = Menu::find($menu_id);
        $menus = Menu::all();
        //INI YANG DIGANTI
        $data = [];
        $bulan = [
            'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];
        $sales = Sales::whereYear('date', Carbon::now()->format('Y'))->get();
        $x = [];
        $y = [];
        foreach($bulan as $index => $nama_bulan){
            $total = 0;
            $price = 0;
            foreach($sales as $sale){
                if(Carbon::parse($sale->date)->format('m') == $index + 1){
                    //loop sales detail ambil sesuai menu_id
                    foreach($sale->salesDetails as $detail){
                        if($detail->menu_id == $menu_id){
                            $total += $detail->qty;
                            // dd($detail->menu->requirementRawMaterials);
                            foreach($detail->menu->requirementRawMaterials as $stock){
                                $price += ($stock->qty*$detail->qty)*$stock->rawMaterial->price;
                            }
                            // $price += ($detail->price*$detail->qty);
                        }
                    }
                }
            }
            $x[] = $total;
            $y[] = $price;
        }
        // dd($x,$y);
        // $x = [5,10,15,20,25]; //jumlah penjualan
        // $y = [50000, 60000, 70000,80000,90000]; //kas keluar
        for($i = 0; $i < count($x); $i++){
            $data[$i] = [
                'x' => $x[$i],
                'y' => $y[$i]
            ];
        }
        //SAMPAI SINI
        return view('owner.prediction.out', compact('menus', 'menu','menu_id', 'data'));
    }

    public function out_prediction_filter(Request $request){
        //ambil first
        $menu_id = $request->menu_id;
        $menu = Menu::find($menu_id);
        $menus = Menu::all();
        //INI YANG DIGANTI
        $data = [];
        $bulan = [
            'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];
        $sales = Sales::whereYear('date', Carbon::now()->format('Y'))->get();
        $x = [];
        $y = [];
        foreach($bulan as $index => $nama_bulan){
            $total = 0;
            $price = 0;
            foreach($sales as $sale){
                if(Carbon::parse($sale->date)->format('m') == $index + 1){
                    //loop sales detail ambil sesuai menu_id
                    foreach($sale->salesDetails as $detail){
                        if($detail->menu_id == $menu_id){
                            $total += $detail->qty;
                            // dd($detail->menu->requirementRawMaterials);
                            foreach($detail->menu->requirementRawMaterials as $stock){
                                $price += ($stock->qty*$detail->qty)*$stock->rawMaterial->price;
                            }
                            // $price += ($detail->price*$detail->qty);
                        }
                    }
                }
            }
            $x[] = $total;
            $y[] = $price;
        }
        // $x = [5,10,15,20,25]; //jumlah penjualan
        // $y = [50000, 60000, 70000,80000,90000]; //kas keluar
        for($i = 0; $i < count($x); $i++){
            $data[$i] = [
                'x' => $x[$i],
                'y' => $y[$i]
            ];
        }
        //SAMPAI SINI
        return view('owner.prediction.out', compact('menus', 'menu','menu_id', 'data'));
    }

    public function start_out(Request $request,$menu_id){
        $x_x = $request->x;
        $menu = Menu::find($menu_id);
        $menus = Menu::all();
        $data = [];
        $bulan = [
            'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];
        $sales = Sales::whereYear('date', Carbon::now()->format('Y'))->get();
        $x = [];
        $y = [];
        foreach($bulan as $index => $nama_bulan){
            $total = 0;
            $price = 0;
            foreach($sales as $sale){
                if(Carbon::parse($sale->date)->format('m') == $index + 1){
                    //loop sales detail ambil sesuai menu_id
                    foreach($sale->salesDetails as $detail){
                        if($detail->menu_id == $menu_id){
                            $total += $detail->qty;
                            // dd($detail->menu->requirementRawMaterials);
                            foreach($detail->menu->requirementRawMaterials as $stock){
                                $price += ($stock->qty*$detail->qty)*$stock->rawMaterial->price;
                            }
                            // $price += ($detail->price*$detail->qty);
                        }
                    }
                }
            }
            $x[] = $total;
            $y[] = $price;
        }
        // $x = [5,10,15,20,25]; //jumlah penjualan
        // $y = [50000, 60000, 70000,80000,90000]; //kas keluar
        for($i = 0; $i < count($x); $i++){
            $data[$i] = [
                'x' => $x[$i],
                'y' => $y[$i]
            ];
        }
        $rata_rata_x = array_sum($x) / count($x);
        $rata_rata_y = array_sum($y) / count($y);
        $koeffisien_regresi = 0;
        $koeffisien_pembagi = 0;
        $rata_rata_x_no_ribuan = $rata_rata_x;
        $rata_rata_y_no_ribuan = $rata_rata_y;
        for($i = 0; $i < count($x); $i++){
            //ribuan dari harga tidak diambil
            $x_no_ribuan = $x[$i];
            $koefisien_regresi = ($x_no_ribuan - $rata_rata_x_no_ribuan) * ($y[$i] - $rata_rata_y_no_ribuan);
            $koeffisien_regresi += $koefisien_regresi;
            $koeffisien_pembagi += pow($x_no_ribuan - $rata_rata_x_no_ribuan,2);
        }
        if($koeffisien_pembagi == 0){
            $koeffisien_pembagi = 1;
        }
        $koefisien_regresi_final = $koeffisien_regresi / $koeffisien_pembagi;
        $konstanta_regresi = $rata_rata_y_no_ribuan - ($koefisien_regresi_final * $rata_rata_x_no_ribuan);

        $prediksi = $koefisien_regresi_final * ($x_x) + $konstanta_regresi;

        //insert ke table prediction
        $prediction = new Prediction();
        $prediction->date = Carbon::now();
        $prediction->input = $x_x;
        $prediction->result = $prediksi;
        $prediction->category = 'Kas Keluar';
        $prediction->save();

        return view('owner.prediction.out', compact('menus', 'menu', 'menu_id', 'data'))
        ->with('message','Prediksi kas keluar berhasil dengan jumlah penjualan '.number_format($x_x,0,',','.').' sebanyak Rp. '.number_format(round($prediksi,2),0,',','.'));
    }

    public function profit_prediction(){
        //ambil first
        $tahun = Carbon::now()->format('Y');
        $bulan = [
            'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];

        $data = [];
        //INI YANG DIGANTI
        $cash_flows = CashFlow::whereYear('date', $tahun)->get();
        $y = [];
        foreach($bulan as $index => $nama_bulan){
            $profit = 0;
            $pendapatan = 0;
            $biaya_produksi = 0;
            $biaya_lainnya=0;
            foreach($cash_flows as $cash_flow){
                if(Carbon::parse($cash_flow->date)->format('m') == $index + 1){
                    if($cash_flow->category == 'Pendapatan'){
                        $pendapatan += $cash_flow->in;
                    }elseif($cash_flow->category == 'Biaya Produksi'){
                        $biaya_produksi += $cash_flow->out;
                    }elseif($cash_flow->category == 'Biaya Lainnya'){
                        $biaya_lainnya += $cash_flow->out;
                    }
                }
            }
            $profit = $pendapatan - ($biaya_produksi + $biaya_lainnya);
            $y[] = $profit;
        }
        $x = [1,2,3,4,5,6,7,8,9,10,11,12]; //Periode
        // $y = [22140000,22760000,20720000,28300000,21460000,27180000,20350000,20260000,24100000,24780000,31860000,25960000]; //Profit
        // dd($x,$y);
        for($i = 0; $i < count($x); $i++){
            $data[$i] = [
                'x' => $x[$i],
                'y' => $y[$i],
                'bulan'=>$bulan[$i]
            ];
        }
        //SAMPAI SINI
        return view('owner.prediction.profit', compact('data','tahun'));
    }

    public function start_profit(Request $request){
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        //berapa bulan dari sekarang
        $bulan_sekarang = Carbon::now()->format('m');
        $tahun_sekarang = Carbon::now()->format('Y');
        $selisih_bulan = $bulan - $bulan_sekarang;
        $selisih_tahun = $tahun - $tahun_sekarang;
        $selisih_total = ($selisih_tahun * 12) + $selisih_bulan;

        $x_x = $selisih_total;
        $bulanx = [
            'Januari', 'Februari', 'Maret', 'April',
            'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];

        $data = [];
        //INI YANG DIGANTI
        $cash_flows = CashFlow::whereYear('date', $tahun_sekarang)->get();
        $y = [];
        foreach($bulanx as $index => $nama_bulan){
            $profit = 0;
            $pendapatan = 0;
            $biaya_produksi = 0;
            $biaya_lainnya=0;
            foreach($cash_flows as $cash_flow){
                if(Carbon::parse($cash_flow->date)->format('m') == $index + 1){
                    if($cash_flow->category == 'Pendapatan'){
                        $pendapatan += $cash_flow->in;
                    }elseif($cash_flow->category == 'Biaya Produksi'){
                        $biaya_produksi += $cash_flow->out;
                    }elseif($cash_flow->category == 'Biaya Lainnya'){
                        $biaya_lainnya += $cash_flow->out;
                    }
                }
            }
            $profit = $pendapatan - ($biaya_produksi + $biaya_lainnya);
            $y[] = $profit;
        }
        $x = [1,2,3,4,5,6,7,8,9,10,11,12]; //Periode
        // $y = [22140000,22760000,20720000,28300000,21460000,27180000,20350000,20260000,24100000,24780000,31860000,25960000]; //Profit
        for($i = 0; $i < count($x); $i++){
            $data[$i] = [
                'x' => $x[$i],
                'y' => $y[$i],
                'bulan'=>$bulanx[$i]
            ];
        }
        $rata_rata_x = array_sum($x) / count($x);
        $rata_rata_y = array_sum($y) / count($y);
        $koeffisien_regresi = 0;
        $koeffisien_pembagi = 0;
        $rata_rata_x_no_ribuan = $rata_rata_x;
        // dd($rata_rata_x_no_ribuan);
        $rata_rata_y_no_ribuan = $rata_rata_y;
        for($i = 0; $i < count($x); $i++){
            //ribuan dari harga tidak diambil
            $x_no_ribuan = $x[$i];
            $koefisien_regresi = ($x_no_ribuan - $rata_rata_x_no_ribuan) * ($y[$i] - $rata_rata_y_no_ribuan);
            $koeffisien_regresi += $koefisien_regresi;
            $koeffisien_pembagi += pow($x_no_ribuan - $rata_rata_x_no_ribuan,2);
        }
        if($koeffisien_pembagi == 0){
            $koeffisien_pembagi = 1;
        }
        $koefisien_regresi_final = $koeffisien_regresi / $koeffisien_pembagi;

        $konstanta_regresi = $rata_rata_y_no_ribuan - ($koefisien_regresi_final * $rata_rata_x_no_ribuan);

        $prediksi = $koefisien_regresi_final * ($x_x) + $konstanta_regresi;

        $array_input  = [$bulan, $tahun];
        //insert ke table prediction
        $prediction = new Prediction();
        $prediction->date = Carbon::now();
        $prediction->input = json_encode($array_input);
        $prediction->result = $prediksi;
        $prediction->category = 'Profit';
        $prediction->save();

        return view('owner.prediction.profit', compact('data','tahun'))
        ->with('message','Prediksi profit berhasil untuk periode '.getIndonesiaMonth($bulan).' '.$tahun.' sebesar Rp. '.number_format(round($prediksi,2),0,',','.'));
    }
}
