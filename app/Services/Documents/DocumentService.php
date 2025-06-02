<?php

namespace App\Services\Documents;

use App\Enums\CommonEnum;
use App\Enums\Status;
use App\Models\Chains\VerificationDocument;
use Illuminate\Validation\Rules\Enum;

class DocumentService
{
    protected $model;

    public function __construct(VerificationDocument $model)
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

    public function softDelete(int $model_id): ?bool
    {
        return $this->model->whereId($model_id)->delete();
    }

    public function hardDelete(int $model_id): ?bool
    {

        return $this->model->whereId($model_id)->forceDelete();
    }

    public function uploadFile($request)
    {
        if ($request->hasFile('document')) {
            $thumbnail = $request->file('document');
            $destinationPath = 'images/chains/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            return VerificationDocument::create([
                'chain_id' => $request->chain_id,
                'document_name' => $filename,
                'document_path' => $destinationPath.$filename,
            ]);
        }
        return null;

    }

    public function review($request)
    {
        $data = $request->validate([
            'status' => ['required', new Enum(Status::class)],
            "id" => "required|exists:verification_documents,id",
        ]);

        $document = VerificationDocument::findOrFail($data['id']);
        return $document->update($data);


    }

}
