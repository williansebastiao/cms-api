<?php

namespace App\Models;

use App\Notifications\UserResetPasswordNotification;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as PasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject, PasswordContract
{

    use HasFactory, SoftDeletes, Notifiable, CanResetPassword;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password', 'slug', 'avatar', 'permission_id', 'active'
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @param $value
     */
    public function setCnpjAttribute($value)
    {
        $this->attributes['cnpj'] = clearSpecialCharacters($value);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function getCnpjAttribute($value)
    {
        return mask('##.###.###/####-##', $value);
    }

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * @param $value
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\UrlGenerator|string
     */
    public function getAvatarAttribute($value)
    {
        return !is_null($value) || isset($value) ? Storage::url($value) : url('assets/images/avatar.jpg');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Jenssegers\Mongodb\Relations\BelongsTo
     */
    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }

    protected static function booted()
    {
        parent::boot();
        static::created(function ($model) {
            $model->update(['slug' => Str::slug($model->name)]);
        });
        static::deleted(function ($model) {
            $model->update(['active' => false]);
        });
    }
}
