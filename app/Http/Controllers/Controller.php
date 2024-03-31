<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function chekRole($role)
    {
        if (Auth::user()->role =='admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role =='owner') {
            return redirect()->route('owner.dashboard');
        } else {
            return redirect()->route('login');
        }
    }

    public function profile()
    {
        $data = User::find(Auth::user()->id);
        return view('profile', compact('data'));
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);

        //cek email duplikat
        $cek_email = User::where('email', $request->email)->where('id', '!=', $id)->count();
        if($cek_email > 0){
            return redirect()->route('manager.user.index')->with('message', [
                'success' => false,
                'message' => 'Email sudah digunakan'
            ]);
        }

        $simpan = User::find($id);
        if($request->password){
            $request->validate([
                'password' => 'required',
            ]);
            $simpan->password = bcrypt($request->password);
        }

        $simpan->name = $request->name;
        $simpan->email = $request->email;
        $simpan = $simpan->save();

        if($simpan){
            //simpan notifikasi
            $notif = new Notification();
            $notif->user_id = $id;
            $notif->title = 'Update Profil';
            $notif->content = 'Data Profil berhasil diperbarui';
            $notif->type='user';
            $notif->is_read = 0;
            $notif->save();
            return redirect()->route('profile')->with('message', [
                'success' => true,
                'message' => 'User berhasil diubah'
            ]);
        }else{
            return redirect()->route('profile')->with('message', [
                'success' => false,
                'message' => 'User gagal diubah'
            ]);
        }
    }

    public function notification()
    {
        $data = Notification::where('user_id', Auth::user()->id)->get();
        //update
        Notification::where('user_id', Auth::user()->id)->update(['is_read' => 1]);
        return view('notification', compact('data'));
    }
}
