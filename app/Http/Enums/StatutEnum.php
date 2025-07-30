<?php

namespace App\Http\Enums;

enum StatutEnum: string
{
    case EN_ATTENTE = 'en attente';
    case ACCEPTE = 'accepté';
    case REFUSE = 'refusé';
}
