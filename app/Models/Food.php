<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Food extends Model
{
    use HasFactory;

    /* mass assignable */
    public $fillable = [
        'name',
        'price',
        'pic',
    ];

    /* guarded attributes */
    protected $guarded = ['user_id'];

    protected $appends = ['img'];

    /* Magic function to retrieve accessible img url */
    public function getImgAttribute(): string
    {
        return Storage::url($this->pic);
    }
}
