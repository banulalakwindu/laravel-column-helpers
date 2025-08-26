<?php

namespace BanulaLakwindu\ColumnHelpers\Support\Macros;

use Illuminate\Database\Schema\Blueprint;

class MetaColumnMacros
{
    public static function register(): void
    {
        Blueprint::macro('metaColumns', function (): void {
            $this->string('meta_title')->nullable();
            $this->text('meta_description')->nullable();
            $this->json('meta_keywords')->nullable();
            $this->text('meta_image')->nullable();
        });
    }
}
