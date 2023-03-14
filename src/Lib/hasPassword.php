<?php
namespace App\Lib;

class HashPassword{
    public static function hash($password){
        $options = [
            'memory_cost' => 2 ** 15, // 32MB de memoria
            'time_cost' => 4, // 4 iteraciones
            'threads' => 2 // 2 hilos
        ];
        
        $hash = password_hash($password, PASSWORD_ARGON2ID, $options);
        return $hash;
    }
}