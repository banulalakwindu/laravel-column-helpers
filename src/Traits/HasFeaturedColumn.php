<?php

namespace BanulaLakwindu\ColumnHelpers\Traits;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait HasFeaturedColumn
{
    public function initializeHasFeaturedColumn(): void
    {
        $this->mergeFillable(['is_featured']);
        $this->mergeCasts(['is_featured' => 'boolean']);
    }

    /**
     * @param  Builder<Model>  $builder
     */
    #[Scope]
    protected function featured(Builder $builder): void
    {
        $builder->where('is_featured', true);
    }

    public function isFeatured(): bool
    {
        return (bool) $this->is_featured;
    }

    public function markFeatured(): void
    {
        $this->is_featured = true;
        $this->save();
    }

    public function markUnfeatured(): void
    {
        $this->is_featured = false;
        $this->save();
    }
}
