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
        switch ($value) {
            case 'Root':
                return 'Master';
            case 'Administrator':
                return 'Administrador';
            case 'User':
            default:
                return 'Usuário';
        }
    }

    public function administrator(){
        $this->hasOne(Administrator::class);
    }

    public function client(){
        $this->hasOne(Client::class);
    }

}
