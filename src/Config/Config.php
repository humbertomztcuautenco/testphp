<?php
namespace App\Config;

class Config{

    private static $tipoServidor = 'local';
    // private static $tipoServidor = 'dev';
    // private static $tipoServidor = 'prod';

    private static $twllio = [
        'local'=>[
            'sid'   => 'AC8ea21b10f86004e95b513f09fcf2ea03',
            'token' => 'b5607e502c91de60a0de3f4dba11b9b5',
            'from'  => '+13023068960'
        ],
        'dev'=> [
            'sid'   => 'AC8ea21b10f86004e95b513f09fcf2ea03',
            'token' => 'b5607e502c91de60a0de3f4dba11b9b5',
            'from'  => '+13023068960'
        ],
        // 'prod' => [
        //     'sid'   => 'AC409535b5d2d9099f03c774bd80e47729',
        //     'token' => 'c894d3dfbbc77961ed720231d9d6f196',
        //     'from'  => '+19033006521'
        // ]    
    ];

    private static $url = [
        'local'=>[
            'servidor' => '/var/www/html/cumulusback/', #linux defect url
            // 'servidor' => '/Users/humbertomartinez/Sites/cumulus/cumulusback/',
            'host'     => 'http://localhost/cumulusback/'
        ],
        'dev'=> [
            'servidor'  =>  '/home/u219376423/domains/stardust.com.mx/public_html/cumulus/cumulusback/',
            'host'      => 'https://cumulus.stardust.com.mx/cumulusback/'
        ],
        // 'prod'=>[
        //     'servidor'  => '/home/u788033113/domains/econosupersierra.com/public_html/econoback/',
        //     'host'      => 'https://econosupersierra.com/econoback/'
        // ]
    ];

    private static $stringsDB = [
        'local'=>[
            'host'  => '45.84.204.205',
            'db'    => 'u219376423_cumulusDev',
            'user'  => 'u219376423_cumulusDev',
            'pass'  => 'Stardust88/@Cumulus*' 
        ],
        'dev'=>[
            'host'  => '45.84.204.205',
            'db'    => 'u219376423_cumulusDev',
            'user'  => 'u219376423_cumulusDev',
            'pass'  => 'Stardust88/@Cumulus*' 
        ]
    ];
    
    public static function getTwilio(){
        return self::$twllio[self::$tipoServidor];
    }

    public static function getUrl(){
        return self::$url[self::$tipoServidor];
    }

    public static function getStringsDB(){
        return self::$stringsDB[self::$tipoServidor];
    }
}