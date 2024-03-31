<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use App\Models\Dataset;
use App\Models\Notification;
use App\Models\ProductStock;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        //buat custom sesi yang tersimpan
        $is_login = session('is_login') ? session('is_login') : false;
        if(!$is_login){
            //simpan sesi
            session(['is_login' => true]);
            //buat notifikasi login
            $notification = new Notification();
            $notification->title = 'Informasi login';
            $notification->content = 'Anda login pada '.Carbon::now()->format('d F Y H:i:s');
            $notification->type = 'user';
            $notification->user_id = auth()->user()->id;
            $notification->is_read = 0;
            $notification->save();

        }

        return view('manager.dashboard');
    }
}
