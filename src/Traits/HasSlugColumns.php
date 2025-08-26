<?php

namespace BanulaLakwindu\ColumnHelpers\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

trait HasSlugColumns
{
    use HasSlug;

    public function initializeHasSlugColumns(): void
    {
        $mainColumn = $this->getSlugSourceColumn();

        $this->mergeFillable([$mainColumn, 'slug']);
    }

    protected function getSlugSourceColumn(): string
    {
        return $this->slugSourceColumn();
    }

    /**
     * Get the source column name for slug generation.
     *
     * Override this method in your model to specify a custom source column.
     * If not overridden, it will try to read from the slugColumns('#') in migration,
     * or fall back to 'name' as default.
     *
     * If you are not going to add same column name which is used in the migration - slugColumns('#') (default #name),
     * then you should add slugColumns('#') (default #name) attribute manually to the fillable array.
     *
     * @return string The column name to generate slugs from
     */
    protected function slugSourceColumn(): string
    {
        $comment = $this->getSlugColumnComment();

        if (is_string($comment)) {
            $parts = explode(':', $comment);

            return $parts[1] ?? 'name';
        }

        return 'name';
    }

    protected function getSlugColumnComment(): ?string
    {
        $table = $this->getTable();

        try {
            $connection = $this->getConnection();

            /** @var array<int, object> $columns */
            $columns = $connection->select("
            SELECT COLUMN_COMMENT 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE TABLE_SCHEMA = ? 
            AND TABLE_NAME = ? 
            AND COLUMN_NAME = 'slug'
        ", [$connection->getDatabaseName(), $table]);

            if (empty($columns)) {
                return null;
            }

            /** @var object $firstColumn */
            $firstColumn = $columns[0];

            $comment = $firstColumn->COLUMN_COMMENT ?? null;

            return is_string($comment) ? $comment : null;
        } catch (Exception) {
            return null;
        }
    }

    public function getSlugOptions(): SlugOptions
    {
        $mainColumn = $this->getSlugSourceColumn();

        return SlugOptions::create()
            ->generateSlugsFrom($mainColumn)
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate()
            ->extraScope(
                function (Builder $builder): void {
                    $builder->whereNull($this->getDeletedAtColumn());
                }
            );
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
