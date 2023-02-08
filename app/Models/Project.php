<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Project extends  Model implements HasMedia
{
    use HasFactory ;
    use InteractsWithMedia;
    use HasTranslations;
    protected $fillable = ['name','slug','phone','email','address','content','is_published'];
    public $translatable = ['name','slug','address','content'];
    protected $casts = [
        'is_published' => 'boolean',
        // 'tags' => 'array',
    ];
}
