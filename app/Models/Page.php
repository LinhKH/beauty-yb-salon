<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $table = 'pages';

    protected $fillable = [
        'page_title',
        'page_slug',
        'description',
        'show_in_header',
        'show_in_footer',
        'status',
    ];
}
