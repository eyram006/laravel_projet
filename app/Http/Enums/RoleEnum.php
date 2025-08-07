<?php

namespace App\Http\enums;

enum RoleEnum : string {

    case ASSURE ='assure';
    case GESTIONNAIRE ='gestionnaire';
    case ADMIN ='admin';
    case CLIENT='client';

    public static function values():array {
          return array_map(fn($case) => $case->value, self::cases()); 
    }
}
