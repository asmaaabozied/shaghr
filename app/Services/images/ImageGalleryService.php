<?php

namespace App\Services\images;

use App\Enums\CommonEnum;
use App\Models\Images\ImageGallery;

class ImageGalleryService
{
    protected $model;
    public function __construct(ImageGallery $model)
    {
        $this->model = $model;
    }
    public function getAll(?bool $is_paginate = false, ?array $wheres = [], ?array $wheresIn = [], ?array $with = [], ?array $withCount = [], ?array $orWheres = [], ?array $has = [], ?string $sortBy = null, ?string $sortOrder = 'asc', ?string $pluck = null)
    {
        if (count($wheres)) {
            $this->model = $this->model->where($wheres);
        }
        if (count($orWheres)) {
            $this->model = $this->model->orWhere($orWheres);
        }
        if (count($wheresIn)) {
            foreach ($wheresIn as $key => $wIn)
                $this->model = $this->model->whereIn($key, $wIn);
        }
        if (count($with)) {
            $this->model = $this->model->with($with);
        }
        if (count($withCount)) {
            $this->model = $this->model->withCount($withCount);
        }

        if (count($has)) {
            foreach ($has as $relation => $closure) {
                $this->model = $this->model->whereHas($relation, $closure);
            }
        }

        if ($sortBy && in_array(strtolower($sortOrder), ['asc', 'desc'])) {
            $this->model = $this->model->orderBy($sortBy, $sortOrder);
        }
        if ($pluck) {
            $records = $this->model->pluck($pluck);
        } elseif ($is_paginate) {
            $records = $this->model->paginate(CommonEnum::paginate);
        } else {
            $records = $this->model->get();
        }
        return $records;
    }
}
