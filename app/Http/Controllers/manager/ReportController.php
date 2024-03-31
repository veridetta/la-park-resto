<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Sales;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $data = Sales::whereMonth('date', date('m'))
            ->whereYear('date', date('Y'))
            ->get();
            $month = date('m');
            $year = date('Y');
        return view('manager.report.index', compact('data', 'month', 'year'));
    }

    public function filter(Request $request)
    {

        $month = $request->month;
        $tahun = $request->year;
        $year = Sales::whereMonth('date', $request->month)
            ->whereYear('date', $request->year)
            ->get();
        return view('manager.report.index', compact('data', 'month', 'year'));
    }

    //print
    public function print(Request $request)
    {
        //data where month and year
        $month = $request->month;
        $year = $request->year;
        $data = Sales::whereMonth('date', $request->month)
            ->whereYear('date', $request->year)
            ->get();
        return view('manager.report.print', compact('data', 'month', 'year'));
    }
}
