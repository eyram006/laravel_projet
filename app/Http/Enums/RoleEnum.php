<?php

namespace App\Http\enums;

enum RoleEnum : string {

    case EMPLOYE ='employe';
    case GESTIONNAIRE ='gestionnaire';
    case ADMIN ='admin';

    public static function values():array {
          return array_map(fn($case) => $case->value, self::cases()); 
    }
}
