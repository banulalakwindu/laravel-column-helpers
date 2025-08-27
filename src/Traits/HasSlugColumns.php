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

    /**
     * Get the source column name for slug generation.
     *
     * Override this method in your model to specify a custom source column.
     * If not overridden, it will try to read from the slugColumns('#') in migration,
     * or fall back to 'name' as default.
     *
     * @return string The column name to generate slugs from
     */
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

    /**
     * Get the cache duration for slug column comment caching.
     * Override this method in your model to customize cache duration.
     *
     * @return int Cache duration in seconds
     */
    protected function getSlugColumnCommentCacheDuration(): int
    {
        return 7 * 24 * 60 * 60; // 7 days in seconds
    }

    protected function getSlugColumnComment(): ?string
    {
        $table = $this->getTable();
        $cacheKey = "table_{$table}_slug_comment";
        $cacheDuration = $this->getSlugColumnCommentCacheDuration();

        /** @var string|null $result */
        $result = Cache::remember($cacheKey, $cacheDuration, function () use ($table): ?string {
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
        });

        return $result; // already string|null, no cast needed
    }

    public function getSlugOptions(): SlugOptions
    {
        $mainColumn = $this->getSlugSourceColumn();

        $slugOptions = SlugOptions::create()
            ->generateSlugsFrom($mainColumn)
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();

        if (method_exists($this, 'getDeletedAtColumn')) {
            $slugOptions->extraScope(
                function (Builder $builder): void {
                    $builder->whereNull($this->getDeletedAtColumn());
                }
            );
        }

        return $slugOptions;
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
