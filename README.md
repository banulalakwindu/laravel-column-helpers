# Laravel Column Helpers

A Laravel package providing useful traits and migration macros for common model columns.

## Installation

```bash
composer require banulalakwindu/laravel-column-helpers
```

## Features

### Migration Macros

#### Active Column
```php
Schema::table('posts', function (Blueprint $table) {
    $table->activeColumn(); // Adds is_active boolean column with default true
});
```

#### Featured Column
```php
Schema::table('posts', function (Blueprint $table) {
    $table->featuredColumn(); // Adds is_featured boolean column with default false
});
```

#### Meta Columns
```php
Schema::table('posts', function (Blueprint $table) {
    $table->metaColumns(); // Adds meta_title, meta_description, meta_keywords, meta_image
});
```

#### Slug Columns
```php
Schema::table('posts', function (Blueprint $table) {
    $table->slugColumns(); // Adds name and slug columns
    $table->slugColumns('title'); // Adds title and slug columns
});
```

#### Sort Order Column
```php
Schema::table('posts', function (Blueprint $table) {
    $table->sortOrderColumn(); // Adds sort_order integer column with default 0
});
```

### Model Traits

#### HasActiveColumn
```php
use BanulaLakwindu\ColumnHelpers\Traits\HasActiveColumn;

class Post extends Model
{
    use HasActiveColumn;
}

// Usage
$post->isActive();
$post->markActive();
$post->markInactive();
Post::active()->get(); // Scope
```

#### HasFeaturedColumn
```php
use BanulaLakwindu\ColumnHelpers\Traits\HasFeaturedColumn;

class Post extends Model
{
    use HasFeaturedColumn;
}

// Usage
$post->isFeatured();
$post->markFeatured();
$post->markUnfeatured();
Post::featured()->get(); // Scope
```

#### HasMetaColumns
```php
use BanulaLakwindu\ColumnHelpers\Traits\HasMetaColumns;

class Post extends Model
{
    use HasMetaColumns;
}
```

#### HasSlugColumns
```php
use BanulaLakwindu\ColumnHelpers\Traits\HasSlugColumns;

class Post extends Model
{
    use HasSlugColumns;

    protected function slugSourceColumn(): string
    {
        return 'title';
    }

    protected function getSlugColumnCommentCacheDuration(): int
    {
        return 7 * 24 * 60 * 60; // 7 days in seconds
    }
}
```

**Override Functions:**

- `slugSourceColumn()`: **Required override** - Specifies which column to use as the source for generating slugs. If not overridden, the trait will auto-detect the slug source column from database comments every time (caching is needed).

- `getSlugColumnCommentCacheDuration()`: **Optional override** - Sets cache duration for slug source column detection. Default is 7 days. Only used when `slugSourceColumn()` is not overridden.

#### HasSortOrderColumn
```php
use BanulaLakwindu\ColumnHelpers\Traits\HasSortOrderColumn;

class Post extends Model
{
    use HasSortOrderColumn;
}

// Usage
$post->getSortOrder();
$post->setSortOrder(5);
$post->moveBefore($otherPost);
$post->moveAfter($otherPost);
Post::orderBySortOrder()->get(); // Scope
Post::orderBySortOrderDesc()->get(); // Scope
```

## Requirements

- PHP 8.0+
- Laravel 10.0+

## License

MIT License