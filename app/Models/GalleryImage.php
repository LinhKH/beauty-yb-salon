<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use HasFactory;

    protected $table = 'gallery_image';

    protected $fillable = [
        'title',
        'image',
        'description',
        'category',
        'status',
    ];
    
    public function gallery_category(){
        return $this->hasOne(GalleryCategory::class,'id','category');
    }
}
