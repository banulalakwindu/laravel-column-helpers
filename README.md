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

    protected static function booted()
    {
        static::addGlobalScope('active', function ($query) {
            $query->active();
        });
    }
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
        return 'title'; // Override to use different source column
    }
}
```

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