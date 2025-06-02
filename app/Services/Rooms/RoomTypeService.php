<?php

namespace App\Services\Rooms;

use App\Enums\CommonEnum;
use App\Models\Rooms\RoomTypes;
use Illuminate\Database\Eloquent\Model;

class RoomTypeService
{
    protected $model;
    public function __construct(RoomTypes $model)
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
    public function showById(int $model_id): ?Model
    {

        return $this->model->whereId($model_id)->firstOrFail();
    }

    public function checkExists(array $conditions): ?bool
    {
        return $this->model->where($conditions)->exists();
    }

    public function getByCondition(array $conditions): ?Model
    {
        return $this->model->where($conditions)->first();
    }

    public function showByColumn(string $column, mixed $id): ?Model
    {
        return $this->model->where($column, $id)->firstOrFail();
    }

    public function update(int $model_id, array $data): Model|bool
    {
        return $this->model->whereId($model_id)->update($data);
    }

    public function softDelete(int $model_id): ?bool
    {
        return $this->model->whereId($model_id)->delete();
    }

    public function hardDelete(int $model_id): ?bool
    {

        return $this->model->whereId($model_id)->forceDelete();
    }
}
