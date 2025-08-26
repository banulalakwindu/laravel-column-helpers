<?php

namespace BanulaLakwindu\ColumnHelpers\Support\Macros;

class RegisterMacros
{
    public static function register(): void
    {
        // Register all macro classes
        ActiveColumnMacros::register();
        FeaturedColumnMacros::register();
        MetaColumnMacros::register();
        SlugColumnMacros::register();
        SortOrderColumnMacros::register();
    }
}
