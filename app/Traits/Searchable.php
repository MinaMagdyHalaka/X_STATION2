<?php

namespace App\Traits;

use App\Http\Controllers\SearchController;
use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    public function scopeSearchable(Builder $query, array $columns = ['name'], array $translatedKeys = [], string $handleKeyName = 'handle')
    {
        SearchController::searchForHandle($query, $columns, request($handleKeyName), $translatedKeys);
    }

    public function scopeSearchByForeignKey(Builder $builder, string $foreignKeyColumn, ?string $value = null)
    {
        return $builder->when(
            $value,
            fn ($innerQuery) => $innerQuery->where($foreignKeyColumn, $value)
        );
    }

    public function scopeSearchInJson(Builder $query, string $column, array $keys = ['name'], string $value = null)
    {
        $value = $value ?: request('handle');

        SearchController::searchInJson($query, $column, $keys, $value);
    }
}
