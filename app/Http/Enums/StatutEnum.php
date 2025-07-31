<?php

namespace App\Http\Enums;

enum StatutEnum: string
{
    case EN_ATTENTE = 'en attente'; 
    case ACCEPTE = 'accepté';
    case REFUSE = 'refusé';


    public static function values():array {
          return array_map(fn($case) => $case->value, self::cases()); 
    }
    }