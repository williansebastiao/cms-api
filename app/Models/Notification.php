<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Notification extends Model {

    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'description', 'icon', 'read', 'active'
    ];
}
