<?php

namespace App\Http\Enums;

enum StatutEnum: string
{
    case EN_ATTENTE = 'en attente'; 
    case ACCEPTE = 'accepté';
    case REFUSE = 'refusé';

     public function label(): string
    {
        return match($this) {
    self::EN_ATTENTE => 'En attente',
        self::ACCEPTE => 'Acceptée',
            self::REFUSE => 'Refusée',
        };}

         public function color(): string
    {
        return match($this) {
            self::EN_ATTENTE => 'warning',  
            self::ACCEPTE => 'success',
            self::REFUSE => 'danger',
            
        };
    }

    public static function values():array {
          return array_map(fn($case) => $case->value, self::cases()); 
    }
    }