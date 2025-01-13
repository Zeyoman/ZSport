<?php

declare(strict_types=1);
# App\Enum\ProgrammeTheme
namespace App\Enum;

enum ProgrammeTheme: string
{
    case HAUTCORPS = 'Haut du corps';
    case BASCORPS = 'Bas du corps';
    case COMPLETCORPS = 'Corps complet';
    case HIT = 'Hit';
    case CARDIO = 'Cardio';
}