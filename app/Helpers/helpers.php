<?php

if (!function_exists('terbilang')) {
    function terbilang($nilai): string
    {
        return trim(penyebut($nilai));
    }
}

if (!function_exists('penyebut')) {
    function penyebut($nilai): string
    {
        $nilai = abs($nilai);
        $huruf = [
            "", "satu", "dua", "tiga", "empat", "lima", "enam",
            "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"
        ];
        $temp = "";

        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } elseif ($nilai < 20) {
            $temp = penyebut($nilai - 10) . " belas";
        } elseif ($nilai < 100) {
            $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
        } elseif ($nilai < 200) {
            $temp = " seratus" . penyebut($nilai - 100);
        } elseif ($nilai < 1000) {
            $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
        } elseif ($nilai < 2000) {
            $temp = " seribu" . penyebut($nilai - 1000);
        } elseif ($nilai < 1000000) {
            $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
        } elseif ($nilai < 1000000000) {
            $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
        } elseif ($nilai < 1000000000000) {
            $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
        } else {
            $temp = penyebut($nilai / 1000000000000) . " triliun" . penyebut(fmod($nilai, 1000000000000));
        }

        return $temp;
    }
}