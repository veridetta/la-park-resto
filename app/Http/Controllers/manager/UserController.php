<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $data = User::all();
        return view('manager.user.index', compact('data'));
    }

    public function create()
    {
        return view('manager.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required',
        ]);

        $simpan = new User();
        $simpan->name = $request->name;
        $simpan->email = $request->email;
        $simpan->password = bcrypt($request->password);
        $simpan->role = $request->role;
        $simpan = $simpan->save();

        if($simpan){
            return redirect()->route('manager.user.index')->with('message', [
                'success' => true,
                'message' => 'User berhasil ditambahkan'
            ]);
        }else{
            return redirect()->route('manager.user.index')->with('message', [
                'success' => false,
                'message' => 'User gagal ditambahkan'
            ]);
        }
    }

    public function show($id)
    {
        $data = User::find($id);
        return view('manager.user.show', compact('data'));
    }

    public function edit($id)
    {
        $data = User::find($id);
        return view('manager.user.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,',
            'role' => 'required',
        ]);

        $simpan = User::find($id);
        if($request->password){
            $request->validate([
                'password' => 'required',
            ]);
            $simpan->password = bcrypt($request->password);
        }
        //cek email duplikat
        $cek_email = User::where('email', $request->email)->where('id', '!=', $id)->count();
        if($cek_email > 0){
            return redirect()->route('manager.user.index')->with('message', [
                'success' => false,
                'message' => 'Email sudah digunakan'
            ]);
        }

        $simpan->name = $request->name;
        $simpan->email = $request->email;
        $simpan->role = $request->role;
        $simpan = $simpan->save();

        if($simpan){
            return redirect()->route('manager.user.index')->with('message', [
                'success' => true,
                'message' => 'User berhasil diubah'
            ]);
        }else{
            return redirect()->route('manager.user.index')->with('message', [
                'success' => false,
                'message' => 'User gagal diubah'
            ]);
        }
    }

    public function destroy($id)
    {
        $hapus = User::find($id);
        //pindahkan sales (user_id) ke user_id manager
        $kasir = User::where('role', 'kasir')->first();
        $sales = Sales::where('user_id', $id)->update(['user_id' => $kasir->id]);
        $hapus = $hapus->delete();
        if($hapus){
            return redirect()->route('manager.user.index')->with('message', [
                'success' => true,
                'message' => 'User berhasil dihapus'
            ]);
        }else{
            return redirect()->route('manager.user.index')->with('message', [
                'success' => false,
                'message' => 'User gagal dihapus'
            ]);
        }
    }
}
