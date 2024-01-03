<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugHelper
{
    /**
     * @param  Model  $modelExists
     */
    public static function indexAlreadyExistingKeys($modelExists, array $translatedArray, array &$errors, string $key = 'slug'): void
    {
        if ($modelExists) {
            foreach ($modelExists->getTranslations($key) as $locale => $value) {
                if ($translatedArray[$locale] == $value) {
                    $errors["$key.$locale"] = translate_error_message($key, 'exists');
                }
            }
        }
    }

    public static function slugArray(array $slug): array
    {
        return collect($slug)->map(function ($value, $locale) {
            return Str::slug($value, language: $locale);
        })->toArray();
    }
}
