<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Role extends Model {

    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'active'
    ];

    /**
     * @param $value
     * @return string
     */
    public function getNameAttribute($value) {
        return strtolower($value);
    }

    public function user(){
        $this->hasOne(User::class);
    }

    public function administrator(){
        $this->hasOne(Administrator::class);
    }

    public function client(){
        $this->hasOne(Client::class);
    }

}
