<?php

namespace BanulaLakwindu\ColumnHelpers\Support\Macros;

use Illuminate\Database\Schema\Blueprint;

class FeaturedColumnMacros
{
    public static function register(): void
    {
        Blueprint::macro('featuredColumn', function (): void {
            $this->boolean('is_featured')->default(false);
        });
    }
}
