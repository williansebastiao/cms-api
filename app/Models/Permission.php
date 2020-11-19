<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Permission extends Model {

    use HasFactory, SoftDeletes;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'description', 'color', 'route', 'slug', 'active'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|\Jenssegers\Mongodb\Relations\HasOne
     */
    public function user() {
        return $this->hasOne(User::class);
    }

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
