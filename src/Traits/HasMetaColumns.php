<?php

namespace BanulaLakwindu\ColumnHelpers\Traits;

trait HasMetaColumns
{
    public function initializeHasMetaColumns(): void
    {
        $this->mergeFillable([
            'meta_title',
            'meta_description',
            'meta_keywords',
            'meta_image',
        ]);

        $this->mergeCasts([
            'meta_keywords' => 'array',
        ]);
    }
}
