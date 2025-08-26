<?php

namespace BanulaLakwindu\ColumnHelpers\Support\Macros;

use Illuminate\Database\Schema\Blueprint;

class SortOrderColumnMacros
{
    public static function register(): void
    {
        Blueprint::macro('sortOrderColumn', function (): void {
            $this->integer('sort_order')->default(0);
        });
    }
}
