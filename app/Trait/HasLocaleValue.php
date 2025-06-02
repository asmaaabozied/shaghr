<?php

namespace App\Trait;

use Illuminate\Support\Facades\App;

trait HasLocaleValue
{
    protected mixed $fallbackLocale;

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->initializeFallbackLocale();
        });
    }

    protected function initializeFallbackLocale()
    {
        $this->fallbackLocale = config('app.locale', 'en');
    }

    public function getLocaleValue($attribute): mixed
    {
        $locale = App::getLocale();
        $value = $this->{"{$attribute}_{$locale}"};
        return $value ?: $this->{"{$attribute}_{$this->fallbackLocale}"};
    }
}
