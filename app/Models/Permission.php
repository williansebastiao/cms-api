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

    protected $appends = [
        'dashboard'
    ];

    public function getDashboardAttribute() {
        $route = $this->attributes['route'];
        $status = Arr::get($route[0], 'role');
        $arr = [
            'read' =>  $status['read'] ? 'sim' : 'não',
            'create' =>  $status['create'] ? 'sim' : 'não',
            'edit' =>  $status['edit'] ? 'sim' : 'não',
            'delete' =>  $status['delete'] ? 'sim' : 'não',
        ];
        return $arr;
    }

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
        static::updated(function($model){
            $model->update(['slug' => Str::slug($model->name)]);
        });
        static::deleted(function($model){
            $model->update(['active' => false]);
        });
    }
}
