<?php

namespace BanulaLakwindu\ColumnHelpers\Traits;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait HasActiveColumn
{
    public function initializeHasActiveColumn(): void
    {
        $this->mergeFillable(['is_active']);
        $this->mergeCasts(['is_active' => 'boolean']);
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    public function markActive(): void
    {
        $this->is_active = true;
        $this->save();
    }

    public function markInactive(): void
    {
        $this->is_active = false;
        $this->save();
    }

    /**
     * @param  Builder<Model>  $builder
     */
    #[Scope]
    protected function active(Builder $builder): void
    {
        $builder->where('is_active', true);
    }
}
