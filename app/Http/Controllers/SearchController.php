<?php

namespace App\Http\Controllers;

class SearchController extends Controller
{
    public static function searchForHandle($query, array $searchableKeys, $handle, array $translatedKeys = [])
    {

        if (! is_null($handle)) {

            $isFirstKey = false;
            foreach ($searchableKeys as $key) {
                if (in_array($key, $translatedKeys)) {
                    foreach (config('translatable.locales') as $locale) {
                        if (! $isFirstKey) {
                            $query->where("$key->$locale", 'like', "%$handle%");
                            $isFirstKey = true;
                        } else {
                            $query->orWhere("$key->$locale", 'like', "%$handle%");
                        }
                    }
                } else {
                    if (! $isFirstKey) {
                        $query->where($key, 'like', "%$handle%");
                        $isFirstKey = true;
                    } else {
                        $query->orWhere($key, 'like', "%$handle%");
                    }
                }
            }
        }
    }

    public static function searchInJson($query, string $column, array $keys, $value)
    {
        if($value)
        {
            $query->where(function($query)  use ($value, $column, $keys){
                $isFirstOne = true;
                array_map(function($key) use ($query, $value, $column, &$isFirstOne){
                    if($isFirstOne)
                    {
                        $query->where("$column->$key", 'like', "%$value%");
                        $isFirstOne = false;
                    } else {
                        $query->orWhere("$column->$key", 'like', "%$value%");
                    }
                }, $keys);
            });

        }
    }
}
