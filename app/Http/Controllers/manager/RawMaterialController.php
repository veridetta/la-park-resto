<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\RawMaterial;
use App\Models\RawMaterialHistory;
use Illuminate\Http\Request;

class RawMaterialController extends Controller
{
    public function index()
    {
        $data = RawMaterial::all();
        return view('manager.raw_material.index', compact('data'));
    }

    public function create()
    {
        return view('manager.raw_material.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'qty' => 'required',
            'limit' => 'required', //add 'limit' to the validation rule
            'unit' => 'required',
            'price' => 'required'
        ]);

        $simpan = new RawMaterial();
        $simpan->name = $request->name;
        $simpan->qty = $request->qty;
        $simpan->unit = $request->unit;
        $simpan->price = $request->price;
        $simpan->limit = $request->limit; //add 'limit' to the save method
        $simpan->save();
        //ambil id
        $id = $simpan->id;

        if($simpan){
            //simpan history
            $history = new RawMaterialHistory();
            $history->raw_material_id = $id;
            $history->date = date('Y-m-d');
            $history->in = $request->qty;
            $history->out = 0;
            $history->price = $request->price;
            $history->balance = $request->qty;
            $history->description = 'Tambah stok awal';
            $history->save();
            return redirect()->route('manager.raw_material.index')->with('message', [
                'success' => true,
                'message' => 'Bahan baku berhasil ditambahkan'
            ]);
        }else{
            return redirect()->route('manager.raw_material.index')->with('message', [
                'success' => false,
                'message' => 'Bahan baku gagal ditambahkan'
            ]);
        }
    }

    public function show($id)
    {
        $data = RawMaterial::find($id);
        return view('manager.raw_material.show', compact('data'));
    }

    public function edit($id)
    {
        $data = RawMaterial::find($id);
        return view('manager.raw_material.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'qty' => 'required',
            'unit' => 'required',
            'limit' => 'required', //add 'limit' to the validation rule
            'price' => 'required'
        ]);
        $stok_awal = RawMaterial::find($id)->qty;
        $selisih = $request->qty - $stok_awal;
        $simpan = RawMaterial::find($id);
        $simpan->name = $request->name;
        $simpan->qty = $request->qty;
        $simpan->unit = $request->unit;
        $simpan->price = $request->price;
        $simpan->limit = $request->limit; //add 'limit' to the save method
        $simpan = $simpan->save();

        if($simpan){
            //update history
            $history = new RawMaterialHistory();
            $history->raw_material_id = $id;
            $history->date = date('Y-m-d');
            $history->in = $selisih > 0 ? $selisih : 0;
            $history->out = $selisih < 0 ? $selisih : 0;
            $history->balance = $request->qty;
            $history->description = 'Penyesuaian stok';

            return redirect()->route('manager.raw_material.index')->with('message', [
                'success' => true,
                'message' => 'Bahan baku berhasil diubah'
            ]);
        }else{
            return redirect()->route('manager.raw_material.index')->with('message', [
                'success' => false,
                'message' => 'Bahan baku gagal diubah'
            ]);
        }
    }

    public function destroy($id)
    {
        $hapus = RawMaterial::find($id);
        $history = RawMaterialHistory::where('raw_material_id', $id);
        $history->delete();
        $hapus = $hapus->delete();
        if($hapus){
            return redirect()->route('manager.raw_material.index')->with('message', [
                'success' => true,
                'message' => 'Bahan baku berhasil dihapus'
            ]);
        }else{
            return redirect()->route('manager.raw_material.index')->with('message', [
                'success' => false,
                'message' => 'Bahan baku gagal dihapus'
            ]);
        }
    }


    public function addStock($id)
    {
        $data = RawMaterial::find($id);
        return view('manager.raw_material_history.create', compact('data','id'));
    }

    public function storeStock(Request $request, $id)
    {
        $request->validate([
            'qty' => 'required',
        ]);
        $data = RawMaterial::find($id);
        $stock_awal = $data->qty;
        $data->qty = $stock_awal + $request->qty;
        $data->save();

        $simpan = new RawMaterialHistory();
        $simpan->raw_material_id = $id;
        $simpan->date = date('Y-m-d');
        $simpan->in = $request->qty;
        $simpan->out = 0;
        $simpan->balance = $data->qty;
        $simpan->description = 'Penambahan stok';
        $simpan->save();

        if($simpan){
            //update qty history
            return redirect()->route('manager.raw_material.history', [$data->id])->with('message', [
                'success' => true,
                'message' => 'Stok bahan baku berhasil ditambahkan'
            ]);
        }else{
            return redirect()->route('manager.raw_material.history', [$data->id])->with('message', [
                'success' => false,
                'message' => 'Stok bahan baku gagal ditambahkan'
            ]);
        }
    }

    public function history($id)
    {
        //order terbaru ke lama
        $data = RawMaterialHistory::where('raw_material_id', $id)->orderBy('date', 'DESC')->get();
        return view('manager.raw_material_history.index', compact('data','id'));
    }
}
