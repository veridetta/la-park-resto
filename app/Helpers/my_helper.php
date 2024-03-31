<?php

if (!function_exists('get_my_app_config')) {
    function get_my_app_config($key)
    {
        $config =  [
            'logo'             => 'img/logo.png',
            'favicon'          => 'img/logo.png',
            'hero_bg'          => asset('img/bg/bg3.jpeg'),
            'nama_web'   => 'La-Park Resto',
            'email'            => '',
            'telpon'           => '',
            'alamat'           => '',
            'link_facebook'    => '#',
            'link_twitter'     => '#',
            'link_instagram'   => '#',
            'link_youtube'     => '#',
        ];

        return $config[$key];
    }
}

if (!function_exists('daysToYearMonthDay')) {
    function daysToYearMonthDay($days)
    {
        $years  = floor($days / 365);
        $days -= 365 * $years;
        $months = floor($days / 30);
        $days -= 30 * $months;
        $days   = $days % 30;

        $result = '';

        if ($years > 0) {
            $result .= $years . ' tahun';
        }

        if ($months > 0) {
            if ($result != '') {
                $result .= ' - ';
            }
            $result .= $months . ' bulan';
        }

        if ($days > 0) {
            if ($result != '') {
                $result .= ' - ';
            }
            $result .= $days . ' hari';
        }

        return $result;
    }
}

if (!function_exists('daysToYearMonthDayForForm')) {
    function daysToYearMonthDayForForm($days)
    {
        $years  = floor($days / 365);
        $days -= 365 * $years;
        $months = floor($days / 30);
        $days -= 30 * $months;
        $days   = $days % 30;

        return [
            'year'  => $years,
            'month' => $months,
            'day'   => $days,
        ];
    }
}

if (!function_exists('getIndonesiaMonth')) {
    function getIndonesiaMonth($month)
    {
        $monthText = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];
        return $monthText[(int)$month - 1];
    }
}

if (!function_exists('stockStatus')) {
    function stockStatus($stock,$limit)
    {
        //0 Out of Stock
        // <= $limit = Limited
        // > $limit = Available
        if($stock == 0){
            return '<span class="badge bg-danger">Out of Stock</span>';
        }elseif($stock <= $limit){
            return '<span class="badge bg-warning">Limited</span>';
        }else{
            return '<span class="badge bg-success">Available</span>';
        }
    }
}
//stock warna
if(!function_exists('stockColor')){
    function stockColor($stock,$limit){
        //0 Out of Stock
        // <= $limit = Limited
        // > $limit = Available
        if($stock == 0){
            return '<span class="badge bg-danger">'.$stock.'</span>';
        }elseif($stock <= $limit){
            return '<span class="badge bg-warning">'.$stock.'</span>';
        }else{
            return '<span class="badge bg-success">'.$stock.'</span>';
        }
    }
}
