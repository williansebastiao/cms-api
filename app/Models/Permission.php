<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Permission extends Model {

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'color', 'route', 'slug', 'active'
    ];

    protected static function booted() {
        parent::boot();
        static::created(function($model){
            $model->update(['slug' => Str::slug($model->name)]);
        });
        static::deleted(function($model){
            $model->update(['active' => false]);
        });
    }
}
