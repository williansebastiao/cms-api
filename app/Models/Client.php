<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Client extends Model {

    use HasFactory, SoftDeletes, Notifiable;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'cnpj', 'password', 'avatar', 'active'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
      'password'
    ];

    /**
     * @param $value
     */
    public function setPasswordAttribute($value) {
        $this->attributes['password'] = bcrypt($value);
    }


}
