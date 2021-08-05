<?php
    namespace App\Helpers;

    use Carbon\Carbon;

    /**
     * 
     */
    class CustomTanggal
    {
        
        public static function tgl_indonesia($tgl)
        {
            $dt = new Carbon($tgl);
            setlocale(LC_TIME, 'IND');

            return $dt->formatLocalized('%A, %e %B %Y');
        }

        public static function tgl_indonesia_waktu($tgl)
        {
            $dt = new Carbon($tgl);
            setlocale(LC_TIME, 'IND');

            return $dt->formatLocalized('%A, %e %B %Y %H:%M:%S');
        }
    }