<?php

use Illuminate\Database\Seeder;

class TimezoneTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('timezone')->delete();
        
        \DB::table('timezone')->insert(array (
            0 => 
            array (
                'country_code' => 'AD',
                'timezone' => 'Europe/Andorra',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            1 => 
            array (
                'country_code' => 'AE',
                'timezone' => 'Asia/Dubai',
                'gmt_offset' => 4.0,
                'dst_offset' => 4.0,
                'raw_offset' => 4.0,
            ),
            2 => 
            array (
                'country_code' => 'AF',
                'timezone' => 'Asia/Kabul',
                'gmt_offset' => 4.5,
                'dst_offset' => 4.5,
                'raw_offset' => 4.5,
            ),
            3 => 
            array (
                'country_code' => 'AG',
                'timezone' => 'America/Antigua',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            4 => 
            array (
                'country_code' => 'AI',
                'timezone' => 'America/Anguilla',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            5 => 
            array (
                'country_code' => 'AL',
                'timezone' => 'Europe/Tirane',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            6 => 
            array (
                'country_code' => 'AM',
                'timezone' => 'Asia/Yerevan',
                'gmt_offset' => 4.0,
                'dst_offset' => 4.0,
                'raw_offset' => 4.0,
            ),
            7 => 
            array (
                'country_code' => 'AO',
                'timezone' => 'Africa/Luanda',
                'gmt_offset' => 1.0,
                'dst_offset' => 1.0,
                'raw_offset' => 1.0,
            ),
            8 => 
            array (
                'country_code' => 'AQ',
                'timezone' => 'Antarctica/Casey',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            9 => 
            array (
                'country_code' => 'AQ',
                'timezone' => 'Antarctica/Davis',
                'gmt_offset' => 7.0,
                'dst_offset' => 7.0,
                'raw_offset' => 7.0,
            ),
            10 => 
            array (
                'country_code' => 'AQ',
                'timezone' => 'Antarctica/DumontDUrville',
                'gmt_offset' => 10.0,
                'dst_offset' => 10.0,
                'raw_offset' => 10.0,
            ),
            11 => 
            array (
                'country_code' => 'AQ',
                'timezone' => 'Antarctica/Mawson',
                'gmt_offset' => 5.0,
                'dst_offset' => 5.0,
                'raw_offset' => 5.0,
            ),
            12 => 
            array (
                'country_code' => 'AQ',
                'timezone' => 'Antarctica/McMurdo',
                'gmt_offset' => 13.0,
                'dst_offset' => 12.0,
                'raw_offset' => 12.0,
            ),
            13 => 
            array (
                'country_code' => 'AQ',
                'timezone' => 'Antarctica/Palmer',
                'gmt_offset' => -3.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            14 => 
            array (
                'country_code' => 'AQ',
                'timezone' => 'Antarctica/Rothera',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            15 => 
            array (
                'country_code' => 'AQ',
                'timezone' => 'Antarctica/South_Pole',
                'gmt_offset' => 13.0,
                'dst_offset' => 12.0,
                'raw_offset' => 12.0,
            ),
            16 => 
            array (
                'country_code' => 'AQ',
                'timezone' => 'Antarctica/Syowa',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            17 => 
            array (
                'country_code' => 'AQ',
                'timezone' => 'Antarctica/Vostok',
                'gmt_offset' => 6.0,
                'dst_offset' => 6.0,
                'raw_offset' => 6.0,
            ),
            18 => 
            array (
                'country_code' => 'AR',
                'timezone' => 'America/Argentina/Buenos_Aires',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            19 => 
            array (
                'country_code' => 'AR',
                'timezone' => 'America/Argentina/Catamarca',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            20 => 
            array (
                'country_code' => 'AR',
                'timezone' => 'America/Argentina/Cordoba',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            21 => 
            array (
                'country_code' => 'AR',
                'timezone' => 'America/Argentina/Jujuy',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            22 => 
            array (
                'country_code' => 'AR',
                'timezone' => 'America/Argentina/La_Rioja',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            23 => 
            array (
                'country_code' => 'AR',
                'timezone' => 'America/Argentina/Mendoza',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            24 => 
            array (
                'country_code' => 'AR',
                'timezone' => 'America/Argentina/Rio_Gallegos',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            25 => 
            array (
                'country_code' => 'AR',
                'timezone' => 'America/Argentina/Salta',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            26 => 
            array (
                'country_code' => 'AR',
                'timezone' => 'America/Argentina/San_Juan',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            27 => 
            array (
                'country_code' => 'AR',
                'timezone' => 'America/Argentina/San_Luis',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            28 => 
            array (
                'country_code' => 'AR',
                'timezone' => 'America/Argentina/Tucuman',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            29 => 
            array (
                'country_code' => 'AR',
                'timezone' => 'America/Argentina/Ushuaia',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            30 => 
            array (
                'country_code' => 'AS',
                'timezone' => 'Pacific/Pago_Pago',
                'gmt_offset' => -11.0,
                'dst_offset' => -11.0,
                'raw_offset' => -11.0,
            ),
            31 => 
            array (
                'country_code' => 'AT',
                'timezone' => 'Europe/Vienna',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            32 => 
            array (
                'country_code' => 'AU',
                'timezone' => 'Antarctica/Macquarie',
                'gmt_offset' => 11.0,
                'dst_offset' => 11.0,
                'raw_offset' => 11.0,
            ),
            33 => 
            array (
                'country_code' => 'AU',
                'timezone' => 'Australia/Adelaide',
                'gmt_offset' => 10.5,
                'dst_offset' => 9.5,
                'raw_offset' => 9.5,
            ),
            34 => 
            array (
                'country_code' => 'AU',
                'timezone' => 'Australia/Brisbane',
                'gmt_offset' => 10.0,
                'dst_offset' => 10.0,
                'raw_offset' => 10.0,
            ),
            35 => 
            array (
                'country_code' => 'AU',
                'timezone' => 'Australia/Broken_Hill',
                'gmt_offset' => 10.5,
                'dst_offset' => 9.5,
                'raw_offset' => 9.5,
            ),
            36 => 
            array (
                'country_code' => 'AU',
                'timezone' => 'Australia/Currie',
                'gmt_offset' => 11.0,
                'dst_offset' => 10.0,
                'raw_offset' => 10.0,
            ),
            37 => 
            array (
                'country_code' => 'AU',
                'timezone' => 'Australia/Darwin',
                'gmt_offset' => 9.5,
                'dst_offset' => 9.5,
                'raw_offset' => 9.5,
            ),
            38 => 
            array (
                'country_code' => 'AU',
                'timezone' => 'Australia/Eucla',
                'gmt_offset' => 8.75,
                'dst_offset' => 8.75,
                'raw_offset' => 8.75,
            ),
            39 => 
            array (
                'country_code' => 'AU',
                'timezone' => 'Australia/Hobart',
                'gmt_offset' => 11.0,
                'dst_offset' => 10.0,
                'raw_offset' => 10.0,
            ),
            40 => 
            array (
                'country_code' => 'AU',
                'timezone' => 'Australia/Lindeman',
                'gmt_offset' => 10.0,
                'dst_offset' => 10.0,
                'raw_offset' => 10.0,
            ),
            41 => 
            array (
                'country_code' => 'AU',
                'timezone' => 'Australia/Lord_Howe',
                'gmt_offset' => 11.0,
                'dst_offset' => 10.5,
                'raw_offset' => 10.5,
            ),
            42 => 
            array (
                'country_code' => 'AU',
                'timezone' => 'Australia/Melbourne',
                'gmt_offset' => 11.0,
                'dst_offset' => 10.0,
                'raw_offset' => 10.0,
            ),
            43 => 
            array (
                'country_code' => 'AU',
                'timezone' => 'Australia/Perth',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            44 => 
            array (
                'country_code' => 'AU',
                'timezone' => 'Australia/Sydney',
                'gmt_offset' => 11.0,
                'dst_offset' => 10.0,
                'raw_offset' => 10.0,
            ),
            45 => 
            array (
                'country_code' => 'AW',
                'timezone' => 'America/Aruba',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            46 => 
            array (
                'country_code' => 'AX',
                'timezone' => 'Europe/Mariehamn',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            47 => 
            array (
                'country_code' => 'AZ',
                'timezone' => 'Asia/Baku',
                'gmt_offset' => 4.0,
                'dst_offset' => 5.0,
                'raw_offset' => 4.0,
            ),
            48 => 
            array (
                'country_code' => 'BA',
                'timezone' => 'Europe/Sarajevo',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            49 => 
            array (
                'country_code' => 'BB',
                'timezone' => 'America/Barbados',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            50 => 
            array (
                'country_code' => 'BD',
                'timezone' => 'Asia/Dhaka',
                'gmt_offset' => 6.0,
                'dst_offset' => 6.0,
                'raw_offset' => 6.0,
            ),
            51 => 
            array (
                'country_code' => 'BE',
                'timezone' => 'Europe/Brussels',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            52 => 
            array (
                'country_code' => 'BF',
                'timezone' => 'Africa/Ouagadougou',
                'gmt_offset' => 0.0,
                'dst_offset' => 0.0,
                'raw_offset' => 0.0,
            ),
            53 => 
            array (
                'country_code' => 'BG',
                'timezone' => 'Europe/Sofia',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            54 => 
            array (
                'country_code' => 'BH',
                'timezone' => 'Asia/Bahrain',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            55 => 
            array (
                'country_code' => 'BI',
                'timezone' => 'Africa/Bujumbura',
                'gmt_offset' => 2.0,
                'dst_offset' => 2.0,
                'raw_offset' => 2.0,
            ),
            56 => 
            array (
                'country_code' => 'BJ',
                'timezone' => 'Africa/Porto-Novo',
                'gmt_offset' => 1.0,
                'dst_offset' => 1.0,
                'raw_offset' => 1.0,
            ),
            57 => 
            array (
                'country_code' => 'BL',
                'timezone' => 'America/St_Barthelemy',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            58 => 
            array (
                'country_code' => 'BM',
                'timezone' => 'Atlantic/Bermuda',
                'gmt_offset' => -4.0,
                'dst_offset' => -3.0,
                'raw_offset' => -4.0,
            ),
            59 => 
            array (
                'country_code' => 'BN',
                'timezone' => 'Asia/Brunei',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            60 => 
            array (
                'country_code' => 'BO',
                'timezone' => 'America/La_Paz',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            61 => 
            array (
                'country_code' => 'BQ',
                'timezone' => 'America/Kralendijk',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            62 => 
            array (
                'country_code' => 'BR',
                'timezone' => 'America/Araguaina',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            63 => 
            array (
                'country_code' => 'BR',
                'timezone' => 'America/Bahia',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            64 => 
            array (
                'country_code' => 'BR',
                'timezone' => 'America/Belem',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            65 => 
            array (
                'country_code' => 'BR',
                'timezone' => 'America/Boa_Vista',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            66 => 
            array (
                'country_code' => 'BR',
                'timezone' => 'America/Campo_Grande',
                'gmt_offset' => -3.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            67 => 
            array (
                'country_code' => 'BR',
                'timezone' => 'America/Cuiaba',
                'gmt_offset' => -3.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            68 => 
            array (
                'country_code' => 'BR',
                'timezone' => 'America/Eirunepe',
                'gmt_offset' => -5.0,
                'dst_offset' => -5.0,
                'raw_offset' => -5.0,
            ),
            69 => 
            array (
                'country_code' => 'BR',
                'timezone' => 'America/Fortaleza',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            70 => 
            array (
                'country_code' => 'BR',
                'timezone' => 'America/Maceio',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            71 => 
            array (
                'country_code' => 'BR',
                'timezone' => 'America/Manaus',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            72 => 
            array (
                'country_code' => 'BR',
                'timezone' => 'America/Noronha',
                'gmt_offset' => -2.0,
                'dst_offset' => -2.0,
                'raw_offset' => -2.0,
            ),
            73 => 
            array (
                'country_code' => 'BR',
                'timezone' => 'America/Porto_Velho',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            74 => 
            array (
                'country_code' => 'BR',
                'timezone' => 'America/Recife',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            75 => 
            array (
                'country_code' => 'BR',
                'timezone' => 'America/Rio_Branco',
                'gmt_offset' => -5.0,
                'dst_offset' => -5.0,
                'raw_offset' => -5.0,
            ),
            76 => 
            array (
                'country_code' => 'BR',
                'timezone' => 'America/Santarem',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            77 => 
            array (
                'country_code' => 'BR',
                'timezone' => 'America/Sao_Paulo',
                'gmt_offset' => -2.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            78 => 
            array (
                'country_code' => 'BS',
                'timezone' => 'America/Nassau',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            79 => 
            array (
                'country_code' => 'BT',
                'timezone' => 'Asia/Thimphu',
                'gmt_offset' => 6.0,
                'dst_offset' => 6.0,
                'raw_offset' => 6.0,
            ),
            80 => 
            array (
                'country_code' => 'BW',
                'timezone' => 'Africa/Gaborone',
                'gmt_offset' => 2.0,
                'dst_offset' => 2.0,
                'raw_offset' => 2.0,
            ),
            81 => 
            array (
                'country_code' => 'BY',
                'timezone' => 'Europe/Minsk',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            82 => 
            array (
                'country_code' => 'BZ',
                'timezone' => 'America/Belize',
                'gmt_offset' => -6.0,
                'dst_offset' => -6.0,
                'raw_offset' => -6.0,
            ),
            83 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Atikokan',
                'gmt_offset' => -5.0,
                'dst_offset' => -5.0,
                'raw_offset' => -5.0,
            ),
            84 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Blanc-Sablon',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            85 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Cambridge_Bay',
                'gmt_offset' => -7.0,
                'dst_offset' => -6.0,
                'raw_offset' => -7.0,
            ),
            86 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Creston',
                'gmt_offset' => -7.0,
                'dst_offset' => -7.0,
                'raw_offset' => -7.0,
            ),
            87 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Dawson',
                'gmt_offset' => -8.0,
                'dst_offset' => -7.0,
                'raw_offset' => -8.0,
            ),
            88 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Dawson_Creek',
                'gmt_offset' => -7.0,
                'dst_offset' => -7.0,
                'raw_offset' => -7.0,
            ),
            89 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Edmonton',
                'gmt_offset' => -7.0,
                'dst_offset' => -6.0,
                'raw_offset' => -7.0,
            ),
            90 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Glace_Bay',
                'gmt_offset' => -4.0,
                'dst_offset' => -3.0,
                'raw_offset' => -4.0,
            ),
            91 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Goose_Bay',
                'gmt_offset' => -4.0,
                'dst_offset' => -3.0,
                'raw_offset' => -4.0,
            ),
            92 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Halifax',
                'gmt_offset' => -4.0,
                'dst_offset' => -3.0,
                'raw_offset' => -4.0,
            ),
            93 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Inuvik',
                'gmt_offset' => -7.0,
                'dst_offset' => -6.0,
                'raw_offset' => -7.0,
            ),
            94 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Iqaluit',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            95 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Moncton',
                'gmt_offset' => -4.0,
                'dst_offset' => -3.0,
                'raw_offset' => -4.0,
            ),
            96 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Montreal',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            97 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Nipigon',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            98 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Pangnirtung',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            99 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Rainy_River',
                'gmt_offset' => -6.0,
                'dst_offset' => -5.0,
                'raw_offset' => -6.0,
            ),
            100 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Rankin_Inlet',
                'gmt_offset' => -6.0,
                'dst_offset' => -5.0,
                'raw_offset' => -6.0,
            ),
            101 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Regina',
                'gmt_offset' => -6.0,
                'dst_offset' => -6.0,
                'raw_offset' => -6.0,
            ),
            102 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Resolute',
                'gmt_offset' => -6.0,
                'dst_offset' => -5.0,
                'raw_offset' => -6.0,
            ),
            103 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/St_Johns',
                'gmt_offset' => -3.5,
                'dst_offset' => -2.5,
                'raw_offset' => -3.5,
            ),
            104 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Swift_Current',
                'gmt_offset' => -6.0,
                'dst_offset' => -6.0,
                'raw_offset' => -6.0,
            ),
            105 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Thunder_Bay',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            106 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Toronto',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            107 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Vancouver',
                'gmt_offset' => -8.0,
                'dst_offset' => -7.0,
                'raw_offset' => -8.0,
            ),
            108 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Whitehorse',
                'gmt_offset' => -8.0,
                'dst_offset' => -7.0,
                'raw_offset' => -8.0,
            ),
            109 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Winnipeg',
                'gmt_offset' => -6.0,
                'dst_offset' => -5.0,
                'raw_offset' => -6.0,
            ),
            110 => 
            array (
                'country_code' => 'CA',
                'timezone' => 'America/Yellowknife',
                'gmt_offset' => -7.0,
                'dst_offset' => -6.0,
                'raw_offset' => -7.0,
            ),
            111 => 
            array (
                'country_code' => 'CC',
                'timezone' => 'Indian/Cocos',
                'gmt_offset' => 6.5,
                'dst_offset' => 6.5,
                'raw_offset' => 6.5,
            ),
            112 => 
            array (
                'country_code' => 'CD',
                'timezone' => 'Africa/Kinshasa',
                'gmt_offset' => 1.0,
                'dst_offset' => 1.0,
                'raw_offset' => 1.0,
            ),
            113 => 
            array (
                'country_code' => 'CD',
                'timezone' => 'Africa/Lubumbashi',
                'gmt_offset' => 2.0,
                'dst_offset' => 2.0,
                'raw_offset' => 2.0,
            ),
            114 => 
            array (
                'country_code' => 'CF',
                'timezone' => 'Africa/Bangui',
                'gmt_offset' => 1.0,
                'dst_offset' => 1.0,
                'raw_offset' => 1.0,
            ),
            115 => 
            array (
                'country_code' => 'CG',
                'timezone' => 'Africa/Brazzaville',
                'gmt_offset' => 1.0,
                'dst_offset' => 1.0,
                'raw_offset' => 1.0,
            ),
            116 => 
            array (
                'country_code' => 'CH',
                'timezone' => 'Europe/Zurich',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            117 => 
            array (
                'country_code' => 'CI',
                'timezone' => 'Africa/Abidjan',
                'gmt_offset' => 0.0,
                'dst_offset' => 0.0,
                'raw_offset' => 0.0,
            ),
            118 => 
            array (
                'country_code' => 'CK',
                'timezone' => 'Pacific/Rarotonga',
                'gmt_offset' => -10.0,
                'dst_offset' => -10.0,
                'raw_offset' => -10.0,
            ),
            119 => 
            array (
                'country_code' => 'CL',
                'timezone' => 'America/Santiago',
                'gmt_offset' => -3.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            120 => 
            array (
                'country_code' => 'CL',
                'timezone' => 'Pacific/Easter',
                'gmt_offset' => -5.0,
                'dst_offset' => -6.0,
                'raw_offset' => -6.0,
            ),
            121 => 
            array (
                'country_code' => 'CM',
                'timezone' => 'Africa/Douala',
                'gmt_offset' => 1.0,
                'dst_offset' => 1.0,
                'raw_offset' => 1.0,
            ),
            122 => 
            array (
                'country_code' => 'CN',
                'timezone' => 'Asia/Chongqing',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            123 => 
            array (
                'country_code' => 'CN',
                'timezone' => 'Asia/Harbin',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            124 => 
            array (
                'country_code' => 'CN',
                'timezone' => 'Asia/Kashgar',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            125 => 
            array (
                'country_code' => 'CN',
                'timezone' => 'Asia/Shanghai',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            126 => 
            array (
                'country_code' => 'CN',
                'timezone' => 'Asia/Urumqi',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            127 => 
            array (
                'country_code' => 'CO',
                'timezone' => 'America/Bogota',
                'gmt_offset' => -5.0,
                'dst_offset' => -5.0,
                'raw_offset' => -5.0,
            ),
            128 => 
            array (
                'country_code' => 'CR',
                'timezone' => 'America/Costa_Rica',
                'gmt_offset' => -6.0,
                'dst_offset' => -6.0,
                'raw_offset' => -6.0,
            ),
            129 => 
            array (
                'country_code' => 'CU',
                'timezone' => 'America/Havana',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            130 => 
            array (
                'country_code' => 'CV',
                'timezone' => 'Atlantic/Cape_Verde',
                'gmt_offset' => -1.0,
                'dst_offset' => -1.0,
                'raw_offset' => -1.0,
            ),
            131 => 
            array (
                'country_code' => 'CW',
                'timezone' => 'America/Curacao',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            132 => 
            array (
                'country_code' => 'CX',
                'timezone' => 'Indian/Christmas',
                'gmt_offset' => 7.0,
                'dst_offset' => 7.0,
                'raw_offset' => 7.0,
            ),
            133 => 
            array (
                'country_code' => 'CY',
                'timezone' => 'Asia/Nicosia',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            134 => 
            array (
                'country_code' => 'CZ',
                'timezone' => 'Europe/Prague',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            135 => 
            array (
                'country_code' => 'DE',
                'timezone' => 'Europe/Berlin',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            136 => 
            array (
                'country_code' => 'DE',
                'timezone' => 'Europe/Busingen',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            137 => 
            array (
                'country_code' => 'DJ',
                'timezone' => 'Africa/Djibouti',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            138 => 
            array (
                'country_code' => 'DK',
                'timezone' => 'Europe/Copenhagen',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            139 => 
            array (
                'country_code' => 'DM',
                'timezone' => 'America/Dominica',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            140 => 
            array (
                'country_code' => 'DO',
                'timezone' => 'America/Santo_Domingo',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            141 => 
            array (
                'country_code' => 'DZ',
                'timezone' => 'Africa/Algiers',
                'gmt_offset' => 1.0,
                'dst_offset' => 1.0,
                'raw_offset' => 1.0,
            ),
            142 => 
            array (
                'country_code' => 'EC',
                'timezone' => 'America/Guayaquil',
                'gmt_offset' => -5.0,
                'dst_offset' => -5.0,
                'raw_offset' => -5.0,
            ),
            143 => 
            array (
                'country_code' => 'EC',
                'timezone' => 'Pacific/Galapagos',
                'gmt_offset' => -6.0,
                'dst_offset' => -6.0,
                'raw_offset' => -6.0,
            ),
            144 => 
            array (
                'country_code' => 'EE',
                'timezone' => 'Europe/Tallinn',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            145 => 
            array (
                'country_code' => 'EG',
                'timezone' => 'Africa/Cairo',
                'gmt_offset' => 2.0,
                'dst_offset' => 2.0,
                'raw_offset' => 2.0,
            ),
            146 => 
            array (
                'country_code' => 'EH',
                'timezone' => 'Africa/El_Aaiun',
                'gmt_offset' => 0.0,
                'dst_offset' => 0.0,
                'raw_offset' => 0.0,
            ),
            147 => 
            array (
                'country_code' => 'ER',
                'timezone' => 'Africa/Asmara',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            148 => 
            array (
                'country_code' => 'ES',
                'timezone' => 'Africa/Ceuta',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            149 => 
            array (
                'country_code' => 'ES',
                'timezone' => 'Atlantic/Canary',
                'gmt_offset' => 0.0,
                'dst_offset' => 1.0,
                'raw_offset' => 0.0,
            ),
            150 => 
            array (
                'country_code' => 'ES',
                'timezone' => 'Europe/Madrid',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            151 => 
            array (
                'country_code' => 'ET',
                'timezone' => 'Africa/Addis_Ababa',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            152 => 
            array (
                'country_code' => 'FI',
                'timezone' => 'Europe/Helsinki',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            153 => 
            array (
                'country_code' => 'FJ',
                'timezone' => 'Pacific/Fiji',
                'gmt_offset' => 13.0,
                'dst_offset' => 12.0,
                'raw_offset' => 12.0,
            ),
            154 => 
            array (
                'country_code' => 'FK',
                'timezone' => 'Atlantic/Stanley',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            155 => 
            array (
                'country_code' => 'FM',
                'timezone' => 'Pacific/Chuuk',
                'gmt_offset' => 10.0,
                'dst_offset' => 10.0,
                'raw_offset' => 10.0,
            ),
            156 => 
            array (
                'country_code' => 'FM',
                'timezone' => 'Pacific/Kosrae',
                'gmt_offset' => 11.0,
                'dst_offset' => 11.0,
                'raw_offset' => 11.0,
            ),
            157 => 
            array (
                'country_code' => 'FM',
                'timezone' => 'Pacific/Pohnpei',
                'gmt_offset' => 11.0,
                'dst_offset' => 11.0,
                'raw_offset' => 11.0,
            ),
            158 => 
            array (
                'country_code' => 'FO',
                'timezone' => 'Atlantic/Faroe',
                'gmt_offset' => 0.0,
                'dst_offset' => 1.0,
                'raw_offset' => 0.0,
            ),
            159 => 
            array (
                'country_code' => 'FR',
                'timezone' => 'Europe/Paris',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            160 => 
            array (
                'country_code' => 'GA',
                'timezone' => 'Africa/Libreville',
                'gmt_offset' => 1.0,
                'dst_offset' => 1.0,
                'raw_offset' => 1.0,
            ),
            161 => 
            array (
                'country_code' => 'GB',
                'timezone' => 'Europe/London',
                'gmt_offset' => 0.0,
                'dst_offset' => 1.0,
                'raw_offset' => 0.0,
            ),
            162 => 
            array (
                'country_code' => 'GD',
                'timezone' => 'America/Grenada',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            163 => 
            array (
                'country_code' => 'GE',
                'timezone' => 'Asia/Tbilisi',
                'gmt_offset' => 4.0,
                'dst_offset' => 4.0,
                'raw_offset' => 4.0,
            ),
            164 => 
            array (
                'country_code' => 'GF',
                'timezone' => 'America/Cayenne',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            165 => 
            array (
                'country_code' => 'GG',
                'timezone' => 'Europe/Guernsey',
                'gmt_offset' => 0.0,
                'dst_offset' => 1.0,
                'raw_offset' => 0.0,
            ),
            166 => 
            array (
                'country_code' => 'GH',
                'timezone' => 'Africa/Accra',
                'gmt_offset' => 0.0,
                'dst_offset' => 0.0,
                'raw_offset' => 0.0,
            ),
            167 => 
            array (
                'country_code' => 'GI',
                'timezone' => 'Europe/Gibraltar',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            168 => 
            array (
                'country_code' => 'GL',
                'timezone' => 'America/Danmarkshavn',
                'gmt_offset' => 0.0,
                'dst_offset' => 0.0,
                'raw_offset' => 0.0,
            ),
            169 => 
            array (
                'country_code' => 'GL',
                'timezone' => 'America/Godthab',
                'gmt_offset' => -3.0,
                'dst_offset' => -2.0,
                'raw_offset' => -3.0,
            ),
            170 => 
            array (
                'country_code' => 'GL',
                'timezone' => 'America/Scoresbysund',
                'gmt_offset' => -1.0,
                'dst_offset' => 0.0,
                'raw_offset' => -1.0,
            ),
            171 => 
            array (
                'country_code' => 'GL',
                'timezone' => 'America/Thule',
                'gmt_offset' => -4.0,
                'dst_offset' => -3.0,
                'raw_offset' => -4.0,
            ),
            172 => 
            array (
                'country_code' => 'GM',
                'timezone' => 'Africa/Banjul',
                'gmt_offset' => 0.0,
                'dst_offset' => 0.0,
                'raw_offset' => 0.0,
            ),
            173 => 
            array (
                'country_code' => 'GN',
                'timezone' => 'Africa/Conakry',
                'gmt_offset' => 0.0,
                'dst_offset' => 0.0,
                'raw_offset' => 0.0,
            ),
            174 => 
            array (
                'country_code' => 'GP',
                'timezone' => 'America/Guadeloupe',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            175 => 
            array (
                'country_code' => 'GQ',
                'timezone' => 'Africa/Malabo',
                'gmt_offset' => 1.0,
                'dst_offset' => 1.0,
                'raw_offset' => 1.0,
            ),
            176 => 
            array (
                'country_code' => 'GR',
                'timezone' => 'Europe/Athens',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            177 => 
            array (
                'country_code' => 'GS',
                'timezone' => 'Atlantic/South_Georgia',
                'gmt_offset' => -2.0,
                'dst_offset' => -2.0,
                'raw_offset' => -2.0,
            ),
            178 => 
            array (
                'country_code' => 'GT',
                'timezone' => 'America/Guatemala',
                'gmt_offset' => -6.0,
                'dst_offset' => -6.0,
                'raw_offset' => -6.0,
            ),
            179 => 
            array (
                'country_code' => 'GU',
                'timezone' => 'Pacific/Guam',
                'gmt_offset' => 10.0,
                'dst_offset' => 10.0,
                'raw_offset' => 10.0,
            ),
            180 => 
            array (
                'country_code' => 'GW',
                'timezone' => 'Africa/Bissau',
                'gmt_offset' => 0.0,
                'dst_offset' => 0.0,
                'raw_offset' => 0.0,
            ),
            181 => 
            array (
                'country_code' => 'GY',
                'timezone' => 'America/Guyana',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            182 => 
            array (
                'country_code' => 'HK',
                'timezone' => 'Asia/Hong_Kong',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            183 => 
            array (
                'country_code' => 'HN',
                'timezone' => 'America/Tegucigalpa',
                'gmt_offset' => -6.0,
                'dst_offset' => -6.0,
                'raw_offset' => -6.0,
            ),
            184 => 
            array (
                'country_code' => 'HR',
                'timezone' => 'Europe/Zagreb',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            185 => 
            array (
                'country_code' => 'HT',
                'timezone' => 'America/Port-au-Prince',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            186 => 
            array (
                'country_code' => 'HU',
                'timezone' => 'Europe/Budapest',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            187 => 
            array (
                'country_code' => 'ID',
                'timezone' => 'Asia/Jakarta',
                'gmt_offset' => 7.0,
                'dst_offset' => 7.0,
                'raw_offset' => 7.0,
            ),
            188 => 
            array (
                'country_code' => 'ID',
                'timezone' => 'Asia/Jayapura',
                'gmt_offset' => 9.0,
                'dst_offset' => 9.0,
                'raw_offset' => 9.0,
            ),
            189 => 
            array (
                'country_code' => 'ID',
                'timezone' => 'Asia/Makassar',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            190 => 
            array (
                'country_code' => 'ID',
                'timezone' => 'Asia/Pontianak',
                'gmt_offset' => 7.0,
                'dst_offset' => 7.0,
                'raw_offset' => 7.0,
            ),
            191 => 
            array (
                'country_code' => 'IE',
                'timezone' => 'Europe/Dublin',
                'gmt_offset' => 0.0,
                'dst_offset' => 1.0,
                'raw_offset' => 0.0,
            ),
            192 => 
            array (
                'country_code' => 'IL',
                'timezone' => 'Asia/Jerusalem',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            193 => 
            array (
                'country_code' => 'IM',
                'timezone' => 'Europe/Isle_of_Man',
                'gmt_offset' => 0.0,
                'dst_offset' => 1.0,
                'raw_offset' => 0.0,
            ),
            194 => 
            array (
                'country_code' => 'IN',
                'timezone' => 'Asia/Kolkata',
                'gmt_offset' => 5.5,
                'dst_offset' => 5.5,
                'raw_offset' => 5.5,
            ),
            195 => 
            array (
                'country_code' => 'IO',
                'timezone' => 'Indian/Chagos',
                'gmt_offset' => 6.0,
                'dst_offset' => 6.0,
                'raw_offset' => 6.0,
            ),
            196 => 
            array (
                'country_code' => 'IQ',
                'timezone' => 'Asia/Baghdad',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            197 => 
            array (
                'country_code' => 'IR',
                'timezone' => 'Asia/Tehran',
                'gmt_offset' => 3.5,
                'dst_offset' => 4.5,
                'raw_offset' => 3.5,
            ),
            198 => 
            array (
                'country_code' => 'IS',
                'timezone' => 'Atlantic/Reykjavik',
                'gmt_offset' => 0.0,
                'dst_offset' => 0.0,
                'raw_offset' => 0.0,
            ),
            199 => 
            array (
                'country_code' => 'IT',
                'timezone' => 'Europe/Rome',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            200 => 
            array (
                'country_code' => 'JE',
                'timezone' => 'Europe/Jersey',
                'gmt_offset' => 0.0,
                'dst_offset' => 1.0,
                'raw_offset' => 0.0,
            ),
            201 => 
            array (
                'country_code' => 'JM',
                'timezone' => 'America/Jamaica',
                'gmt_offset' => -5.0,
                'dst_offset' => -5.0,
                'raw_offset' => -5.0,
            ),
            202 => 
            array (
                'country_code' => 'JO',
                'timezone' => 'Asia/Amman',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            203 => 
            array (
                'country_code' => 'JP',
                'timezone' => 'Asia/Tokyo',
                'gmt_offset' => 9.0,
                'dst_offset' => 9.0,
                'raw_offset' => 9.0,
            ),
            204 => 
            array (
                'country_code' => 'KE',
                'timezone' => 'Africa/Nairobi',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            205 => 
            array (
                'country_code' => 'KG',
                'timezone' => 'Asia/Bishkek',
                'gmt_offset' => 6.0,
                'dst_offset' => 6.0,
                'raw_offset' => 6.0,
            ),
            206 => 
            array (
                'country_code' => 'KH',
                'timezone' => 'Asia/Phnom_Penh',
                'gmt_offset' => 7.0,
                'dst_offset' => 7.0,
                'raw_offset' => 7.0,
            ),
            207 => 
            array (
                'country_code' => 'KI',
                'timezone' => 'Pacific/Enderbury',
                'gmt_offset' => 13.0,
                'dst_offset' => 13.0,
                'raw_offset' => 13.0,
            ),
            208 => 
            array (
                'country_code' => 'KI',
                'timezone' => 'Pacific/Kiritimati',
                'gmt_offset' => 14.0,
                'dst_offset' => 14.0,
                'raw_offset' => 14.0,
            ),
            209 => 
            array (
                'country_code' => 'KI',
                'timezone' => 'Pacific/Tarawa',
                'gmt_offset' => 12.0,
                'dst_offset' => 12.0,
                'raw_offset' => 12.0,
            ),
            210 => 
            array (
                'country_code' => 'KM',
                'timezone' => 'Indian/Comoro',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            211 => 
            array (
                'country_code' => 'KN',
                'timezone' => 'America/St_Kitts',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            212 => 
            array (
                'country_code' => 'KP',
                'timezone' => 'Asia/Pyongyang',
                'gmt_offset' => 9.0,
                'dst_offset' => 9.0,
                'raw_offset' => 9.0,
            ),
            213 => 
            array (
                'country_code' => 'KR',
                'timezone' => 'Asia/Seoul',
                'gmt_offset' => 9.0,
                'dst_offset' => 9.0,
                'raw_offset' => 9.0,
            ),
            214 => 
            array (
                'country_code' => 'KW',
                'timezone' => 'Asia/Kuwait',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            215 => 
            array (
                'country_code' => 'KY',
                'timezone' => 'America/Cayman',
                'gmt_offset' => -5.0,
                'dst_offset' => -5.0,
                'raw_offset' => -5.0,
            ),
            216 => 
            array (
                'country_code' => 'KZ',
                'timezone' => 'Asia/Almaty',
                'gmt_offset' => 6.0,
                'dst_offset' => 6.0,
                'raw_offset' => 6.0,
            ),
            217 => 
            array (
                'country_code' => 'KZ',
                'timezone' => 'Asia/Aqtau',
                'gmt_offset' => 5.0,
                'dst_offset' => 5.0,
                'raw_offset' => 5.0,
            ),
            218 => 
            array (
                'country_code' => 'KZ',
                'timezone' => 'Asia/Aqtobe',
                'gmt_offset' => 5.0,
                'dst_offset' => 5.0,
                'raw_offset' => 5.0,
            ),
            219 => 
            array (
                'country_code' => 'KZ',
                'timezone' => 'Asia/Oral',
                'gmt_offset' => 5.0,
                'dst_offset' => 5.0,
                'raw_offset' => 5.0,
            ),
            220 => 
            array (
                'country_code' => 'KZ',
                'timezone' => 'Asia/Qyzylorda',
                'gmt_offset' => 6.0,
                'dst_offset' => 6.0,
                'raw_offset' => 6.0,
            ),
            221 => 
            array (
                'country_code' => 'LA',
                'timezone' => 'Asia/Vientiane',
                'gmt_offset' => 7.0,
                'dst_offset' => 7.0,
                'raw_offset' => 7.0,
            ),
            222 => 
            array (
                'country_code' => 'LB',
                'timezone' => 'Asia/Beirut',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            223 => 
            array (
                'country_code' => 'LC',
                'timezone' => 'America/St_Lucia',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            224 => 
            array (
                'country_code' => 'LI',
                'timezone' => 'Europe/Vaduz',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            225 => 
            array (
                'country_code' => 'LK',
                'timezone' => 'Asia/Colombo',
                'gmt_offset' => 5.5,
                'dst_offset' => 5.5,
                'raw_offset' => 5.5,
            ),
            226 => 
            array (
                'country_code' => 'LR',
                'timezone' => 'Africa/Monrovia',
                'gmt_offset' => 0.0,
                'dst_offset' => 0.0,
                'raw_offset' => 0.0,
            ),
            227 => 
            array (
                'country_code' => 'LS',
                'timezone' => 'Africa/Maseru',
                'gmt_offset' => 2.0,
                'dst_offset' => 2.0,
                'raw_offset' => 2.0,
            ),
            228 => 
            array (
                'country_code' => 'LT',
                'timezone' => 'Europe/Vilnius',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            229 => 
            array (
                'country_code' => 'LU',
                'timezone' => 'Europe/Luxembourg',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            230 => 
            array (
                'country_code' => 'LV',
                'timezone' => 'Europe/Riga',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            231 => 
            array (
                'country_code' => 'LY',
                'timezone' => 'Africa/Tripoli',
                'gmt_offset' => 2.0,
                'dst_offset' => 2.0,
                'raw_offset' => 2.0,
            ),
            232 => 
            array (
                'country_code' => 'MA',
                'timezone' => 'Africa/Casablanca',
                'gmt_offset' => 0.0,
                'dst_offset' => 0.0,
                'raw_offset' => 0.0,
            ),
            233 => 
            array (
                'country_code' => 'MC',
                'timezone' => 'Europe/Monaco',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            234 => 
            array (
                'country_code' => 'MD',
                'timezone' => 'Europe/Chisinau',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            235 => 
            array (
                'country_code' => 'ME',
                'timezone' => 'Europe/Podgorica',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            236 => 
            array (
                'country_code' => 'MF',
                'timezone' => 'America/Marigot',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            237 => 
            array (
                'country_code' => 'MG',
                'timezone' => 'Indian/Antananarivo',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            238 => 
            array (
                'country_code' => 'MH',
                'timezone' => 'Pacific/Kwajalein',
                'gmt_offset' => 12.0,
                'dst_offset' => 12.0,
                'raw_offset' => 12.0,
            ),
            239 => 
            array (
                'country_code' => 'MH',
                'timezone' => 'Pacific/Majuro',
                'gmt_offset' => 12.0,
                'dst_offset' => 12.0,
                'raw_offset' => 12.0,
            ),
            240 => 
            array (
                'country_code' => 'MK',
                'timezone' => 'Europe/Skopje',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            241 => 
            array (
                'country_code' => 'ML',
                'timezone' => 'Africa/Bamako',
                'gmt_offset' => 0.0,
                'dst_offset' => 0.0,
                'raw_offset' => 0.0,
            ),
            242 => 
            array (
                'country_code' => 'MM',
                'timezone' => 'Asia/Rangoon',
                'gmt_offset' => 6.5,
                'dst_offset' => 6.5,
                'raw_offset' => 6.5,
            ),
            243 => 
            array (
                'country_code' => 'MN',
                'timezone' => 'Asia/Choibalsan',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            244 => 
            array (
                'country_code' => 'MN',
                'timezone' => 'Asia/Hovd',
                'gmt_offset' => 7.0,
                'dst_offset' => 7.0,
                'raw_offset' => 7.0,
            ),
            245 => 
            array (
                'country_code' => 'MN',
                'timezone' => 'Asia/Ulaanbaatar',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            246 => 
            array (
                'country_code' => 'MO',
                'timezone' => 'Asia/Macau',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            247 => 
            array (
                'country_code' => 'MP',
                'timezone' => 'Pacific/Saipan',
                'gmt_offset' => 10.0,
                'dst_offset' => 10.0,
                'raw_offset' => 10.0,
            ),
            248 => 
            array (
                'country_code' => 'MQ',
                'timezone' => 'America/Martinique',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            249 => 
            array (
                'country_code' => 'MR',
                'timezone' => 'Africa/Nouakchott',
                'gmt_offset' => 0.0,
                'dst_offset' => 0.0,
                'raw_offset' => 0.0,
            ),
            250 => 
            array (
                'country_code' => 'MS',
                'timezone' => 'America/Montserrat',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            251 => 
            array (
                'country_code' => 'MT',
                'timezone' => 'Europe/Malta',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            252 => 
            array (
                'country_code' => 'MU',
                'timezone' => 'Indian/Mauritius',
                'gmt_offset' => 4.0,
                'dst_offset' => 4.0,
                'raw_offset' => 4.0,
            ),
            253 => 
            array (
                'country_code' => 'MV',
                'timezone' => 'Indian/Maldives',
                'gmt_offset' => 5.0,
                'dst_offset' => 5.0,
                'raw_offset' => 5.0,
            ),
            254 => 
            array (
                'country_code' => 'MW',
                'timezone' => 'Africa/Blantyre',
                'gmt_offset' => 2.0,
                'dst_offset' => 2.0,
                'raw_offset' => 2.0,
            ),
            255 => 
            array (
                'country_code' => 'MX',
                'timezone' => 'America/Bahia_Banderas',
                'gmt_offset' => -6.0,
                'dst_offset' => -5.0,
                'raw_offset' => -6.0,
            ),
            256 => 
            array (
                'country_code' => 'MX',
                'timezone' => 'America/Cancun',
                'gmt_offset' => -6.0,
                'dst_offset' => -5.0,
                'raw_offset' => -6.0,
            ),
            257 => 
            array (
                'country_code' => 'MX',
                'timezone' => 'America/Chihuahua',
                'gmt_offset' => -7.0,
                'dst_offset' => -6.0,
                'raw_offset' => -7.0,
            ),
            258 => 
            array (
                'country_code' => 'MX',
                'timezone' => 'America/Hermosillo',
                'gmt_offset' => -7.0,
                'dst_offset' => -7.0,
                'raw_offset' => -7.0,
            ),
            259 => 
            array (
                'country_code' => 'MX',
                'timezone' => 'America/Matamoros',
                'gmt_offset' => -6.0,
                'dst_offset' => -5.0,
                'raw_offset' => -6.0,
            ),
            260 => 
            array (
                'country_code' => 'MX',
                'timezone' => 'America/Mazatlan',
                'gmt_offset' => -7.0,
                'dst_offset' => -6.0,
                'raw_offset' => -7.0,
            ),
            261 => 
            array (
                'country_code' => 'MX',
                'timezone' => 'America/Merida',
                'gmt_offset' => -6.0,
                'dst_offset' => -5.0,
                'raw_offset' => -6.0,
            ),
            262 => 
            array (
                'country_code' => 'MX',
                'timezone' => 'America/Mexico_City',
                'gmt_offset' => -6.0,
                'dst_offset' => -5.0,
                'raw_offset' => -6.0,
            ),
            263 => 
            array (
                'country_code' => 'MX',
                'timezone' => 'America/Monterrey',
                'gmt_offset' => -6.0,
                'dst_offset' => -5.0,
                'raw_offset' => -6.0,
            ),
            264 => 
            array (
                'country_code' => 'MX',
                'timezone' => 'America/Ojinaga',
                'gmt_offset' => -7.0,
                'dst_offset' => -6.0,
                'raw_offset' => -7.0,
            ),
            265 => 
            array (
                'country_code' => 'MX',
                'timezone' => 'America/Santa_Isabel',
                'gmt_offset' => -8.0,
                'dst_offset' => -7.0,
                'raw_offset' => -8.0,
            ),
            266 => 
            array (
                'country_code' => 'MX',
                'timezone' => 'America/Tijuana',
                'gmt_offset' => -8.0,
                'dst_offset' => -7.0,
                'raw_offset' => -8.0,
            ),
            267 => 
            array (
                'country_code' => 'MY',
                'timezone' => 'Asia/Kuala_Lumpur',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            268 => 
            array (
                'country_code' => 'MY',
                'timezone' => 'Asia/Kuching',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            269 => 
            array (
                'country_code' => 'MZ',
                'timezone' => 'Africa/Maputo',
                'gmt_offset' => 2.0,
                'dst_offset' => 2.0,
                'raw_offset' => 2.0,
            ),
            270 => 
            array (
                'country_code' => 'NA',
                'timezone' => 'Africa/Windhoek',
                'gmt_offset' => 2.0,
                'dst_offset' => 1.0,
                'raw_offset' => 1.0,
            ),
            271 => 
            array (
                'country_code' => 'NC',
                'timezone' => 'Pacific/Noumea',
                'gmt_offset' => 11.0,
                'dst_offset' => 11.0,
                'raw_offset' => 11.0,
            ),
            272 => 
            array (
                'country_code' => 'NE',
                'timezone' => 'Africa/Niamey',
                'gmt_offset' => 1.0,
                'dst_offset' => 1.0,
                'raw_offset' => 1.0,
            ),
            273 => 
            array (
                'country_code' => 'NF',
                'timezone' => 'Pacific/Norfolk',
                'gmt_offset' => 11.5,
                'dst_offset' => 11.5,
                'raw_offset' => 11.5,
            ),
            274 => 
            array (
                'country_code' => 'NG',
                'timezone' => 'Africa/Lagos',
                'gmt_offset' => 1.0,
                'dst_offset' => 1.0,
                'raw_offset' => 1.0,
            ),
            275 => 
            array (
                'country_code' => 'NI',
                'timezone' => 'America/Managua',
                'gmt_offset' => -6.0,
                'dst_offset' => -6.0,
                'raw_offset' => -6.0,
            ),
            276 => 
            array (
                'country_code' => 'NL',
                'timezone' => 'Europe/Amsterdam',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            277 => 
            array (
                'country_code' => 'NO',
                'timezone' => 'Europe/Oslo',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            278 => 
            array (
                'country_code' => 'NP',
                'timezone' => 'Asia/Kathmandu',
                'gmt_offset' => 5.75,
                'dst_offset' => 5.75,
                'raw_offset' => 5.75,
            ),
            279 => 
            array (
                'country_code' => 'NR',
                'timezone' => 'Pacific/Nauru',
                'gmt_offset' => 12.0,
                'dst_offset' => 12.0,
                'raw_offset' => 12.0,
            ),
            280 => 
            array (
                'country_code' => 'NU',
                'timezone' => 'Pacific/Niue',
                'gmt_offset' => -11.0,
                'dst_offset' => -11.0,
                'raw_offset' => -11.0,
            ),
            281 => 
            array (
                'country_code' => 'NZ',
                'timezone' => 'Pacific/Auckland',
                'gmt_offset' => 13.0,
                'dst_offset' => 12.0,
                'raw_offset' => 12.0,
            ),
            282 => 
            array (
                'country_code' => 'NZ',
                'timezone' => 'Pacific/Chatham',
                'gmt_offset' => 13.75,
                'dst_offset' => 12.75,
                'raw_offset' => 12.75,
            ),
            283 => 
            array (
                'country_code' => 'OM',
                'timezone' => 'Asia/Muscat',
                'gmt_offset' => 4.0,
                'dst_offset' => 4.0,
                'raw_offset' => 4.0,
            ),
            284 => 
            array (
                'country_code' => 'PA',
                'timezone' => 'America/Panama',
                'gmt_offset' => -5.0,
                'dst_offset' => -5.0,
                'raw_offset' => -5.0,
            ),
            285 => 
            array (
                'country_code' => 'PE',
                'timezone' => 'America/Lima',
                'gmt_offset' => -5.0,
                'dst_offset' => -5.0,
                'raw_offset' => -5.0,
            ),
            286 => 
            array (
                'country_code' => 'PF',
                'timezone' => 'Pacific/Gambier',
                'gmt_offset' => -9.0,
                'dst_offset' => -9.0,
                'raw_offset' => -9.0,
            ),
            287 => 
            array (
                'country_code' => 'PF',
                'timezone' => 'Pacific/Marquesas',
                'gmt_offset' => -9.5,
                'dst_offset' => -9.5,
                'raw_offset' => -9.5,
            ),
            288 => 
            array (
                'country_code' => 'PF',
                'timezone' => 'Pacific/Tahiti',
                'gmt_offset' => -10.0,
                'dst_offset' => -10.0,
                'raw_offset' => -10.0,
            ),
            289 => 
            array (
                'country_code' => 'PG',
                'timezone' => 'Pacific/Port_Moresby',
                'gmt_offset' => 10.0,
                'dst_offset' => 10.0,
                'raw_offset' => 10.0,
            ),
            290 => 
            array (
                'country_code' => 'PH',
                'timezone' => 'Asia/Manila',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            291 => 
            array (
                'country_code' => 'PK',
                'timezone' => 'Asia/Karachi',
                'gmt_offset' => 5.0,
                'dst_offset' => 5.0,
                'raw_offset' => 5.0,
            ),
            292 => 
            array (
                'country_code' => 'PL',
                'timezone' => 'Europe/Warsaw',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            293 => 
            array (
                'country_code' => 'PM',
                'timezone' => 'America/Miquelon',
                'gmt_offset' => -3.0,
                'dst_offset' => -2.0,
                'raw_offset' => -3.0,
            ),
            294 => 
            array (
                'country_code' => 'PN',
                'timezone' => 'Pacific/Pitcairn',
                'gmt_offset' => -8.0,
                'dst_offset' => -8.0,
                'raw_offset' => -8.0,
            ),
            295 => 
            array (
                'country_code' => 'PR',
                'timezone' => 'America/Puerto_Rico',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            296 => 
            array (
                'country_code' => 'PS',
                'timezone' => 'Asia/Gaza',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            297 => 
            array (
                'country_code' => 'PS',
                'timezone' => 'Asia/Hebron',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            298 => 
            array (
                'country_code' => 'PT',
                'timezone' => 'Atlantic/Azores',
                'gmt_offset' => -1.0,
                'dst_offset' => 0.0,
                'raw_offset' => -1.0,
            ),
            299 => 
            array (
                'country_code' => 'PT',
                'timezone' => 'Atlantic/Madeira',
                'gmt_offset' => 0.0,
                'dst_offset' => 1.0,
                'raw_offset' => 0.0,
            ),
            300 => 
            array (
                'country_code' => 'PT',
                'timezone' => 'Europe/Lisbon',
                'gmt_offset' => 0.0,
                'dst_offset' => 1.0,
                'raw_offset' => 0.0,
            ),
            301 => 
            array (
                'country_code' => 'PW',
                'timezone' => 'Pacific/Palau',
                'gmt_offset' => 9.0,
                'dst_offset' => 9.0,
                'raw_offset' => 9.0,
            ),
            302 => 
            array (
                'country_code' => 'PY',
                'timezone' => 'America/Asuncion',
                'gmt_offset' => -3.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            303 => 
            array (
                'country_code' => 'QA',
                'timezone' => 'Asia/Qatar',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            304 => 
            array (
                'country_code' => 'RE',
                'timezone' => 'Indian/Reunion',
                'gmt_offset' => 4.0,
                'dst_offset' => 4.0,
                'raw_offset' => 4.0,
            ),
            305 => 
            array (
                'country_code' => 'RO',
                'timezone' => 'Europe/Bucharest',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            306 => 
            array (
                'country_code' => 'RS',
                'timezone' => 'Europe/Belgrade',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            307 => 
            array (
                'country_code' => 'RU',
                'timezone' => 'Asia/Anadyr',
                'gmt_offset' => 12.0,
                'dst_offset' => 12.0,
                'raw_offset' => 12.0,
            ),
            308 => 
            array (
                'country_code' => 'RU',
                'timezone' => 'Asia/Irkutsk',
                'gmt_offset' => 9.0,
                'dst_offset' => 9.0,
                'raw_offset' => 9.0,
            ),
            309 => 
            array (
                'country_code' => 'RU',
                'timezone' => 'Asia/Kamchatka',
                'gmt_offset' => 12.0,
                'dst_offset' => 12.0,
                'raw_offset' => 12.0,
            ),
            310 => 
            array (
                'country_code' => 'RU',
                'timezone' => 'Asia/Khandyga',
                'gmt_offset' => 10.0,
                'dst_offset' => 10.0,
                'raw_offset' => 10.0,
            ),
            311 => 
            array (
                'country_code' => 'RU',
                'timezone' => 'Asia/Krasnoyarsk',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            312 => 
            array (
                'country_code' => 'RU',
                'timezone' => 'Asia/Magadan',
                'gmt_offset' => 12.0,
                'dst_offset' => 12.0,
                'raw_offset' => 12.0,
            ),
            313 => 
            array (
                'country_code' => 'RU',
                'timezone' => 'Asia/Novokuznetsk',
                'gmt_offset' => 7.0,
                'dst_offset' => 7.0,
                'raw_offset' => 7.0,
            ),
            314 => 
            array (
                'country_code' => 'RU',
                'timezone' => 'Asia/Novosibirsk',
                'gmt_offset' => 7.0,
                'dst_offset' => 7.0,
                'raw_offset' => 7.0,
            ),
            315 => 
            array (
                'country_code' => 'RU',
                'timezone' => 'Asia/Omsk',
                'gmt_offset' => 7.0,
                'dst_offset' => 7.0,
                'raw_offset' => 7.0,
            ),
            316 => 
            array (
                'country_code' => 'RU',
                'timezone' => 'Asia/Sakhalin',
                'gmt_offset' => 11.0,
                'dst_offset' => 11.0,
                'raw_offset' => 11.0,
            ),
            317 => 
            array (
                'country_code' => 'RU',
                'timezone' => 'Asia/Ust-Nera',
                'gmt_offset' => 11.0,
                'dst_offset' => 11.0,
                'raw_offset' => 11.0,
            ),
            318 => 
            array (
                'country_code' => 'RU',
                'timezone' => 'Asia/Vladivostok',
                'gmt_offset' => 11.0,
                'dst_offset' => 11.0,
                'raw_offset' => 11.0,
            ),
            319 => 
            array (
                'country_code' => 'RU',
                'timezone' => 'Asia/Yakutsk',
                'gmt_offset' => 10.0,
                'dst_offset' => 10.0,
                'raw_offset' => 10.0,
            ),
            320 => 
            array (
                'country_code' => 'RU',
                'timezone' => 'Asia/Yekaterinburg',
                'gmt_offset' => 6.0,
                'dst_offset' => 6.0,
                'raw_offset' => 6.0,
            ),
            321 => 
            array (
                'country_code' => 'RU',
                'timezone' => 'Europe/Kaliningrad',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            322 => 
            array (
                'country_code' => 'RU',
                'timezone' => 'Europe/Moscow',
                'gmt_offset' => 4.0,
                'dst_offset' => 4.0,
                'raw_offset' => 4.0,
            ),
            323 => 
            array (
                'country_code' => 'RU',
                'timezone' => 'Europe/Samara',
                'gmt_offset' => 4.0,
                'dst_offset' => 4.0,
                'raw_offset' => 4.0,
            ),
            324 => 
            array (
                'country_code' => 'RU',
                'timezone' => 'Europe/Volgograd',
                'gmt_offset' => 4.0,
                'dst_offset' => 4.0,
                'raw_offset' => 4.0,
            ),
            325 => 
            array (
                'country_code' => 'RW',
                'timezone' => 'Africa/Kigali',
                'gmt_offset' => 2.0,
                'dst_offset' => 2.0,
                'raw_offset' => 2.0,
            ),
            326 => 
            array (
                'country_code' => 'SA',
                'timezone' => 'Asia/Riyadh',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            327 => 
            array (
                'country_code' => 'SB',
                'timezone' => 'Pacific/Guadalcanal',
                'gmt_offset' => 11.0,
                'dst_offset' => 11.0,
                'raw_offset' => 11.0,
            ),
            328 => 
            array (
                'country_code' => 'SC',
                'timezone' => 'Indian/Mahe',
                'gmt_offset' => 4.0,
                'dst_offset' => 4.0,
                'raw_offset' => 4.0,
            ),
            329 => 
            array (
                'country_code' => 'SD',
                'timezone' => 'Africa/Khartoum',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            330 => 
            array (
                'country_code' => 'SE',
                'timezone' => 'Europe/Stockholm',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            331 => 
            array (
                'country_code' => 'SG',
                'timezone' => 'Asia/Singapore',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            332 => 
            array (
                'country_code' => 'SH',
                'timezone' => 'Atlantic/St_Helena',
                'gmt_offset' => 0.0,
                'dst_offset' => 0.0,
                'raw_offset' => 0.0,
            ),
            333 => 
            array (
                'country_code' => 'SI',
                'timezone' => 'Europe/Ljubljana',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            334 => 
            array (
                'country_code' => 'SJ',
                'timezone' => 'Arctic/Longyearbyen',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            335 => 
            array (
                'country_code' => 'SK',
                'timezone' => 'Europe/Bratislava',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            336 => 
            array (
                'country_code' => 'SL',
                'timezone' => 'Africa/Freetown',
                'gmt_offset' => 0.0,
                'dst_offset' => 0.0,
                'raw_offset' => 0.0,
            ),
            337 => 
            array (
                'country_code' => 'SM',
                'timezone' => 'Europe/San_Marino',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            338 => 
            array (
                'country_code' => 'SN',
                'timezone' => 'Africa/Dakar',
                'gmt_offset' => 0.0,
                'dst_offset' => 0.0,
                'raw_offset' => 0.0,
            ),
            339 => 
            array (
                'country_code' => 'SO',
                'timezone' => 'Africa/Mogadishu',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            340 => 
            array (
                'country_code' => 'SR',
                'timezone' => 'America/Paramaribo',
                'gmt_offset' => -3.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            341 => 
            array (
                'country_code' => 'SS',
                'timezone' => 'Africa/Juba',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            342 => 
            array (
                'country_code' => 'ST',
                'timezone' => 'Africa/Sao_Tome',
                'gmt_offset' => 0.0,
                'dst_offset' => 0.0,
                'raw_offset' => 0.0,
            ),
            343 => 
            array (
                'country_code' => 'SV',
                'timezone' => 'America/El_Salvador',
                'gmt_offset' => -6.0,
                'dst_offset' => -6.0,
                'raw_offset' => -6.0,
            ),
            344 => 
            array (
                'country_code' => 'SX',
                'timezone' => 'America/Lower_Princes',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            345 => 
            array (
                'country_code' => 'SY',
                'timezone' => 'Asia/Damascus',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            346 => 
            array (
                'country_code' => 'SZ',
                'timezone' => 'Africa/Mbabane',
                'gmt_offset' => 2.0,
                'dst_offset' => 2.0,
                'raw_offset' => 2.0,
            ),
            347 => 
            array (
                'country_code' => 'TC',
                'timezone' => 'America/Grand_Turk',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            348 => 
            array (
                'country_code' => 'TD',
                'timezone' => 'Africa/Ndjamena',
                'gmt_offset' => 1.0,
                'dst_offset' => 1.0,
                'raw_offset' => 1.0,
            ),
            349 => 
            array (
                'country_code' => 'TF',
                'timezone' => 'Indian/Kerguelen',
                'gmt_offset' => 5.0,
                'dst_offset' => 5.0,
                'raw_offset' => 5.0,
            ),
            350 => 
            array (
                'country_code' => 'TG',
                'timezone' => 'Africa/Lome',
                'gmt_offset' => 0.0,
                'dst_offset' => 0.0,
                'raw_offset' => 0.0,
            ),
            351 => 
            array (
                'country_code' => 'TH',
                'timezone' => 'Asia/Bangkok',
                'gmt_offset' => 7.0,
                'dst_offset' => 7.0,
                'raw_offset' => 7.0,
            ),
            352 => 
            array (
                'country_code' => 'TJ',
                'timezone' => 'Asia/Dushanbe',
                'gmt_offset' => 5.0,
                'dst_offset' => 5.0,
                'raw_offset' => 5.0,
            ),
            353 => 
            array (
                'country_code' => 'TK',
                'timezone' => 'Pacific/Fakaofo',
                'gmt_offset' => 13.0,
                'dst_offset' => 13.0,
                'raw_offset' => 13.0,
            ),
            354 => 
            array (
                'country_code' => 'TL',
                'timezone' => 'Asia/Dili',
                'gmt_offset' => 9.0,
                'dst_offset' => 9.0,
                'raw_offset' => 9.0,
            ),
            355 => 
            array (
                'country_code' => 'TM',
                'timezone' => 'Asia/Ashgabat',
                'gmt_offset' => 5.0,
                'dst_offset' => 5.0,
                'raw_offset' => 5.0,
            ),
            356 => 
            array (
                'country_code' => 'TN',
                'timezone' => 'Africa/Tunis',
                'gmt_offset' => 1.0,
                'dst_offset' => 1.0,
                'raw_offset' => 1.0,
            ),
            357 => 
            array (
                'country_code' => 'TO',
                'timezone' => 'Pacific/Tongatapu',
                'gmt_offset' => 13.0,
                'dst_offset' => 13.0,
                'raw_offset' => 13.0,
            ),
            358 => 
            array (
                'country_code' => 'TR',
                'timezone' => 'Europe/Istanbul',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            359 => 
            array (
                'country_code' => 'TT',
                'timezone' => 'America/Port_of_Spain',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            360 => 
            array (
                'country_code' => 'TV',
                'timezone' => 'Pacific/Funafuti',
                'gmt_offset' => 12.0,
                'dst_offset' => 12.0,
                'raw_offset' => 12.0,
            ),
            361 => 
            array (
                'country_code' => 'TW',
                'timezone' => 'Asia/Taipei',
                'gmt_offset' => 8.0,
                'dst_offset' => 8.0,
                'raw_offset' => 8.0,
            ),
            362 => 
            array (
                'country_code' => 'TZ',
                'timezone' => 'Africa/Dar_es_Salaam',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            363 => 
            array (
                'country_code' => 'UA',
                'timezone' => 'Europe/Kiev',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            364 => 
            array (
                'country_code' => 'UA',
                'timezone' => 'Europe/Simferopol',
                'gmt_offset' => 2.0,
                'dst_offset' => 4.0,
                'raw_offset' => 4.0,
            ),
            365 => 
            array (
                'country_code' => 'UA',
                'timezone' => 'Europe/Uzhgorod',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            366 => 
            array (
                'country_code' => 'UA',
                'timezone' => 'Europe/Zaporozhye',
                'gmt_offset' => 2.0,
                'dst_offset' => 3.0,
                'raw_offset' => 2.0,
            ),
            367 => 
            array (
                'country_code' => 'UG',
                'timezone' => 'Africa/Kampala',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            368 => 
            array (
                'country_code' => 'UM',
                'timezone' => 'Pacific/Johnston',
                'gmt_offset' => -10.0,
                'dst_offset' => -10.0,
                'raw_offset' => -10.0,
            ),
            369 => 
            array (
                'country_code' => 'UM',
                'timezone' => 'Pacific/Midway',
                'gmt_offset' => -11.0,
                'dst_offset' => -11.0,
                'raw_offset' => -11.0,
            ),
            370 => 
            array (
                'country_code' => 'UM',
                'timezone' => 'Pacific/Wake',
                'gmt_offset' => 12.0,
                'dst_offset' => 12.0,
                'raw_offset' => 12.0,
            ),
            371 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Adak',
                'gmt_offset' => -10.0,
                'dst_offset' => -9.0,
                'raw_offset' => -10.0,
            ),
            372 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Anchorage',
                'gmt_offset' => -9.0,
                'dst_offset' => -8.0,
                'raw_offset' => -9.0,
            ),
            373 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Boise',
                'gmt_offset' => -7.0,
                'dst_offset' => -6.0,
                'raw_offset' => -7.0,
            ),
            374 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Chicago',
                'gmt_offset' => -6.0,
                'dst_offset' => -5.0,
                'raw_offset' => -6.0,
            ),
            375 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Denver',
                'gmt_offset' => -7.0,
                'dst_offset' => -6.0,
                'raw_offset' => -7.0,
            ),
            376 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Detroit',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            377 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Indiana/Indianapolis',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            378 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Indiana/Knox',
                'gmt_offset' => -6.0,
                'dst_offset' => -5.0,
                'raw_offset' => -6.0,
            ),
            379 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Indiana/Marengo',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            380 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Indiana/Petersburg',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            381 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Indiana/Tell_City',
                'gmt_offset' => -6.0,
                'dst_offset' => -5.0,
                'raw_offset' => -6.0,
            ),
            382 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Indiana/Vevay',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            383 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Indiana/Vincennes',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            384 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Indiana/Winamac',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            385 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Juneau',
                'gmt_offset' => -9.0,
                'dst_offset' => -8.0,
                'raw_offset' => -9.0,
            ),
            386 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Kentucky/Louisville',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            387 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Kentucky/Monticello',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            388 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Los_Angeles',
                'gmt_offset' => -8.0,
                'dst_offset' => -7.0,
                'raw_offset' => -8.0,
            ),
            389 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Menominee',
                'gmt_offset' => -6.0,
                'dst_offset' => -5.0,
                'raw_offset' => -6.0,
            ),
            390 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Metlakatla',
                'gmt_offset' => -8.0,
                'dst_offset' => -8.0,
                'raw_offset' => -8.0,
            ),
            391 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/New_York',
                'gmt_offset' => -5.0,
                'dst_offset' => -4.0,
                'raw_offset' => -5.0,
            ),
            392 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Nome',
                'gmt_offset' => -9.0,
                'dst_offset' => -8.0,
                'raw_offset' => -9.0,
            ),
            393 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/North_Dakota/Beulah',
                'gmt_offset' => -6.0,
                'dst_offset' => -5.0,
                'raw_offset' => -6.0,
            ),
            394 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/North_Dakota/Center',
                'gmt_offset' => -6.0,
                'dst_offset' => -5.0,
                'raw_offset' => -6.0,
            ),
            395 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/North_Dakota/New_Salem',
                'gmt_offset' => -6.0,
                'dst_offset' => -5.0,
                'raw_offset' => -6.0,
            ),
            396 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Phoenix',
                'gmt_offset' => -7.0,
                'dst_offset' => -7.0,
                'raw_offset' => -7.0,
            ),
            397 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Shiprock',
                'gmt_offset' => -7.0,
                'dst_offset' => -6.0,
                'raw_offset' => -7.0,
            ),
            398 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Sitka',
                'gmt_offset' => -9.0,
                'dst_offset' => -8.0,
                'raw_offset' => -9.0,
            ),
            399 => 
            array (
                'country_code' => 'US',
                'timezone' => 'America/Yakutat',
                'gmt_offset' => -9.0,
                'dst_offset' => -8.0,
                'raw_offset' => -9.0,
            ),
            400 => 
            array (
                'country_code' => 'US',
                'timezone' => 'Pacific/Honolulu',
                'gmt_offset' => -10.0,
                'dst_offset' => -10.0,
                'raw_offset' => -10.0,
            ),
            401 => 
            array (
                'country_code' => 'UY',
                'timezone' => 'America/Montevideo',
                'gmt_offset' => -2.0,
                'dst_offset' => -3.0,
                'raw_offset' => -3.0,
            ),
            402 => 
            array (
                'country_code' => 'UZ',
                'timezone' => 'Asia/Samarkand',
                'gmt_offset' => 5.0,
                'dst_offset' => 5.0,
                'raw_offset' => 5.0,
            ),
            403 => 
            array (
                'country_code' => 'UZ',
                'timezone' => 'Asia/Tashkent',
                'gmt_offset' => 5.0,
                'dst_offset' => 5.0,
                'raw_offset' => 5.0,
            ),
            404 => 
            array (
                'country_code' => 'VA',
                'timezone' => 'Europe/Vatican',
                'gmt_offset' => 1.0,
                'dst_offset' => 2.0,
                'raw_offset' => 1.0,
            ),
            405 => 
            array (
                'country_code' => 'VC',
                'timezone' => 'America/St_Vincent',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            406 => 
            array (
                'country_code' => 'VE',
                'timezone' => 'America/Caracas',
                'gmt_offset' => -4.5,
                'dst_offset' => -4.5,
                'raw_offset' => -4.5,
            ),
            407 => 
            array (
                'country_code' => 'VG',
                'timezone' => 'America/Tortola',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            408 => 
            array (
                'country_code' => 'VI',
                'timezone' => 'America/St_Thomas',
                'gmt_offset' => -4.0,
                'dst_offset' => -4.0,
                'raw_offset' => -4.0,
            ),
            409 => 
            array (
                'country_code' => 'VN',
                'timezone' => 'Asia/Ho_Chi_Minh',
                'gmt_offset' => 7.0,
                'dst_offset' => 7.0,
                'raw_offset' => 7.0,
            ),
            410 => 
            array (
                'country_code' => 'VU',
                'timezone' => 'Pacific/Efate',
                'gmt_offset' => 11.0,
                'dst_offset' => 11.0,
                'raw_offset' => 11.0,
            ),
            411 => 
            array (
                'country_code' => 'WF',
                'timezone' => 'Pacific/Wallis',
                'gmt_offset' => 12.0,
                'dst_offset' => 12.0,
                'raw_offset' => 12.0,
            ),
            412 => 
            array (
                'country_code' => 'WS',
                'timezone' => 'Pacific/Apia',
                'gmt_offset' => 14.0,
                'dst_offset' => 13.0,
                'raw_offset' => 13.0,
            ),
            413 => 
            array (
                'country_code' => 'YE',
                'timezone' => 'Asia/Aden',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            414 => 
            array (
                'country_code' => 'YT',
                'timezone' => 'Indian/Mayotte',
                'gmt_offset' => 3.0,
                'dst_offset' => 3.0,
                'raw_offset' => 3.0,
            ),
            415 => 
            array (
                'country_code' => 'ZA',
                'timezone' => 'Africa/Johannesburg',
                'gmt_offset' => 2.0,
                'dst_offset' => 2.0,
                'raw_offset' => 2.0,
            ),
            416 => 
            array (
                'country_code' => 'ZM',
                'timezone' => 'Africa/Lusaka',
                'gmt_offset' => 2.0,
                'dst_offset' => 2.0,
                'raw_offset' => 2.0,
            ),
            417 => 
            array (
                'country_code' => 'ZW',
                'timezone' => 'Africa/Harare',
                'gmt_offset' => 2.0,
                'dst_offset' => 2.0,
                'raw_offset' => 2.0,
            ),
        ));
        
        
    }
}