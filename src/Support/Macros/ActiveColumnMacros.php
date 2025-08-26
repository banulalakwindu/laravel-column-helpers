<?php

namespace BanulaLakwindu\ColumnHelpers\Support\Macros;

use Illuminate\Database\Schema\Blueprint;

class ActiveColumnMacros
{
    public static function register(): void
    {
        Blueprint::macro('activeColumn', function (): void {
            $this->boolean('is_active')->default(true);
        });
    }
}
