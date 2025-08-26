<?php

namespace BanulaLakwindu\ColumnHelpers\Support\Macros;

use Illuminate\Database\Schema\Blueprint;

class SlugColumnMacros
{
    public static function register(): void
    {
        Blueprint::macro('slugColumns', function (string $mainColumn = 'name'): void {
            $this->string($mainColumn);
            $this->string('slug')->comment("slug_source:{$mainColumn}");
        });
    }
}
