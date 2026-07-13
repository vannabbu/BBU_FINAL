<?php

namespace App\Http\Controllers;

use App\Support\ClinicUi;

abstract class Controller
{
    protected function clinicDoctor(): array
    {
        return ClinicUi::doctor();
    }

    protected function clinicNavigation(?string $active = null): array
    {
        return ClinicUi::navigation($active);
    }
}
