<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The table associated with the model.
     */
    protected $table = 'usuarios';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'cod_us',
        'nom_us',
        'ema_us',
        'pas_us',
        'tel_us',
        'ciu_us',
        'ava_us',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'pas_us',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'profile_photo_url',
        'name',
        'email',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'pas_us' => 'hashed',
        ];
    }

    /**
     * Get the user's name for Jetstream.
     */
    public function getNameAttribute()
    {
        return $this->nom_us;
    }

    /**
     * Get the user's email for Jetstream.
     */
    public function getEmailAttribute()
    {
        return $this->ema_us;
    }

    /**
     * Get the user's password for Laravel.
     */
    public function getAuthPassword()
    {
        return $this->pas_us;
    }

    /**
     * Get the user's email for authentication.
     */
    public function getEmailForVerification()
    {
        return $this->ema_us;
    }

    /**
     * Find user by email for authentication.
     */
    public function findForPassport($email)
    {
        return $this->where('ema_us', $email)->first();
    }

    // ==============================================
    // RELACIONES CON OTRAS TABLAS
    // ==============================================

    public function mascotas()
    {
        return $this->hasMany(Mascota::class, 'us_id');
    }

    public function amistadesEnviadas()
    {
        return $this->hasMany(Amistad::class, 'us_sol');
    }

    public function amistadesRecibidas()
    {
        return $this->hasMany(Amistad::class, 'us_rec');
    }

    public function amigos()
    {
        $amistades = Amistad::where(function($q) {
            $q->where('us_sol', $this->id)
              ->orWhere('us_rec', $this->id);
        })->where('est_ami', 'aceptada')->get();

        $amigosIds = $amistades->map(function($amistad) {
            return $amistad->us_sol == $this->id ? $amistad->us_rec : $amistad->us_sol;
        });

        return User::whereIn('id', $amigosIds);
    }

    public function publicaciones()
    {
        return $this->hasMany(Publicacion::class, 'us_id');
    }

    public function productos()
    {
        return $this->hasMany(Producto::class, 'us_ven');
    }

    public function conversaciones()
    {
        return $this->belongsToMany(Conversacion::class, 'participantes', 'us_id', 'con_id')
                    ->withPivot('fch_uni_par', 'fch_sal_par')
                    ->withTimestamps();
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class, 'us_rem');
    }

    public function notificaciones()
    {
        return $this->hasMany(Notificacion::class, 'us_id');
    }
}