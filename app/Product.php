<?php

namespace App;

use Conner\Tagging\Taggable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasTranslations;
    use Taggable;

    public $translatable = ['name', 'description', 'price'];

    protected $fillable = ['publish_start','publish_end'];

}
