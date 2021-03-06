<?php

namespace App\Models;

use App\Notifications\ClientResetPasswordNotification;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as PasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Client extends Authenticatable implements JWTSubject, PasswordContract
{

    use HasFactory, SoftDeletes, Notifiable, CanResetPassword;

    /**
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password', 'slug', 'avatar', 'role_id', 'active'
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
        return !is_null($value) ? Storage::url($value) : url('assets/images/avatar.jpg');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
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
     * @param $roles
     * @return bool
     */
    public function hasRole($roles)
    {
        $this->have_role = $this->getUserRole();

        if ($this->have_role->name == 'Root') {
            return true;
        }

        if (is_array($roles)) {
            foreach ($roles as $need_role) {
                if ($this->checkIfUserHasRole($need_role)) {
                    return true;
                }
            }
        } else {
            return $this->checkIfUserHasRole($roles);
        }

        return false;
    }

    /**
     * @return mixed
     */
    private function getUserRole()
    {
        return $this->role()->getResults();
    }

    /**
     * @param $need_role
     * @return bool
     */
    private function checkIfUserHasRole($need_role)
    {
        return (strtolower($need_role) == strtolower($this->have_role->name)) ? true : false;
    }

    /**
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ClientResetPasswordNotification($token));
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
