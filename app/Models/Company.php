<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Company extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasTranslations;

    protected $fillable = ['title','slug','content','is_published'];
 public $translatable = ['title','slug','content'];


    protected $casts = [
        'is_published' => 'boolean',
    ];

}
