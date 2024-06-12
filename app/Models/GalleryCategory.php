<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GalleryImage;

class GalleryCategory extends Model
{
    use HasFactory;

    protected $table = 'gallery_category';

    protected $fillable = [
        'title',
    ];

    public function images(){
        return $this->hasMany(GalleryImage::class,'category','id');
    }
}
