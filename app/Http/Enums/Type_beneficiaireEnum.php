<?php

namespace App\Http\Enums;

enum Type_beneficiaireEnum:string
{
    case ENFANT = 'enfant'; 
    case CONJOINT = 'conjoint';
  public static function values():array {
          return array_map(fn($case) => $case->value, self::cases()); 
    }

}
