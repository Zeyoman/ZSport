<?php

declare(strict_types=1);
// App\Enum\VideoLevel
namespace App\Enum;

enum VideoLevel: string
{
    case DEBUTANT = 'Débutant';
    case INTERMEDIAIRE = 'Intermédiare';
    case DIFFICILE = 'Avancé';
}