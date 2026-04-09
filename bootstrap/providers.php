<?php

use App\Providers\AppServiceProvider;
use App\Providers\FortifyServiceProvider; // Add this import

return [
    AppServiceProvider::class,
    FortifyServiceProvider::class, // Add this line
];