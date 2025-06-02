<?php

namespace App\Models\Chains;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationDocument extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'status' => Status::class,
    ];
    protected $hidden = ['deleted_at', 'delete_id', 'updated_at', 'creator_id', 'update_id', 'document_path'];

    public function chain()
    {
        return $this->belongsTo(Chains::class, 'chain_id');
    }

    protected $appends = ['path'];

    public function getPathAttribute()
    {
        return asset($this->document_path);

    }//end of get document path
}
