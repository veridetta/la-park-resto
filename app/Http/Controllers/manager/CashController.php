<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\CashFlow;
use Illuminate\Http\Request;

class CashController extends Controller
{
    public function index()
    {
        //data where month and year
        $data = CashFlow::whereMonth('date', date('m'))
            ->whereYear('date', date('Y'))
            ->get();
            $month = date('m');
            $year = date('Y');
        $saldo = CashFlow::sum('in') - CashFlow::sum('out');
        return view('manager.cash.index', compact('data', 'month', 'year', 'saldo'));
    }

    public function filter(Request $request)
    {
        //data where month and year
        $month = $request->month;
        $year = $request->year;
        $data = CashFlow::whereMonth('date', $request->month)
            ->whereYear('date', $request->year)
            ->get();
        $saldo = CashFlow::sum('in') - CashFlow::sum('out');
        return view('manager.cash.index', compact('data', 'month', 'year', 'saldo'));
    }

    public function create()
    {
        return view('manager.cash.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'amount' => 'required',
            'description' => 'required',
            'date' => 'required'
        ]);
        // dd($request->all());
        //ambil amount terakhir
        $last = CashFlow::latest()->first();
        if($last){
            $balance = $last->amount;
        }else{
            $balance = 0;
        }
        $simpan = new CashFlow();
        if($request->type == 'in'){
            $simpan->in = $request->amount;
            $simpan->category = 'Pendapatan Lainnya';
            $simpan->out = 0;
        }else{
            $simpan->in = 0;
            $simpan->out = $request->amount;
            $simpan->category = 'Biaya Lainnya';
        }
        $simpan->description = $request->description;
        $simpan->date = $request->date;
        $simpan->amount = $balance + $request->amount;

        $simpan->save();

        if($simpan){
            return redirect()->route('manager.cash.index')->with('message', [
                'success' => true,
                'message' => 'Transaksi berhasil ditambahkan'
            ]);
        }else{
            return redirect()->route('manager.cash.index')->with('message', [
                'success' => false,
                'message' => 'Transaksi gagal ditambahkan'
            ]);
        }
    }

    public function show($id)
    {
        $data = CashFlow::find($id);
        return view('manager.cash.show', compact('data'));
    }

    public function edit($id)
    {
        $data = CashFlow::find($id);
        //set amount
        if($data->in > 0){
            $data->amount = $data->in;
        }else{
            $data->amount = $data->out;
        }
        return view('manager.cash.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required',
            'amount' => 'required',
            'description' => 'required',
            'date' => 'required'
        ]);

        $simpan = CashFlow::find($id);
        $balance = $simpan->amount - $simpan->in + $simpan->out;
        if($request->type == 'in'){
            $simpan->in = $request->amount;
            $simpan->out = 0;
        }else{
            $simpan->in = 0;
            $simpan->out = $request->amount;
        }
        $simpan->description = $request->description;
        $simpan->date = $request->date;
        $simpan->amount = $balance + $request->amount;

        $simpan->save();

        if($simpan){
            return redirect()->route('manager.cash.index')->with('message', [
                'success' => true,
                'message' => 'Transaksi berhasil diubah'
            ]);
        }else{
            return redirect()->route('manager.cash.index')->with('message', [
                'success' => false,
                'message' => 'Transaksi gagal diubah'
            ]);
        }
    }

    public function destroy($id)
    {
        $hapus = CashFlow::find($id);
        if(!$hapus){
            return redirect()->route('manager.cash.index')->with('message', [
                'success' => false,
                'message' => 'Transaksi tidak ditemukan'
            ]);
        }
        $hapus->delete();

        if($hapus){
            return redirect()->route('manager.cash.index')->with('message', [
                'success' => true,
                'message' => 'Transaksi berhasil dihapus'
            ]);
        }else{
            return redirect()->route('manager.cash.index')->with('message', [
                'success' => false,
                'message' => 'Transaksi gagal dihapus'
            ]);
        }
    }
}
