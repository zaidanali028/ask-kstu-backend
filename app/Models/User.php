<?php
namespace App\Models;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
use HasFactory, Notifiable;

/**
* The attributes that are mass assignable.
*
* @var array<int, string>
    */
    protected $fillable = [
    'name',
    'email',
    'password',
    'gender',
    'index_no',
    'admin_type',
    'faculty_id',
    'dept_id',
    'program_id',
    'status',
    'yr_of_admission',
    'yr_of_completion'

    ];

    /**
    * The attributes that should be hidden for serialization.
    *
    * @var array<int, string>
        */
        protected $hidden = [
        'password',
        'remember_token',
        ];

        /**
        * The attributes that should be cast.
        *
        * @var array<string, string>
            */
            protected $casts = [
            'email_verified_at' => 'datetime',
            ];

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

            }