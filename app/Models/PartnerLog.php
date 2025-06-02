<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartnerLog extends Model
{

    use HasFactory;
    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('images/logo/' . $this->image);

    }//end of get image path
}
