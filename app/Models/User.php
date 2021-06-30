<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Authenticable\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{

    protected $label='User';
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
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

    public function fieldsOpened()
    {
        return $this->hasMany(Field::class, 'PLAYER_OPENED');
    }

    public function gamesPlayed()
    {
        return $this->hasMany(Game::class, 'PLAYED');
    }

    public function hasPlayedTheGame(Game $game)
    {
        return $this->hasMany(Game::class, 'PLAYED')->where('id', $game->id)->count() > 0;
    }

    public function didPlayerOpenTheField(Field $field)
    {
        return $this->fieldsOpened()->where('id', $field->id)->count() > 0;
    }
}
