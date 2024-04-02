<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\RawMaterial;
use App\Models\RequirementRawMaterial;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        $tanggal = date('Y-m-d');
        $saldo = \App\Models\Sales::where('date', 'like', $tanggal.'%')->where('user_id', auth()->user()->id)->sum('total');
        $data = \App\Models\Sales::where('date', 'like', $tanggal.'%')->where('user_id', auth()->user()->id)->get();
        return view('kasir.sales.index', compact('data', 'saldo','tanggal'));
    }

    public function create()
    {
        $menu = Menu::whereHas('requirementRawMaterials', function($q){
            $q->where('qty', '>', 0);
        })->get();
        //ambil menu yang sudah memiliki bahan baku
        $menu_jquery = Menu::whereHas('requirementRawMaterials', function($q){
            $q->where('qty', '>', 0);
        })->get();
        $menu_jquery = $menu_jquery->map(function($item){
            return [
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
            ];
        });
        $menu_jquery = $menu_jquery->toJson();

        return view('kasir.sales.create', compact('menu', 'menu_jquery'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'customer' => 'required',
            'menu' => 'required',
            'qty' => 'required',
        ]);

        //nomor penjualan
        $no = \App\Models\Sales::max('id') + 1;
        $no = str_pad($no, 4, '0', STR_PAD_LEFT);
        $no = 'ORD-'.date('Ymd').'-'.$no;

        $simpan = new \App\Models\Sales();
        $simpan->date = $request->date;
        $simpan->sales_no = $no;
        $simpan->customer = $request->customer;
        $simpan->user_id = auth()->user()->id;
        foreach($request->menu as $key => $value){
            //ambil harga
            $menu = \App\Models\Menu::find($value);
            $total = $request->qty[$key] * $menu->price;
        }
        $simpan->total = $total;
        $simpan->save();

        //simpan detail
        foreach($request->menu as $key => $value){
            $detail = new \App\Models\SalesDetail();
            $detail->sales_id = $simpan->id;
            $detail->menu_id = $value;
            $detail->qty = $request->qty[$key];
            $menu = \App\Models\Menu::find($value);
            $total = $request->qty[$key] * $menu->price;
            $detail->price = $menu->price;
            $detail->save();
        }

        //masukkan ke penambahan kas untuk penjualan
        $cash = new \App\Models\CashFlow();
        $cash->date = $request->date;
        $cash->description = 'Pendapatan dari penjualan '.$request->customer;
        $cash->in = $total;
        $cash->out = 0;
        //ambil saldo terakhir
        $saldo = \App\Models\CashFlow::where('date', '<=', $request->date)->orderBy('date', 'desc')->orderBy('id', 'desc')->first();
        if($saldo){
            $cash->amount = $saldo->amount + $total;
        }else{
            $cash->amount = $total;
        }
        $cash->sales_no = $no;
        $cash->category = 'Pendapatan';
        $cash->save();

        $total_biaya = 0;

        //massukan pengurangan stock bahan baku
        foreach($request->menu as $key => $value){
            $menu = \App\Models\Menu::find($value);
            $data = RequirementRawMaterial::where('menu_id', $value)->get();
            foreach($data as $m){
                $stock = RawMaterial::find($m->raw_material_id);
                $stock->qty = $stock->qty - ($m->qty * $request->qty[$key]);
                $stock->save();

                //masukkan ke history
                $history = new \App\Models\RawMaterialHistory();
                $history->raw_material_id = $m->raw_material_id;
                $history->date = $request->date;
                $history->in = 0;
                $history->out = $m->qty * $request->qty[$key];
                $history->price = $stock->price;
                $history->description = 'Pengurangan stock bahan baku untuk penjualan '.$request->customer;
                //last balance
                $last = \App\Models\RawMaterialHistory::where('raw_material_id', $m->raw_material_id)->orderBy('date', 'desc')->orderBy('id', 'desc')->first();
                if($last){
                    $history->balance = $last->balance - ($m->qty * $request->qty[$key]);
                }else{
                    $history->balance = $stock->qty - ($m->qty * $request->qty[$key]);
                }
                $history->price = $stock->price;
                $history->save();
                $total_biaya += $stock->price * ($m->qty * $request->qty[$key]);
            }
        }

        //masukkan ke pengurangan kas untuk biaya produksi
        $cash = new \App\Models\CashFlow();
        $cash->date = $request->date;
        $cash->description = 'Biaya produksi untuk penjualan '.$request->customer;
        $cash->in = 0;
        $cash->out = $total_biaya;
        //ambil saldo terakhir
        $saldo = \App\Models\CashFlow::where('date', '<=', $request->date)->orderBy('date', 'desc')->orderBy('id', 'desc')->first();
        if($saldo){
            $cash->amount = $saldo->amount - $total_biaya;
        }else{
            $cash->amount = 0 - $total_biaya;
        }
        $cash->sales_no = $no;
        $cash->category = 'Biaya Produksi';
        $cash->save();



        return redirect()->route('kasir.sales.index')->with('message', [
            'success' => true,
            'message' => 'Data penjualan berhasil disimpan'
        ]);
    }

    public function destroy($id)
    {
        $data = \App\Models\Sales::find($id);
        //delete detail
        $data->salesDetails()->delete();
        //delete cash
        $cash = \App\Models\CashFlow::where('sales_no', $data->sales_no)->get();
        foreach($cash as $c){
            //update saldo
            $saldo = \App\Models\CashFlow::where('date', '>', $c->date)->orderBy('date', 'asc')->orderBy('id', 'asc')->first();
            if($saldo){
                $c->delete();
                $saldo->amount = $saldo->amount - $c->out;
                $saldo->save();
            }else{
                $c->delete();
            }
        }
        //delete bahan baku
        $detail = \App\Models\SalesDetail::where('sales_id', $id)->get();
        foreach($detail as $d){
            $data = RequirementRawMaterial::where('menu_id', $d->menu_id)->get();
            foreach($data as $m){
                $stock = RawMaterial::find($m->raw_material_id);
                $stock->qty = $stock->qty + ($m->qty * $d->qty);
                $stock->save();

                //delete history
                $history = \App\Models\RawMaterialHistory::where('raw_material_id', $m->raw_material_id)->where('date', $data->date)->where('description', 'Pengurangan stock bahan baku untuk penjualan '.$data->customer)->first();
                $history->delete();
            }
        }

        $data->delete();

        return redirect()->route('kasir.sales.index')->with('message', [
            'success' => true,
            'message' => 'Data penjualan berhasil dihapus'
        ]);
    }

    public function filter(Request $request)
    {
        $data = \App\Models\Sales::where('created_at', 'like', $request->date.'%')->get();
        $tanggal = $request->date;
        $saldo = \App\Models\Sales::where('created_at', 'like', $request->date.'%')->where('user_id', auth()->user()->id)->sum('total');
        return view('kasir.sales.index', compact('data', 'saldo','tanggal'));
    }

    public function checkStock(Request $request)
    {
        $id = $request->id;
        $qty = $request->qty;
        $data = RequirementRawMaterial::where('menu_id', $id)->get();
        //cek stok setiap bahan baku
        foreach($data as $m){
            $stock = RawMaterial::find($m->raw_material_id);
            // echo $stock->qty ." - ". $m->qty ."<br>";
            if($stock->qty < ((int)$m->qty * (int)$qty)){
                $max = (int)($stock->qty / $m->qty);
                //pembulatan ke bawah
                $max = floor($max);
                $data = [
                    'status' => false,
                    'message' => '<span class="badge bg-danger">Stock '.$stock->name.' tidak mencukupi. Stock saat ini '.$stock->qty. ' '.$stock->unit.' hanya bisa membuat '.$max.' menu</span>'
                ];
                return response()->json($data);
            }
        }

        $data = [
            'status' => true,
            'message' => '<span class="badge bg-success">Stock mencukupi</span>'
        ];

        return response()->json($data);
    }

    public function print($id)
    {
        $data = \App\Models\Sales::find($id);
        return view('kasir.sales.print', compact('data'));
    }
}

