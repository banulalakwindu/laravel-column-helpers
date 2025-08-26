<?php

namespace BanulaLakwindu\ColumnHelpers\Traits;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait HasSortOrderColumn
{
    public function initializeHasSortOrderColumn(): void
    {
        $this->mergeFillable(['sort_order']);
        $this->mergeCasts(['sort_order' => 'integer']);
    }

    /**
     * @param  Builder<Model>  $builder
     */
    #[Scope]
    protected function orderBySortOrder(Builder $builder): void
    {
        $builder->orderBy('sort_order');
    }

    /**
     * @param  Builder<Model>  $builder
     */
    #[Scope]
    protected function orderBySortOrderDesc(Builder $builder): void
    {
        $builder->orderBy('sort_order', 'desc');
    }

    public function getSortOrder(): int
    {
        return (int) $this->sort_order;
    }

    public function setSortOrder(int $order): void
    {
        $this->sort_order = $order;
        $this->save();
    }

    public function moveBefore(self $item): void
    {
        if ($this->sort_order > $item->sort_order) {
            static::query()
                ->where('sort_order', '>=', $item->sort_order)
                ->where('sort_order', '<', $this->sort_order)
                ->increment('sort_order');

            $this->sort_order = $item->sort_order;
            $this->save();
        } else {
            static::query()
                ->where('sort_order', '>', $this->sort_order)
                ->where('sort_order', '<=', $item->sort_order)
                ->decrement('sort_order');

            $this->sort_order = $item->sort_order;
            $this->save();
        }
    }

    public function moveAfter(self $item): void
    {
        if ($this->sort_order > $item->sort_order) {
            static::query()
                ->where('sort_order', '>', $item->sort_order)
                ->where('sort_order', '<', $this->sort_order)
                ->increment('sort_order');

            $this->sort_order = $item->sort_order + 1;
            $this->save();
        } else {
            static::query()
                ->where('sort_order', '>', $this->sort_order)
                ->where('sort_order', '<=', $item->sort_order)
                ->decrement('sort_order');

            $this->sort_order = $item->sort_order;
            $this->save();
        }
    }
}
