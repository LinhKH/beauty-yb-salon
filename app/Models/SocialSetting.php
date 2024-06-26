<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialSetting extends Model
{
    use HasFactory;

    protected $table ="social-setting";

    protected $fillable = [
        'facebook',
        'twitter',
        'instagram',
        'you_tube',
    ];
}
